<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin's statistics') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Overall statistics</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div class="p-4 bg-blue-100 rounded-lg shadow-md">
                            <h4 class="font-semibold text-blue-800">Tasks total</h4>
                            <p class="text-3xl font-bold text-blue-900">{{ $totalTasks }}</p>
                        </div>
                        <div class="p-4 bg-green-100 rounded-lg shadow-md">
                            <h4 class="font-semibold text-green-800">Tsaks completed</h4>
                            <p class="text-3xl font-bold text-green-900">{{ $completedTasks }}</p>
                        </div>
                        <div class="p-4 bg-purple-100 rounded-lg shadow-md">
                            <h4 class="font-semibold text-purple-800">Total users</h4>
                            <p class="text-3xl font-bold text-purple-900">{{ $totalUsers }}</p>
                        </div>
                        <div class="p-4 bg-yellow-100 rounded-lg shadow-md">
                            <h4 class="font-semibold text-yellow-800">Task completed during last month</h4>
                            <p class="text-3xl font-bold text-yellow-900">{{ $completedTasksLastMonth }}</p>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</x-app-layout>