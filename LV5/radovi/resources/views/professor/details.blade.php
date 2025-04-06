<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">

        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="row">
                    <div class="col p-6">
                        <h1>{{ $dissertation->title }}</h1>
                        <h3>{{ $dissertation->eng_title }}</h3>
                        <p>{{ $dissertation->description }}</p>
                        <p>{{ $dissertation->course }}</p>
                        <p>Odobreni student: {{ $approved_student->name}}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-2">
                <div class="row p-6">
                    <table class="table ">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">E-mail</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($students as $student)
                                <tr>
                                    <th scope="row">{{ $student->id }}</th>
                                    <td>{{$student->name}}</td>
                                    <td>{{$student->email}}</td>
                                    <td>
                                        <form method="POST"
                                            action="{{ route("professor.approve_student", $dissertation->id) }}">
                                            {{ csrf_field() }}
                                            <input type="number" hidden name="student_id" value="{{ $student->id }}">
                                            <button type="submit" class="btn btn-primary">Odobri</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>