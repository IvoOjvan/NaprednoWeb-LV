<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tasks') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="row gx-2">
                <div class="col-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-2">
                        <form action="{{ route('tasks.update', $task->id)  }}" method="POST" class="p-6">
                            {{ csrf_field() }}
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col">
                                        <label for="inputTitle" class="form-label">Title</label>
                                        <input type="text" class="form-control" id="inputTitle" name="title"
                                            value="{{ $task->title }}" @disabled(Auth::id() !== $task->user_id)>
                                    </div>
                                    <div class="col">
                                        <label for="inputPrice" class="form-label">Price</label>
                                        <input type="number" class="form-control" id="inputPrice" name="price"
                                            value="{{ $task->price }}" @disabled(Auth::id() !== $task->user_id)>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="inputStartDate" class="form-label">Start Date</label>
                                        <input type="date" class="form-control" id="inputStartDate" name="start_date"
                                            value="{{ $task->start_date }}" readonly>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="inputDueDate" class="form-label">Due Date</label>
                                        <input type="date" class="form-control" id="inputDueDate" name="due_date"
                                            value="{{ $task->due_date }}" @disabled(Auth::id() !== $task->user_id)>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="textAreaDescription" class="form-label">Description</label>
                                <textarea class="form-control" id="textAreaDescription" name="description" rows="2"
                                    @disabled(Auth::id() !== $task->user_id)>{{ $task->description }}</textarea>
                            </div>

                            @if(Auth::id() === $task->user_id)
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
                <div class="col-4">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-2">
                        <div class="p-6">
                            Collaborators
                            @if (count($users) > 0)
                                <ul class="list-group">
                                    {{-- If logged user is NOT owner --}}
                                    @if (Auth::user()->id !== $task->user_id)
                                        @foreach ($users as $user)
                                            @if (in_array($user->id, explode(',', $task->collaborators)))
                                                <li class="list-group-item">{{ $user->email }}</li>
                                            @endif
                                        @endforeach

                                    @else
                                        {{-- If logged user IS owner --}}
                                        @foreach ($users as $user)
                                            @if ($user->id !== Auth::user()->id)
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-8">{{ $user->email }}</div>
                                                        <div class="col-4">
                                                            {{-- If user is NOT collaborator --}}
                                                            @if (!in_array($user->id, explode(',', $task->collaborators)))
                                                                <form action="{{ route('tasks.store_collaborator', $task->id) }}"
                                                                    method="POST">
                                                                    {{ csrf_field() }}
                                                                    <input type="number" hidden name="collaborator_id"
                                                                        value="{{ $user->id }}">
                                                                    <button class="btn btn-primary">Add</button>
                                                                </form>
                                                            @else
                                                                {{-- User IS collaborator --}}
                                                                <form action="{{ route('tasks.destroy_collaborator', $task->id) }}"
                                                                    method="POST">
                                                                    {{ csrf_field() }}
                                                                    @method('DELETE')
                                                                    <input type="number" hidden name="collaborator_id"
                                                                        value="{{ $user->id }}">
                                                                    <button class="btn btn-danger">Remove</button>
                                                                </form>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </li>
                                            @endif
                                        @endforeach
                                    @endif
                                </ul>
                            @else
                                <div class="text-gray-900">
                                    <p>No collaborators on this task.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg ">
                <div class="p-6 text-gray-900">

                    <form action="{{ route("tasks.store_completed_job", $task->id) }}" method="POST">
                        {{ csrf_field() }}
                        <div class="mb-3">
                            <label for="textAreaComplitedJob" class="form-label">Add new completed job</label>
                            <textarea class="form-control" id="textAreaComplitedJob" name="completed_job"
                                rows="2"></textarea>
                        </div>
                        <div class="mb-3 text-end">
                            <button class="btn btn-primary" type="submit">Add</button>
                        </div>
                    </form>

                    <ul class="list-group">
                        <h1 class="mb-2">Completed jobs</h1>
                        @if (!empty($task->completed_jobs))
                            @foreach (explode(',', $task->completed_jobs) as $completed_job)
                                <li class="list-group-item">{{ trim($completed_job) }}</li>
                            @endforeach
                        @else
                            <div class="text-gray-900">
                                <p>No completed jobs yet.</p>
                            </div>

                        @endif
                    </ul>
                </div>
            </div>@if (Auth::id() === $task->user_id)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-2">
                    <div class="px-6 py-2">


                        <form action="{{ route("tasks.destroy", $task->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <div class="row">
                                <div class="col">
                                    <div class="text-danger pt-4">
                                        Do you want to delete task: {{ $task->title }}?
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="text-end py-3">
                                        <button type="submit" class="btn btn-danger">Delete Task</button>
                                    </div>
                                </div>
                            </div>

                        </form>

                    </div>

                </div>
            @endif
        </div>
    </div>
</x-app-layout>