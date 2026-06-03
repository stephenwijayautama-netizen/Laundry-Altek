<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class PelangganController extends Controller
{
    public function index()
    {
        $pelanggan = Pelanggan::all();
        return view('pelanggan', compact('pelanggan'));
    }

    public function create()
    {
        return view('pelanggan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'telepon' => 'required',
            'alamat' => 'nullable',
            'status' => 'required|in:antrean,dicuci,siap diambil,selesai'
        ]);

        Pelanggan::create($request->all());

        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil ditambahkan');
    }

    public function show(string $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        return view('pelanggan.show', compact('pelanggan'));
    }

    public function edit(string $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        return view('pelanggan_edit', compact('pelanggan'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama' => 'required',
            'telepon' => 'required',
            'alamat' => 'nullable',
            'status' => 'required|in:antrean,dicuci,siap diambil,selesai'
        ]);

        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->update($request->all());

        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->delete();

        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil dihapus');
    }

    // Auth Logic
    public function showLogin()
    {
        return view('login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        return view('register');
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        // After registration, redirect user to their orders page
        return redirect()->route('my.orders');
    }

    public function myOrders()
    {
        // Get orders (transactions) for the logged‑in user
        $userId = Auth::id();
        $query = \App\Models\Transaksi::with(['detailTransaksi.layanan'])
            ->where('user_id', $userId);
        if ($status = request('status')) {
            $query->where('status', $status);
        }
        $myOrders = $query->orderByDesc('tanggal_masuk')
            ->paginate(10);
        return view('my_orders', compact('myOrders'));
    }


    public function dashboard(Request $request)
    {
        // Stats Summary
        $range = $request->query('range', 'today');
        $today = \Carbon\Carbon::today();
        $month = \Carbon\Carbon::now()->month;
        $year = \Carbon\Carbon::now()->year;

        // Calculate Selected Period Stats
        $active_query = \App\Models\Transaksi::query();
        $active_label = 'Hari Ini';
        
        if ($range === 'weekly') {
            $active_query->whereBetween('tanggal_masuk', [\Carbon\Carbon::now()->startOfWeek(), \Carbon\Carbon::now()->endOfWeek()]);
            $active_label = 'Minggu Ini';
        } elseif ($range === 'monthly') {
            $active_query->whereMonth('tanggal_masuk', $month)->whereYear('tanggal_masuk', $year);
            $active_label = 'Bulan Ini';
        } else {
            $active_query->whereDate('tanggal_masuk', $today);
        }

        $active_count = $active_query->count();
        $active_revenue = $active_query->sum('total_harga');

        $stats = [
            'active_count' => $active_count,
            'active_revenue' => $active_revenue,
            'active_label' => $active_label,
            'range' => $range,
            'month_count' => \App\Models\Transaksi::whereMonth('tanggal_masuk', $month)->whereYear('tanggal_masuk', $year)->count(),
            'month_revenue' => \App\Models\Transaksi::whereMonth('tanggal_masuk', $month)->whereYear('tanggal_masuk', $year)->sum('total_harga'),
        ];

        // Charts Data
        $today_chart = [];
        for ($i = 0; $i < 24; $i += 4) { // Sample every 4 hours for today
            $today_chart[] = \App\Models\Transaksi::whereDate('tanggal_masuk', $today)
                ->whereTime('tanggal_masuk', '>=', sprintf('%02d:00:00', $i))
                ->whereTime('tanggal_masuk', '<', sprintf('%02d:00:00', $i + 4))
                ->sum('total_harga');
        }

        $month_chart = [];
        $daysInMonth = \Carbon\Carbon::now()->daysInMonth;
        for ($i = 1; $i <= $daysInMonth; $i += 5) { // Sample every 5 days for month
            $month_chart[] = \App\Models\Transaksi::whereYear('tanggal_masuk', $year)
                ->whereMonth('tanggal_masuk', $month)
                ->whereDay('tanggal_masuk', '>=', $i)
                ->whereDay('tanggal_masuk', '<', min($i + 5, $daysInMonth + 1))
                ->sum('total_harga');
        }

        // Service Stats
        $service_stats = \App\Models\Detail_Transaksi::with('layanan')
            ->select('layanan_id', DB::raw('count(*) as total'))
            ->groupBy('layanan_id')
            ->get();

        // Ready for Pickup (Selesai status)
        $ready_pickup = \App\Models\Transaksi::with('pelanggan')
            ->where('status', 'selesai')
            ->latest()
            ->take(5)
            ->get();

        $pelanggan_ready = \App\Models\Pelanggan::whereIn('status', ['siap diambil', 'selesai'])->latest()->get();

        // Unified Recent Transactions Table
        $latest_trans = \App\Models\Transaksi::with(['pelanggan', 'detailTransaksi.layanan'])
            ->latest()->take(10)->get();

        return view('dashboard', compact(
            'stats', 'today_chart', 'month_chart', 
            'service_stats', 'ready_pickup', 
            'latest_trans', 'pelanggan_ready'
        ));
    }
}
