<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-bold text-3xl text-slate-100 tracking-tight">
                {{ __('Facturen Overzicht') }}
            </h2>
            <p class="mt-1 text-sm text-slate-400 font-medium">Beheer alle facturen en betalingsstromen.</p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('facturen.create') }}" class="px-4 py-2 bg-indigo-500 text-white text-sm font-semibold rounded-xl hover:bg-indigo-600 transition-colors shadow-lg shadow-indigo-500/20">
                Nieuwe Factuur Aanmaken
            </a>
        </div>
    </x-slot>

    <div class="space-y-6">
        @if(session('success'))
            <div class="p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 backdrop-blur-md shadow-lg">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="p-4 rounded-xl bg-red-500/10 border border-red-500/20 text-red-400 backdrop-blur-md shadow-lg">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-slate-800/60 backdrop-blur-xl overflow-hidden shadow-xl sm:rounded-2xl border border-slate-700/50">
            <div class="p-0 text-slate-200">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-700/50 bg-slate-900/30">
                                <th class="px-6 py-4 text-xs uppercase tracking-wider text-slate-400 font-bold">UUID / Referentie</th>
                                <th class="px-6 py-4 text-xs uppercase tracking-wider text-slate-400 font-bold">Klant & Reis</th>
                                <th class="px-6 py-4 text-xs uppercase tracking-wider text-slate-400 font-bold">Bedrag</th>
                                <th class="px-6 py-4 text-xs uppercase tracking-wider text-slate-400 font-bold">Vervaldatum</th>
                                <th class="px-6 py-4 text-xs uppercase tracking-wider text-slate-400 font-bold">Status</th>
                                <th class="px-6 py-4 text-xs uppercase tracking-wider text-slate-400 font-bold text-right">Acties</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-700/50">
                            @forelse($facturen as $factuur)
                                <tr class="hover:bg-slate-700/20 transition-colors group">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex flex-col">
                                            <span class="text-sm font-bold text-indigo-400 font-mono">{{ $factuur->invoice_number }}</span>
                                            <span class="text-[10px] text-slate-500 uppercase tracking-tighter">Factuur ID: #{{ $factuur->id }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex flex-col">
                                            <span class="text-sm font-semibold text-slate-200">{{ $factuur->klant_name }}</span>
                                            <span class="text-xs text-slate-500">{{ $factuur->reis_title }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-slate-100">
                                        &euro;{{ number_format($factuur->amount, 2, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-400 font-medium">
                                        {{ \Carbon\Carbon::parse($factuur->due_date)->format('d-m-Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $statusClasses = [
                                                'paid' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
                                                'unpaid' => 'bg-amber-500/10 text-amber-400 border-amber-500/20',
                                                'cancelled' => 'bg-slate-500/10 text-slate-400 border-slate-500/20',
                                            ];
                                            $statusLabel = [
                                                'paid' => 'Betaald',
                                                'unpaid' => 'Openstaand',
                                                'cancelled' => 'Geannuleerd',
                                            ];
                                        @endphp
                                        <span class="px-3 py-1 text-[10px] font-bold rounded-full border {{ $statusClasses[$factuur->status] ?? $statusClasses['unpaid'] }} uppercase tracking-wider">
                                            {{ $statusLabel[$factuur->status] ?? $factuur->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <div class="flex items-center justify-end space-x-4">
                                            <a href="{{ route('facturen.edit', $factuur->id) }}" class="text-slate-400 hover:text-indigo-400 transition-colors" title="Bewerken">
                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            
                                            <form action="{{ route('facturen.destroy', $factuur->id) }}" method="POST" onsubmit="return confirm('Weet je zeker dat je deze factuur wilt verwijderen?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-slate-400 hover:text-rose-500 transition-colors" title="Verwijderen">
                                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-slate-500 font-medium italic">
                                        Geen facturen in de administratie gevonden.
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
