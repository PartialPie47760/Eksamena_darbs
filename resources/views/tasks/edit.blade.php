<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Task') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Task's editing: "{{ $task->title }}"</h3>

                    <form method="POST" action="{{ route('tasks.update', $task) }}">
                        @csrf
                        @method('patch')

                        {{-- Field Name --}}
                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700">Name</label>
                            @can('create', App\Models\Task::class) {{-- Checking rights for creation/editing --}}
                                <input type="text" name="title" id="title" value="{{ old('title', $task->title) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            @else
                                <input type="text" name="title" id="title" value="{{ old('title', $task->title) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" readonly>
                                <input type="hidden" name="title" value="{{ $task->title }}">
                            @endcan
                            @error('title')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Field Description --}}
                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            @can('create', App\Models\Task::class)
                                <textarea name="description" id="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('description', $task->description) }}</textarea>
                            @else
                                <textarea name="description" id="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" readonly>{{ old('description', $task->description) }}</textarea>
                                <input type="hidden" name="description" value="{{ $task->description }}">
                            @endcan
                            @error('description')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Fiels Status  --}}
                        <div class="mb-4">
                            <label for="status_id" class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status_id" id="status_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                @foreach($statuses as $status)
                                    <option value="{{ $status->id }}" {{ (old('status_id', $task->status_id) == $status->id) ? 'selected' : '' }}>
                                        {{ $status->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Fields : Priority, Deadline, Responsible, Project, Tags --}}
                        {{-- Available only for Supreme user and Admin, or Author of the task --}}
                        @can('create', App\Models\Task::class) {{-- Usinf 'create' as almighty permission --}}
                            <div class="mb-4">
                                <label for="priority_id" class="block text-sm font-medium text-gray-700">Priority</label>
                                <select name="priority_id" id="priority_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    @foreach($priorities as $priority)
                                        <option value="{{ $priority->id }}" {{ (old('priority_id', $task->priority_id) == $priority->id) ? 'selected' : '' }}>
                                            {{ $priority->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('priority_id')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="due_date" class="block text-sm font-medium text-gray-700">Deadline</label>
                                <input type="date" name="due_date" id="due_date" value="{{ old('due_date', $task->due_date?->format('Y-m-d')) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                @error('due_date')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Field "Responsible" --}}
                            @can('assignUser', App\Models\Task::class) {{-- Checking the rights for assignance --}}
                                <div class="mb-4">
                                    <label for="assigned_to_user_id" class="block text-sm font-medium text-gray-700">Assign to user</label>
                                    <select name="assigned_to_user_id" id="assigned_to_user_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        <option value="">Not assigned</option>
                                        @foreach($users as $userOption)
                                            <option value="{{ $userOption->id }}" {{ (old('assigned_to_user_id', $task->assigned_to_user_id) == $userOption->id) ? 'selected' : '' }}>
                                                {{ $userOption->name }} ({{ $userOption->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('assigned_to_user_id')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            @else
                                {{-- No rights to assign a task , but ... bla bla bla --}}
                                @if($task->assignedTo)
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700">Responsible</label>
                                        <p class="mt-1 text-gray-900">{{ $task->assignedTo->name }}</p>
                                        <input type="hidden" name="assigned_to_user_id" value="{{ $task->assigned_to_user_id }}">
                                    </div>
                                @endif
                            @endcan

                            {{-- Project field --}}
                            <div class="mb-4">
                                <label for="project_id" class="block text-sm font-medium text-gray-700">Project</label>
                                <select name="project_id" id="project_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="">without project</option>
                                    @foreach($projects as $project)
                                        <option value="{{ $project->id }}" {{ (old('project_id', $task->project_id) == $project->id) ? 'selected' : '' }}>
                                            {{ $project->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('project_id')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Tags fiels (multichoise) --}}
                            <div class="mb-4">
                                <label for="tags" class="block text-sm font-medium text-gray-700">Tags</label>
                                <select name="tags[]" id="tags" multiple class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    @foreach($tags as $tag)
                                        <option value="{{ $tag->id }}" {{ (in_array($tag->id, old('tags', $task->tags->pluck('id')->toArray()))) ? 'selected' : '' }}>
                                            {{ $tag->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('tags')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                                @error('tags.*')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        @else
                            {{-- No rights for edit, but still is something in there --}}
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Priority</label>
                                <p class="mt-1 text-gray-900">{{ $task->priority->name }}</p>
                                <input type="hidden" name="priority_id" value="{{ $task->priority_id }}">
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Due to</label>
                                <p class="mt-1 text-gray-900">{{ $task->due_date?->format('Y-m-d') ?? 'N/A' }}</p>
                                <input type="hidden" name="due_date" value="{{ $task->due_date?->format('Y-m-d') }}">
                            </div>
                            @if($task->assignedTo)
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700">Responsible</label>
                                    <p class="mt-1 text-gray-900">{{ $task->assignedTo->name }}</p>
                                    <input type="hidden" name="assigned_to_user_id" value="{{ $task->assigned_to_user_id }}">
                                </div>
                            @endif
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Project</label>
                                <p class="mt-1 text-gray-900">{{ $task->project->name ?? 'Without project' }}</p>
                                <input type="hidden" name="project_id" value="{{ $task->project_id }}">
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Tags</label>
                                <p class="mt-1 text-gray-900">{{ $task->tags->pluck('name')->join(', ') }}</p>
                                @foreach($task->tags as $tag)
                                    <input type="hidden" name="tags[]" value="{{ $tag->id }}">
                                @endforeach
                            </div>
                        @endcan

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Save changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>