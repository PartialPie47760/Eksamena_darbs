<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Managment of users') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <h3 class="text-lg font-medium text-gray-900 mb-4">List of users</h3>

                    <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="py-3 px-6">Name</th>
                                    <th scope="col" class="py-3 px-6">Email</th>
                                    <th scope="col" class="py-3 px-6">Role</th>
                                    {{-- <th scope="col" class="py-3 px-6">Status</th> --}}
                                    <th scope="col" class="py-3 px-6">Actiones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $user)
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                            {{ $user->name }}
                                        </th>
                                        <td class="py-4 px-6">{{ $user->email }}</td>
                                        <td class="py-4 px-6">{{ $user->role }}</td>
                                        {{-- <td class="py-4 px-6">
                                            @if (isset($user->is_blocked) && $user->is_blocked)
                                                <span class="text-red-600">Blocked</span>
                                            @else
                                                <span class="text-green-600">Active</span>
                                            @endif
                                        </td> --}}
                                        <td class="py-4 px-6 flex space-x-2">
                                            <a href="{{ route('admin.users.edit', $user) }}" class="font-medium text-blue-600 hover:underline">Edit</a>
                                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Are you sure you want to block that user?');">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="font-medium text-red-600 hover:underline">Delete</button>
                                            </form>
                                            {{-- 'is_blocked' --}}
                                            {{-- @if (isset($user->is_blocked) && $user->is_blocked)
                                                <form action="{{ route('admin.users.unblock', $user) }}" method="POST">
                                                    @csrf
                                                    @method('patch')
                                                    <button type="submit" class="font-medium text-green-600 hover:underline">Unblock</button>
                                                </form>
                                            @else
                                                <form action="{{ route('admin.users.block', $user) }}" method="POST">
                                                    @csrf
                                                    @method('patch')
                                                    <button type="submit" class="font-medium text-orange-600 hover:underline">Block</button>
                                                </form>
                                            @endif --}}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-4 px-6 text-center text-gray-500">Users not found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $users->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>