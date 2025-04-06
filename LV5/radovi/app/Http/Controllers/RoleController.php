<?php

namespace App\Http\Controllers;

use App\Models\Dissertation;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    //
    public function index()
    {
        $users = User::where('role', '!=', 'admin')->get();
        return view('admin.users', compact('users'));
    }

    public function professorIndex(Request $request)
    {
        $user = Auth::user();
        $dissertations = Dissertation::where('user_id', $user->id)
            ->orderBy("id", "desc")
            ->paginate(10);
        return view('professor.index', compact('dissertations'));
    }

    public function studentIndex(Request $request)
    {
        $user = Auth::user();
        $dissertations = Dissertation::all();
        return view('student.index', compact('dissertations', 'user'));
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => ['required', 'in:student,professor'],
        ]);

        $user->update(['role' => $request->role]);

        return redirect()->back()->with('success', 'Uloga promijenjena.');
    }

    public function storeDissertation(Request $request)
    {
        $request->user()->dissertations()->create([
            'title' => $request->title,
            'eng_title' => $request->title_eng,
            'description' => $request->description,
            'course' => $request->course
        ]);

        return redirect()->back()->with('success', '');
    }

}
