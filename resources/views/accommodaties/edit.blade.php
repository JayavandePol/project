<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-3xl text-slate-100 tracking-tight">
                    {{ __('Accommodatie Bewerken') }}
                </h2>
                <p class="mt-1 text-sm text-slate-400 font-medium">Wijzig details voor {{ $accommodatie->name }}.</p>
            </div>
            <a href="{{ route('accommodaties.index') }}" class="px-4 py-2 bg-slate-800 border border-slate-700 text-slate-300 text-sm font-semibold rounded-xl hover:bg-slate-700 transition-colors">
                Terug naar Overzicht
            </a>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto py-8">
        <div class="bg-slate-800/60 backdrop-blur-xl border border-slate-700/50 rounded-2xl shadow-xl overflow-hidden">
            <form action="{{ route('accommodaties.update', $accommodatie->id) }}" method="POST" id="editAccommodatieForm" class="p-8 space-y-6">
                @csrf
                @method('PUT')
                    <!-- Naam -->
                    <div>
                        <label for="name" class="block text-sm font-semibold text-slate-300 mb-2">Naam van de Accommodatie</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $accommodatie->name) }}" required
                            class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all">
                        @error('name') <p class="mt-1 text-sm text-rose-400 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <!-- Locatie -->
                    <div>
                        <label for="location" class="block text-sm font-semibold text-slate-300 mb-2">Locatie</label>
                        <input type="text" name="location" id="location" value="{{ old('location', $accommodatie->location) }}" required
                            class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all">
                        @error('location') <p class="mt-1 text-sm text-rose-400 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Type -->
                        <div>
                            <label for="type" class="block text-sm font-semibold text-slate-300 mb-2">Type</label>
                            <select name="type" id="type" required
                                class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all">
                                <option value="Hotel" {{ old('type', $accommodatie->type) == 'Hotel' ? 'selected' : '' }}>Hotel</option>
                                <option value="Appartement" {{ old('type', $accommodatie->type) == 'Appartement' ? 'selected' : '' }}>Appartement</option>
                                <option value="Resort" {{ old('type', $accommodatie->type) == 'Resort' ? 'selected' : '' }}>Resort</option>
                                <option value="Camping" {{ old('type', $accommodatie->type) == 'Camping' ? 'selected' : '' }}>Camping</option>
                                <option value="Anders" {{ old('type', $accommodatie->type) == 'Anders' ? 'selected' : '' }}>Anders</option>
                            </select>
                            @error('type') <p class="mt-1 text-sm text-rose-400 font-medium">{{ $message }}</p> @enderror
                        </div>
                        <!-- Rating -->
                        <div>
                            <label for="rating" class="block text-sm font-semibold text-slate-300 mb-2">Rating</label>
                            <select name="rating" id="rating" required
                                class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all">
                                @for($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}" {{ old('rating', $accommodatie->rating) == $i ? 'selected' : '' }}>{{ $i }} Ster{{ $i > 1 ? 'ren' : '' }}</option>
                                @endfor
                            </select>
                            @error('rating') <p class="mt-1 text-sm text-rose-400 font-medium">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Voorzieningen -->
                    <div>
                        <label for="amenities" class="block text-sm font-semibold text-slate-300 mb-2">Voorzieningen</label>
                        <textarea name="amenities" id="amenities" rows="3"
                            class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all">{{ old('amenities', $accommodatie->amenities) }}</textarea>
                        @error('amenities') <p class="mt-1 text-sm text-rose-400 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <!-- Prijs per nacht -->
                    <div>
                        <label for="price_per_night" class="block text-sm font-semibold text-slate-300 mb-2">Prijs per nacht (&euro;)</label>
                        <input type="number" step="0.01" name="price_per_night" id="price_per_night" value="{{ old('price_per_night', $accommodatie->price_per_night) }}" required
                            class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all">
                        @error('price_per_night') <p class="mt-1 text-sm text-rose-400 font-medium">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full py-4 bg-indigo-500 hover:bg-indigo-600 text-white font-bold rounded-xl transition-all shadow-lg shadow-indigo-500/25 flex items-center justify-center space-x-2 group">
                        <span>Accommodatie Bijwerken</span>
                        <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </button>
                    <p class="mt-4 text-center text-xs text-slate-500 italic">Wijzigingen worden direct doorgevoerd via Stored Procedure.</p>
                </div>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('editAccommodatieForm');
            
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
            });
        });
    </script>
</x-app-layout>
