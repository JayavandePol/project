<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-3xl text-slate-100 tracking-tight">
                    {{ __('Klant Bewerken') }}
                </h2>
                <p class="mt-1 text-sm text-slate-400 font-medium">Wijzig de gegevens van {{ $klant->name }}.</p>
            </div>
            <a href="{{ route('klanten.index') }}" class="px-4 py-2 bg-slate-800 border border-slate-700 text-slate-300 text-sm font-semibold rounded-xl hover:bg-slate-700 transition-colors">
                Terug naar Overzicht
            </a>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto py-8">
        <div class="bg-slate-800/60 backdrop-blur-xl border border-slate-700/50 rounded-2xl shadow-xl overflow-hidden">
            <form action="{{ route('klanten.update', $klant->id) }}" method="POST" id="editKlantForm" class="p-8 space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-6">
                    <!-- Naam -->
                    <div>
                        <label for="name" class="block text-sm font-semibold text-slate-300 mb-2">Volledige Naam</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $klant->name) }}" required
                            class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all">
                        @error('name') <p class="mt-1 text-sm text-rose-400 font-medium">{{ $message }}</p> @enderror
                        <p id="nameError" class="hidden mt-1 text-sm text-rose-400 font-medium">Naam is verplicht.</p>
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-slate-300 mb-2">E-mailadres</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $klant->email) }}" required
                            class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all">
                        @error('email') <p class="mt-1 text-sm text-rose-400 font-medium">{{ $message }}</p> @enderror
                        <p id="emailError" class="hidden mt-1 text-sm text-rose-400 font-medium">Voer een geldig e-mailadres in.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="postal_code" class="block text-sm font-semibold text-slate-300 mb-2">Postcode</label>
                            <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code', $klant->postal_code) }}" required
                                class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all">
                            @error('postal_code') <p class="mt-1 text-sm text-rose-400 font-medium">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="city" class="block text-sm font-semibold text-slate-300 mb-2">Stad</label>
                            <input type="text" name="city" id="city" value="{{ old('city', $klant->city) }}" required
                                class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all">
                            @error('city') <p class="mt-1 text-sm text-rose-400 font-medium">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="phone" class="block text-sm font-semibold text-slate-300 mb-2">Telefoonnummer</label>
                            <input type="text" name="phone" id="phone" value="{{ old('phone', $klant->phone) }}"
                                class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all">
                            @error('phone') <p class="mt-1 text-sm text-rose-400 font-medium">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="address" class="block text-sm font-semibold text-slate-300 mb-2">Adres</label>
                            <input type="text" name="address" id="address" value="{{ old('address', $klant->address) }}" required
                                class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all">
                            @error('address') <p class="mt-1 text-sm text-rose-400 font-medium">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full py-4 bg-indigo-500 hover:bg-indigo-600 text-white font-bold rounded-xl transition-all shadow-lg shadow-indigo-500/25 flex items-center justify-center space-x-2 group">
                        <span>Wijzigingen Opslaan</span>
                        <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </button>
                    <p class="mt-4 text-center text-xs text-slate-500 italic">De wijzigingen worden direct doorgevoerd in de database via Stored Procedures.</p>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('editKlantForm').addEventListener('submit', function(e) {
            let hasError = false;
            const name = document.getElementById('name').value.trim();
            const email = document.getElementById('email').value.trim();
            const postalCode = document.getElementById('postal_code').value.trim();
            const city = document.getElementById('city').value.trim();
            const address = document.getElementById('address').value.trim();

            const pcRegex = /^[0-9]{4}\s?[A-Z]{2}$/i;

            if (!name || !email || !postalCode || !city || !address) {
                alert('Vul alstublieft alle verplichte velden in.');
                hasError = true;
            } else if (!email.includes('@')) {
                alert('Voer een geldig e-mailadres in.');
                hasError = true;
            } else if (!pcRegex.test(postalCode)) {
                alert('Voer een geldige Nederlandse postcode in (bijv. 1234 AB).');
                hasError = true;
            }

            if (hasError) {
                e.preventDefault();
            }
        });
    </script>
</x-app-layout>
