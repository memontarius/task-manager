<?php

namespace App\Http\Controllers;

use App\Http\Resources\TaskStatusResource;
use App\Models\TaskStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class TaskStatusController extends Controller
{
    private readonly string $table;

    public function __construct()
    {
        $this->table = TaskStatus::getTableName();
    }

    public function index(): Response
    {
        $statuses = TaskStatus::all()->sortBy('id');
        return Inertia::render('Statuses/Index', [
            'statuses' => TaskStatusResource::collection($statuses)
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Statuses/Create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'min:3', "unique:{$this->table}"]
        ]);

        TaskStatus::create($data);

        return Redirect::back()
            ->with('message', [__('New status created successfully')]);
    }

    public function edit(string $id): Response
    {
        $status = TaskStatus::findOrFail($id);

        return Inertia::render('Statuses/Edit', [
            'status' => $status
        ]);
    }

    public function show(string $id): Response
    {
        $status = TaskStatus::findOrFail($id);

        return Inertia::render('Statuses/Show', [
            'status' => $status
        ]);
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'min:3', "unique:{$this->table}"]
        ]);

        TaskStatus::where('id', $id)->update($data);

        return Redirect::back()
            ->with('message', [__('Status updated successfully')]);
    }

    public function destroy(string $id): RedirectResponse
    {
        $status = TaskStatus::findOrFail($id);
        $status->delete();

        return redirect()->route('statuses')
            ->with('message', [__('Status updated successfully')]);
    }
}
