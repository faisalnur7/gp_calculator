<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 min-h-screen flex">

    <aside id="sidebar" class="fixed inset-y-0 left-0 z-40 w-64 bg-slate-900 flex flex-col transition-transform -translate-x-full lg:translate-x-0">
        <div class="flex items-center gap-3 px-5 py-5 border-b border-slate-700/60">
            <div class="w-9 h-9 rounded-xl bg-amber-500 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                </svg>
            </div>
            <div>
                <p class="text-white font-semibold text-sm leading-tight">{{ config('app.name') }}</p>
                <p class="text-slate-400 text-xs">Management System</p>
            </div>
        </div>

        <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-1">
            <a href="/" @class(['flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition', 'bg-amber-500 text-white' => request()->is('/'), 'text-slate-300 hover:bg-slate-800 hover:text-white' => !request()->is('/')])>
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
            </a>

            <div class="pt-3 pb-1 px-3"><p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Catalogue</p></div>

            <a href="/jewellery-categories" @class(['flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition', 'bg-amber-500 text-white' => request()->is('jewellery-categories*'), 'text-slate-300 hover:bg-slate-800 hover:text-white' => !request()->is('jewellery-categories*')])>
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                Categories
            </a>

            <a href="/jewellery-items" @class(['flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition', 'bg-amber-500 text-white' => request()->is('jewellery-items*'), 'text-slate-300 hover:bg-slate-800 hover:text-white' => !request()->is('jewellery-items*')])>
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                Jewellery Items
            </a>

            <div class="pt-3 pb-1 px-3"><p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Operations</p></div>

            <a href="/shops" @class(['flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition', 'bg-amber-500 text-white' => request()->is('shops*'), 'text-slate-300 hover:bg-slate-800 hover:text-white' => !request()->is('shops*')])>
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                Shops
            </a>

            <div class="pt-3 pb-1 px-3"><p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Reports</p></div>

            <a href="/reports/shops" @class(['flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition', 'bg-amber-500 text-white' => request()->is('reports/shops*'), 'text-slate-300 hover:bg-slate-800 hover:text-white' => !request()->is('reports/shops*')])>
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Shop Report
            </a>

            <a href="/reports/inventory" @class(['flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition', 'bg-amber-500 text-white' => request()->is('reports/inventory*'), 'text-slate-300 hover:bg-slate-800 hover:text-white' => !request()->is('reports/inventory*')])>
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                Inventory Report
            </a>
        </nav>

        <div class="border-t border-slate-700/60 px-4 py-4">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-amber-500/20 flex items-center justify-center shrink-0">
                    <span class="text-amber-400 text-xs font-bold">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-white text-sm font-medium truncate">{{ auth()->user()->name }}</p>
                    <p class="text-slate-400 text-xs truncate">{{ auth()->user()->email }}</p>
                </div>
                <form method="POST" action="/logout">
                    @csrf
                    <button type="submit" title="Logout" class="text-slate-400 hover:text-red-400 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <div id="sidebar-overlay" class="fixed inset-0 z-30 bg-black/50 hidden lg:hidden" onclick="toggleSidebar()"></div>

    <div class="flex-1 flex flex-col lg:ml-64 min-h-screen">
        <header class="bg-white border-b border-slate-200 px-6 py-4 flex items-center gap-4 sticky top-0 z-20">
            <button onclick="toggleSidebar()" class="lg:hidden text-slate-500 hover:text-slate-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
            <div class="flex-1">
                <h1 class="text-lg font-semibold text-slate-800">@yield('heading')</h1>
                @hasSection('subheading')<p class="text-xs text-slate-400">@yield('subheading')</p>@endif
            </div>
            <div class="text-xs text-slate-400">{{ now()->format('D, d M Y') }}</div>
        </header>

        <main class="flex-1 p-6">
            @if(session('success'))
                <div class="mb-5 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm rounded-xl px-4 py-3">
                    <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    {{ session('success') }}
                </div>
            @endif
            @if($errors->any())
                <div class="mb-5 bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl px-4 py-3">
                    <ul class="list-disc list-inside space-y-1">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
            @endif
            @yield('content')
        </main>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('-translate-x-full');
            document.getElementById('sidebar-overlay').classList.toggle('hidden');
        }
    </script>
    @stack('scripts')
</body>
</html>
