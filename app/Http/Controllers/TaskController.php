<?php

namespace App\Http\Controllers;

use App\Http\Resources\MinifiedTaskResource;
use App\Http\Resources\RealTaskResource;
use App\Http\Resources\TaskResource;
use App\Models\Label;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class TaskController extends Controller
{
    public function index(Request $request): \Inertia\Response
    {
        $query = $request->validate([
            'page' => 'numeric',
            'perPage' => 'numeric',
        ]);

        $page = $query['page'] ?? 1;
        $perPage = $query['perPage'] ?? 10;
        $query['page'] = $page;

        $paginatedTasks = Task::orderBy('id')->paginate(
            page: $page,
            perPage: $perPage
        );

        $tasks = $paginatedTasks->items();

        return Inertia::render('Tasks/Index', [
                'tasks' => MinifiedTaskResource::collection($tasks),
                'page' => $paginatedTasks->currentPage(),
                'perPage' => $paginatedTasks->perPage(),
                'total' => $paginatedTasks->total(),
                'params' => $query
            ]);
    }

    public function create(): \Inertia\Response
    {
        $statuses = TaskStatus::all()->toArray();
        $users = User::all()->sortBy('id');
        $labels = Label::all();

        return Inertia::render('Tasks/Create', [
            'statuses' => $statuses,
            'users' => $users,
            'labels' => $labels
            ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|min:3',
            'description' => 'max:128',
            'status_id' => '',
            'assigned_to_id' => '',
            'label_id' => ''
        ]);

        $levelIds = $data['label_id'] ?? [];
        unset($data['label_id']);
        $data['created_by_id'] = $request->user()->id;

        $task = new Task($data);
        $task->save();
        if (!empty($levelIds)) {
            $task->labels()->attach($levelIds);
        }

        return Redirect::back()
            ->with('message', [__('Task created successfully')]);
    }

    public function show(Task $task): Response
    {
        return Inertia::render('Tasks/Show', [
            'task' => RealTaskResource::make($task)
        ]);
    }

    public function edit(Task $task): \Inertia\Response
    {
        $statuses = TaskStatus::all()->toArray();
        $users = User::all()->sortBy('id');
        $labels = Label::all();

        return Inertia::render('Tasks/Edit', [
            'task' => TaskResource::make($task),
            'statuses' => $statuses,
            'users' => $users,
            'labels' => $labels
        ]);
    }

    public function update(Task $task, Request $request): \Illuminate\Http\RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|min:3',
            'description' => 'max:128',
            'status_id' => '',
            'assigned_to_id' => '',
            'label_id' => ''
        ]);

        $levelIds = $data['label_id'] ?? [];
        unset($data['label_id']);

        $task->update($data);
        $task->labels()->sync($levelIds);

        return Redirect::back()
            ->with('message', [__('Task updated successfully')]);
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return Redirect::back();
    }
}
