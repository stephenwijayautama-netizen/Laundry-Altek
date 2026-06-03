<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Laundry Altek - Cheap & Trusted Laundry & Dry Cleaning Services</title>
    
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            scroll-behavior: smooth;
        }

        /* Slide Transition Effects */
        .slide {
            opacity: 0;
            transition: opacity 1s ease-in-out;
            pointer-events: none;
        }
        .slide.active {
            opacity: 1;
            pointer-events: auto;
        }

        /* Keyframes for Staggered Fade Up Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-up {
            opacity: 0;
            animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        
        .delay-100 { animation-delay: 150ms; }
        .delay-200 { animation-delay: 300ms; }
        .delay-300 { animation-delay: 450ms; }

        /* Scroll Reveal Animations */
        .scroll-reveal {
            opacity: 0;
            transform: translateY(40px);
            transition: all 1s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .scroll-reveal-left {
            opacity: 0;
            transform: translateX(-50px);
            transition: all 1s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .scroll-reveal-right {
            opacity: 0;
            transform: translateX(50px);
            transition: all 1s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .scroll-reveal.visible,
        .scroll-reveal-left.visible,
        .scroll-reveal-right.visible {
            opacity: 1;
            transform: translate(0);
        }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex flex-col">

    <!-- Top Bar -->
    <div class="w-full bg-[#8cc63f] text-white py-2.5 px-6 md:px-12 text-sm z-50">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-2">
            <div class="flex flex-wrap items-center justify-center gap-6">
                <div class="flex items-center gap-2">
                    <i data-lucide="map-pin" class="w-4 h-4 text-white/90"></i>
                    <span>241 Taxi, newyork 10012, USA</span>
                </div>
                <div class="flex items-center gap-2">
                    <i data-lucide="mail" class="w-4 h-4 text-white/90"></i>
                    <a href="mailto:info@example.com" class="hover:underline">info@example.com</a>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <i data-lucide="phone" class="w-4 h-4 text-white/90"></i>
                <a href="tel:+44567890123" class="hover:underline font-medium">+44 567 890123</a>
            </div>
        </div>
    </div>

    <!-- Header / Navbar -->
    <header class="w-full bg-white shadow-md border-b border-gray-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <!-- Logo -->
            <a href="#" class="flex items-center gap-3">
                <img 
                    src="{{ asset('photo/logo.png') }}" 
                    alt="Logo"
                    class="h-12 w-auto object-contain"
                    onerror="this.src='https://via.placeholder.com/150x50?text=Laundry'"
                >
            </a>

            <!-- Menu (Desktop) -->
            <nav class="hidden md:flex items-center gap-8">
                <a href="#" class="text-[#8cc63f] font-semibold text-sm tracking-wider uppercase border-b-2 border-[#8cc63f] pb-1">
                    HOME
                </a>
                <a href="#about" class="text-slate-700 hover:text-[#8cc63f] font-semibold text-sm tracking-wider uppercase transition duration-300 pb-1">
                    ABOUT
                </a>
                <a href="#services" class="text-slate-700 hover:text-[#8cc63f] font-semibold text-sm tracking-wider uppercase transition duration-300 pb-1">
                    SERVICES
                </a>
                <a href="#why-us" class="text-slate-700 hover:text-[#8cc63f] font-semibold text-sm tracking-wider uppercase transition duration-300 pb-1">
                    BENEFITS
                </a>
                <a href="#pricing" class="text-slate-700 hover:text-[#8cc63f] font-semibold text-sm tracking-wider uppercase transition duration-300 pb-1">
                    PRICING
                </a>
                <a href="#testimonials" class="text-slate-700 hover:text-[#8cc63f] font-semibold text-sm tracking-wider uppercase transition duration-300 pb-1">
                    REVIEWS
                </a>
                <a href="#footer" class="text-slate-700 hover:text-[#8cc63f] font-semibold text-sm tracking-wider uppercase transition duration-300 pb-1">
                    CONTACT US
                </a>
            </nav>

            <!-- Auth/Action Button -->
            <div class="flex items-center gap-4">
                @auth
                    <a href="{{ route('dashboard') }}" class="px-5 py-2.5 bg-[#8cc63f] text-white rounded-lg font-semibold text-sm shadow-md hover:bg-[#7bb334] transition duration-300">
                        DASHBOARD
                    </a>
                @else
                    <a href="{{ route('login') }}" class="px-5 py-2.5 bg-[#8cc63f] text-white rounded-lg font-semibold text-sm shadow-md hover:bg-[#7bb334] transition duration-300">
                        LOGIN
                    </a>
                @endauth
                
                <!-- Mobile Menu Button -->
                <button id="mobile-menu-btn" class="md:hidden text-slate-700 hover:text-[#8cc63f] transition">
                    <i data-lucide="menu" class="w-6 h-6"></i>
                </button>
            </div>
        </div>
        
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-100 px-6 py-4 space-y-3 shadow-inner">
            <a href="#" class="block text-[#8cc63f] font-semibold text-sm uppercase">HOME</a>
            <a href="#about" class="block text-slate-700 hover:text-[#8cc63f] font-semibold text-sm uppercase transition">ABOUT</a>
            <a href="#services" class="block text-slate-700 hover:text-[#8cc63f] font-semibold text-sm uppercase transition">SERVICES</a>
            <a href="#why-us" class="block text-slate-700 hover:text-[#8cc63f] font-semibold text-sm uppercase transition">BENEFITS</a>
            <a href="#pricing" class="block text-slate-700 hover:text-[#8cc63f] font-semibold text-sm uppercase transition">PRICING</a>
            <a href="#testimonials" class="block text-slate-700 hover:text-[#8cc63f] font-semibold text-sm uppercase transition">REVIEWS</a>
            <a href="#footer" class="block text-slate-700 hover:text-[#8cc63f] font-semibold text-sm uppercase transition">CONTACT US</a>
        </div>
    </header>

    <!-- Carousel / Hero Section -->
    <div class="relative min-h-[580px] md:min-h-[680px] overflow-hidden bg-slate-900 z-10">
        
        <!-- Slide 1 -->
        <div class="slide active absolute inset-0 w-full h-full bg-cover bg-center" style="background-image: linear-gradient(to right, rgba(15, 23, 42, 0.75) 30%, rgba(15, 23, 42, 0.4)), url('https://images.unsplash.com/photo-1545173168-9f1947eebb7f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');">
            <div class="max-w-7xl mx-auto h-full px-6 md:px-12 flex items-center">
                <div class="bg-black/55 backdrop-blur-md border border-white/10 rounded-2xl p-8 md:p-10 max-w-xl text-left shadow-2xl">
                    <h2 class="slide-animate animate-fade-up text-4xl md:text-5xl font-bold text-white leading-tight mb-4">
                        Cheap & Trusted <br/><span class="text-[#8cc63f]">Wash and Fold.</span>
                    </h2>
                    <p class="slide-animate animate-fade-up delay-100 text-lg text-gray-200 mb-8">
                        Laundry Service Delivered to Your Home. Get your clothes cleaned by professionals.
                    </p>
                    <div class="slide-animate animate-fade-up delay-200 flex flex-wrap gap-4">
                        <a href="#services" class="px-6 py-3 bg-[#8cc63f] hover:bg-[#7bb334] text-white font-semibold rounded-lg shadow-lg shadow-[#8cc63f]/30 transition duration-300">
                            Our Services
                        </a>
                        <a href="#pricing" class="px-6 py-3 border-2 border-white hover:bg-white hover:text-slate-900 text-white font-semibold rounded-lg transition duration-300">
                            Request Quote
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Slide 2 -->
        <div class="slide absolute inset-0 w-full h-full bg-cover bg-center" style="background-image: linear-gradient(to right, rgba(15, 23, 42, 0.75) 30%, rgba(15, 23, 42, 0.4)), url('https://images.unsplash.com/photo-1517677208171-0bc6725a3e60?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');">
            <div class="max-w-7xl mx-auto h-full px-6 md:px-12 flex items-center">
                <div class="bg-black/55 backdrop-blur-md border border-white/10 rounded-2xl p-8 md:p-10 max-w-xl text-left shadow-2xl">
                    <h2 class="slide-animate text-4xl md:text-5xl font-bold text-white leading-tight mb-4">
                        Our Service is dedicated <br/>to <span class="text-[#8cc63f]">making your</span>
                    </h2>
                    <p class="slide-animate text-lg text-gray-200 mb-8">
                        life easier by providing pick up laundry service. Free delivery for first-time orders.
                    </p>
                    <div class="slide-animate flex flex-wrap gap-4">
                        <a href="#services" class="px-6 py-3 bg-[#8cc63f] hover:bg-[#7bb334] text-white font-semibold rounded-lg shadow-lg shadow-[#8cc63f]/30 transition duration-300">
                            Our Services
                        </a>
                        <a href="#pricing" class="px-6 py-3 border-2 border-white hover:bg-white hover:text-slate-900 text-white font-semibold rounded-lg transition duration-300">
                            Request Quote
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Slide 3 -->
        <div class="slide absolute inset-0 w-full h-full bg-cover bg-center" style="background-image: linear-gradient(to right, rgba(15, 23, 42, 0.75) 30%, rgba(15, 23, 42, 0.4)), url('https://images.unsplash.com/photo-1582735689369-4fe89db7114c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');">
            <div class="max-w-7xl mx-auto h-full px-6 md:px-12 flex items-center">
                <div class="bg-black/55 backdrop-blur-md border border-white/10 rounded-2xl p-8 md:p-10 max-w-xl text-left shadow-2xl">
                    <h2 class="slide-animate text-4xl md:text-5xl font-bold text-white leading-tight mb-4">
                        Premium Quality <br/><span class="text-[#8cc63f]">Dry Cleaning.</span>
                    </h2>
                    <p class="slide-animate text-lg text-gray-200 mb-8">
                        Professional care for your delicate fabrics. Cleaned, ironed, and perfectly folded.
                    </p>
                    <div class="slide-animate flex flex-wrap gap-4">
                        <a href="#services" class="px-6 py-3 bg-[#8cc63f] hover:bg-[#7bb334] text-white font-semibold rounded-lg shadow-lg shadow-[#8cc63f]/30 transition duration-300">
                            Our Services
                        </a>
                        <a href="#pricing" class="px-6 py-3 border-2 border-white hover:bg-white hover:text-slate-900 text-white font-semibold rounded-lg transition duration-300">
                            Request Quote
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Prev/Next Navigation Controls -->
        <button id="prev-slide" class="absolute left-4 md:left-8 top-1/2 -translate-y-1/2 z-30 w-12 h-12 flex items-center justify-center rounded-full bg-white/15 hover:bg-[#8cc63f] border border-white/20 hover:border-[#8cc63f] text-white transition duration-300 focus:outline-none">
            <i data-lucide="chevron-left" class="w-6 h-6"></i>
        </button>
        <button id="next-slide" class="absolute right-4 md:right-8 top-1/2 -translate-y-1/2 z-30 w-12 h-12 flex items-center justify-center rounded-full bg-white/15 hover:bg-[#8cc63f] border border-white/20 hover:border-[#8cc63f] text-white transition duration-300 focus:outline-none">
            <i data-lucide="chevron-right" class="w-6 h-6"></i>
        </button>

        <!-- Slide Indicator Dots -->
        <div class="absolute bottom-6 left-1/2 -translate-x-1/2 z-30 flex items-center gap-3">
            <button class="dot w-3.5 h-3.5 rounded-full bg-white/40 hover:bg-[#8cc63f] transition duration-300 focus:outline-none active" data-slide="0"></button>
            <button class="dot w-3.5 h-3.5 rounded-full bg-white/40 hover:bg-[#8cc63f] transition duration-300 focus:outline-none" data-slide="1"></button>
            <button class="dot w-3.5 h-3.5 rounded-full bg-white/40 hover:bg-[#8cc63f] transition duration-300 focus:outline-none" data-slide="2"></button>
        </div>

    </div>

    <!-- Commercial Services Section (About) -->
    <section id="about" class="w-full py-24 px-6 md:px-12 bg-white relative z-10 border-b border-gray-100">
        <div class="max-w-7xl mx-auto">
            <!-- Section Title -->
            <div class="text-center mb-16 scroll-reveal">
                <h2 class="text-3xl md:text-4xl font-bold text-slate-800 mb-4">
                    Your Dry Cleaning and Laundry. Done.
                </h2>
                <div class="w-24 h-1 bg-[#8cc63f] mx-auto rounded-full"></div>
            </div>

            <!-- Two Column Content -->
            <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-16">
                <!-- Left Image with hover effect and scroll animation -->
                <div class="flex-1 w-full scroll-reveal-left">
                    <div class="relative group overflow-hidden rounded-2xl shadow-xl">
                        <div class="absolute inset-0 bg-[#8cc63f]/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500 z-10"></div>
                        <img 
                         src="{{ asset('images/commercial_laundry.png') }}" 
                            alt="Commercial Laundry Service" 
                            class="w-full h-[450px] object-cover transition-transform duration-700 group-hover:scale-105"
                            onerror="this.src='https://via.placeholder.com/800x600?text=Laundry+Service'"
                        >
                    </div>
                </div>

                <!-- Right Text Content -->
                <div class="flex-1 w-full space-y-6 scroll-reveal-right">
                    <h3 class="text-2xl md:text-3xl font-bold text-slate-800 leading-tight">
                        Commercial Laundry Service.
                    </h3>
                    <p class="text-slate-600 leading-relaxed">
                        Large corporations have determined that there is a financial benefit to outsourcing back office work because it saves money. Allowing us to do your laundry is cost effective and will allow you and your employees to focus on your core business. We offer smart solutions to meet your commercial laundry needs. Our Commercial Laundry Clients include:
                    </p>
                    
                    <!-- Bullet List -->
                    <ul class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-slate-700 font-semibold pt-2">
                        <li class="flex items-center gap-3">
                            <span class="w-6 h-6 flex items-center justify-center rounded-full bg-[#8cc63f]/15 text-[#8cc63f]">
                                <i data-lucide="check" class="w-4 h-4"></i>
                            </span>
                            <span>Hotels & Resorts</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="w-6 h-6 flex items-center justify-center rounded-full bg-[#8cc63f]/15 text-[#8cc63f]">
                                <i data-lucide="check" class="w-4 h-4"></i>
                            </span>
                            <span>Hospitals & Clinics</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="w-6 h-6 flex items-center justify-center rounded-full bg-[#8cc63f]/15 text-[#8cc63f]">
                                <i data-lucide="check" class="w-4 h-4"></i>
                            </span>
                            <span>Restaurants & Cafes</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="w-6 h-6 flex items-center justify-center rounded-full bg-[#8cc63f]/15 text-[#8cc63f]">
                                <i data-lucide="check" class="w-4 h-4"></i>
                            </span>
                            <span>Salons & Spas</span>
                        </li>
                    </ul>

                    <div class="pt-6">
                        <a href="#" class="inline-block px-8 py-3.5 bg-slate-900 text-white font-semibold rounded-lg border-2 border-slate-900 hover:bg-transparent hover:text-slate-900 transition-all duration-300 shadow-lg shadow-slate-900/10">
                            Know More
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="w-full py-24 px-6 md:px-12 bg-slate-50 relative z-10 border-b border-gray-100">
        <div class="max-w-7xl mx-auto">
            <!-- Section Title -->
            <div class="text-center mb-16 scroll-reveal">
                <span class="text-[#8cc63f] font-bold text-sm tracking-widest uppercase">OUR SERVICES</span>
                <h2 class="text-3xl md:text-4xl font-bold text-slate-800 mt-2 mb-4">
                    Expert Cleaning Services For You
                </h2>
                <div class="w-24 h-1 bg-[#8cc63f] mx-auto rounded-full"></div>
            </div>

            <!-- Services Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @php
                    $icons = [
                        'kiloan' => 'package',
                        'cuci' => 'droplet',
                        'setrika' => 'zap',
                        'dry' => 'wind',
                        'kering' => 'wind',
                        'satuan' => 'shirt',
                        'jas' => 'shirt',
                        'karpet' => 'home',
                        'carpet' => 'home',
                        'bed' => 'home',
                        'selimut' => 'home',
                    ];
                @endphp
                @forelse($layanans as $index => $layanan)
                    @php
                        $selectedIcon = 'droplet';
                        $serviceNameLower = strtolower($layanan->nama_layanan);
                        foreach ($icons as $key => $icon) {
                            if (str_contains($serviceNameLower, $key)) {
                                $selectedIcon = $icon;
                                break;
                            }
                        }
                        // Delay calculation for scroll reveal
                        $delay = (($index % 4) + 1) * 100;
                    @endphp
                    <div class="bg-white rounded-2xl p-6 shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-1.5 border border-gray-100 group scroll-reveal delay-{{ $delay }}">
                        <div class="w-14 h-14 bg-[#8cc63f]/10 text-[#8cc63f] rounded-xl flex items-center justify-center mb-6 group-hover:bg-[#8cc63f] group-hover:text-white transition duration-300">
                            <i data-lucide="{{ $selectedIcon }}" class="w-8 h-8"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800 mb-3">{{ $layanan->nama_layanan }}</h3>
                        <p class="text-slate-500 text-sm leading-relaxed mb-4">
                            Layanan berkualitas tinggi per {{ $layanan->satuan }} dengan penanganan profesional.
                        </p>
                        <div class="text-[#8cc63f] font-bold text-lg mb-2">
                            Rp {{ number_format($layanan->harga, 0, ',', '.') }} <span class="text-xs text-slate-400 font-normal">/ {{ $layanan->satuan }}</span>
                        </div>
                        @if($layanan->estimasi)
                            <div class="text-xs text-slate-400 flex items-center gap-1.5 mt-2">
                                <i data-lucide="clock" class="w-3.5 h-3.5 text-[#8cc63f]"></i>
                                <span>Estimasi: {{ $layanan->estimasi }} Hari</span>
                            </div>
                        @endif
                    </div>
                @empty
                    <!-- Fallback Cards -->
                    <div class="bg-white rounded-2xl p-6 shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-1.5 border border-gray-100 group scroll-reveal delay-100">
                        <div class="w-14 h-14 bg-[#8cc63f]/10 text-[#8cc63f] rounded-xl flex items-center justify-center mb-6 group-hover:bg-[#8cc63f] group-hover:text-white transition duration-300">
                            <i data-lucide="droplet" class="w-8 h-8"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800 mb-3">Wash & Fold</h3>
                        <p class="text-slate-500 text-sm leading-relaxed mb-4">
                            Perfect for everyday wear, shirts, jeans, and activewear. Cleaned and perfectly folded.
                        </p>
                        <div class="text-[#8cc63f] font-bold text-lg">Rp 6.000 <span class="text-xs text-slate-400 font-normal">/ kg</span></div>
                    </div>
                    <div class="bg-white rounded-2xl p-6 shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-1.5 border border-gray-100 group scroll-reveal delay-200">
                        <div class="w-14 h-14 bg-[#8cc63f]/10 text-[#8cc63f] rounded-xl flex items-center justify-center mb-6 group-hover:bg-[#8cc63f] group-hover:text-white transition duration-300">
                            <i data-lucide="shirt" class="w-8 h-8"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800 mb-3">Dry Cleaning</h3>
                        <p class="text-slate-500 text-sm leading-relaxed mb-4">
                            Expert care for suits, gowns, coats, and delicate fabrics. High quality solvents.
                        </p>
                        <div class="text-[#8cc63f] font-bold text-lg">Rp 15.000 <span class="text-xs text-slate-400 font-normal">/ pcs</span></div>
                    </div>
                    <div class="bg-white rounded-2xl p-6 shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-1.5 border border-gray-100 group scroll-reveal delay-300">
                        <div class="w-14 h-14 bg-[#8cc63f]/10 text-[#8cc63f] rounded-xl flex items-center justify-center mb-6 group-hover:bg-[#8cc63f] group-hover:text-white transition duration-300">
                            <i data-lucide="zap" class="w-8 h-8"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800 mb-3">Steam Ironing</h3>
                        <p class="text-slate-500 text-sm leading-relaxed mb-4">
                            Remove all wrinkles with our premium steam press. Crisp and ready to wear.
                        </p>
                        <div class="text-[#8cc63f] font-bold text-lg">Rp 5.000 <span class="text-xs text-slate-400 font-normal">/ kg</span></div>
                    </div>
                    <div class="bg-white rounded-2xl p-6 shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-1.5 border border-gray-100 group scroll-reveal delay-400">
                        <div class="w-14 h-14 bg-[#8cc63f]/10 text-[#8cc63f] rounded-xl flex items-center justify-center mb-6 group-hover:bg-[#8cc63f] group-hover:text-white transition duration-300">
                            <i data-lucide="home" class="w-8 h-8"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800 mb-3">Household Items</h3>
                        <p class="text-slate-500 text-sm leading-relaxed mb-4">
                            Cleaning for carpets, curtains, bed sheets, and duvets to keep your home fresh.
                        </p>
                        <div class="text-[#8cc63f] font-bold text-lg">Rp 20.000 <span class="text-xs text-slate-400 font-normal">/ pcs</span></div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Why Choose Us / Benefits Section -->
    <section id="why-us" class="w-full py-24 px-6 md:px-12 bg-white relative z-10 border-b border-gray-100">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col lg:flex-row items-center gap-16">
                <!-- Left Details -->
                <div class="flex-1 w-full space-y-6 scroll-reveal-left">
                    <span class="text-[#8cc63f] font-bold text-sm tracking-widest uppercase">OUR BENEFITS</span>
                    <h2 class="text-2xl md:text-4xl font-bold text-slate-800 leading-tight">
                        Why Choose Us For Your Laundry Needs
                    </h2>
                    <p class="text-slate-600 leading-relaxed">
                        We pride ourselves on offering an unrivaled level of service. We clean your clothes using state-of-the-art tech and environmentally friendly detergents.
                    </p>

                    <!-- Features Listing -->
                    <div class="space-y-4 pt-2">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-full bg-[#8cc63f]/10 text-[#8cc63f] flex items-center justify-center flex-shrink-0 mt-1">
                                <i data-lucide="zap" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <h4 class="text-lg font-bold text-slate-800">Super Fast Delivery</h4>
                                <p class="text-slate-500 text-sm mt-1">We guarantee 24-hour delivery for our standard laundry services.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-full bg-[#8cc63f]/10 text-[#8cc63f] flex items-center justify-center flex-shrink-0 mt-1">
                                <i data-lucide="shield" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <h4 class="text-lg font-bold text-slate-800">100% Safe Cleaning</h4>
                                <p class="text-slate-500 text-sm mt-1">Your fabrics are handled with supreme care. We prevent color bleeding and damage.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-full bg-[#8cc63f]/10 text-[#8cc63f] flex items-center justify-center flex-shrink-0 mt-1">
                                <i data-lucide="leaf" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <h4 class="text-lg font-bold text-slate-800">Eco-Friendly Detergents</h4>
                                <p class="text-slate-500 text-sm mt-1">We protect the planet by using biodegradable, hypoallergenic soaps.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Image Grid -->
                <div class="flex-1 w-full scroll-reveal-right mt-20">
                    <div class="relative">
                        <div class="absolute -top-12 -left-4 w-96 h-96 bg-[#8cc63f]/10 rounded-3xl blur-2xl z-0"></div>
                        <img 
                            src="https://images.unsplash.com/photo-1517677208171-0bc6725a3e60?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                            alt="Laundry Facility" 
                            class="relative z-10 w-full h-[400px] object-cover rounded-2xl shadow-xl"
                        >
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="w-full py-24 px-6 md:px-12 bg-slate-50 relative z-10 border-b border-gray-100">
        <div class="max-w-7xl mx-auto">
            <!-- Section Title -->
            <div class="text-center mb-20 scroll-reveal">
                <span class="text-[#8cc63f] font-bold text-sm tracking-widest uppercase">EASY STEPS</span>
                <h2 class="text-3xl md:text-4xl font-bold text-slate-800 mt-2 mb-4">
                    How We Work
                </h2>
                <div class="w-24 h-1 bg-[#8cc63f] mx-auto rounded-full"></div>
            </div>

            <!-- Steps layout -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 relative">
                <!-- Step 1 -->
                <div class="text-center space-y-4 scroll-reveal delay-100">
                    <div class="relative inline-block">
                        <div class="w-20 h-20 rounded-full bg-white shadow-md flex items-center justify-center mx-auto text-[#8cc63f] font-bold text-2xl border-2 border-slate-100">
                            <i data-lucide="shopping-bag" class="w-8 h-8"></i>
                        </div>
                        <span class="absolute -top-1 -right-1 w-7 h-7 bg-[#8cc63f] text-white font-bold rounded-full flex items-center justify-center text-sm shadow-md">1</span>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800">Bag your clothes</h3>
                    <p class="text-slate-500 text-sm leading-relaxed px-4">
                        Put all your dirty garments in a bag. We'll pick them up.
                    </p>
                </div>

                <!-- Step 2 -->
                <div class="text-center space-y-4 scroll-reveal delay-200">
                    <div class="relative inline-block">
                        <div class="w-20 h-20 rounded-full bg-white shadow-md flex items-center justify-center mx-auto text-[#8cc63f] font-bold text-2xl border-2 border-slate-100">
                            <i data-lucide="truck" class="w-8 h-8"></i>
                        </div>
                        <span class="absolute -top-1 -right-1 w-7 h-7 bg-[#8cc63f] text-white font-bold rounded-full flex items-center justify-center text-sm shadow-md">2</span>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800">We Pick Up</h3>
                    <p class="text-slate-500 text-sm leading-relaxed px-4">
                        Our courier will arrive at your doorstep to pick up the laundry.
                    </p>
                </div>

                <!-- Step 3 -->
                <div class="text-center space-y-4 scroll-reveal delay-300">
                    <div class="relative inline-block">
                        <div class="w-20 h-20 rounded-full bg-white shadow-md flex items-center justify-center mx-auto text-[#8cc63f] font-bold text-2xl border-2 border-slate-100">
                            <i data-lucide="sparkles" class="w-8 h-8"></i>
                        </div>
                        <span class="absolute -top-1 -right-1 w-7 h-7 bg-[#8cc63f] text-white font-bold rounded-full flex items-center justify-center text-sm shadow-md">3</span>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800">We Clean & Iron</h3>
                    <p class="text-slate-500 text-sm leading-relaxed px-4">
                        We clean, dry, press, and sort your clothes according to instructions.
                    </p>
                </div>

                <!-- Step 4 -->
                <div class="text-center space-y-4 scroll-reveal delay-300">
                    <div class="relative inline-block">
                        <div class="w-20 h-20 rounded-full bg-white shadow-md flex items-center justify-center mx-auto text-[#8cc63f] font-bold text-2xl border-2 border-slate-100">
                            <i data-lucide="package" class="w-8 h-8"></i>
                        </div>
                        <span class="absolute -top-1 -right-1 w-7 h-7 bg-[#8cc63f] text-white font-bold rounded-full flex items-center justify-center text-sm shadow-md">4</span>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800">We Deliver</h3>
                    <p class="text-slate-500 text-sm leading-relaxed px-4">
                        Get fresh, clean, and perfectly pressed clothes back at your door.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="w-full py-24 px-6 md:px-12 bg-white relative z-10 border-b border-gray-100">
        <div class="max-w-5xl mx-auto">
            <!-- Section Title -->
            <div class="text-center mb-16 scroll-reveal">
                <span class="text-[#8cc63f] font-bold text-sm tracking-widest uppercase">OUR PRICING</span>
                <h2 class="text-3xl md:text-4xl font-bold text-slate-800 mt-2 mb-4">
                    Simple & Affordable Rates
                </h2>
                <div class="w-24 h-1 bg-[#8cc63f] mx-auto rounded-full"></div>
            </div>

            <!-- Pricing Table -->
            <div class="bg-white rounded-2xl border border-gray-150 overflow-hidden shadow-lg scroll-reveal">
                <div class="bg-[#8cc63f] text-white px-6 py-4 font-bold text-lg flex items-center gap-2">
                    <i data-lucide="tag" class="w-5 h-5"></i>
                    <span>Laundry & Dry Cleaning Rates</span>
                </div>
                <div class="divide-y divide-gray-100">
                    @forelse($layanans as $layanan)
                        <div class="flex justify-between items-center px-6 py-4 hover:bg-slate-50 transition">
                            <div>
                                <span class="font-bold text-slate-800">{{ $layanan->nama_layanan }}</span>
                                @if($layanan->estimasi)
                                    <p class="text-slate-400 text-xs mt-0.5">Estimasi: {{ $layanan->estimasi }} Hari</p>
                                @else
                                    <p class="text-slate-400 text-xs mt-0.5">Penanganan Profesional</p>
                                @endif
                            </div>
                            <span class="font-bold text-lg text-[#8cc63f]">Rp {{ number_format($layanan->harga, 0, ',', '.') }} / {{ $layanan->satuan }}</span>
                        </div>
                    @empty
                        <!-- Fallback Rates -->
                        <div class="flex justify-between items-center px-6 py-4 hover:bg-slate-50 transition">
                            <div>
                                <span class="font-bold text-slate-800">T-Shirt / Polo Shirt (Cuci & Setrika)</span>
                                <p class="text-slate-400 text-xs mt-0.5">Washed & Pressed</p>
                            </div>
                            <span class="font-bold text-lg text-[#8cc63f]">Rp 6.000 / kg</span>
                        </div>
                        <div class="flex justify-between items-center px-6 py-4 hover:bg-slate-50 transition">
                            <div>
                                <span class="font-bold text-slate-800">Formal Shirt / Blouse (Satuan)</span>
                                <p class="text-slate-400 text-xs mt-0.5">Washed & Starched</p>
                            </div>
                            <span class="font-bold text-lg text-[#8cc63f]">Rp 15.000 / pcs</span>
                        </div>
                        <div class="flex justify-between items-center px-6 py-4 hover:bg-slate-50 transition">
                            <div>
                                <span class="font-bold text-slate-800">Jeans / Trousers</span>
                                <p class="text-slate-400 text-xs mt-0.5">Washed & Folded</p>
                            </div>
                            <span class="font-bold text-lg text-[#8cc63f]">Rp 8.000 / pcs</span>
                        </div>
                        <div class="flex justify-between items-center px-6 py-4 hover:bg-slate-50 transition">
                            <div>
                                <span class="font-bold text-slate-800">Suit (2-Piece)</span>
                                <p class="text-slate-400 text-xs mt-0.5">Premium Dry Cleaned</p>
                            </div>
                            <span class="font-bold text-lg text-[#8cc63f]">Rp 45.000 / pcs</span>
                        </div>
                        <div class="flex justify-between items-center px-6 py-4 hover:bg-slate-50 transition">
                            <div>
                                <span class="font-bold text-slate-800">Karpet / Curtains</span>
                                <p class="text-slate-400 text-xs mt-0.5">Dry Cleaned per kg</p>
                            </div>
                            <span class="font-bold text-lg text-[#8cc63f]">Rp 15.000 / kg</span>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="w-full py-24 px-6 md:px-12 bg-slate-50 relative z-10 border-b border-gray-100">
        <div class="max-w-7xl mx-auto">
            <!-- Section Title -->
            <div class="text-center mb-16 scroll-reveal">
                <span class="text-[#8cc63f] font-bold text-sm tracking-widest uppercase">FEEDBACK</span>
                <h2 class="text-3xl md:text-4xl font-bold text-slate-800 mt-2 mb-4">
                    What Our Customers Say
                </h2>
                <div class="w-24 h-1 bg-[#8cc63f] mx-auto rounded-full"></div>
            </div>

            <!-- Testimonials Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Card 1 -->
                <div class="bg-white rounded-2xl p-8 border border-gray-100 shadow-md flex flex-col justify-between scroll-reveal delay-100">
                    <div class="space-y-4">
                        <div class="flex text-amber-400">
                            <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
                            <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
                            <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
                            <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
                            <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
                        </div>
                        <p class="text-slate-600 leading-relaxed text-sm italic">
                            "Absolutely standard laundry experience! They picked up my suits on time and delivered them back clean, crisp, and fresh. Highly recommended!"
                        </p>
                    </div>
                    <div class="flex items-center gap-4 pt-6 mt-6 border-t border-gray-50">
                        <div class="w-12 h-12 rounded-full bg-slate-100 overflow-hidden flex items-center justify-center font-bold text-slate-700">JS</div>
                        <div>
                            <h4 class="font-bold text-slate-800 text-sm">John Smith</h4>
                            <span class="text-slate-400 text-xs">Hotel Manager</span>
                        </div>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="bg-white rounded-2xl p-8 border border-gray-100 shadow-md flex flex-col justify-between scroll-reveal delay-200">
                    <div class="space-y-4">
                        <div class="flex text-amber-400">
                            <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
                            <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
                            <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
                            <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
                            <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
                        </div>
                        <p class="text-slate-600 leading-relaxed text-sm italic">
                            "The best dry cleaning service in the city. The customer support is friendly and the mobile booking makes it incredibly easy to use."
                        </p>
                    </div>
                    <div class="flex items-center gap-4 pt-6 mt-6 border-t border-gray-50">
                        <div class="w-12 h-12 rounded-full bg-slate-100 overflow-hidden flex items-center justify-center font-bold text-slate-700">AD</div>
                        <div>
                            <h4 class="font-bold text-slate-800 text-sm">Amara Doe</h4>
                            <span class="text-slate-400 text-xs">Designer</span>
                        </div>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="bg-white rounded-2xl p-8 border border-gray-100 shadow-md flex flex-col justify-between scroll-reveal delay-300">
                    <div class="space-y-4">
                        <div class="flex text-amber-400">
                            <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
                            <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
                            <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
                            <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
                            <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
                        </div>
                        <p class="text-slate-600 leading-relaxed text-sm italic">
                            "Excellent prices and eco-friendly clean! My clothes have never smelled so fresh without having strong chemical scents. Highly satisfied!"
                        </p>
                    </div>
                    <div class="flex items-center gap-4 pt-6 mt-6 border-t border-gray-50">
                        <div class="w-12 h-12 rounded-full bg-slate-100 overflow-hidden flex items-center justify-center font-bold text-slate-700">RK</div>
                        <div>
                            <h4 class="font-bold text-slate-800 text-sm">Rian Kevin</h4>
                            <span class="text-slate-400 text-xs">Regular Client</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Member Registration Section -->
<section id="register-member" class="w-full py-24 px-6 md:px-12 bg-slate-900 text-white relative overflow-hidden z-10">
    <div class="absolute -right-10 -bottom-10 w-96 h-96 bg-[#8cc63f]/10 rounded-full blur-3xl z-0"></div>
    <div class="absolute -left-10 -top-10 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl z-0"></div>
    
    <div class="max-w-7xl mx-auto flex flex-col lg:flex-row items-center gap-12 relative z-10">
        <!-- Left Side Info -->
        <div class="flex-1 w-full space-y-6 text-left scroll-reveal-left">
            <span class="text-[#8cc63f] font-bold text-sm tracking-widest uppercase">MEMBER BENEFITS</span>
            <h2 class="text-3xl md:text-5xl font-bold leading-tight">
                Join As a Member <br/>&amp; Enjoy <span class="text-[#8cc63f]">Premium Care</span>
            </h2>
            <p class="text-gray-300 leading-relaxed max-w-lg">
                Daftar sebagai member sekarang untuk memantau status cucian Anda secara langsung dari dashboard, melacak pengeluaran, mendapatkan notifikasi pembayaran, dan promo khusus.
            </p>
            <div class="space-y-3 pt-2">
                <div class="flex items-center gap-3">
                    <i data-lucide="check-circle" class="w-5 h-5 text-[#8cc63f]"></i>
                    <span class="text-gray-200">Pantau status laundry real-time</span>
                </div>
                <div class="flex items-center gap-3">
                    <i data-lucide="check-circle" class="w-5 h-5 text-[#8cc63f]"></i>
                    <span class="text-gray-200">Riwayat transaksi &amp; laporan otomatis</span>
                </div>
                <div class="flex items-center gap-3">
                    <i data-lucide="check-circle" class="w-5 h-5 text-[#8cc63f]"></i>
                    <span class="text-gray-200">Keamanan data &amp; kemudahan booking</span>
                </div>
            </div>
        </div>

        <!-- Right Side Form / Dashboard Link -->
        <div class="flex-1 w-full max-w-md scroll-reveal-right">
            @auth
                <div class="bg-white/5 backdrop-blur-md border border-white/10 rounded-3xl p-8 md:p-10 text-center shadow-2xl space-y-6">
                    <div class="w-20 h-20 bg-[#8cc63f]/10 text-[#8cc63f] rounded-full flex items-center justify-center mx-auto">
                        <i data-lucide="user-check" class="w-10 h-10"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold">Welcome Back, {{ auth()->user()->name }}!</h3>
                        <p class="text-gray-300 text-sm mt-2">Anda sudah terdaftar sebagai member dan sedang login.</p>
                    </div>
                    <a href="{{ route('dashboard') }}" class="block w-full py-4 bg-[#8cc63f] hover:bg-[#7bb334] text-white font-bold rounded-2xl shadow-lg shadow-[#8cc63f]/30 transition-all duration-300 text-center">
                        Masuk ke Dashboard
                    </a>
                </div>
            @else
                <div class="bg-white/5 backdrop-blur-md border border-white/10 rounded-3xl p-8 md:p-10 shadow-2xl">
                    <h3 class="text-2xl font-bold mb-6 text-center">Pendaftaran Member</h3>
                    
                    @if ($errors->any())
                        <div class="bg-red-500/10 border border-red-500/20 text-red-300 rounded-xl p-4 mb-5 text-sm">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('register') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label for="reg-name" class="block text-xs font-semibold text-gray-300 uppercase tracking-wider mb-2 ml-1">Nama Lengkap</label>
                            <input 
                                type="text" 
                                name="name" 
                                id="reg-name"
                                class="w-full px-5 py-3.5 rounded-xl bg-white/5 border border-white/10 text-white placeholder-gray-500 focus:outline-none focus:border-[#8cc63f] focus:ring-1 focus:ring-[#8cc63f] transition duration-300"
                                placeholder="Masukkan nama lengkap"
                                value="{{ old('name') }}"
                                required
                            >
                        </div>
                        <div>
                            <label for="reg-email" class="block text-xs font-semibold text-gray-300 uppercase tracking-wider mb-2 ml-1">Alamat Email</label>
                            <input 
                                type="email" 
                                name="email" 
                                id="reg-email"
                                class="w-full px-5 py-3.5 rounded-xl bg-white/5 border border-white/10 text-white placeholder-gray-500 focus:outline-none focus:border-[#8cc63f] focus:ring-1 focus:ring-[#8cc63f] transition duration-300"
                                placeholder="nama@email.com"
                                value="{{ old('email') }}"
                                required
                            >
                        </div>
                        <div>
                            <label for="reg-password" class="block text-xs font-semibold text-gray-300 uppercase tracking-wider mb-2 ml-1">Kata Sandi</label>
                            <input 
                                type="password" 
                                name="password" 
                                id="reg-password"
                                class="w-full px-5 py-3.5 rounded-xl bg-white/5 border border-white/10 text-white placeholder-gray-500 focus:outline-none focus:border-[#8cc63f] focus:ring-1 focus:ring-[#8cc63f] transition duration-300"
                                placeholder="Min. 8 karakter"
                                required
                            >
                        </div>
                        <button type="submit" class="w-full py-4 bg-[#8cc63f] hover:bg-[#7bb334] text-white font-bold rounded-xl shadow-lg shadow-[#8cc63f]/20 transition-all duration-300 hover:-translate-y-0.5 mt-6">
                            Daftar Sekarang
                        </button>
                    </form>
                </div>
            @endauth
        </div>
    </div>
</section>

    <!-- Footer Section -->
    <footer id="footer" class="w-full bg-[#1b252f] text-gray-400 py-16 px-6 md:px-12 relative z-10 border-t border-slate-850">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
            <!-- Col 1 -->
            <div class="space-y-4">
                <img 
                    src="{{ asset('photo/logo.png') }}" 
                    alt="Logo"
                    class="h-12 w-auto object-contain filter brightness-0 invert"
                    onerror="this.src='https://via.placeholder.com/150x50?text=Laundry'"
                >
                <p class="text-sm leading-relaxed">
                    We deliver the best laundry and dry cleaning services right to your doorstep. Enjoy high-quality cleaning today!
                </p>
                <div class="flex items-center gap-3 pt-2">
                    <a href="#" class="w-9 h-9 rounded-full bg-white/5 hover:bg-[#8cc63f] hover:text-white flex items-center justify-center transition">
                        <i data-lucide="facebook" class="w-4 h-4"></i>
                    </a>
                    <a href="#" class="w-9 h-9 rounded-full bg-white/5 hover:bg-[#8cc63f] hover:text-white flex items-center justify-center transition">
                        <i data-lucide="twitter" class="w-4 h-4"></i>
                    </a>
                    <a href="#" class="w-9 h-9 rounded-full bg-white/5 hover:bg-[#8cc63f] hover:text-white flex items-center justify-center transition">
                        <i data-lucide="instagram" class="w-4 h-4"></i>
                    </a>
                </div>
            </div>

            <!-- Col 2 -->
            <div class="space-y-4">
                <h4 class="text-white font-bold text-lg tracking-wider border-l-4 border-[#8cc63f] pl-3">SERVICES</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="#services" class="hover:text-white transition">Wash & Fold Laundry</a></li>
                    <li><a href="#services" class="hover:text-white transition">Premium Dry Cleaning</a></li>
                    <li><a href="#services" class="hover:text-white transition">Professional Pressing</a></li>
                    <li><a href="#services" class="hover:text-white transition">Carpet & Rug Wash</a></li>
                </ul>
            </div>

            <!-- Col 3 -->
            <div class="space-y-4">
                <h4 class="text-white font-bold text-lg tracking-wider border-l-4 border-[#8cc63f] pl-3">QUICK LINKS</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="#" class="hover:text-white transition">Home</a></li>
                    <li><a href="#about" class="hover:text-white transition">About Us</a></li>
                    <li><a href="#pricing" class="hover:text-white transition">Pricing Tables</a></li>
                    <li><a href="#testimonials" class="hover:text-white transition">Customer Reviews</a></li>
                </ul>
            </div>

            <!-- Col 4 -->
            <div class="space-y-4">
                <h4 class="text-white font-bold text-lg tracking-wider border-l-4 border-[#8cc63f] pl-3">CONTACT INFO</h4>
                <ul class="space-y-3 text-sm">
                    <li class="flex items-start gap-3">
                        <i data-lucide="map-pin" class="w-5 h-5 text-[#8cc63f] flex-shrink-0 mt-0.5"></i>
                        <span>241 Taxi, newyork 10012, USA</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <i data-lucide="phone" class="w-5 h-5 text-[#8cc63f] flex-shrink-0"></i>
                        <span>+44 567 890123</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <i data-lucide="mail" class="w-5 h-5 text-[#8cc63f] flex-shrink-0"></i>
                        <span>info@example.com</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Copyright -->
        <div class="max-w-7xl mx-auto border-t border-white/5 mt-12 pt-6 text-center text-sm">
            <span>© 2026 Laundry Altek. All Rights Reserved.</span>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        // Initialize Lucide Icons
        lucide.createIcons();

        // Mobile Menu Toggle
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');

        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // Carousel Logic
        const slides = document.querySelectorAll('.slide');
        const dots = document.querySelectorAll('.dot');
        const prevBtn = document.getElementById('prev-slide');
        const nextBtn = document.getElementById('next-slide');
        let currentSlide = 0;
        let slideInterval;

        function showSlide(index) {
            // Remove active classes
            slides[currentSlide].classList.remove('active');
            dots[currentSlide].classList.remove('active');
            dots[currentSlide].classList.replace('bg-[#8cc63f]', 'bg-white/40');
            dots[currentSlide].classList.add('bg-white/40');

            // Reset animations on outgoing slide text
            const prevTextElements = slides[currentSlide].querySelectorAll('.slide-animate');
            prevTextElements.forEach(el => {
                el.classList.remove('animate-fade-up');
            });

            // Set new slide
            currentSlide = (index + slides.length) % slides.length;
            slides[currentSlide].classList.add('active');
            dots[currentSlide].classList.add('active');
            dots[currentSlide].classList.replace('bg-white/40', 'bg-[#8cc63f]');

            // Trigger animations on incoming slide text
            const activeTextElements = slides[currentSlide].querySelectorAll('.slide-animate');
            activeTextElements.forEach((el, i) => {
                // Stagger delay
                el.style.animationDelay = `${i * 150}ms`;
                el.classList.add('animate-fade-up');
            });
        }

        function nextSlide() {
            showSlide(currentSlide + 1);
        }

        // Event Listeners for Buttons
        nextBtn.addEventListener('click', () => {
            nextSlide();
            resetInterval();
        });

        const prevSlideFunc = () => {
            showSlide(currentSlide - 1);
        }

        prevBtn.addEventListener('click', () => {
            prevSlideFunc();
            resetInterval();
        });

        // Event Listeners for Dots
        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                showSlide(index);
                resetInterval();
            });
        });

        // Auto play function
        function startInterval() {
            slideInterval = setInterval(nextSlide, 6000); // changes every 6 seconds
        }

        function resetInterval() {
            clearInterval(slideInterval);
            startInterval();
        }

        // Initialize Slider & Dots state
        dots[0].classList.replace('bg-white/40', 'bg-[#8cc63f]');
        startInterval();

        // Intersection Observer for Scroll Reveal Animations
        const revealElements = document.querySelectorAll('.scroll-reveal, .scroll-reveal-left, .scroll-reveal-right');
        
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    revealObserver.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.15,
            rootMargin: "0px 0px -50px 0px"
        });

        revealElements.forEach(el => revealObserver.observe(el));
    </script>
</body>
</html>