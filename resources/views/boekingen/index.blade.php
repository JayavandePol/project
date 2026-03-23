<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-bold text-3xl text-slate-100 tracking-tight">
                {{ __('Boekingen') }}
            </h2>
            <p class="mt-1 text-sm text-slate-400 font-medium">Houd al uw geregistreerde reisboekingen overzichtelijk bij.</p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('boekingen.create') }}" class="px-4 py-2 bg-indigo-500 text-white text-sm font-semibold rounded-xl hover:bg-indigo-600 transition-colors shadow-lg shadow-indigo-500/20">
                Nieuwe Boeking
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
                                <th class="px-6 py-4 text-xs uppercase tracking-wider text-slate-400 font-medium">Klant</th>
                                <th class="px-6 py-4 text-xs uppercase tracking-wider text-slate-400 font-medium">Reis</th>
                                <th class="px-6 py-4 text-xs uppercase tracking-wider text-slate-400 font-medium">Boeking Datum</th>
                                <th class="px-6 py-4 text-xs uppercase tracking-wider text-slate-400 font-medium">Status</th>
                                <th class="px-6 py-4 text-xs uppercase tracking-wider text-slate-400 font-medium text-right">Acties</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-700/50">
                            @forelse($boekingen as $boeking)
                                <tr class="hover:bg-slate-700/30 transition-all duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-200">
                                        {{ $boeking->klant_name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-300">
                                        {{ $boeking->reis_title }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-300">
                                        {{ $boeking->acc_name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-300">
                                        {{ \Carbon\Carbon::parse($boeking->booking_date)->format('d-m-Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-300">
                                        {{ $boeking->user_name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 text-xs font-bold rounded-full
                                            {{ $boeking->status === 'confirmed' ? 'bg-green-500/10 text-green-400 border border-green-500/20' :
                                               ($boeking->status === 'pending' ? 'bg-amber-500/10 text-amber-400 border border-amber-500/20' :
                                               'bg-red-500/10 text-red-400 border border-red-500/20') }}">
                                            {{ ucfirst($boeking->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                        <a href="{{ route('boekingen.edit', $boeking->id) }}" class="text-indigo-400 hover:text-indigo-300 font-medium transition-colors">Bewerken</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-slate-500 font-medium">
                                        Geen boekingen gevonden.
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
