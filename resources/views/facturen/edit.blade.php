<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-bold text-3xl text-slate-100 tracking-tight">
                {{ __('Factuur Bewerken') }}
            </h2>
            <p class="mt-1 text-sm text-slate-400 font-medium font-mono text-indigo-400">{{ $factuur->invoice_number }}</p>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <div class="bg-slate-800/60 backdrop-blur-xl border border-slate-700/50 shadow-2xl rounded-3xl overflow-hidden relative">
            @if($factuur->status === 'paid')
                <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-[2px] z-10 flex items-center justify-center p-8">
                    <div class="bg-slate-800 p-6 rounded-2xl border border-amber-500/30 shadow-2xl max-w-sm text-center">
                        <svg class="w-12 h-12 text-amber-500 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m0 0v2m0-2h2m-2 0H10m11 3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="text-slate-100 font-bold mb-2 uppercase tracking-wide">Factuur Vergrendeld</h3>
                        <p class="text-slate-400 text-sm">Deze factuur is al betaald en kan daarom niet meer worden gewijzigd in de administratie.</p>
                        <a href="{{ route('facturen.index') }}" class="mt-6 inline-block text-indigo-400 font-bold text-sm uppercase">Terug naar overzicht</a>
                    </div>
                </div>
            @endif

            <form action="{{ route('facturen.update', $factuur->id) }}" method="POST" class="p-8 space-y-6">
                @csrf
                @method('PUT')

                @if(session('error'))
                    <div class="p-4 rounded-xl bg-red-500/10 border border-red-500/20 text-red-400 text-sm font-medium">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                     <!-- Informatie velden (Read-only) -->
                     <div class="space-y-1">
                        <span class="text-[10px] font-bold text-slate-500 uppercase">Gekoppelde Klant</span>
                        <p class="text-slate-200 font-semibold">{{ $factuur->klant_name }}</p>
                    </div>
                    <div class="space-y-1">
                        <span class="text-[10px] font-bold text-slate-500 uppercase">Reis</span>
                        <p class="text-slate-200 font-semibold">{{ $factuur->reis_title }}</p>
                    </div>

                    <hr class="col-span-full border-slate-700/50">

                    <!-- Bedrag -->
                    <div class="space-y-2">
                        <label for="amount" class="block text-sm font-bold text-slate-300 uppercase tracking-wide">Bedrag (€)</label>
                        <input type="number" step="0.01" name="amount" id="amount" value="{{ old('amount', $factuur->amount) }}" class="w-full bg-slate-900/50 border border-slate-700 text-slate-100 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all font-mono">
                        @error('amount') <p class="text-rose-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <!-- Vervaldatum -->
                    <div class="space-y-2">
                        <label for="due_date" class="block text-sm font-bold text-slate-300 uppercase tracking-wide">Vervaldatum</label>
                        <input type="date" name="due_date" id="due_date" value="{{ old('due_date', $factuur->due_date) }}" class="w-full bg-slate-900/50 border border-slate-700 text-slate-100 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all">
                        @error('due_date') <p class="text-rose-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <!-- Status -->
                    <div class="space-y-2">
                        <label for="status" class="block text-sm font-bold text-slate-300 uppercase tracking-wide">Status</label>
                        <select name="status" id="status" class="w-full bg-slate-900/50 border border-slate-700 text-slate-100 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all">
                            <option value="unpaid" {{ old('status', $factuur->status) == 'unpaid' ? 'selected' : '' }}>Onbetaald</option>
                            <option value="paid" {{ old('status', $factuur->status) == 'paid' ? 'selected' : '' }}>Betaald</option>
                            <option value="cancelled" {{ old('status', $factuur->status) == 'cancelled' ? 'selected' : '' }}>Geannuleerd</option>
                        </select>
                        @error('status') <p class="text-rose-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-slate-700/50">
                    <a href="{{ route('facturen.index') }}" class="text-sm font-bold text-slate-400 hover:text-slate-200 transition-colors uppercase">Annuleren</a>
                    <button type="submit" class="px-8 py-3 bg-indigo-500 text-white font-bold rounded-xl hover:bg-indigo-600 transition-all shadow-lg shadow-indigo-500/20 active:scale-95">
                        Wijzigingen Opslaan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
