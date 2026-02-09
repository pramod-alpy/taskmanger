<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Task;
use App\Models\Project;

class TaskController extends Controller
{
    /**
     * List all tasks with their projects and project filter when a user logged in.
     * @param Request $request containing the project_id
     * @return \Illuminate\View\View
     */

    public function index(Request $request)
    {
        $projects = Project::all();

        $projectId = $request->project_id;

        $tasks = Task::with('project')
            ->orderBy('priority')
            ->when($projectId, fn($q) =>
                $q->where('project_id',$projectId)
            )->get();

        return view('tasks.index', compact('tasks','projects','projectId'));
    }

    /**
     * Create  a new task by selecting a project.
     * @param Request $request containing the name and project_id
     * @return \Illuminate\Http\RedirectResponse
     */

    public function store(Request $request)
    {
        $maxPriority = Task::where('project_id',$request->project_id)->max('priority');

        Task::create([
            'name' => $request->name,
            'project_id' => $request->project_id,
            'priority' => $maxPriority + 1
        ]);

        return back();
    }
    /**
     * Update a task name.
     * @param Task $task the task to update
     * @param Request $request containing the name
     * @return \Illuminate\Http\RedirectResponse
     */

    public function update(Task $task, Request $request)
    {
        $task->update(['name' => $request->name]);
        return back();
    }

    /**
     * Delete a task.
     * @param Task $task the task to delete
     * @return \Illuminate\Http\RedirectResponse
     */
    
    public function destroy(Task $task)
    {
        $task->delete();
        return back();
    }

    /**
     * Reorder tasks by dragging and dropping.
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function reorder(Request $request)
    {
        foreach ($request->order as $index => $id) {

            Task::where('id', $id)
                ->update(['priority' => $index + 1]);
        }

        return response()->json(['success' => true]);
    }
}
