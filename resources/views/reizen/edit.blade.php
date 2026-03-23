<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-3xl text-slate-100 tracking-tight">
                    {{ __('Reis Bewerken') }}
                </h2>
                <p class="mt-1 text-sm text-slate-400 font-medium">Wijzig de details van "{{ $reis->title }}".</p>
            </div>
            <a href="{{ route('reizen.index') }}" class="px-4 py-2 bg-slate-800 border border-slate-700 text-slate-300 text-sm font-semibold rounded-xl hover:bg-slate-700 transition-colors">
                Terug naar Overzicht
            </a>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto py-8">
        @php $isExpired = \Carbon\Carbon::parse($reis->start_date)->isPast(); @endphp
        
        @if($isExpired)
            <div class="mb-6 p-6 bg-rose-500/10 border border-rose-500/20 rounded-2xl backdrop-blur-md flex items-start space-x-4 shadow-xl">
                <div class="p-3 bg-rose-500/20 rounded-xl">
                    <svg class="w-6 h-6 text-rose-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-rose-400 font-bold text-lg">Reis is Vergrendeld</h3>
                    <p class="text-rose-400/80 text-sm mt-1">Deze reis is al gestart op {{ \Carbon\Carbon::parse($reis->start_date)->format('d-m-Y') }}. Wijzigingen zijn niet meer toegestaan volgens de bedrijfsregels.</p>
                </div>
            </div>
        @endif

        <div class="bg-slate-800/60 backdrop-blur-xl border border-slate-700/50 rounded-2xl shadow-xl overflow-hidden">
            <form action="{{ route('reizen.update', $reis->id) }}" method="POST" id="editReisForm" class="p-8 space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-6 {{ $isExpired ? 'opacity-50 pointer-events-none' : '' }}">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="title" class="block text-sm font-semibold text-slate-300 mb-2">Titel van de Reis</label>
                            <input type="text" name="title" id="title" value="{{ old('title', $reis->title) }}" required
                                class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all">
                            @error('title') <p class="mt-1 text-sm text-rose-400 font-medium">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="destination" class="block text-sm font-semibold text-slate-300 mb-2">Bestemming</label>
                            <input type="text" name="destination" id="destination" value="{{ old('destination', $reis->destination) }}" required
                                class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all">
                            @error('destination') <p class="mt-1 text-sm text-rose-400 font-medium">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Beschrijving -->
                    <div>
                        <label for="description" class="block text-sm font-semibold text-slate-300 mb-2">Beschrijving</label>
                        <textarea name="description" id="description" rows="4" required
                            class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all">{{ old('description', $reis->description) }}</textarea>
                        @error('description') <p class="mt-1 text-sm text-rose-400 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="price" class="block text-sm font-semibold text-slate-300 mb-2">Prijs (&euro;)</label>
                            <input type="number" step="0.01" name="price" id="price" value="{{ old('price', $reis->price) }}" required
                                class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all">
                            @error('price') <p class="mt-1 text-sm text-rose-400 font-medium">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="max_participants" class="block text-sm font-semibold text-slate-300 mb-2">Max. Deelnemers</label>
                            <input type="number" name="max_participants" id="max_participants" value="{{ old('max_participants', $reis->max_participants) }}" required
                                class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all">
                            @error('max_participants') <p class="mt-1 text-sm text-rose-400 font-medium">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Datums -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="start_date" class="block text-sm font-semibold text-slate-300 mb-2">Begindatum</label>
                            <input type="date" name="start_date" id="start_date" value="{{ old('start_date', $reis->start_date) }}" required
                                class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all">
                            @error('start_date') <p class="mt-1 text-sm text-rose-400 font-medium">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="end_date" class="block text-sm font-semibold text-slate-300 mb-2">Einddatum</label>
                            <input type="date" name="end_date" id="end_date" value="{{ old('end_date', $reis->end_date) }}" required
                                class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all">
                            @error('end_date') <p class="mt-1 text-sm text-rose-400 font-medium">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <div id="dateErrorMessage" class="hidden p-4 bg-rose-500/10 border border-rose-500/30 rounded-xl text-rose-400 text-sm font-medium">
                    De einddatum moet na de begindatum liggen.
                </div>

                @if(!$isExpired)
                    <div class="pt-4">
                        <button type="submit" class="w-full py-4 bg-indigo-500 hover:bg-indigo-600 text-white font-bold rounded-xl transition-all shadow-lg shadow-indigo-500/25 flex items-center justify-center space-x-2 group">
                            <span>Reis Bijwerken</span>
                            <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </button>
                    </div>
                @endif
            </form>
        </div>
    </div>

    <script>
        document.getElementById('editReisForm').addEventListener('submit', function(e) {
            const startDate = new Date(document.getElementById('start_date').value);
            const endDate = new Date(document.getElementById('end_date').value);
            const errorMsg = document.getElementById('dateErrorMessage');

            if (endDate <= startDate) {
                e.preventDefault();
                errorMsg.classList.remove('hidden');
            } else {
                errorMsg.classList.add('hidden');
            }
        });
    </script>
</x-app-layout>
