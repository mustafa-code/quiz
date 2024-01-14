<?php

namespace Tests\Feature;

use App\Models\User;

test('questions list page is displayed', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->get(route("questions.index"));

    $response->assertOk();
    $response->assertSee(route("questions.create"));
    $response->assertViewIs("questions.index");
});

