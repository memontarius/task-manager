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
    public function index(): Response
    {
        $statuses = TaskStatus::all();

        return Inertia::render('Statuses', [
            'statuses' => TaskStatusResource::collection($statuses)
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Statuses/Create');
    }

    public function store(Request $request): RedirectResponse
    {
        $table = TaskStatus::getTableName();

        $data = $request->validate([
            'name' => ['required', 'min:3', "unique:{$table}"]
        ]);

        TaskStatus::create($data);
        return Redirect::route('statuses.create')->with('message', ['New status created successfully']);
    }

    public function edit(string $id): Response
    {
        echo static::class . " edit";
        die();
        return 'edit';
    }

    public function show(string $id): Response
    {
        echo static::class . " show";
        die();
        return 'edit';
    }

    public function update(string $id): Response
    {
        echo static::class . " update";
        die();
        return 'update';
    }
}
