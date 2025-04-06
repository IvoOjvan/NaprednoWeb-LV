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
                    Admin
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">E-mail</th>
                                <th scope="col">Role</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <th scope="row">{{ $user->id }}</th>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>
                                        <form method="POST" action="{{ route("admin.users.updateRole", $user) }}">
                                            {{ csrf_field() }}
                                            <div class="row">
                                                <div class="col-8">
                                                    <select id="role" name="role" class="form-select"
                                                        aria-label="Default select example">
                                                        <option value="student" @if($user->role == "student") selected @endif>
                                                            Student
                                                        </option>
                                                        <option value="professor" @if($user->role == "professor") selected
                                                        @endif>
                                                            Professor</option>
                                                    </select>
                                                </div>
                                                <div class="col-4">
                                                    <button class="btn btn-primary">Save</button>
                                                </div>
                                            </div>


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