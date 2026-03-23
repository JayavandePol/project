<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-3xl text-slate-100 tracking-tight">
                    {{ __('Boeking Bewerken') }}
                </h2>
                <p class="mt-1 text-sm text-slate-400 font-medium">Wijzig de details van boeking #{{ $boeking->id }}.</p>
            </div>
            <a href="{{ route('boekingen.index') }}" class="px-4 py-2 bg-slate-800 border border-slate-700 text-slate-300 text-sm font-semibold rounded-xl hover:bg-slate-700 transition-colors">
                Terug naar Overzicht
            </a>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto py-8">
        <div class="bg-slate-800/60 backdrop-blur-xl border border-slate-700/50 rounded-2xl shadow-xl overflow-hidden">
            <form action="{{ route('boekingen.update', $boeking->id) }}" method="POST" id="editBoekingForm" class="p-8 space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-6">
                    <!-- Klant Selectie -->
                    <div>
                        <label for="klant_id" class="block text-sm font-semibold text-slate-300 mb-2">Klant</label>
                        <select name="klant_id" id="klant_id" required
                            class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all">
                            @foreach($klanten as $klant)
                                <option value="{{ $klant->id }}" {{ old('klant_id', $boeking->klant_id) == $klant->id ? 'selected' : '' }}>
                                    {{ $klant->name }} ({{ $klant->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('klant_id') <p class="mt-1 text-sm text-rose-400 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <!-- Reis Selectie -->
                    <div>
                        <label for="reis_id" class="block text-sm font-semibold text-slate-300 mb-2">Reis</label>
                        <select name="reis_id" id="reis_id" required
                            class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all">
                            @foreach($reizen as $reis)
                                <option value="{{ $reis->id }}" {{ old('reis_id', $boeking->reis_id) == $reis->id ? 'selected' : '' }}>
                                    {{ $reis->title }} (&euro;{{ number_format($reis->price, 2, ',', '.') }})
                                </option>
                            @endforeach
                        </select>
                        @error('reis_id') <p class="mt-1 text-sm text-rose-400 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <!-- Accommodatie Selectie -->
                    <div>
                        <label for="accommodatie_id" class="block text-sm font-semibold text-slate-300 mb-2">Accommodatie</label>
                        <select name="accommodatie_id" id="accommodatie_id" required
                            class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all">
                            @foreach($accommodaties as $acc)
                                <option value="{{ $acc->id }}" {{ old('accommodatie_id', $boeking->accommodatie_id) == $acc->id ? 'selected' : '' }}>
                                    {{ $acc->name }} ({{ $acc->location }})
                                </option>
                            @endforeach
                        </select>
                        @error('accommodatie_id') <p class="mt-1 text-sm text-rose-400 font-medium">{{ $message }}</p> @enderror
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Boekingsdatum -->
                        <div>
                            <label for="booking_date" class="block text-sm font-semibold text-slate-300 mb-2">Boekingsdatum</label>
                            <input type="date" name="booking_date" id="booking_date" value="{{ old('booking_date', $boeking->booking_date) }}" required
                                class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all">
                            @error('booking_date') <p class="mt-1 text-sm text-rose-400 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <!-- Aantal personen -->
                        <div>
                            <label for="num_people" class="block text-sm font-semibold text-slate-300 mb-2">Aantal Personen</label>
                            <input type="number" name="num_people" id="num_people" value="{{ old('num_people', $boeking->num_people) }}" min="1" required
                                class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all">
                            @error('num_people') <p class="mt-1 text-sm text-rose-400 font-medium">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-semibold text-slate-300 mb-2">Status</label>
                        <select name="status" id="status" required
                            class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all">
                            <option value="pending" {{ old('status', $boeking->status) == 'pending' ? 'selected' : '' }}>In Behandeling</option>
                            <option value="confirmed" {{ old('status', $boeking->status) == 'confirmed' ? 'selected' : '' }}>Bevestigd</option>
                            <option value="cancelled" {{ old('status', $boeking->status) == 'cancelled' ? 'selected' : '' }}>Geannuleerd</option>
                        </select>
                        @error('status') <p class="mt-1 text-sm text-rose-400 font-medium">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full py-4 bg-indigo-500 hover:bg-indigo-600 text-white font-bold rounded-xl transition-all shadow-lg shadow-indigo-500/25 flex items-center justify-center space-x-2 group">
                        <span>Wijzigingen Opslaan</span>
                        <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </button>
                    <p class="mt-4 text-center text-xs text-slate-500 italic">Wijzigingen in de boeking hebben geen invloed op reeds gegenereerde facturen.</p>
                </div>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('editBoekingForm');
            
            form.addEventListener('submit', function(e) {
                const numPeople = document.getElementById('num_people').value;

                if (numPeople < 1) {
                    e.preventDefault();
                    alert('Aantal personen moet minimaal 1 zijn.');
                }
            });
        });
    </script>
</x-app-layout>
