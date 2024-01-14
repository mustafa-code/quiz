<?php

namespace Tests\Feature;

use App\Models\Question;
use App\Models\Quiz;
use App\Models\Tenant;
use App\Models\User;

test('questions list page is displayed', function () {
    $user = User::factory()->create();
    $tenant = Tenant::factory()->create([
        "user_id" => $user->id,
    ]);
    $quiz = Quiz::factory()->create([
        "tenant_id" => $tenant->id,
    ]);
    $question = Question::factory()->create([
        'tenant_id' => $tenant->id,
        'quiz_id' => $quiz->id,
    ]);
    
    $response = $this
        ->actingAs($user)
        ->get(route("questions.index"));

    $response->assertOk();
    $response->assertSeeInOrder([$quiz->title, $question->question, $question->slug, $question->created_at]);
    $response->assertSee(route("questions.create"));
    $response->assertViewIs("questions.index");
});

test('questions create page is displayed', function () {
    $user = User::factory()->create();
    $tenant = Tenant::factory()->create([
        "user_id" => $user->id,
    ]);

    $response = $this
        ->actingAs($user)
        ->get(route("questions.create"));

    $response->assertOk();
    $response->assertSee(route("questions.store"));
    $response->assertSee($tenant->name);
    $response->assertViewIs("questions.create");
});

test('question can be created', function () {
    $user = User::factory()->create();
    $tenant = Tenant::factory()->create([
        "user_id" => $user->id,
    ]);
    $quiz = Quiz::factory()->create([
        "tenant_id" => $tenant->id,
    ]);

    $data = [
        "question" => "Test Question",
        "slug" => "test-question",
        "tenant_id" => $tenant->id,
        "quiz_id" => $quiz->id,
        "description" => "Test Question Description",
    ];

    $response = $this
        ->actingAs($user)
        ->post(route("questions.store"), $data);

    $response->assertSessionHasNoErrors();
    $response->assertSessionHas('success', true);
    $response->assertRedirect(route("questions.index"));
    $this->assertDatabaseHas("questions", $data);
});

test('question edit page is displayed', function () {
    $user = User::factory()->create();
    $tenant = Tenant::factory()->create([
        "user_id" => $user->id,
    ]);
    $quiz = Quiz::factory()->create([
        "tenant_id" => $tenant->id,
    ]);
    $question = Question::factory()->create([
        'tenant_id' => $tenant->id,
        'quiz_id' => $quiz->id,
    ]);

    $response = $this
        ->actingAs($user)
        ->get(route("questions.edit", $quiz));

    $response->assertOk();
    $response->assertSee(route("questions.update", $quiz));
    $response->assertSeeInOrder([$question->question, 
        $question->slug, 
        $question->description,
    ]);
    $response->assertViewIs("questions.edit");
});

test('question can be updated', function () {
    $user = User::factory()->create();
    $tenant = Tenant::factory()->create([
        "user_id" => $user->id,
    ]);
    $quiz = Quiz::factory()->create([
        "tenant_id" => $tenant->id,
    ]);
    $question = Question::factory()->create([
        'tenant_id' => $tenant->id,
        'quiz_id' => $quiz->id,
    ]);

    $data = [
        "question" => "Updated Question",
        "slug" => "updated-question",
        "tenant_id" => $tenant->id,
        "quiz_id" => $quiz->id,
        "description" => "Updated Question Description",
    ];
    $response = $this
        ->actingAs($user)
        ->put(route("questions.update", $question), $data);

    $response->assertSessionHasNoErrors();
    $response->assertSessionHas('success', true);
    $response->assertRedirect(route("questions.edit", $question));
    $this->assertDatabaseHas("questions", $data);

});
