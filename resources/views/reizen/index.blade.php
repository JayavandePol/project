<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-bold text-3xl text-slate-100 tracking-tight">
                {{ __('Reizen Overzicht') }}
            </h2>
            <p class="mt-1 text-sm text-slate-400 font-medium">Bekijk al onze prachtige reisbestemmingen.</p>
        </div>
        <div class="flex items-center space-x-3">
            <button class="px-4 py-2 bg-indigo-500 text-white text-sm font-semibold rounded-xl hover:bg-indigo-600 transition-colors shadow-lg shadow-indigo-500/20">
                Nieuwe Reis Aanmaken
            </button>
        </div>
    </x-slot>

    <div class="space-y-6">
        @if(session('error'))
            <div class="p-4 rounded-xl bg-red-500/10 border border-red-500/20 text-red-400 backdrop-blur-md shadow-lg">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($reizen as $reis)
                <div class="bg-slate-800/60 backdrop-blur-xl border border-slate-700/50 rounded-2xl shadow-xl overflow-hidden group hover:border-indigo-500/30 transition-all duration-300">
                    <div class="h-48 bg-slate-700 relative">
                        <!-- Placeholder for travel image -->
                        <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/20 to-purple-500/30"></div>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <svg class="w-12 h-12 text-slate-500 group-hover:scale-110 transition-transform duration-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="absolute bottom-4 left-4">
                            <span class="px-3 py-1 bg-indigo-500 text-white text-xs font-bold rounded-full shadow-lg">
                                &euro;{{ number_format($reis->price, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-slate-100 mb-2">{{ $reis->title }}</h3>
                        <p class="text-slate-400 text-sm mb-4 line-clamp-2">{{ $reis->description }}</p>
                        
                        <div class="flex items-center justify-between mt-6 pt-4 border-t border-slate-700/50">
                            <div class="flex flex-col">
                                <span class="text-[10px] uppercase font-bold text-slate-500 tracking-wider">Datum</span>
                                <span class="text-xs text-slate-300">{{ \Carbon\Carbon::parse($reis->start_date)->format('d M') }} - {{ \Carbon\Carbon::parse($reis->end_date)->format('d M Y') }}</span>
                            </div>
                            <button class="text-indigo-400 hover:text-indigo-300 text-sm font-medium transition-colors">Bekijken</button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 bg-slate-800/60 backdrop-blur-xl border border-slate-700/50 rounded-2xl text-center">
                    <p class="text-slate-500 font-medium">Geen reizen beschikbaar op dit moment.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
