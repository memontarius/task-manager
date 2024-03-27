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
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class TaskController extends Controller
{
    public function index(Request $request): Response|\Illuminate\Http\RedirectResponse
    {
        $query = $request->validate([
            'page' => 'numeric',
            'perPage' => 'numeric',
            'filter' => ''
        ]);

        $page = $query['page'] ?? 1;
        $perPage = $query['perPage'] ?? 10;
        $query['page'] = $page;

        try {
            $paginatedTasks = QueryBuilder::for(Task::class)
                ->allowedFilters([
                    AllowedFilter::exact('status_id'),
                    AllowedFilter::exact('created_by_id'),
                    AllowedFilter::exact('assigned_to_id')])
                ->orderBy('id')
                ->paginate(
                    perPage: $perPage,
                    page: $page
                );
        }
        catch (\Exception $exception) {
            return to_route('tasks.index');
        }

        $statuses = TaskStatus::all()->toArray();
        $users = User::all()->sortBy('id');

        return Inertia::render('Tasks/Index', [
                'tasks' => MinifiedTaskResource::collection($paginatedTasks->items()),
                'page' => $paginatedTasks->currentPage(),
                'perPage' => $paginatedTasks->perPage(),
                'total' => $paginatedTasks->total(),
                'params' => $query,
                'statuses' => $statuses,
                'users' => $users
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
