<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Dissertation;
use App\Models\User;

class DissertationController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }

    //
    public function store(Request $request)
    {
        $request->user()->dissertations()->create([
            'title' => $request->title,
            'eng_title' => $request->title_eng,
            'description' => $request->description,
            'course' => $request->course
        ]);

        return redirect()->back()->with('success', '');
    }

    public function details(Request $request, string $dissertation_id)
    {
        $dissertation = Dissertation::findOrFail($dissertation_id);
        // Convert the comma-separated string into an array of IDs
        $studentIds = $dissertation->students
            ? explode(',', $dissertation->students)
            : [];

        // Fetch users with those IDs
        $students = User::whereIn('id', $studentIds)->get();
        $approved_student = "";
        if (!empty($dissertation->approved_student)) {
            $approved_student = User::find($dissertation->approved_student);
        }

        return view('professor.details', compact('dissertation', 'students', 'approved_student'));
    }

    public function storeStudentToDissertation(Request $request, string $dissertation_id)
    {
        \Log::info("Received POST for dissertation: $dissertation_id by student: {$request->student_id}");
        $dissertation = Dissertation::findOrFail($dissertation_id);

        $students = $dissertation->students ? explode(',', $dissertation->students) : [];

        if (!in_array($request->student_id, $students)) {
            $students[] = $request->student_id;

            $dissertation->update([
                'students' => implode(',', $students)
            ]);
        }

        return redirect()->back()->with('success', 'Disertacija je uspješno odabrana!');
    }

    public function approveStudent(Request $request, string $dissertation_id)
    {
        $dissertation = Dissertation::findOrFail($dissertation_id);
        if (empty($dissertation->approved_student)) {
            $dissertation->approved_student = $request->student_id;
            $dissertation->save();

            return redirect()->back()->with('success', 'Student uspješno odobren.');
        }

        return redirect()->back()->with('error', 'Student je već odobren za ovu temu.');
    }
}
