<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Task's detales: ') . $task->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ $task->title }}</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <p class="text-sm text-gray-600">Description:</p>
                            <p class="text-base">{{ $task->description ?? 'Just no description' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Status:</p>
                            <p class="text-base">{{ $task->status->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Prority:</p>
                            <p class="text-base">{{ $task->priority->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Deadline:</p>
                            <p class="text-base">{{ $task->due_date ? $task->due_date->format('Y-m-d') : 'No deadline' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Author:</p>
                            <p class="text-base">{{ $task->user->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Responsible:</p>
                            <p class="text-base">{{ $task->assignedTo->name ?? 'Not assigned' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Project:</p>
                            <p class="text-base">{{ $task->project->name ?? 'Without project' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Tags:</p>
                            <p class="text-base">
                                @forelse($task->tags as $tag)
                                    <span class="bg-gray-200 text-gray-800 text-xs font-medium mr-1 px-2.5 py-0.5 rounded">{{ $tag->name }}</span>
                                @empty
                                    No
                                @endforelse
                            </p>
                        </div>
                    </div>

                    <div class="flex space-x-2 mb-6">
                        @can('update', $task)
                            <a href="{{ route('tasks.edit', $task) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                Edit
                            </a>
                        @endcan
                        @can('delete', $task)
                            <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Are you sure you will to delete this task?');">
                                @csrf
                                @method('delete')
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700">
                                    Delete
                                </button>
                            </form>
                        @endcan
                    </div>

                    {{-- Comments --}}
                    <h4 class="text-lg font-medium text-gray-900 mb-4 mt-8">Comments</h4>
                    <div class="space-y-4">
                        @forelse ($task->comments as $comment)
                            <div class="bg-gray-100 p-4 rounded-lg">
                                <p class="text-sm font-semibold text-gray-800">{{ $comment->user->name }} <span class="text-gray-500 text-xs">- {{ $comment->created_at->format('d.m.Y H:i') }}</span></p>
                                <p class="text-gray-700">{{ $comment->content }}</p>
                            </div>
                        @empty
                            <p class="text-gray-500">No comments yet.</p>
                        @endforelse
                    </div>

                    {{-- Adding form --}}
                    <div class="mt-8">
                        <h4 class="text-lg font-medium text-gray-900 mb-4">Add comment</h4>
                        <form method="POST" action="{{ route('comments.store', $task) }}">
                            @csrf
                            <div class="mb-4">
                                <label for="content" class="sr-only">Your comment</label>
                                <textarea name="content" id="content" rows="3" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="This could be your comment..."></textarea>
                                @error('content')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Add comment
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>