<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-bold text-3xl text-slate-100 tracking-tight">
                {{ __('Nieuwe Reis Aanmaken') }}
            </h2>
            <p class="mt-1 text-sm text-slate-400 font-medium">Definieer een nieuwe reisbestemming voor uw klanten.</p>
        </div>
    </x-slot>

    <div class="max-w-4xl">
        @if(session('error'))
            <div class="mb-6 p-4 rounded-xl bg-red-500/10 border border-red-500/20 text-red-400 backdrop-blur-md shadow-lg">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-slate-800/60 backdrop-blur-xl shadow-xl sm:rounded-2xl border border-slate-700/50 overflow-hidden">
            <form action="{{ route('reizen.store') }}" method="POST" class="p-8 space-y-8">
                @csrf

                <div class="space-y-6">
                    <div>
                        <label for="title" class="block text-sm font-bold text-slate-400 uppercase tracking-wider mb-2">Titel van de Reis</label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" required
                            class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-200 placeholder-slate-600"
                            placeholder="Bijv. Zonnig Spanje Extra">
                        @error('title') <p class="mt-2 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-bold text-slate-400 uppercase tracking-wider mb-2">Beschrijving</label>
                        <textarea name="description" id="description" rows="5" required
                            class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-200 placeholder-slate-600"
                            placeholder="Beschrijf de reis in detail...">{{ old('description') }}</textarea>
                        @error('description') <p class="mt-2 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="price" class="block text-sm font-bold text-slate-400 uppercase tracking-wider mb-2">Prijs (&euro;)</label>
                            <input type="number" step="0.01" name="price" id="price" value="{{ old('price') }}" required
                                class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-200 placeholder-slate-600">
                            @error('price') <p class="mt-2 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="start_date" class="block text-sm font-bold text-slate-400 uppercase tracking-wider mb-2">Startdatum</label>
                            <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" required
                                class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-200">
                            @error('start_date') <p class="mt-2 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="end_date" class="block text-sm font-bold text-slate-400 uppercase tracking-wider mb-2">Einddatum</label>
                            <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}" required
                                class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-200">
                            @error('end_date') <p class="mt-2 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end space-x-6 pt-8 border-t border-slate-700/50">
                    <a href="{{ route('reizen.index') }}" class="text-sm font-semibold text-slate-400 hover:text-slate-200 transition-colors">Terug</a>
                    <button type="submit" class="px-8 py-4 bg-indigo-500 text-white font-bold rounded-2xl hover:bg-indigo-600 transition-all duration-200 shadow-xl shadow-indigo-500/30 transform hover:-translate-y-0.5">
                        Reis Publiceren
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
