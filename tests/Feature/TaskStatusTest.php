<?php

namespace Tests\Feature;

use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;


class TaskStatusTest extends TestCase
{
    use RefreshDatabase;

    public function test_add_status()
    {
        $user = User::factory()->create();
        $statusName = 'New Status';

        $this
            ->actingAs($user)
            ->followingRedirects()
            ->from("/task_statuses/create")
            ->post("/task_statuses/create", [
                'name' => $statusName
            ])
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Statuses/Create')
                ->where('errors', []));
    }

    public function test_edit_name_status()
    {
        $user = User::factory()->create();
        $status = TaskStatus::factory()->create();
        $newName = "$status->name 2";

        $this
            ->actingAs($user)
            ->followingRedirects()
            ->from("/task_statuses/{$status->id}/edit")
            ->put("/task_statuses/{$status->id}", [
                'id' => $status->id,
                'name' => $newName
            ])
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Statuses/Edit')
                ->where('status.name', $newName));
    }
}
