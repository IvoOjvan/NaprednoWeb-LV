<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-2">

                <div class="p-6 text-gray-900">
                    <div class="row">
                        @foreach ($dissertations as $diss)
                            <div class="card me-2 mb-2" style="width: 18rem;">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $diss->title }} ({{ $diss->eng_title }})</h5>
                                    <p class="card-text py-2">Smjer: {{ $diss->course }}</p>
                                    <p class="card-text py-2">{{ $diss->description }}</p>
                                    <form method="POST" action="{{ route("student.dissertations.select", $diss->id) }}">
                                        {{ csrf_field() }}
                                        <input type="number" name="student_id" value="{{ $user->id }}" hidden>
                                        <button type="submit" class="btn btn-primary">Odaberi</button>
                                    </form>


                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>