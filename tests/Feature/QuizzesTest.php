<?php

namespace Tests\Feature;

use App\Models\Quiz;
use App\Models\Tenant;
use App\Models\User;

test('quizzes list page is displayed', function () {
    $user = User::factory()->create();
    $tenant = Tenant::factory()->create([
        "user_id" => $user->id,
    ]);
    $quiz = Quiz::factory()->create([
        "tenant_id" => $tenant->id,
    ]);

    $response = $this
        ->actingAs($user)
        ->get(route("quizzes.index"));

    $response->assertOk();
    $response->assertSeeInOrder([$quiz->title, $quiz->slug, $quiz->tenant->name, $quiz->quiz_type_name]);
    $response->assertSee(route("quizzes.create"));
    $response->assertViewIs("quizzes.index");
});

test('quizzes create page is displayed', function () {
    $user = User::factory()->create();
    $tenant = Tenant::factory()->create([
        "user_id" => $user->id,
    ]);

    $response = $this
        ->actingAs($user)
        ->get(route("quizzes.create"));

    $response->assertOk();
    $response->assertSee(route("quizzes.store"));
    $response->assertSee($tenant->name);
    $response->assertViewIs("quizzes.create");
});

test('quiz can be created', function () {
    $user = User::factory()->create();
    $tenant = Tenant::factory()->create([
        "user_id" => $user->id,
    ]);

    $data = [
        "title" => "Test Quiz",
        "slug" => "test-quiz",
        "tenant_id" => $tenant->id,
        "quiz_type" => "out-of-time",
        "description" => "Test Quiz Description",
    ];

    $response = $this
        ->actingAs($user)
        ->post(route("quizzes.store"), $data);

    $response->assertSessionHasNoErrors();
    $response->assertSessionHas('success', true);
    $response->assertRedirect(route("quizzes.index"));
    $this->assertDatabaseHas("quizzes", $data);
});

test('quiz edit page is displayed', function () {
    $user = User::factory()->create();
    $tenant = Tenant::factory()->create([
        "user_id" => $user->id,
    ]);
    $quiz = Quiz::factory()->create([
        "tenant_id" => $tenant->id,
    ]);

    $response = $this
        ->actingAs($user)
        ->get(route("quizzes.edit", $quiz));

    $response->assertOk();
    $response->assertSee(route("quizzes.update", $quiz));
    $response->assertSeeInOrder([$quiz->title, $quiz->slug, $quiz->tenant->name, $quiz->quiz_type_name, $quiz->description]);
    $response->assertViewIs("quizzes.edit");
});

test('quiz can be updated', function () {
    $user = User::factory()->create();
    $tenant = Tenant::factory()->create([
        "user_id" => $user->id,
    ]);
    $quiz = Quiz::factory()->create([
        "tenant_id" => $tenant->id,
    ]);

    $data = [
        "title" => "Updated Quiz",
        "slug" => "updated-quiz",
        "tenant_id" => $tenant->id,
        "quiz_type" => "out-of-time",
        "description" => "Updated Quiz Description",
    ];
    $response = $this
        ->actingAs($user)
        ->put(route("quizzes.update", $quiz), $data);

    $response->assertSessionHasNoErrors();
    $response->assertSessionHas('success', true);
    $response->assertRedirect(route("quizzes.edit", $quiz));
    $this->assertDatabaseHas("quizzes", $data);

});

test('quiz can be deleted', function () {
    $user = User::factory()->create();
    $tenant = Tenant::factory()->create([
        "user_id" => $user->id,
    ]);
    $quiz = Quiz::factory()->create([
        "tenant_id" => $tenant->id,
    ]);

    $response = $this
        ->actingAs($user)
        ->delete(route("quizzes.destroy", $quiz));

    $response->assertSessionHasNoErrors();
    $response->assertSessionHas('success', true);
    $response->assertRedirect(route("quizzes.index"));
    $this->assertDatabaseMissing("quizzes", [
        "id" => $quiz->id,
    ]);
});
