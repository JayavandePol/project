<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-bold text-3xl text-slate-100 tracking-tight">
                {{ __('Nieuwe Klant Toevoegen') }}
            </h2>
            <p class="mt-1 text-sm text-slate-400 font-medium">Voer de gegevens van de nieuwe klant in.</p>
        </div>
    </x-slot>

    <div class="max-w-3xl">
        @if(session('error'))
            <div class="mb-6 p-4 rounded-xl bg-red-500/10 border border-red-500/20 text-red-400 backdrop-blur-md shadow-lg">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-slate-800/60 backdrop-blur-xl shadow-xl sm:rounded-2xl border border-slate-700/50 overflow-hidden">
            <form action="{{ route('klanten.store') }}" method="POST" class="p-8 space-y-6">
                @csrf

                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-bold text-slate-400 uppercase tracking-wider mb-2">Naam</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                            class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-200 placeholder-slate-600"
                            placeholder="Bijv. Jan Janssen">
                        @error('name') <p class="mt-2 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-bold text-slate-400 uppercase tracking-wider mb-2">E-mailadres</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required
                            class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-200 placeholder-slate-600"
                            placeholder="jan@voorbeeld.nl">
                        @error('email') <p class="mt-2 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="postal_code" class="block text-sm font-bold text-slate-400 uppercase tracking-wider mb-2">Postcode</label>
                            <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code') }}" required
                                class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-200 placeholder-slate-600"
                                placeholder="1234 AB">
                            @error('postal_code') <p class="mt-2 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="city" class="block text-sm font-bold text-slate-400 uppercase tracking-wider mb-2">Stad</label>
                            <input type="text" name="city" id="city" value="{{ old('city') }}" required
                                class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-200 placeholder-slate-600"
                                placeholder="Amsterdam">
                            @error('city') <p class="mt-2 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="phone" class="block text-sm font-bold text-slate-400 uppercase tracking-wider mb-2">Telefoonnummer</label>
                            <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                                class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-200 placeholder-slate-600"
                                placeholder="0612345678">
                            @error('phone') <p class="mt-2 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="address" class="block text-sm font-bold text-slate-400 uppercase tracking-wider mb-2">Adres</label>
                            <input type="text" name="address" id="address" value="{{ old('address') }}" required
                                class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-200 placeholder-slate-600"
                                placeholder="Straatnaam 1">
                            @error('address') <p class="mt-2 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-slate-700/50">
                    <a href="{{ route('klanten.index') }}" class="text-sm font-semibold text-slate-400 hover:text-slate-200 transition-colors">Annuleren</a>
                    <button type="submit" id="submitBtn" class="px-6 py-3 bg-indigo-500 text-white font-bold rounded-xl hover:bg-indigo-600 transition-all duration-200 shadow-lg shadow-indigo-500/25">
                        Klant Opslaan
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
                const name = document.getElementById('name').value.trim();
                const email = document.getElementById('email').value.trim();
                const postalCode = document.getElementById('postal_code').value.trim();
                const city = document.getElementById('city').value.trim();
                const address = document.getElementById('address').value.trim();

                const pcRegex = /^[0-9]{4}\s?[A-Z]{2}$/i;

                if (!name || !email || !postalCode || !city || !address) {
                    e.preventDefault();
                    alert('Vul alstublieft alle verplichte velden in.');
                    return;
                }

                if (!email.includes('@')) {
                    e.preventDefault();
                    alert('Voer een geldig e-mailadres in.');
                    return;
                }

                if (!pcRegex.test(postalCode)) {
                    e.preventDefault();
                    alert('Voer een geldige Nederlandse postcode in (bijv. 1234 AB).');
                    return;
                }

                submitBtn.disabled = true;
                submitBtn.innerHTML = '<svg class="animate-spin h-5 w-5 mr-3 text-white inline-block" viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle class="opacity-25" cx="12" cy="12" r="10" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Verwerken...';
            });
        });
    </script>
</x-app-layout>
