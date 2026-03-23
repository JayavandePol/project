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
