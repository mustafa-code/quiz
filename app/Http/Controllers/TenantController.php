<?php

namespace App\Http\Controllers;

use App\Http\Requests\TenantStoreRequest;
use App\Http\Requests\TenantUpdateRequest;
use App\Models\Tenant;
use App\Models\User;

class TenantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tenants = Tenant::latest()->paginate(10);
        return view('tenants.index', compact('tenants'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // TODO: Use select2 ajax to load users, this is just for demo.
        $users = User::all()->map(function ($user) {
            $isCurrentUser = auth()->user()->id == $user->id;
            return [
                'id' => $user->id,
                'name' => $user->name . ($isCurrentUser ? ' (You)' : ''),
            ];
        });
        return view('tenants.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TenantStoreRequest $request)
    {
        $validatedData = $request->validated();

        try {
            // Create new tenant with validated data
            $tenant = Tenant::create([
                'name' => $validatedData['name'],
                'user_id' => $validatedData['user_id'],
            ]);

            $tenant->domains()->create([
                'domain' => $validatedData['domain'],
            ]);
        
            // Redirect or return response
            return to_route('tenants.index')->with([
                'message' => __("Tenant created successfully!"),
                'success' => true,
            ]);
        } catch (\Exception $e) {
            report($e);
            return to_route('tenants.index')->with([
                'message' => __("Error creating tenant")." {$validatedData['name']}",
                'success' => false,
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tenant $tenant)
    {
        // TODO: Use select2 ajax to load users, this is just for demo.
        $users = User::all()->map(function ($user) {
            $isCurrentUser = auth()->user()->id == $user->id;
            return [
                'id' => $user->id,
                'name' => $user->name . ($isCurrentUser ? ' (You)' : ''),
            ];
        });
        return view('tenants.edit', compact('tenant', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TenantUpdateRequest $request, Tenant $tenant)
    {
        $validatedData = $request->validated();

        try {
            // Update tenant with validated data
            $tenant->update([
                'name' => $validatedData['name'],
                'user_id' => $validatedData['user_id'],
            ]);
            // Sync domains
            $tenant->domains()->update([
                'domain' => $validatedData['domain'],
            ]);
        
            // Redirect or return response
            return to_route('tenants.edit', $tenant)->with([
                'message' => __("Tenant updated successfully!"),
                'success' => true,
            ]);
        } catch (\Exception $e) {
            report($e);
            return to_route('tenants.index')->with([
                'message' => __("Error updating tenant")." {$validatedData['name']}",
                'success' => false,
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tenant $tenant)
    {
        try {
            // Delete tenant
            $tenant->delete();
        
            // Redirect or return response
            return to_route('tenants.index')->with([
                'message' => __("Tenant deleted successfully!"),
                'success' => true,
            ]);
        } catch (\Exception $e) {
            report($e);
            return to_route('tenants.index')->with([
                'message' => __("Error deleting tenant")." {$tenant->name}",
                'success' => false,
            ]);
        }
    }
}
