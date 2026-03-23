<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-bold text-3xl text-slate-100 tracking-tight">
                {{ __('Accommodatie Toevoegen') }}
            </h2>
            <p class="mt-1 text-sm text-slate-400 font-medium">Voeg een nieuw hotel, camping of ander verblijf toe.</p>
        </div>
    </x-slot>

    <div class="max-w-3xl">
        <div class="bg-slate-800/60 backdrop-blur-xl shadow-xl sm:rounded-2xl border border-slate-700/50 overflow-hidden">
            <form action="{{ route('accommodaties.store') }}" method="POST" class="p-8 space-y-6">
                @csrf

                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-bold text-slate-400 uppercase tracking-wider mb-2">Naam Accommodatie</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                            class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-200">
                        @error('name') <p class="mt-2 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="location" class="block text-sm font-bold text-slate-400 uppercase tracking-wider mb-2">Locatie</label>
                        <input type="text" name="location" id="location" value="{{ old('location') }}" required
                            class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-200">
                        @error('location') <p class="mt-2 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="type" class="block text-sm font-bold text-slate-400 uppercase tracking-wider mb-2">Type</label>
                            <select name="type" id="type" required
                                class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-200 appearance-none">
                                <option value="Hotel" {{ old('type') == 'Hotel' ? 'selected' : '' }}>Hotel</option>
                                <option value="Appartement" {{ old('type') == 'Appartement' ? 'selected' : '' }}>Appartement</option>
                                <option value="Resort" {{ old('type') == 'Resort' ? 'selected' : '' }}>Resort</option>
                                <option value="Camping" {{ old('type') == 'Camping' ? 'selected' : '' }}>Camping</option>
                                <option value="Anders" {{ old('type') == 'Anders' ? 'selected' : '' }}>Anders</option>
                            </select>
                            @error('type') <p class="mt-2 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="rating" class="block text-sm font-bold text-slate-400 uppercase tracking-wider mb-2">Rating (Sterren)</label>
                            <select name="rating" id="rating" required
                                class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-200">
                                @for($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}" {{ old('rating', 3) == $i ? 'selected' : '' }}>{{ $i }} Ster{{ $i > 1 ? 'ren' : '' }}</option>
                                @endfor
                            </select>
                            @error('rating') <p class="mt-2 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label for="amenities" class="block text-sm font-bold text-slate-400 uppercase tracking-wider mb-2">Voorzieningen (Amenities)</label>
                        <textarea name="amenities" id="amenities" rows="3"
                            class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-200"
                            placeholder="Bijv. WiFi, Zwembad, Ontbijt inbegrepen...">{{ old('amenities') }}</textarea>
                        @error('amenities') <p class="mt-2 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="price_per_night" class="block text-sm font-bold text-slate-400 uppercase tracking-wider mb-2">Prijs per nacht (&euro;)</label>
                        <input type="number" step="0.01" name="price_per_night" id="price_per_night" value="{{ old('price_per_night') }}" required
                            class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-200">
                        @error('price_per_night') <p class="mt-2 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="flex items-center justify-end space-x-4 pt-6">
                    <a href="{{ route('accommodaties.index') }}" class="text-sm font-semibold text-slate-400 hover:text-slate-200 transition-colors">Annuleren</a>
                    <button type="submit" id="submitBtn" class="px-6 py-3 bg-indigo-500 text-white font-bold rounded-xl hover:bg-indigo-600 transition-all duration-200 shadow-lg shadow-indigo-500/25">
                        Opslaan
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
                const price = document.getElementById('price_per_night').value;
                const name = document.getElementById('name').value.trim();
                const location = document.getElementById('location').value.trim();

                if (!name || !location) {
                    e.preventDefault();
                    alert('Naam and locatie zijn verplicht.');
                    return;
                }

                if (price < 0) {
                    e.preventDefault();
                    alert('Prijs per nacht kan niet negatief zijn.');
                    return;
                }

                submitBtn.disabled = true;
                submitBtn.innerHTML = '<svg class="animate-spin h-5 w-5 mr-3 text-white inline-block" viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle class="opacity-25" cx="12" cy="12" r="10" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Opslaan...';
            });
        });
    </script>
</x-app-layout>
