<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware("auth");
    }

    public function index(Request $request)
    {

        $user = Auth::user();

        $tasks = Task::where('user_id', $user->id)
            ->orWhere('collaborators', 'like', "%{$user->id}%")
            ->orderBy("id", "desc")
            ->paginate(10);

        return view('tasks.index', [
            'tasks' => $tasks,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'start_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:start_date',
        ]);

        $request->user()->tasks()->create([
            'title' => $request->title,
            'description' => $request->description,
            'price' => (integer) $request->price,
            'start_date' => $request->start_date,
            'due_date' => $request->due_date
        ]);

        return redirect()->back()->with('success', '');
    }

    public function destroy(Request $request, Task $task)
    {

        $this->authorize('destroy', $task);
        $task->delete();
        return redirect()->back()->with('success', '');
    }

    public function details(Request $request, string $task_id)
    {
        $task = Task::findOrFail($task_id);
        $this->authorize('details', $task);

        $users = User::all();


        return view('tasks.details', ['task' => $task, 'users' => $users]);
    }

    public function store_completed_job(Request $request, string $task_id)
    {
        $task = Task::findOrFail($task_id);
        $this->authorize('store_completed_job', $task);
        $completed_jobs = $task->completed_jobs ? explode(',', $task->completed_jobs) : [];
        $completed_jobs[] = $request->completed_job;
        $task->update([
            'completed_jobs' => implode(',', $completed_jobs)
        ]);
        return redirect()->back()->with('success', '');
    }

    public function update(Request $request, string $task_id)
    {
        $task = Task::findOrFail($task_id);
        $this->authorize('update', $task);

        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'price' => (integer) $request->price,
            'due_date' => $request->due_date
        ]);

        return redirect()->back()->with('success', '');
    }

    public function store_collaborator(Request $request, string $task_id)
    {
        $task = Task::findOrFail($task_id);
        $this->authorize('update', $task);
        $collaborators = $task->collaborators ? explode(',', $task->collaborators) : [];
        $collaborators[] = $request->collaborator_id;
        $task->update([
            'collaborators' => implode(',', $collaborators)
        ]);
        $task->update();
        return redirect()->back()->with('success', '');
    }

    public function destroy_collaborator(Request $request, string $task_id)
    {
        $task = Task::findOrFail($task_id);
        $this->authorize('update', $task);
        $collaborators = $task->collaborators ? explode(',', $task->collaborators) : [];
        // Remove the collaborator if they exist in the array
        $collaborators = array_filter($collaborators, fn($id) => $id != $request->collaborator_id);
        $task->update([
            'collaborators' => implode(',', $collaborators)
        ]);
        $task->update();
        return redirect()->back()->with('success', '');
    }
}
