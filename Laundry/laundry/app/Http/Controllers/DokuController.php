<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Services\DokuService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DokuController extends Controller
{
    protected $dokuService;

    public function __construct(DokuService $dokuService)
    {
        $this->dokuService = $dokuService;
    }

    /**
     * Show QRIS checkout screen
     */
    public function showQris(Request $request, $id)
    {
        $transaksi = Transaksi::with(['pelanggan', 'detailTransaksi.layanan'])->findOrFail($id);
        
        $customerDetails = [
            'name' => $transaksi->pelanggan->nama ?? 'Umum',
            'email' => 'customer@example.com',
            'phone' => $transaksi->pelanggan->telepon ?? '',
        ];

        // Call DokuService to generate Checkout HPP
        $checkoutResponse = $this->dokuService->generateCheckout(
            $transaksi->kode_transaksi,
            $transaksi->total_harga,
            $customerDetails
        );

        return view('doku.qris', compact('transaksi', 'checkoutResponse'));
    }

    /**
     * DOKU Webhook Notification / Callback
     */
    public function callback(Request $request)
    {
        // 1. Log incoming notification
        Log::info('DOKU Callback received: ', $request->all());

        // 2. Validate Doku Signature (when using real keys)
        // For Jokul DOKU QRIS, the payload contains target.invoice_number or similar
        // Let's support both real DOKU webhook keys and simulated webhooks
        $invoiceNumber = $request->input('order.invoice_number') ?? $request->input('invoice_number');
        
        if (!$invoiceNumber) {
            return response()->json(['message' => 'Invoice number not found'], 400);
        }

        $transaksi = Transaksi::where('kode_transaksi', $invoiceNumber)->first();

        if ($transaksi) {
            // Update transaction payment status to paid
            $transaksi->update([
                'status_pembayaran' => 'lunas',
                'metode_pembayaran' => 'qris',
            ]);

            // Also update Pelanggan status dynamically to 'dicuci' (since payment is complete, it enters the queue/wash cycle)
            if ($transaksi->pelanggan) {
                $transaksi->pelanggan->update([
                    'status' => 'dicuci'
                ]);
            }

            return response()->json(['message' => 'Success updated payment'], 200);
        }

        return response()->json(['message' => 'Transaction not found'], 404);
    }

    /**
     * Simulation of Successful Payment
     */
    public function simulateSuccess(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);
        
        // Mock a callback call locally
        $mockRequest = new Request([
            'invoice_number' => $transaksi->kode_transaksi,
            'amount' => $transaksi->total_harga,
            'status' => 'SUCCESS'
        ]);

        $this->callback($mockRequest);

        return redirect()->route('transaksi.index')->with('success', 'Simulasi Pembayaran QRIS Berhasil! Status diubah menjadi Lunas.');
    }
}
