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
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <form action="{{ route('admin.users.updateRole', $user) }}" method="POST" class="inline-flex items-center space-x-2">
                                            @csrf
                                            @method('PATCH')
                                            <select name="role" class="bg-slate-900/50 border border-slate-700 text-slate-300 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block p-2 transition-all duration-200 hover:border-slate-600">
                                                <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                                                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                            </select>
                                            <button type="submit" class="px-4 py-2 bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white text-sm font-medium rounded-lg shadow-lg shadow-indigo-500/20 transition-all duration-200 transform hover:-translate-y-0.5">
                                                Save
                                            </button>
                                        </form>
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
