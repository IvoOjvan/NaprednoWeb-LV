<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Add Dissertation
                    </button>
                </div>

            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-2">

                <div class="p-6 text-gray-900">
                    <div class="row">
                        @foreach ($dissertations as $diss)
                            <div class="card me-2 mb-2" style="width: 18rem;">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $diss->title }}</h5>
                                    <p class="card-text py-2">{{ $diss->description }}</p>
                                    <a href="{{ route("professor.dissertation.details", $diss->id) }}"
                                        class="btn btn-primary">Details</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route("professor.storeDissertation") }}" method="POST">
                    {{ csrf_field() }}
                    <div class="modal-body">

                        <div class="mb-3">
                            <label for="inputTitle" class="form-label">Title</label>
                            <input type="text" class="form-control" id="inputTitle" name="title">
                        </div>
                        <div class="mb-3">
                            <label for="inputTitleEng" class="form-label">English Title</label>
                            <input type="text" class="form-control" id="inputTitleEng" name="title_eng">
                        </div>
                        <div class="mb-3">
                            <label for="textAreaDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="textAreaDescription" name="description"
                                rows="2"></textarea>
                        </div>
                        <div class="mb-3">
                            <select class="form-select" aria-label="Default select example" name="course">
                                <option value="strucni">Strucni</option>
                                <option value="preddiplomski">Preddiplomski</option>
                                <option value="diplomski">Diplomski</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    </div>
</x-app-layout>