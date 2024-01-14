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

