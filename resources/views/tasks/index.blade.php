<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My tasks') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- Massage about success --}}
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <h3 class="text-lg font-medium text-gray-900 mb-4">List of tasks</h3>

                    {{-- Button "Create new task" (available for Supreme User and Admin) --}}
                    @can('create', App\Models\Task::class)
                        <div class="mb-6">
                            <a href="{{ route('tasks.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Create new task
                            </a>
                        </div>
                    @endcan

                    {{-- Filtration and Search form --}}
                    <form method="GET" action="{{ route('tasks.index') }}" class="mb-6 p-4 border rounded-lg bg-gray-50">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            <div>
                                <label for="search" class="block text-sm font-medium text-gray-700">Search after info</label>
                                <input type="text" name="search" id="search" value="{{ request('search') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            </div>

                            <div>
                                <label for="status_id" class="block text-sm font-medium text-gray-700">Status</label>
                                <select name="status_id" id="status_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="">All statuses</option>
                                    @foreach($statuses as $status)
                                        <option value="{{ $status->id }}" {{ (request('status_id') == $status->id) ? 'selected' : '' }}>{{ $status->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="priority_id" class="block text-sm font-medium text-gray-700">Priority</label>
                                <select name="priority_id" id="priority_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="">All priorities</option>
                                    @foreach($priorities as $priority)
                                        <option value="{{ $priority->id }}" {{ (request('priority_id') == $priority->id) ? 'selected' : '' }}>{{ $priority->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="tag_id" class="block text-sm font-medium text-gray-700">Tag</label>
                                <select name="tag_id" id="tag_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="">All tags</option>
                                    @foreach($tags as $tag)
                                        <option value="{{ $tag->id }}" {{ (request('tag_id') == $tag->id) ? 'selected' : '' }}>{{ $tag->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mt-4 flex space-x-2">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Adjust filtres
                            </button>
                            <a href="{{ route('tasks.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Drop filtres
                            </a>
                        </div>
                    </form>

                    {{-- Tasks Table --}}
                    <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="py-3 px-6">Name</th>
                                    <th scope="col" class="py-3 px-6">Status</th>
                                    <th scope="col" class="py-3 px-6">Priority</th>
                                    <th scope="col" class="py-3 px-6">Due to</th>
                                    <th scope="col" class="py-3 px-6">Author</th>
                                    <th scope="col" class="py-3 px-6">Responsible</th>
                                    <th scope="col" class="py-3 px-6">Project</th>
                                    <th scope="col" class="py-3 px-6">Tags</th>
                                    <th scope="col" class="py-3 px-6">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($tasks as $task)
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                            <a href="{{ route('tasks.show', $task) }}" class="text-blue-600 hover:underline">{{ $task->title }}</a>
                                        </th>
                                        <td class="py-4 px-6">{{ $task->status->name }}</td>
                                        <td class="py-4 px-6">{{ $task->priority->name }}</td>
                                        <td class="py-4 px-6">{{ $task->due_date ? $task->due_date->format('Y-m-d') : 'N/A' }}</td>
                                        <td class="py-4 px-6">{{ $task->user->name }}</td>
                                        <td class="py-4 px-6">{{ $task->assignedTo->name ?? 'Not assigned' }}</td>
                                        <td class="py-4 px-6">{{ $task->project->name ?? 'Without a project' }}</td>
                                        <td class="py-4 px-6">
                                            @forelse($task->tags as $tag)
                                                <span class="bg-gray-200 text-gray-800 text-xs font-medium mr-1 px-2.5 py-0.5 rounded">{{ $tag->name }}</span>
                                            @empty
                                                Not
                                            @endforelse
                                        </td>
                                        <td class="py-4 px-6 flex space-x-2">
                                            @can('update', $task)
                                                <a href="{{ route('tasks.edit', $task) }}" class="font-medium text-blue-600 hover:underline">EDIT</a>
                                            @endcan

                                            @can('markAsCompleted', $task)
                                                @if($task->status->name !== 'Completed')
                                                    <form action="{{ route('tasks.complete', $task) }}" method="POST" onsubmit="return confirm('Are you sure about marking this task as COMPLETED?');">
                                                        @csrf
                                                        @method('patch')
                                                        <button type="submit" class="font-medium text-green-600 hover:underline">Do the thing</button>
                                                    </form>
                                                @else
                                                    <span class="text-gray-500">Complete</span>
                                                @endif
                                            @endcan

                                            @can('delete', $task)
                                                <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Bruh, you really wanna delete this task?');">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="font-medium text-red-600 hover:underline">Delete</button>
                                                </form>
                                            @endcan
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="py-4 px-6 text-center text-gray-500">Tasks not found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagnation --}}
                    <div class="mt-6">
                        {{ $tasks->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>