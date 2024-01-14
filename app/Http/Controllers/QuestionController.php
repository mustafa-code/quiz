<?php

namespace App\Http\Controllers;

use App\Http\Requests\Question\StoreQuestionRequest;
use App\Models\Question;
use App\Models\Quiz;
use App\Services\TenantService;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    private TenantService $tenantService;

    public function __construct(TenantService $tenantService)
    {
        $this->tenantService = $tenantService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tenants = auth()->user()->tenants->pluck('id');
        $questions = Question::whereIn("tenant_id", $tenants)->latest()->paginate(10);
        return view('questions.index', compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tenantsList = auth()->user()->tenants;
        $tenants = $this->tenantService->forLookup($tenantsList);

        return view('questions.create', compact('tenants'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreQuestionRequest $request)
    {
        // TODO: use authorize to validate the user has permission to create qustion in this quiz.
        $validatedData = $request->validated();

        try {
            Question::create($validatedData);

            return to_route('questions.index')->with([
                'message' => __("Question created successfully!"),
                'success' => true,
            ]);
        } catch (\Exception $e) {
            report($e);
            return to_route('questions.index')->with([
                'message' => __("Error creating question")." {$validatedData['question']}",
                'success' => false,
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
