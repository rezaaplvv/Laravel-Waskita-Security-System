<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - PT Waskita Angkasa Satya</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @stack('styles')
</head>
<body class="bg-gray-50 font-sans antialiased text-gray-900">

    <div class="flex h-screen overflow-hidden">

        <div id="sidebarBackdrop" class="fixed inset-0 bg-black/50 z-20 hidden md:hidden"></div>

        @unless(Auth::user()->role === 'personel')
        <aside id="sidebar" class="fixed inset-y-0 left-0 z-30 w-64 transform -translate-x-full md:translate-x-0 md:static md:inset-auto bg-gray-900 text-white flex flex-col border-r border-gray-800 shadow-xl transition-transform">
            
            <div class="h-20 flex items-center justify-center border-b border-gray-800">
                <h1 class="text-lg font-black tracking-widest uppercase text-transparent bg-clip-text bg-gradient-to-r from-amber-400 to-amber-200">
                    Security System
                </h1>
            </div>

            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto custom-scrollbar">
                
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-amber-400 text-gray-900 font-bold shadow-lg shadow-amber-400/20' : 'text-gray-400 hover:bg-gray-800 hover:text-white font-medium' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('admin.personel.index') }}" class="block px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.personel.*') ? 'bg-amber-400 text-gray-900 font-bold shadow-lg shadow-amber-400/20' : 'text-gray-400 hover:bg-gray-800 hover:text-white font-medium' }}">
                        Data Personel
                    </a>
                    <a href="{{ route('admin.report.index') }}" class="block px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.report.*') ? 'bg-amber-400 text-gray-900 font-bold shadow-lg shadow-amber-400/20' : 'text-gray-400 hover:bg-gray-800 hover:text-white font-medium' }}">
                        Data Laporan
                    </a>
                    <a href="{{ route('admin.attendance.index') }}" class="block px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.attendance.*') ? 'bg-amber-400 text-gray-900 font-bold shadow-lg shadow-amber-400/20' : 'text-gray-400 hover:bg-gray-800 hover:text-white font-medium' }}">
                        Data Absensi
                    </a>
                    <a href="{{ route('admin.client.index') }}" class="block px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.client.*') ? 'bg-amber-400 text-gray-900 font-bold shadow-lg shadow-amber-400/20' : 'text-gray-400 hover:bg-gray-800 hover:text-white font-medium' }}">
                        Data Lokasi & Klien
                    </a>

                @elseif(Auth::user()->role === 'klien')
                    <a href="{{ route('klien.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('klien.dashboard') ? 'bg-amber-500 text-gray-900 font-bold shadow-md shadow-amber-500/20' : 'text-gray-400 hover:text-amber-400 hover:bg-gray-800 font-semibold' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" /></svg>
                        Dashboard
                    </a>
                    <a href="{{ route('klien.team') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('klien.team') ? 'bg-amber-500 text-gray-900 font-bold shadow-md shadow-amber-500/20' : 'text-gray-400 hover:text-amber-400 hover:bg-gray-800 font-semibold' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" /></svg>
                        Tim Penjaga
                    </a>
                    <a href="{{ route('klien.attendance') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('klien.attendance') ? 'bg-amber-500 text-gray-900 font-bold shadow-md shadow-amber-500/20' : 'text-gray-400 hover:text-amber-400 hover:bg-gray-800 font-semibold' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" /></svg>
                        Log Kehadiran
                    </a>
                    <a href="{{ route('klien.report') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('klien.report') ? 'bg-amber-500 text-gray-900 font-bold shadow-md shadow-amber-500/20' : 'text-gray-400 hover:text-amber-400 hover:bg-gray-800 font-semibold' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                        Laporan Lapangan
                    </a>

                @elseif(Auth::user()->role === 'supervisor')
                    <a href="{{ route('supervisor.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('supervisor.dashboard') ? 'bg-amber-500 text-gray-900 font-bold shadow-md shadow-amber-500/20' : 'text-gray-400 hover:text-amber-400 hover:bg-gray-800 font-semibold' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" /></svg>
                        Pusat Komando
                    </a>
                    <a href="{{ route('supervisor.attendance.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('supervisor.attendance.*') ? 'bg-amber-500 text-gray-900 font-bold shadow-md shadow-amber-500/20' : 'text-gray-400 hover:text-amber-400 hover:bg-gray-800 font-semibold' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" /></svg>
                        Validasi Kehadiran
                    </a>
                    <a href="{{ route('supervisor.report.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('supervisor.report.*') ? 'bg-amber-500 text-gray-900 font-bold shadow-md shadow-amber-500/20' : 'text-gray-400 hover:text-amber-400 hover:bg-gray-800 font-semibold' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                        Tindak Lanjut Laporan
                    </a>

                @elseif(Auth::user()->role === 'personel')
                    <a href="{{ route('personel.dashboard') }}" class="block px-4 py-3 rounded-xl transition-all {{ request()->routeIs('personel.dashboard') ? 'bg-amber-400 text-gray-900 font-bold shadow-lg shadow-amber-400/20' : 'text-gray-400 hover:bg-gray-800 hover:text-white font-medium' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('personel.report.index') }}" class="block px-4 py-3 rounded-xl transition-all {{ request()->routeIs('personel.report.index') ? 'bg-amber-400 text-gray-900 font-bold shadow-lg shadow-amber-400/20' : 'text-gray-400 hover:bg-gray-800 hover:text-white font-medium' }}">
                        Riwayat Laporan
                    </a>
                @endif
                
            </nav>

            <div class="p-4 border-t border-gray-800">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-3 text-sm font-bold text-red-400 hover:text-white hover:bg-red-500 rounded-xl transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                        </svg>
                        Keluar Sistem
                    </button>
                </form>
            </div>
        </aside>
        @endunless

        <div class="flex-1 flex flex-col relative overflow-hidden bg-gray-50">
            
            @unless(Auth::user()->role === 'personel')
            <header class="h-20 bg-gray-900 flex items-center justify-between px-8 z-10 shadow-md relative overflow-hidden border-b border-gray-800">
                
                <button id="sidebarToggle" class="md:hidden p-2 rounded-md text-white hover:bg-gray-800 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <div class="absolute top-0 right-32 w-64 h-64 bg-amber-500/5 rounded-full blur-3xl pointer-events-none"></div>

                <div class="flex items-center gap-4 relative z-10">
                    <div class="w-1.5 h-8 bg-amber-400 rounded-full shadow-[0_0_10px_rgba(251,191,36,0.4)]"></div>
                    <h2 class="text-xl font-black text-white tracking-wide">
                        @yield('header')
                    </h2>
                </div>

                <div class="flex items-center gap-4 relative z-10">
                    <div class="flex items-center gap-3 bg-gray-800 hover:bg-gray-700 border border-gray-700 p-1.5 pr-5 rounded-full transition-colors shadow-inner cursor-default">
                        
                        @if(Auth::user()->foto_profil)
                            <img src="{{ asset('storage/' . Auth::user()->foto_profil) }}" class="w-9 h-9 rounded-full object-cover border border-amber-400">
                        @else
                            <div class="w-9 h-9 rounded-full bg-amber-400 text-gray-900 flex items-center justify-center font-black text-sm">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                        @endif
                        
                        <div class="hidden md:block text-right">
                            <p class="text-sm font-bold text-white leading-none">{{ Auth::user()->name }}</p>
                            <p class="text-[10px] font-black text-amber-400 mt-1 uppercase tracking-wider">{{ Auth::user()->role }}</p>
                        </div>

                    </div>
                </div>
            </header>
            @endunless

            <main class="flex-1 overflow-y-auto {{ Auth::user()->role === 'personel' ? 'p-0 bg-gray-50' : 'p-8' }} relative">
                @yield('content')
            </main>
            
        </div>
    </div>

    @stack('scripts')
</body>
</html>