<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Register | Laundry Altek</title>
    
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
            background-image: linear-gradient(135deg, rgba(15, 23, 42, 0.85) 0%, rgba(27, 37, 47, 0.95) 100%), url("https://images.unsplash.com/photo-1545173168-9f1947eebb7f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4 md:p-8">

    @php
        // Determine default active tab based on route, query param, or validation errors
        $activeTab = request()->routeIs('register') || request()->get('tab') === 'register' || $errors->has('name') ? 'register' : 'login';
    @endphp

    <div class="glass-card w-full max-w-5xl rounded-3xl overflow-hidden shadow-2xl flex flex-col md:flex-row min-h-[620px]">
        
        <!-- Left Side: Welcome Info & Branding -->
        <div class="w-full md:w-5/12 bg-gradient-to-br from-[#8cc63f]/90 to-[#7bb334]/95 p-8 md:p-12 flex flex-col justify-between text-white relative">
            <div class="absolute inset-0 bg-black/10 z-0"></div>
            
            <div class="relative z-10 space-y-6">
                <!-- Logo -->
                <a href="/" class="inline-block">
                    <img 
                        src="{{ asset('photo/logo.png') }}" 
                        alt="Logo"
                        class="h-16 w-auto object-contain brightness-0 invert"
                        onerror="this.src='https://via.placeholder.com/150x50?text=Laundry'"
                    >
                </a>
                
                <div class="space-y-3 pt-6">
                    <h2 class="text-3xl font-bold leading-tight">Clean Clothes,<br/>Happy Life!</h2>
                    <p class="text-white/80 text-sm leading-relaxed">
                        Nikmati layanan laundry & dry cleaning premium dengan proses mudah, cepat, dan terpercaya.
                    </p>
                </div>
            </div>

            <div class="relative z-10 pt-10 space-y-4 text-sm border-t border-white/20 mt-8">
                <div class="flex items-center gap-3">
                    <i data-lucide="shield-check" class="w-5 h-5 text-white/95"></i>
                    <span>Proses aman dan terjamin</span>
                </div>
                <div class="flex items-center gap-3">
                    <i data-lucide="clock" class="w-5 h-5 text-white/95"></i>
                    <span>Tepat waktu & andal</span>
                </div>
                <div class="flex items-center gap-3">
                    <i data-lucide="heart" class="w-5 h-5 text-white/95"></i>
                    <span>Pelayanan dengan ramah</span>
                </div>
            </div>
        </div>

        <!-- Right Side: Forms Section -->
        <div class="w-full md:w-7/12 p-8 md:p-12 flex flex-col justify-center bg-slate-950/40 text-white relative">
            
            <!-- Tab Switcher -->
            <div class="flex border-b border-white/10 mb-8">
                <button 
                    id="tab-login-btn" 
                    class="flex-1 pb-4 text-center font-bold tracking-wider uppercase text-sm border-b-2 transition duration-300 focus:outline-none {{ $activeTab === 'login' ? 'border-[#8cc63f] text-[#8cc63f]' : 'border-transparent text-gray-400 hover:text-white' }}"
                >
                    Sign In
                </button>
                <button 
                    id="tab-register-btn" 
                    class="flex-1 pb-4 text-center font-bold tracking-wider uppercase text-sm border-b-2 transition duration-300 focus:outline-none {{ $activeTab === 'register' ? 'border-[#8cc63f] text-[#8cc63f]' : 'border-transparent text-gray-400 hover:text-white' }}"
                >
                    Sign Up
                </button>
            </div>

            <!-- Validation Errors Block -->
            @if ($errors->any() && !$errors->has('name'))
                <div class="bg-red-500/10 border border-red-500/20 text-red-300 rounded-xl p-4 mb-6 text-sm">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form 1: LOGIN -->
            <form 
                id="login-form" 
                action="{{ route('login') }}" 
                method="POST" 
                class="space-y-5 {{ $activeTab === 'login' ? 'block' : 'hidden' }}"
            >
                @csrf
                <div class="space-y-2">
                    <label for="login-email" class="block text-xs font-semibold text-gray-300 uppercase tracking-wider ml-1">Email Address</label>
                    <input 
                        type="email" 
                        name="email" 
                        id="login-email"
                        class="w-full px-5 py-3.5 rounded-xl bg-white/5 border border-white/10 text-white placeholder-gray-500 focus:outline-none focus:border-[#8cc63f] focus:ring-1 focus:ring-[#8cc63f] transition duration-300" 
                        placeholder="nama@email.com" 
                        value="{{ old('email') }}"
                        required
                    >
                </div>

                <div class="space-y-2">
                    <label for="login-password" class="block text-xs font-semibold text-gray-300 uppercase tracking-wider ml-1">Password</label>
                    <input 
                        type="password" 
                        name="password" 
                        id="login-password"
                        class="w-full px-5 py-3.5 rounded-xl bg-white/5 border border-white/10 text-white placeholder-gray-500 focus:outline-none focus:border-[#8cc63f] focus:ring-1 focus:ring-[#8cc63f] transition duration-300" 
                        placeholder="••••••••" 
                        required
                    >
                </div>

                <div class="flex items-center justify-between text-xs py-1">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" class="rounded border-white/20 bg-transparent text-[#8cc63f] focus:ring-[#8cc63f] mr-2">
                        <span class="text-gray-400">Remember me</span>
                    </label>
                    <a href="#" class="text-gray-400 hover:text-[#8cc63f] transition">Forgot password?</a>
                </div>

                <button type="submit" class="w-full py-4 bg-[#8cc63f] hover:bg-[#7bb334] text-white font-bold rounded-xl shadow-lg shadow-[#8cc63f]/20 transition duration-300 mt-2">
                    Sign In
                </button>
            </form>

            <!-- Form 2: REGISTER -->
            <form 
                id="register-form" 
                action="{{ route('register') }}" 
                method="POST" 
                class="space-y-5 {{ $activeTab === 'register' ? 'block' : 'hidden' }}"
            >
                @csrf
                
                @if ($errors->has('name') || $errors->has('email') || $errors->has('password'))
                    <div class="bg-red-500/10 border border-red-500/20 text-red-300 rounded-xl p-4 mb-4 text-sm">
                        <ul class="list-disc list-inside space-y-1">
                            @if ($errors->has('name')) <li>{{ $errors->first('name') }}</li> @endif
                            @if ($errors->has('email')) <li>{{ $errors->first('email') }}</li> @endif
                            @if ($errors->has('password')) <li>{{ $errors->first('password') }}</li> @endif
                        </ul>
                    </div>
                @endif

                <div class="space-y-2">
                    <label for="reg-name" class="block text-xs font-semibold text-gray-300 uppercase tracking-wider ml-1">Full Name</label>
                    <input 
                        type="text" 
                        name="name" 
                        id="reg-name"
                        class="w-full px-5 py-3.5 rounded-xl bg-white/5 border border-white/10 text-white placeholder-gray-500 focus:outline-none focus:border-[#8cc63f] focus:ring-1 focus:ring-[#8cc63f] transition duration-300" 
                        placeholder="John Doe" 
                        value="{{ old('name') }}"
                        required
                    >
                </div>

                <div class="space-y-2">
                    <label for="reg-email" class="block text-xs font-semibold text-gray-300 uppercase tracking-wider ml-1">Email Address</label>
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

                <div class="space-y-2">
                    <label for="reg-password" class="block text-xs font-semibold text-gray-300 uppercase tracking-wider ml-1">Password</label>
                    <input 
                        type="password" 
                        name="password" 
                        id="reg-password"
                        class="w-full px-5 py-3.5 rounded-xl bg-white/5 border border-white/10 text-white placeholder-gray-500 focus:outline-none focus:border-[#8cc63f] focus:ring-1 focus:ring-[#8cc63f] transition duration-300" 
                        placeholder="Min. 8 karakter" 
                        required
                    >
                </div>

                <button type="submit" class="w-full py-4 bg-[#8cc63f] hover:bg-[#7bb334] text-white font-bold rounded-xl shadow-lg shadow-[#8cc63f]/20 transition duration-300 mt-2">
                    Sign Up
                </button>
            </form>

        </div>
    </div>

    <script>
        // Initialize Lucide Icons
        lucide.createIcons();

        // Switch Tabs Script
        const tabLoginBtn = document.getElementById('tab-login-btn');
        const tabRegisterBtn = document.getElementById('tab-register-btn');
        const loginForm = document.getElementById('login-form');
        const registerForm = document.getElementById('register-form');

        function activateLogin() {
            // Set tabs
            tabLoginBtn.className = "flex-1 pb-4 text-center font-bold tracking-wider uppercase text-sm border-b-2 border-[#8cc63f] text-[#8cc63f] transition duration-300 focus:outline-none";
            tabRegisterBtn.className = "flex-1 pb-4 text-center font-bold tracking-wider uppercase text-sm border-b-2 border-transparent text-gray-400 hover:text-white transition duration-300 focus:outline-none";
            
            // Show / Hide forms
            loginForm.classList.replace('hidden', 'block');
            registerForm.classList.replace('block', 'hidden');
        }

        function activateRegister() {
            // Set tabs
            tabRegisterBtn.className = "flex-1 pb-4 text-center font-bold tracking-wider uppercase text-sm border-b-2 border-[#8cc63f] text-[#8cc63f] transition duration-300 focus:outline-none";
            tabLoginBtn.className = "flex-1 pb-4 text-center font-bold tracking-wider uppercase text-sm border-b-2 border-transparent text-gray-400 hover:text-white transition duration-300 focus:outline-none";
            
            // Show / Hide forms
            registerForm.classList.replace('hidden', 'block');
            loginForm.classList.replace('block', 'hidden');
        }

        tabLoginBtn.addEventListener('click', activateLogin);
        tabRegisterBtn.addEventListener('click', activateRegister);
    </script>
</body>
</html>