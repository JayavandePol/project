<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-bold text-3xl text-slate-100 tracking-tight">
                {{ __('Nieuw Account Toevoegen') }}
            </h2>
            <p class="mt-1 text-sm text-slate-400 font-medium">Maak een nieuw gebruikersaccount aan voor het systeem.</p>
        </div>
    </x-slot>

    <div class="max-w-2xl">
        @if(session('error'))
            <div class="mb-6 p-4 rounded-xl bg-red-500/10 border border-red-500/20 text-red-400 backdrop-blur-md shadow-lg">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-slate-800/60 backdrop-blur-xl shadow-xl sm:rounded-2xl border border-slate-700/50 overflow-hidden">
            <form action="{{ route('admin.users.store') }}" method="POST" class="p-8 space-y-6">
                @csrf

                <div class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-bold text-slate-400 uppercase tracking-wider mb-2">Naam</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                            class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-200">
                        @error('name') <p class="mt-2 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-bold text-slate-400 uppercase tracking-wider mb-2">E-mailadres</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required
                            class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-200">
                        @error('email') <p class="mt-2 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="password" class="block text-sm font-bold text-slate-400 uppercase tracking-wider mb-2">Wachtwoord</label>
                            <input type="password" name="password" id="password" required
                                class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-200">
                            @error('password') <p class="mt-2 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-sm font-bold text-slate-400 uppercase tracking-wider mb-2">Bevestig Wachtwoord</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" required
                                class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-200">
                        </div>
                    </div>

                    <div>
                        <label for="role" class="block text-sm font-bold text-slate-400 uppercase tracking-wider mb-2">Rol</label>
                        <select name="role" id="role" required
                            class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-200 appearance-none">
                            <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>Gebruiker (User)</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Beheerder (Admin)</option>
                        </select>
                        @error('role') <p class="mt-2 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="flex items-center justify-end space-x-4 pt-6">
                    <a href="{{ route('admin.users.index') }}" class="text-sm font-semibold text-slate-400 hover:text-slate-200 transition-colors">Annuleren</a>
                    <button type="submit" id="submitBtn" class="px-6 py-3 bg-indigo-500 text-white font-bold rounded-xl hover:bg-indigo-600 transition-all duration-200 shadow-lg shadow-indigo-500/25">
                        Account Aanmaken
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
                const password = document.getElementById('password').value;
                const confirmation = document.getElementById('password_confirmation').value;

                if (password !== confirmation) {
                    e.preventDefault();
                    alert('Wachtwoorden komen niet overeen.');
                    return;
                }

                if (password.length < 8) {
                    e.preventDefault();
                    alert('Wachtwoord moet minimaal 8 tekens lang zijn.');
                    return;
                }

                submitBtn.disabled = true;
                submitBtn.innerHTML = 'Aanmaken...';
            });
        });
    </script>
</x-app-layout>
