<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tasks') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Create task
                    </button>

                    <table class="table mt-4">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center">#</th>
                                <th scope="col" class="text-center">Title</th>
                                <th scope="col" class="text-center">Description</th>
                                <th scope="col" class="text-center">Price</th>
                                <th scope="col" class="text-center">Start Date</th>
                                <th scope="col" class="text-center">Due Date</th>
                                <th scope="col" class="text-center"></th>
                                <th scope="col" class="text-center"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($tasks) > 0)
                                @foreach ($tasks as $task)
                                    <tr>
                                        <th scope="row">{{ $task->id }}</th>
                                        <td class="text-center">{{ $task->title }}</td>
                                        <td class="text-center">{{ $task->description }}</td>
                                        <td class="text-center">{{ $task->price }} $</td>
                                        <td class="text-center">{{ $task->start_date }}</td>
                                        <td class="text-center">{{ $task->due_date }}</td>
                                        <td class="text-center">
                                            @if (Auth::id() === $task->user_id)
                                                <form action="{{ route("tasks.destroy", $task->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a class="btn btn-primary"
                                                href="{{ route('tasks.details', $task->id) }}">Details</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>



                </div>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Create Task</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form action="{{ url('tasks') }}" method="POST">
                                {{ csrf_field() }}
                                <div class="modal-body">

                                    <div class="mb-3">
                                        <label for="inputTitle" class="form-label">Title</label>
                                        <input type="text" class="form-control" id="inputTitle" name="title">
                                    </div>
                                    <div class="mb-3">
                                        <label for="textAreaDescription" class="form-label">Description</label>
                                        <textarea class="form-control" id="textAreaDescription" name="description"
                                            rows="2"></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="inputPrice" class="form-label">Price</label>
                                        <input type="number" class="form-control" id="inputPrice" name="price">
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label for="inputStartDate" class="form-label">Start Date</label>
                                                <input type="date" class="form-control" id="inputStartDate"
                                                    name="start_date" value="{{ now()->format('Y-m-d') }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3">
                                                <label for="inputDueDate" class="form-label">Due Date</label>
                                                <input type="date" class="form-control" id="inputDueDate"
                                                    name="due_date">
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>