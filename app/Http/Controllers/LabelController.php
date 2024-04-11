<?php

namespace App\Http\Controllers;

use App\Http\Resources\LabelResource;
use App\Models\Label;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class LabelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $labels = Label::all()->sortBy('id');

        return Inertia::render('Labels/Index', [
            'labels' => LabelResource::collection($labels)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Labels/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        Label::create($request->validate([
            'name' => ['required', 'min:3', 'max:32', "unique:labels"],
            'description' => 'string|nullable'
        ]));

        return Redirect::back()
            ->with('message', [__('New label created successfully')]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Label $label): Response
    {
        return Inertia::render('Labels/Show', [
            'label' => $label
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Label $label): Response
    {
        return Inertia::render('Labels/Edit', [
            'label' => $label
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Label $label): RedirectResponse
    {
        $label->update($request->validate([
            'name' => ['required', 'min:3', 'max:32'],
            'description' => 'string|nullable'
        ]));

        return Redirect::back()
            ->with('message', [__('Label updated successfully')]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Label $label): RedirectResponse
    {
        $messages = [];

        if ($label->tasks()->exists()) {
            $messages[] = __('Failed to remove label');
        }
        else {
            $label->delete();
        }

        return Redirect::back()
            ->with('message', $messages);
    }
}
