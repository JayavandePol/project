<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-3xl text-slate-100 tracking-tight">
                    {{ __('Account Bewerken') }}
                </h2>
                <p class="mt-1 text-sm text-slate-400 font-medium">Beheer de gegevens van {{ $user->name }}.</p>
            </div>
            <a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-slate-800 border border-slate-700 text-slate-300 text-sm font-semibold rounded-xl hover:bg-slate-700 transition-colors">
                Terug naar Overzicht
            </a>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto py-8">
        <div class="bg-slate-800/60 backdrop-blur-xl border border-slate-700/50 rounded-2xl shadow-xl overflow-hidden">
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="p-8 space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-6">
                    <!-- Naam -->
                    <div>
                        <label for="name" class="block text-sm font-semibold text-slate-300 mb-2">Naam</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                            class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all">
                        @error('name') <p class="mt-1 text-sm text-rose-400 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-slate-300 mb-2">E-mailadres</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                            class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all">
                        @error('email') <p class="mt-1 text-sm text-rose-400 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <!-- Rol -->
                    <div>
                        <label for="role" class="block text-sm font-semibold text-slate-300 mb-2">Rol</label>
                        <select name="role" id="role" required
                            class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all">
                            <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>Gebruiker</option>
                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Administrator</option>
                        </select>
                        @error('role') <p class="mt-1 text-sm text-rose-400 font-medium">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full py-4 bg-indigo-500 hover:bg-indigo-600 text-white font-bold rounded-xl transition-all shadow-lg shadow-indigo-500/25 flex items-center justify-center space-x-2 group">
                        <span>Account Bijwerken</span>
                        <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </button>
                    <p class="mt-4 text-center text-xs text-slate-500 italic">Het wijzigen van je eigen rol naar 'User' kan leiden tot verlies van toegang tot dit overzicht.</p>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
