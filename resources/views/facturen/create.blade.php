<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-bold text-3xl text-slate-100 tracking-tight">
                {{ __('Nieuwe Factuur') }}
            </h2>
            <p class="mt-1 text-sm text-slate-400 font-medium">Maak een nieuwe factuur aan voor een bestaande boeking.</p>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <div class="bg-slate-800/60 backdrop-blur-xl border border-slate-700/50 shadow-2xl rounded-3xl overflow-hidden">
            <form action="{{ route('facturen.store') }}" method="POST" class="p-8 space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Boeking Selectie -->
                    <div class="space-y-2 col-span-full">
                        <label for="boeking_id" class="block text-sm font-bold text-slate-300 uppercase tracking-wide">Boeking & Klant</label>
                        <select name="boeking_id" id="boeking_id" class="w-full bg-slate-900/50 border border-slate-700 text-slate-100 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all">
                            <option value="">Selecteer een boeking...</option>
                            @foreach($boekingen as $boeking)
                                <option value="{{ $boeking->id }}" {{ old('boeking_id') == $boeking->id ? 'selected' : '' }}>
                                    #{{ $boeking->id }} - {{ $boeking->klant_name }} ({{ $boeking->reis_title }})
                                </option>
                            @endforeach
                        </select>
                        @error('boeking_id') <p class="text-rose-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <!-- Bedrag -->
                    <div class="space-y-2">
                        <label for="amount" class="block text-sm font-bold text-slate-300 uppercase tracking-wide">Bedrag (€)</label>
                        <input type="number" step="0.01" name="amount" id="amount" value="{{ old('amount') }}" class="w-full bg-slate-900/50 border border-slate-700 text-slate-100 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all font-mono" placeholder="0.00">
                        @error('amount') <p class="text-rose-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <!-- Vervaldatum -->
                    <div class="space-y-2">
                        <label for="due_date" class="block text-sm font-bold text-slate-300 uppercase tracking-wide">Vervaldatum</label>
                        <input type="date" name="due_date" id="due_date" value="{{ old('due_date', now()->addDays(14)->format('Y-m-d')) }}" class="w-full bg-slate-900/50 border border-slate-700 text-slate-100 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all">
                        @error('due_date') <p class="text-rose-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <!-- Status -->
                    <div class="space-y-2">
                        <label for="status" class="block text-sm font-bold text-slate-300 uppercase tracking-wide">Initiële Status</label>
                        <select name="status" id="status" class="w-full bg-slate-900/50 border border-slate-700 text-slate-100 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all">
                            <option value="unpaid" {{ old('status') == 'unpaid' ? 'selected' : '' }}>Onbetaald</option>
                            <option value="paid" {{ old('status') == 'paid' ? 'selected' : '' }}>Betaald</option>
                            <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Geannuleerd</option>
                        </select>
                        @error('status') <p class="text-rose-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-slate-700/50">
                    <a href="{{ route('facturen.index') }}" class="text-sm font-bold text-slate-400 hover:text-slate-200 transition-colors uppercase">Annuleren</a>
                    <button type="submit" class="px-8 py-3 bg-indigo-500 text-white font-bold rounded-xl hover:bg-indigo-600 transition-all shadow-lg shadow-indigo-500/20 active:scale-95">
                        Factuur Genereren
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
