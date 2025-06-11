<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create new task') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Task creation form</h3>

                    <form method="POST" action="{{ route('tasks.store') }}">
                        @csrf

                        {{-- Name --}}
                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700">Name of the task</label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}" required autofocus class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            @error('title')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" id="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Status --}}
                        <div class="mb-4">
                            <label for="status_id" class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status_id" id="status_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                @foreach($statuses as $status)
                                    <option value="{{ $status->id }}" {{ (old('status_id') == $status->id) ? 'selected' : '' }}>{{ $status->name }}</option>
                                @endforeach
                            </select>
                            @error('status_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Priority --}}
                        <div class="mb-4">
                            <label for="priority_id" class="block text-sm font-medium text-gray-700">Priority</label>
                            <select name="priority_id" id="priority_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                @foreach($priorities as $priority)
                                    <option value="{{ $priority->id }}" {{ (old('priority_id') == $priority->id) ? 'selected' : '' }}>{{ $priority->name }}</option>
                                @endforeach
                            </select>
                            @error('priority_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Deadline --}}
                        <div class="mb-4">
                            <label for="due_date" class="block text-sm font-medium text-gray-700">Deadline</label>
                            <input type="date" name="due_date" id="due_date" value="{{ old('due_date') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            @error('due_date')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Responsible (only Supreme User and Admin) --}}
                        @can('assignUser', App\Models\Task::class)
                            <div class="mb-4">
                                <label for="assigned_to_user_id" class="block text-sm font-medium text-gray-700">Assign to user</label>
                                <select name="assigned_to_user_id" id="assigned_to_user_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="">Not assigned</option>
                                    @foreach($users as $userOption)
                                        <option value="{{ $userOption->id }}" {{ (old('assigned_to_user_id') == $userOption->id) ? 'selected' : '' }}>{{ $userOption->name }} ({{ $userOption->email }})</option>
                                    @endforeach
                                </select>
                                @error('assigned_to_user_id')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        @endcan

                        {{-- Project --}}
                        <div class="mb-4">
                            <label for="project_id" class="block text-sm font-medium text-gray-700">Project</label>
                            <select name="project_id" id="project_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="">Without project</option>
                                @foreach($projects as $project)
                                    <option value="{{ $project->id }}" {{ (old('project_id') == $project->id) ? 'selected' : '' }}>{{ $project->name }}</option>
                                @endforeach
                            </select>
                            @error('project_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Tags (multichoise) --}}
                        <div class="mb-4">
                            <label for="tags" class="block text-sm font-medium text-gray-700">Tags</label>
                            <select name="tags[]" id="tags" multiple class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                @foreach($tags as $tag)
                                    <option value="{{ $tag->id }}" {{ (in_array($tag->id, old('tags', []))) ? 'selected' : '' }}>{{ $tag->name }}</option>
                                @endforeach
                            </select>
                            @error('tags')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            @error('tags.*')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Create task
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>