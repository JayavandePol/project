<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-bold text-3xl text-slate-100 tracking-tight">
                {{ __('Nieuwe Boeking Maken') }}
            </h2>
            <p class="mt-1 text-sm text-slate-400 font-medium">Registreer een nieuwe boeking voor een klant.</p>
        </div>
    </x-slot>

    <div class="max-w-4xl">
        <div class="bg-slate-800/60 backdrop-blur-xl shadow-xl sm:rounded-2xl border border-slate-700/50 overflow-hidden">
            <form action="{{ route('boekingen.store') }}" method="POST" class="p-8 space-y-8">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-6">
                        <div>
                            <label for="klant_id" class="block text-sm font-bold text-slate-400 uppercase tracking-wider mb-2">Klant Selecteren</label>
                            <select name="klant_id" id="klant_id" required
                                class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-200">
                                <option value="">-- Kies een klant --</option>
                                @foreach($klanten as $klant)
                                    <option value="{{ $klant->id }}" {{ old('klant_id') == $klant->id ? 'selected' : '' }}>{{ $klant->name }} ({{ $klant->email }})</option>
                                @endforeach
                            </select>
                            @error('klant_id') <p class="mt-2 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="reis_id" class="block text-sm font-bold text-slate-400 uppercase tracking-wider mb-2">Reis Selecteren</label>
                            <select name="reis_id" id="reis_id" required
                                class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-200">
                                <option value="">-- Kies een reis --</option>
                                @foreach($reizen as $reis)
                                    <option value="{{ $reis->id }}" {{ old('reis_id') == $reis->id ? 'selected' : '' }}>{{ $reis->title }} (&euro;{{ number_format($reis->price, 0) }})</option>
                                @endforeach
                            </select>
                            @error('reis_id') <p class="mt-2 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="accommodatie_id" class="block text-sm font-bold text-slate-400 uppercase tracking-wider mb-2">Accommodatie Selecteren</label>
                            <select name="accommodatie_id" id="accommodatie_id" required
                                class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-200">
                                <option value="">-- Kies een verblijf --</option>
                                @foreach($accommodaties as $acc)
                                    <option value="{{ $acc->id }}" {{ old('accommodatie_id') == $acc->id ? 'selected' : '' }}>{{ $acc->name }} ({{ $acc->location }})</option>
                                @endforeach
                            </select>
                            @error('accommodatie_id') <p class="mt-2 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <label for="booking_date" class="block text-sm font-bold text-slate-400 uppercase tracking-wider mb-2">Boekingsdatum</label>
                            <input type="date" name="booking_date" id="booking_date" value="{{ old('booking_date', date('Y-m-d')) }}" required
                                class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-200">
                            @error('booking_date') <p class="mt-2 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="num_people" class="block text-sm font-bold text-slate-400 uppercase tracking-wider mb-2">Aantal Personen</label>
                                <input type="number" name="num_people" id="num_people" value="{{ old('num_people', 1) }}" min="1" required
                                    class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-200">
                                @error('num_people') <p class="mt-2 text-sm text-red-500">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="status" class="block text-sm font-bold text-slate-400 uppercase tracking-wider mb-2">Status</label>
                                <select name="status" id="status" required
                                    class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-200">
                                    <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>In afwachting</option>
                                    <option value="confirmed" {{ old('status', 'confirmed') == 'confirmed' ? 'selected' : '' }}>Bevestigd</option>
                                    <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Geannuleerd</option>
                                </select>
                                @error('status') <p class="mt-2 text-sm text-red-500">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="p-6 bg-slate-900/30 rounded-2xl border border-slate-700/30">
                            <h4 class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-4">Informatie</h4>
                            <p class="text-sm text-slate-400 leading-relaxed">
                                Een boeking koppelt een klant aan een reis en een specifiek verblijf. Na het opslaan wordt de boeking direct zichtbaar in het overzicht.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end space-x-6 pt-8 border-t border-slate-700/50">
                    <a href="{{ route('boekingen.index') }}" class="text-sm font-semibold text-slate-400 hover:text-slate-200 transition-colors">Annuleren</a>
                    <button type="submit" id="submitBtn" class="px-8 py-4 bg-indigo-500 text-white font-bold rounded-2xl hover:bg-indigo-600 transition-all duration-200 shadow-xl shadow-indigo-500/30">
                        Boeking Bevestigen
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const submitBtn = document.getElementById('submitBtn');

            form.addEventListener('submit', function(e) {
                const klant = document.getElementById('klant_id').value;
                const reis = document.getElementById('reis_id').value;
                const acc = document.getElementById('accommodatie_id').value;
                const numPeople = document.getElementById('num_people').value;

                if (!klant || !reis || !acc) {
                    e.preventDefault();
                    alert('Selecteer alstublieft een klant, reis én accommodatie.');
                    return;
                }

                if (numPeople < 1) {
                    e.preventDefault();
                    alert('Aantal personen moet minimaal 1 zijn.');
                    return;
                }

                submitBtn.disabled = true;
                submitBtn.innerHTML = '<svg class="animate-spin h-5 w-5 mr-3 text-white inline-block" viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle class="opacity-25" cx="12" cy="12" r="10" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Bevestigen...';
            });
        });
    </script>
</x-app-layout>
