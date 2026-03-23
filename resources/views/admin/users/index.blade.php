<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-bold text-3xl text-slate-100 tracking-tight">
                {{ __('User Management') }}
            </h2>
            <p class="mt-1 text-sm text-slate-400 font-medium">Admins can see and manage all users' roles here.</p>
        </div>
    </x-slot>

    <!-- Content without the inner py-12 div since app.blade.php handles padding -->
    <div class="space-y-6">
            
            @if(session('success'))
                <div class="mb-6 p-4 rounded-xl bg-green-500/10 border border-green-500/20 text-green-400 backdrop-blur-md shadow-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 rounded-xl bg-red-500/10 border border-red-500/20 text-red-400 backdrop-blur-md shadow-lg">
                    {{ session('error') }}
                </div>
            @endif

            <div class="flex items-center space-x-3">
            <a href="{{ route('admin.users.create') }}" class="px-4 py-2 bg-indigo-500 text-white text-sm font-semibold rounded-xl hover:bg-indigo-600 transition-colors shadow-lg shadow-indigo-500/20">
                Nieuw Account Toevoegen
            </a>
        </div>

            <div class="bg-slate-800/60 backdrop-blur-xl overflow-hidden shadow-xl sm:rounded-2xl border border-slate-700/50">
                <div class="p-6 text-slate-200">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-slate-700/50">
                                    <th class="px-6 py-4 text-xs uppercase tracking-wider text-slate-400 font-medium">Name</th>
                                    <th class="px-6 py-4 text-xs uppercase tracking-wider text-slate-400 font-medium">Email</th>
                                    <th class="px-6 py-4 text-xs uppercase tracking-wider text-slate-400 font-medium">Joined</th>
                                    <th class="px-6 py-4 text-xs uppercase tracking-wider text-slate-400 font-medium text-right">Role</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-700/50">
                                @foreach($users as $user)
                                <tr class="hover:bg-slate-700/30 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap font-medium text-slate-200">
                                        {{ $user->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-slate-400">
                                        {{ $user->email }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-slate-400 text-sm">
                                        {{ $user->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                        <div class="flex items-center justify-end space-x-3">
                                            <a href="{{ route('admin.users.edit', $user->id) }}" class="text-indigo-400 hover:text-indigo-300 font-medium transition-colors">Bewerken</a>
                                            
                                            <form action="{{ route('admin.users.updateRole', $user->id) }}" method="POST" class="inline-flex items-center space-x-2">
                                                @csrf
                                                @method('PATCH')
                                                <select name="role" class="bg-slate-900/50 border border-slate-700 text-slate-300 text-[10px] font-bold uppercase rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block p-1.5 transition-all duration-200">
                                                    <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                                                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                                </select>
                                                <button type="submit" class="p-1.5 bg-indigo-500/10 text-indigo-400 border border-indigo-500/30 hover:bg-indigo-500/30 rounded-lg transition-all" title="Rol Opslaan">
                                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                                </button>
                                            </form>

                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Weet je zeker dat je deze gebruiker wilt verwijderen?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-slate-500 hover:text-rose-400 transition-colors" title="Verwijderen">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
</x-app-layout>
