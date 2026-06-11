<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PT Waskita Angkasa Satya</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        /* ========================================== */
        /* 1. ANIMASI PERGERAKAN GRADIENT JELAS (LAVA) */
        /* ========================================== */
        @keyframes gradientLava {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* 2. ANIMASI MASUK DI PERLAMBAT (1.2s) */
        @keyframes fadeInUp {
            0% { opacity: 0; transform: translateY(50px); filter: blur(10px); }
            100% { opacity: 1; transform: translateY(0); filter: blur(0); }
        }
        @keyframes fadeInRight {
            0% { opacity: 0; transform: translateX(-50px); }
            100% { opacity: 1; transform: translateX(0); }
        }
        @keyframes floatLogo {
            0% { transform: translateY(0px) rotate(3deg); }
            50% { transform: translateY(-20px) rotate(0deg); }
            100% { transform: translateY(0px) rotate(3deg); }
        }

        /* ========================================== */
        /* 3. UTILITY CLASSES (Warna Terang)          */
        /* ========================================== */
        .animate-gradient-vibrant {
            background-color: #fbc539;
        }
        
        .animate-fade-up { 
            animation: fadeInUp 1.2s cubic-bezier(0.22, 1, 0.36, 1) forwards; 
            opacity: 0; 
        }
        
        .animate-fade-right { 
            animation: fadeInRight 1.2s cubic-bezier(0.22, 1, 0.36, 1) forwards; 
            opacity: 0; 
        }
        
        .animate-float-logo { 
            animation: floatLogo 8s ease-in-out infinite; 
        }

        /* Delay Sekuensial */
        .delay-100 { animation-delay: 150ms; }
        .delay-200 { animation-delay: 300ms; }
        .delay-300 { animation-delay: 450ms; }
        .delay-400 { animation-delay: 600ms; }
        .delay-500 { animation-delay: 750ms; }

        /* Custom Styling */
        .text-stroke-white {
            -webkit-text-stroke: 1px rgba(255,255,255,0.6);
        }
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased text-gray-900 selection:bg-amber-400 selection:text-gray-900">

    <div class="flex min-h-screen w-full overflow-hidden">

        <div class="hidden lg:flex w-1/2 relative bg-gray-900 flex-col justify-center items-center p-12 overflow-hidden z-10">
            <div class="absolute inset-0 bg-gradient-to-br from-gray-900 via-gray-800 to-black z-0"></div>
            <div class="absolute -top-40 -left-40 w-[500px] h-[500px] rounded-full bg-amber-500/10 blur-[100px] animate-pulse"></div>
            
            <div class="relative z-10 flex flex-col items-center text-center">
                <div class="w-28 h-28 bg-amber-400 rounded-[2rem] shadow-[0_20px_50px_rgba(251,191,36,0.4)] flex items-center justify-center mb-10 animate-float-logo">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-14 h-14 text-gray-900">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                    </svg>
                </div>
                
                <h1 class="text-5xl font-black text-white tracking-tighter mb-6 uppercase animate-fade-up delay-100 italic">Waskita <span class="text-amber-400 text-stroke-white">Angkasa Satya</span></h1>
                <div class="w-20 h-1 bg-amber-400 mb-6 rounded-full animate-fade-right delay-200"></div>
                <p class="text-xl text-gray-400 font-medium max-w-md leading-relaxed animate-fade-up delay-300">
                    Pusat Sistem Informasi Manajemen Keamanan Terintegrasi & Monitoring Lapangan Real-Time.
                </p>
            </div>
            
            <div class="absolute bottom-10 text-[10px] text-gray-500 font-black uppercase tracking-[0.2em] z-10 animate-fade-up delay-500">
                &copy; {{ date('Y') }} PT Waskita Angkasa Satya. Authorized Personnel Only.
            </div>
        </div>

        <div class="w-full lg:w-1/2 relative flex flex-col items-center justify-center p-6 sm:p-12 bg-gradient-to-br from-gray-900 via-gray-800 to-black lg:bg-none lg:bg-[#fbc539] z-0">
            
            <!-- Elemen Logo Khusus Mobile -->
            <div class="lg:hidden flex flex-col items-center text-center w-full mb-8 animate-fade-up">
                <div class="w-20 h-20 bg-amber-400 rounded-2xl shadow-[0_10px_30px_rgba(251,191,36,0.5)] flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 text-gray-900">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                    </svg>
                </div>
                <h1 class="text-3xl font-black text-white tracking-tighter uppercase italic">Waskita <span class="text-amber-400 text-stroke-white drop-shadow-md">Angkasa Satya</span></h1>
            </div>

            <div class="w-full max-w-md bg-white/90 backdrop-blur-2xl p-10 sm:p-12 rounded-[3rem] shadow-[0_30px_100px_rgba(0,0,0,0.12)] border border-white/80 relative z-10 animate-fade-up delay-100">
                
                <div class="mb-10">
                    <h2 class="text-4xl font-black text-gray-900 tracking-tight animate-fade-right delay-100">Selamat Datang</h2>
                    <p class="text-gray-500 mt-3 font-medium animate-fade-right delay-200">Silakan otentikasi akun Anda untuk mengakses portal kendali.</p>
                </div>

                @if ($errors->any())
                    <div class="mb-8 p-5 rounded-2xl bg-red-50 border border-red-100 flex items-start gap-4 animate-fade-up shadow-inner">
                        <div class="w-10 h-10 shrink-0 bg-red-100 rounded-full flex items-center justify-center border border-red-200">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5 text-red-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-black text-red-800 uppercase tracking-widest mb-1">Akses Ditolak</p>
                            <p class="text-xs text-red-600 font-bold leading-relaxed">{{ $errors->first() }}</p>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-7">
                    @csrf

                    <div class="animate-fade-up delay-200">
                        <label for="email" class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.15em] mb-2 ml-1">Kredensial Email</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none group-focus-within:text-amber-500 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-gray-300">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                                </svg>
                            </div>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="Masukkan Email Anda" class="block w-full pl-14 pr-6 py-4.5 bg-gray-50 border-2 border-transparent rounded-2xl text-sm font-bold text-gray-900 focus:ring-0 focus:border-amber-400 focus:bg-white transition-all shadow-innerselection:bg-amber-100">
                        </div>
                    </div>

                    <div class="animate-fade-up delay-300">
                        <label for="password" class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.15em] mb-2 ml-1">Kata Sandi Rahasia</label>
                        <div class="relative group text-gray-400 focus-within:text-amber-500 transition-colors">
                            <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 transition-colors">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                </svg>
                            </div>
                            <input id="password" type="password" name="password" required placeholder="Masukkan Kata Sandi Anda" class="block w-full pl-14 pr-14 py-4.5 bg-gray-50 border-2 border-transparent rounded-2xl text-sm font-bold text-gray-900 focus:ring-0 focus:border-amber-400 focus:bg-white transition-all shadow-inner">
                            <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-5 flex items-center text-gray-300 hover:text-amber-500 focus:outline-none transition-colors">
                                <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center animate-fade-up delay-400">
                        <label for="remember_me" class="flex items-center cursor-pointer group">
                            <div class="relative">
                                <input id="remember_me" type="checkbox" name="remember" class="sr-only">
                                <div class="w-5 h-5 bg-gray-100 border-2 border-gray-200 rounded group-hover:border-amber-400 transition-colors"></div>
                                <div class="check-icon absolute inset-0 hidden items-center justify-center text-amber-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="currentColor" class="w-3 h-3">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                    </svg>
                                </div>
                            </div>
                            <span class="ml-3 text-xs font-black text-gray-500 uppercase tracking-widest group-hover:text-gray-900 transition-colors">Ingat Perangkat Ini</span>
                        </label>
                    </div>

                    <button type="submit" class="w-full group relative flex justify-center items-center py-5 px-6 rounded-2xl bg-gray-900 text-white overflow-hidden transition-all hover:scale-[1.02] active:scale-95 shadow-xl shadow-gray-900/10 animate-fade-up delay-500 z-10">
                        <div class="absolute inset-0 bg-gradient-to-r from-amber-500 to-amber-300 opacity-0 group-hover:opacity-100 transition-opacity duration-500 z-0"></div>
                        
                        <span class="relative z-10 flex items-center gap-3 text-sm font-black uppercase tracking-[0.2em] group-hover:text-gray-900 transition-colors">
                            Masuk Portal
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-4 h-4 transition-transform group-hover:translate-x-1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                            </svg>
                        </span>
                    </button>
                </form>

            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />`;
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />`;
            }
        }
        
        // Custom Checkbox Logic
        const checkbox = document.getElementById('remember_me');
        const checkIcon = document.querySelector('.check-icon');
        checkbox.addEventListener('change', function() {
            if(this.checked) checkIcon.classList.remove('hidden');
            else checkIcon.classList.add('hidden');
        });
    </script>
</body>
</html>
