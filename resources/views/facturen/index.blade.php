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
                                        <form action="{{ route('facturen.updateStatus', $factuur->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" onchange="this.form.submit()" 
                                                class="bg-slate-900/50 border border-slate-700 text-xs font-bold rounded-lg px-3 py-1.5 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all
                                                {{ $factuur->status === 'paid' ? 'text-green-400' : ($factuur->status === 'unpaid' ? 'text-amber-400' : 'text-red-400') }}">
                                                <option value="unpaid" {{ $factuur->status === 'unpaid' ? 'selected' : '' }}>Onbetaald</option>
                                                <option value="paid" {{ $factuur->status === 'paid' ? 'selected' : '' }}>Betaald</option>
                                                <option value="cancelled" {{ $factuur->status === 'cancelled' ? 'selected' : '' }}>Geannuleerd</option>
                                            </select>
                                        </form>
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
