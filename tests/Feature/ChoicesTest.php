<?php

namespace Tests\Feature;

use App\Models\Choice;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\Tenant;
use App\Models\User;

test('question choices list page is displayed', function () {
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
    $choice = Choice::factory()->create([
        "tenant_id" => $tenant->id,
        "question_id" => $question->id,
    ]);

    $response = $this
        ->actingAs($user)
        ->get(route("questions.choices.index", $question));

    $response->assertOk();
    $response->assertSeeInOrder([$choice->title, "Correct", $choice->order, $question->created_at]);
    $response->assertSee(route("questions.choices.create", $question));
    $response->assertViewIs("choices.index");
});

test('questions create page is displayed', function () {
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
        ->get(route("questions.choices.create", $question));

    $response->assertOk();
    $response->assertSee(route("questions.choices.store", $question));
    $response->assertViewIs("choices.create");
});

test('question can be created', function () {
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
        "tenant_id" => $tenant->id,
        "question_id" => $question->id,
        "title" => "Choice Title",
        "is_correct" => true,
        "order" => 1,
        "description" => "Choice Description",
        "explanation" => "Choice Explanation",
    ];

    $response = $this
        ->actingAs($user)
        ->post(route("questions.choices.store", $question), $data);

    $response->assertSessionHasNoErrors();
    $response->assertSessionHas('success', true);
    $response->assertRedirect(route("questions.choices.index", $question));
    $this->assertDatabaseHas("choices", $data);
});