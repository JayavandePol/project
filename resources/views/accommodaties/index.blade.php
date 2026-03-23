<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-bold text-3xl text-slate-100 tracking-tight">
                {{ __('Accommodaties') }}
            </h2>
            <p class="mt-1 text-sm text-slate-400 font-medium">Ontdek diverse verblijfopties voor uw ideale reis.</p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('accommodaties.create') }}" class="px-4 py-2 bg-indigo-500 text-white text-sm font-semibold rounded-xl hover:bg-indigo-600 transition-colors shadow-lg shadow-indigo-500/20">
                Nieuwe Accommodatie
            </a>
        </div>
    </x-slot>

    <div class="space-y-6">
        @if(session('error'))
            <div class="p-4 rounded-xl bg-red-500/10 border border-red-500/20 text-red-400 backdrop-blur-md shadow-lg">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-slate-800/60 backdrop-blur-xl overflow-hidden shadow-xl sm:rounded-2xl border border-slate-700/50">
            <div class="p-6 text-slate-200">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-700/50">
                                <th class="px-6 py-4 text-xs uppercase tracking-wider text-slate-400 font-medium">Naam</th>
                                <th class="px-6 py-4 text-xs uppercase tracking-wider text-slate-400 font-medium">Locatie</th>
                                <th class="px-6 py-4 text-xs uppercase tracking-wider text-slate-400 font-medium">Type</th>
                                <th class="px-6 py-4 text-xs uppercase tracking-wider text-slate-400 font-medium">Prijs p.n.</th>
                                <th class="px-6 py-4 text-xs uppercase tracking-wider text-slate-400 font-medium text-right">Acties</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-700/50">
                            @forelse($accommodaties as $acc)
                                <tr class="hover:bg-slate-700/30 transition-all duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="font-medium text-slate-100">{{ $acc->name }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center text-slate-400">
                                            <svg class="w-4 h-4 mr-1 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                            <span class="text-sm font-medium">{{ $acc->location }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2.5 py-0.5 bg-slate-700 border border-slate-600 rounded-md text-[10px] font-bold text-slate-300 uppercase tracking-tighter">
                                            {{ $acc->type }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-slate-200 font-semibold text-sm">
                                        &euro;{{ number_format($acc->price_per_night, 2, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                        <a href="{{ route('accommodaties.edit', $acc->id) }}" class="text-indigo-400 hover:text-indigo-300 font-medium transition-colors">Bewerken</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-slate-500 font-medium">
                                        Geen accommodaties gevonden.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
