<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Projects') }}
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

                    <div class="mb-6">
                        <a href="{{ route('projects.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Create new project
                        </a>
                    </div>

                    <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="py-3 px-6">Name</th>
                                    <th scope="col" class="py-3 px-6">Description</th>
                                    <th scope="col" class="py-3 px-6">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($projects as $project)
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                            <a href="{{ route('projects.show', $project) }}" class="text-blue-600 hover:underline">{{ $project->name }}</a>
                                        </th>
                                        <td class="py-4 px-6">{{ Str::limit($project->description, 100) }}</td>
                                        <td class="py-4 px-6 flex space-x-2">
                                            <a href="{{ route('projects.edit', $project) }}" class="font-medium text-blue-600 hover:underline">Edit</a>
                                            <form action="{{ route('projects.destroy', $project) }}" method="POST" onsubmit="return confirm('Are you suru you want to delete the project and everything belonging to it?');">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="font-medium text-red-600 hover:underline">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="py-4 px-6 text-center text-gray-500">Projects not found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $projects->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>