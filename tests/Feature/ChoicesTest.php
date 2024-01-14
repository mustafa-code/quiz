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
    $response->assertSeeInOrder([$choice->title, $choice->order, $question->created_at]);
    $response->assertSee(route("questions.choices.create", $question));
    $response->assertViewIs("choices.index");
});

test('questions choice create page is displayed', function () {
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

test('question choice can be created', function () {
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

test('question choice edit page is displayed', function () {
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
        ->get(route("questions.choices.edit", [$question, $choice]));

    $response->assertOk();
    $response->assertSee(route("questions.choices.update", [$question, $choice]));
    $response->assertSeeInOrder([$choice->title, 
        $choice->order, 
        $choice->explanation,
        $choice->description,
    ]);
    $response->assertViewIs("choices.edit");
});

test('question choice can be updated', function () {
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

    $data = [
        "tenant_id" => $tenant->id,
        "question_id" => $question->id,
        "title" => "Updated Title",
        "is_correct" => true,
        "order" => 10,
        "description" => "Updated Description",
        "explanation" => "Updated Explanation",
    ];
    $response = $this
        ->actingAs($user)
        ->put(route("questions.choices.update", [$question, $choice]), $data);

    $response->assertSessionHasNoErrors();
    $response->assertSessionHas('success', true);
    $response->assertRedirect(route("questions.choices.edit", [$question, $choice]));
    $this->assertDatabaseHas("choices", $data);

});

test('question choice can be deleted', function () {
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
        ->delete(route("questions.choices.destroy", [$question, $choice]));

    $response->assertSessionHasNoErrors();
    $response->assertSessionHas('success', true);
    $response->assertRedirect(route("questions.choices.index", $question));
    $this->assertDatabaseMissing("choices", [
        "id" => $choice->id,
    ]);
});
