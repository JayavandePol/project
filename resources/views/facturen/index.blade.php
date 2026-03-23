<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-bold text-3xl text-slate-100 tracking-tight">
                {{ __('Facturen') }}
            </h2>
            <p class="mt-1 text-sm text-slate-400 font-medium">Financieel overzicht en betalingsstatus.</p>
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
                                <th class="px-6 py-4 text-xs uppercase tracking-wider text-slate-400 font-medium">Factuurnummer</th>
                                <th class="px-6 py-4 text-xs uppercase tracking-wider text-slate-400 font-medium">Klant</th>
                                <th class="px-6 py-4 text-xs uppercase tracking-wider text-slate-400 font-medium">Reis</th>
                                <th class="px-6 py-4 text-xs uppercase tracking-wider text-slate-400 font-medium">Bedrag</th>
                                <th class="px-6 py-4 text-xs uppercase tracking-wider text-slate-400 font-medium">Vervaldatum</th>
                                <th class="px-6 py-4 text-xs uppercase tracking-wider text-slate-400 font-medium text-right">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-700/50">
                            @forelse($facturen as $factuur)
                                <tr class="border-b border-slate-700/50 hover:bg-slate-700/20 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-indigo-400">
                                        #{{ $factuur->invoice_number }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-200">
                                        {{ $factuur->klant_name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-300">
                                        {{ $factuur->reis_title }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-slate-100">
                                        &euro;{{ number_format($factuur->amount, 2, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-400 font-medium">
                                        {{ \Carbon\Carbon::parse($factuur->due_date)->format('d-m-Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <div class="flex items-center justify-end space-x-3">
                                            <form action="{{ route('facturen.updateStatus', $factuur->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <select name="status" onchange="this.form.submit()" 
                                                    class="bg-slate-900/50 border border-slate-700 text-[10px] font-bold uppercase rounded-lg px-3 py-1.5 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all
                                                    {{ $factuur->status === 'paid' ? 'text-green-400' : ($factuur->status === 'unpaid' ? 'text-amber-400' : 'text-red-400') }}">
                                                    <option value="unpaid" {{ $factuur->status === 'unpaid' ? 'selected' : '' }}>Onbetaald</option>
                                                    <option value="paid" {{ $factuur->status === 'paid' ? 'selected' : '' }}>Betaald</option>
                                                    <option value="cancelled" {{ $factuur->status === 'cancelled' ? 'selected' : '' }}>Geannuleerd</option>
                                                </select>
                                            </form>

                                            @if($factuur->status !== 'paid')
                                                <form action="{{ route('facturen.destroy', $factuur->id) }}" method="POST" onsubmit="return confirm('Weet je zeker dat je deze factuur wilt verwijderen?');" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-slate-500 hover:text-rose-400 transition-colors" title="Factuur Verwijderen">
                                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            @else
                                                <span class="p-1 px-2 bg-indigo-500/10 text-indigo-400 text-[10px] font-bold rounded-lg border border-indigo-500/20 uppercase">Archief</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-slate-500 font-medium">
                                        Geen facturen gevonden.
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
