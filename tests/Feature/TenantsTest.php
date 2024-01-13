<?php

use App\Models\Domain;
use App\Models\Tenant;
use App\Models\User;

test('tenants list page is displayed', function () {
    $user = User::factory()->create();
    $tenant = Tenant::factory()->create();
    $domain = Domain::factory()->create([
        "tenant_id" => $tenant->id,
    ]);

    $response = $this
        ->actingAs($user)
        ->get(route("tenants.index"));

    $response->assertOk();
    $response->assertSeeInOrder([$tenant->name, $domain->domain]);
    $response->assertSee(route("tenants.create"));
    $response->assertViewIs("tenants.index");
});

test('tenants create page is displayed', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->get(route("tenants.create"));

    $response->assertOk();
    $response->assertSee(route("tenants.store"));
    $response->assertViewIs("tenants.create");
});

test('tenant can be created', function () {
    $user = User::factory()->create();
    $data = [
        "name" => "Test Tenant",
        "domain" => "test.localhost",
    ];

    $response = $this
        ->actingAs($user)
        ->post(route("tenants.store"), $data);

    $response->assertSessionHasNoErrors();
    $response->assertSessionHas('success', true);
    $response->assertRedirect(route("tenants.index"));
    $this->assertDatabaseHas("tenants", [
        "data->name" => $data["name"],
    ]);
    $this->assertDatabaseHas("domains", [
        "domain" => $data["domain"],
    ]);
});

test('tenant edit page is displayed', function () {
    $user = User::factory()->create();
    $tenant = Tenant::factory()->create();
    $domain = Domain::factory()->create([
        "tenant_id" => $tenant->id,
    ]);

    $response = $this
        ->actingAs($user)
        ->get(route("tenants.edit", $tenant));

    $response->assertOk();
    $response->assertSee(route("tenants.update", $tenant));
    $response->assertViewIs("tenants.edit");
});

test('tenant can be updated', function () {
    $user = User::factory()->create();
    $tenant = Tenant::factory()->create();
    $domain = Domain::factory()->create([
        "tenant_id" => $tenant->id,
    ]);
    
    $response = $this
        ->actingAs($user)
        ->put(route("tenants.update", $tenant), [
            "name" => "Updated Tenant",
            "domain" => "updated.localhost",
        ]);

    $response->assertSessionHasNoErrors();
    $response->assertSessionHas('success', true);
    $response->assertRedirect(route("tenants.edit", $tenant));
    $this->assertDatabaseHas("tenants", [
        "data->name" => "Updated Tenant",
    ]);
    $this->assertDatabaseHas("domains", [
        "id" => $domain->id,
        "domain" => "updated.localhost",
        "tenant_id" => $tenant->id,
    ]);
});

test('tenant can be deleted', function () {
    $user = User::factory()->create();
    $tenant = Tenant::factory()->create();
    $domain = Domain::factory()->create([
        "tenant_id" => $tenant->id,
    ]);

    $response = $this
        ->actingAs($user)
        ->delete(route("tenants.destroy", $tenant));

    $response->assertSessionHasNoErrors();
    $response->assertSessionHas('success', true);
    $response->assertRedirect(route("tenants.index"));
    $this->assertDatabaseMissing("tenants", [
        "id" => $tenant->id,
    ]);
    $this->assertDatabaseMissing("domains", [
        "id" => $domain->id,
    ]);
});
