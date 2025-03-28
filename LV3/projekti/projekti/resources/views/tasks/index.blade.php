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
                    <div class="row mt-2 mb-2">
                        @if (count($tasks) > 0)
                            @foreach ($tasks as $task)
                                <div class="card ms-3 mb-3" style="width: 18rem;">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $task->title }}</h5>
                                        <h6 class="card-subtitle mb-2 text-muted">
                                            {{date('d.m.Y', strtotime($task->start_date)) }} -
                                            {{date('d.m.Y', strtotime($task->due_date)) }}
                                        </h6>
                                        <p class="card-text">{{ $task->description }}</p>
                                        <div class="row">
                                            <a href="{{ route('tasks.details', $task->id) }}"
                                                class="card-link text-end">Open</a>
                                        </div>

                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
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