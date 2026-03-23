<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-bold text-3xl text-slate-100 tracking-tight">
                {{ __('Dashboard') }}
            </h2>
            <p class="mt-1 text-sm text-slate-400 font-medium">Here's what's happening today.</p>
        </div>
        <div class="flex items-center space-x-3">
            <button class="px-4 py-2 bg-slate-800/80 border border-slate-700 text-slate-300 text-sm font-semibold rounded-xl hover:bg-slate-700 transition-colors shadow-sm flex items-center">
                <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                Create New
            </button>
            <button class="px-4 py-2 bg-indigo-500 text-white text-sm font-semibold rounded-xl hover:bg-indigo-600 transition-colors shadow-lg shadow-indigo-500/20">
                Generate Report
            </button>
        </div>
    </x-slot>

    <!-- Stats Section -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Stat Card 1 -->
        <div class="bg-slate-800/60 backdrop-blur-xl border border-slate-700/50 p-6 rounded-2xl shadow-xl relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-4 opacity-10 transform translate-x-2 -translate-y-2 group-hover:scale-110 transition-transform duration-500">
                <svg class="w-24 h-24 text-indigo-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
            </div>
            <div class="relative z-10">
                <p class="text-sm font-semibold text-slate-400 uppercase tracking-wider mb-1">Total Users</p>
                <div class="flex items-baseline space-x-2">
                    <h3 class="text-3xl font-bold text-slate-100">1,204</h3>
                    <span class="text-sm font-medium text-green-400 flex items-center">
                        <svg class="w-3 h-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                        12%
                    </span>
                </div>
            </div>
        </div>

        <!-- Stat Card 2 -->
        <div class="bg-slate-800/60 backdrop-blur-xl border border-slate-700/50 p-6 rounded-2xl shadow-xl relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-4 opacity-10 transform translate-x-2 -translate-y-2 group-hover:scale-110 transition-transform duration-500">
                <svg class="w-24 h-24 text-purple-400" fill="currentColor" viewBox="0 0 24 24"><path d="M13 2.05v3.03c3.39 6 3.39 6 6.92 0 .9-.18 1.75-.5 2.54l2.67 1.53c.56-1.24.83-2.61.83-4.07 0-5.18-3.95-9.45-9-9.95zM12 19c-3.87 0-7-3.13-7-7 0-3.53 2.61-6.43 6-6.92V2.05c-5.06.5-9 4.76-9 9.95 0 5.52 4.47 10 9.99 10 3.31 0 6.24-1.61 8.06-4.09l-2.6-1.53C16.17 17.98 14.21 19 12 19z"/></svg>
            </div>
            <div class="relative z-10">
                <p class="text-sm font-semibold text-slate-400 uppercase tracking-wider mb-1">Sessions</p>
                <div class="flex items-baseline space-x-2">
                    <h3 class="text-3xl font-bold text-slate-100">8,430</h3>
                    <span class="text-sm font-medium text-green-400 flex items-center">
                        <svg class="w-3 h-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                        8.5%
                    </span>
                </div>
            </div>
        </div>

        <!-- Stat Card 3 -->
        <div class="bg-gradient-to-br from-indigo-500/20 to-purple-600/20 border border-indigo-500/30 p-6 rounded-2xl shadow-xl relative overflow-hidden group text-white">
            <div class="absolute top-0 right-0 p-4 opacity-20 transform translate-x-2 -translate-y-2 group-hover:scale-110 transition-transform duration-500">
                <svg class="w-24 h-24 text-indigo-400" fill="currentColor" viewBox="0 0 24 24"><path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zm6.93 6h-2.95a15.65 15.65 0 00-1.38-3.56A8.03 8.03 0 0118.92 8zM12 4.04c.83 1.2 1.48 2.53 1.91 3.96h-3.82c.43-1.43 1.08-2.76 1.91-3.96zM4.26 14C4.1 13.36 4 12.69 4 12s.1-1.36.26-2h3.38c-.08.66-.14 1.32-.14 2s.06 1.34.14 2H4.26zm.82 2h2.95c.32 1.25.78 2.45 1.38 3.56A7.987 7.987 0 015.08 16zm2.95-8H5.08a7.987 7.987 0 013.9-3.56C8.37 5.55 7.91 6.75 7.59 8zM12 19.96c-.83-1.2-1.48-2.53-1.91-3.96h3.82c-.43 1.43-1.08 2.76-1.91 3.96zM14.34 14H9.66c-.09-.66-.16-1.32-.16-2s.07-1.34.16-2h4.68c.09.66.16 1.32.16 2s-.07 1.34-.16 2zm.25 5.56c.6-1.11 1.06-2.31 1.38-3.56h2.95a8.03 8.03 0 01-4.33 3.56zM16.36 14c.08-.66.14-1.32.14-2s-.06-1.34-.14-2h3.38c.16.64.26 1.31.26 2s-.1 1.36-.26 2h-3.38z"/></svg>
            </div>
            <div class="relative z-10">
                <p class="text-sm font-medium text-indigo-300 uppercase tracking-wider mb-1">Active Projects</p>
                <div class="flex items-baseline space-x-2">
                    <h3 class="text-3xl font-bold text-slate-100">42</h3>
                    <span class="text-sm font-medium text-indigo-300/80">/ 50 limit</span>
                </div>
                <div class="mt-4 w-full bg-slate-900/50 rounded-full h-1.5">
                    <div class="bg-indigo-400 h-1.5 rounded-full" style="width: 84%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-slate-800/60 backdrop-blur-xl border border-slate-700/50 p-6 rounded-2xl shadow-xl">
            <h3 class="text-lg font-bold text-slate-100 mb-6 border-b border-slate-700 pb-4">Activity Overview</h3>
            <div class="h-64 flex items-center justify-center border-2 border-dashed border-slate-700 rounded-xl bg-slate-800/50">
                <p class="text-slate-500 font-medium text-sm">Chart rendering visualization placeholder</p>
            </div>
        </div>

        <div class="bg-slate-800/60 backdrop-blur-xl border border-slate-700/50 p-6 rounded-2xl shadow-xl">
            <h3 class="text-lg font-bold text-slate-100 mb-6 border-b border-slate-700 pb-4">Recent Notifications</h3>
            <ul class="space-y-5">
                <li class="flex items-start">
                    <div class="flex-shrink-0 w-8 h-8 rounded-full bg-indigo-500/20 flex items-center justify-center text-indigo-400 mt-0.5 ring-1 ring-indigo-500/30">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-semibold text-slate-200">New system update installed</p>
                        <p class="text-xs text-slate-400 mt-1">2 hours ago</p>
                    </div>
                </li>
                <li class="flex items-start">
                    <div class="flex-shrink-0 w-8 h-8 rounded-full bg-purple-500/20 flex items-center justify-center text-purple-400 mt-0.5 ring-1 ring-purple-500/30">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-semibold text-slate-200">Weekly report generated</p>
                        <p class="text-xs text-slate-400 mt-1">Yesterday at 4:30 PM</p>
                    </div>
                </li>
                <li class="flex items-start">
                    <div class="flex-shrink-0 w-8 h-8 rounded-full bg-green-500/20 flex items-center justify-center text-green-400 mt-0.5 ring-1 ring-green-500/30">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-semibold text-slate-200">New user registered</p>
                        <p class="text-xs text-slate-400 mt-1">2 days ago</p>
                    </div>
                </li>
            </ul>
            <button class="mt-6 w-full py-2.5 bg-slate-700/40 hover:bg-slate-700 text-slate-300 text-sm font-semibold rounded-xl transition-colors border border-slate-600/50">
                View All
            </button>
        </div>
    </div>
</x-app-layout>
