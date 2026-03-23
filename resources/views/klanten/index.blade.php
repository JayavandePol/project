<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-bold text-3xl text-slate-100 tracking-tight">
                {{ __('Klanten Overzicht') }}
            </h2>
            <p class="mt-1 text-sm text-slate-400 font-medium">Beheer en bekijk al uw klantgegevens.</p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('klanten.create') }}" class="px-4 py-2 bg-indigo-500 text-white text-sm font-semibold rounded-xl hover:bg-indigo-600 transition-colors shadow-lg shadow-indigo-500/20">
                Nieuwe Klant Toevoegen
            </a>
        </div>
    </x-slot>

    <div class="space-y-6">
        @if(session('error'))
            <div class="p-4 rounded-xl bg-red-500/10 border border-red-500/20 text-red-400 backdrop-blur-md shadow-lg">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-slate-800/60 backdrop-blur-xl overflow-hidden shadow-xl sm:rounded-2xl border border-slate-700/50">
            <div class="p-6 text-slate-200">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-700/50">
                                <th class="px-6 py-4 text-xs uppercase tracking-wider text-slate-400 font-medium whitespace-nowrap">Naam</th>
                                <th class="px-6 py-4 text-xs uppercase tracking-wider text-slate-400 font-medium whitespace-nowrap">E-mail</th>
                                <th class="px-6 py-4 text-xs uppercase tracking-wider text-slate-400 font-medium whitespace-nowrap">Telefoon</th>
                                <th class="px-6 py-4 text-xs uppercase tracking-wider text-slate-400 font-medium whitespace-nowrap">Adres</th>
                                <th class="px-6 py-4 text-xs uppercase tracking-wider text-slate-400 font-medium text-right">Acties</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-700/50">
                            @forelse($klanten as $klant)
                                <tr class="hover:bg-slate-700/30 transition-all duration-200 group">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 rounded-full bg-indigo-500/20 flex items-center justify-center text-indigo-400 mr-3 text-xs font-bold ring-1 ring-indigo-500/30">
                                                {{ substr($klant->name, 0, 1) }}
                                            </div>
                                            <span class="font-medium text-slate-100">{{ $klant->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-slate-400 text-sm">{{ $klant->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-slate-400 text-sm">{{ $klant->phone ?? '-' }}</td>
                                    <td class="px-6 py-4 text-slate-400 text-sm max-w-xs truncate">{{ $klant->address ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                        <div class="flex items-center justify-end space-x-3">
                                            <a href="{{ route('klanten.edit', $klant->id) }}" class="text-indigo-400 hover:text-indigo-300 font-medium transition-colors">Bewerken</a>
                                            
                                            <form action="{{ route('klanten.destroy', $klant->id) }}" method="POST" onsubmit="return confirm('Weet je zeker dat je deze klant wilt verwijderen?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-slate-500 hover:text-rose-400 transition-colors">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-12 h-12 text-slate-600 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                            </svg>
                                            <p class="text-slate-500 font-medium">Geen klanten gevonden.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
