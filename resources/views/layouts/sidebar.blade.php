<aside class="flex-shrink-0 w-72 bg-slate-800/60 backdrop-blur-2xl border-r border-slate-700/50 flex flex-col h-full shadow-2xl z-50">
    <div class="h-24 flex items-center px-8 flex-shrink-0">
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 group">
            <div class="w-10 h-10 bg-gradient-to-tr from-indigo-500 to-purple-500 rounded-xl flex items-center justify-center shadow-lg transform group-hover:-translate-y-0.5 transition-all duration-300">
                <x-application-logo class="w-6 h-6 fill-current text-white" />
            </div>
            <span class="text-2xl font-bold text-slate-100 tracking-tight">
                {{ config('app.name', 'MyApp') }}
            </span>
        </a>
    </div>

    <nav class="flex-1 px-5 py-6 space-y-2 overflow-y-auto">
        <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-4 px-3">Menu</div>
        
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 px-4 py-3.5 rounded-xl transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-indigo-500/10 text-indigo-400 shadow-sm border border-indigo-500/20' : 'text-slate-400 hover:bg-slate-700/50 hover:text-slate-200' }}">
            <svg class="w-5 h-5 {{ request()->routeIs('dashboard') ? 'text-indigo-400' : 'text-slate-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            <span class="font-medium">Dashboard</span>
        </a>

        <!-- Phase 1 Links -->
        <a href="{{ route('klanten.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('klanten.*') ? 'bg-indigo-500/10 text-indigo-400 shadow-sm border border-indigo-500/20' : 'text-slate-400 hover:bg-slate-700/50 hover:text-slate-200' }}">
            <svg class="w-5 h-5 {{ request()->routeIs('klanten.*') ? 'text-indigo-400' : 'text-slate-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            <span class="text-sm font-medium">Klanten</span>
        </a>

        <a href="{{ route('reizen.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('reizen.*') ? 'bg-indigo-500/10 text-indigo-400 shadow-sm border border-indigo-500/20' : 'text-slate-400 hover:bg-slate-700/50 hover:text-slate-200' }}">
            <svg class="w-5 h-5 {{ request()->routeIs('reizen.*') ? 'text-indigo-400' : 'text-slate-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span class="text-sm font-medium">Reizen</span>
        </a>

        <a href="{{ route('accommodaties.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('accommodaties.*') ? 'bg-indigo-500/10 text-indigo-400 shadow-sm border border-indigo-500/20' : 'text-slate-400 hover:bg-slate-700/50 hover:text-slate-200' }}">
            <svg class="w-5 h-5 {{ request()->routeIs('accommodaties.*') ? 'text-indigo-400' : 'text-slate-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            <span class="text-sm font-medium">Accommodaties</span>
        </a>

        <a href="{{ route('boekingen.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('boekingen.*') ? 'bg-indigo-500/10 text-indigo-400 shadow-sm border border-indigo-500/20' : 'text-slate-400 hover:bg-slate-700/50 hover:text-slate-200' }}">
            <svg class="w-5 h-5 {{ request()->routeIs('boekingen.*') ? 'text-indigo-400' : 'text-slate-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            <span class="text-sm font-medium">Boekingen</span>
        </a>

        <a href="{{ route('facturen.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('facturen.*') ? 'bg-indigo-500/10 text-indigo-400 shadow-sm border border-indigo-500/20' : 'text-slate-400 hover:bg-slate-700/50 hover:text-slate-200' }}">
            <svg class="w-5 h-5 {{ request()->routeIs('facturen.*') ? 'text-indigo-400' : 'text-slate-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            <span class="text-sm font-medium">Facturen</span>
        </a>

        @if(Auth::user() && Auth::user()->role === 'admin')
            <div class="mt-8 mb-4 px-3 pt-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Administration</div>
            <a href="{{ route('admin.users.index') }}" class="flex items-center space-x-3 px-4 py-3.5 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-indigo-500/10 text-indigo-400 shadow-sm border border-indigo-500/20' : 'text-slate-400 hover:bg-slate-700/50 hover:text-slate-200' }}">
                <svg class="w-5 h-5 {{ request()->routeIs('admin.users.*') ? 'text-indigo-400' : 'text-slate-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                <span class="font-medium">User Management</span>
            </a>
        @endif
    </nav>

    <div class="p-5 flex-shrink-0">
        <div class="p-4 bg-slate-800/50 border border-slate-700/50 rounded-2xl shadow-sm">
            <div class="flex items-center space-x-3 mb-4">
                <div class="w-10 h-10 rounded-full bg-gradient-to-r from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold shadow-md ring-2 ring-slate-800">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="flex-1 overflow-hidden">
                    <h4 class="text-sm font-bold text-slate-200 truncate">{{ Auth::user()->name }}</h4>
                    <p class="text-xs text-slate-400 truncate">{{ Auth::user()->email }}</p>
                </div>
            </div>
            
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center space-x-2 px-4 py-2 bg-slate-700/50 border border-slate-600 text-slate-300 rounded-xl hover:bg-red-500/10 hover:text-red-400 hover:border-red-500/30 transition-all duration-200 shadow-sm group">
                    <svg class="w-4 h-4 group-hover:text-red-400 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    <span class="text-sm font-medium">Log out</span>
                </button>
            </form>
        </div>
    </div>
</aside>
