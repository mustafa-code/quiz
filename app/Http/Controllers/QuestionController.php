<?php

namespace App\Http\Controllers;

use App\Http\Requests\Question\StoreQuestionRequest;
use App\Http\Requests\Question\UpdateQuestionRequest;
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
            return to_route('questions.create')->with([
                'message' => __("Error creating question")." {$validatedData['question']}",
                'success' => false,
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Question $question)
    {
        $tenantsList = auth()->user()->tenants;
        $tenants = $this->tenantService->forLookup($tenantsList);

        return view('questions.edit', compact('question', 'tenants'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateQuestionRequest $request, Question $question)
    {
        $validatedData = $request->validated();

        try {
            // Update quiz with validated data
            $question->update($validatedData);

            // Redirect or return response
            return to_route('questions.edit', $question)->with([
                'message' => __("Question updated successfully!"),
                'success' => true,
            ]);
        } catch (\Exception $e) {
            report($e);
            return to_route('questions.edit', $question)->with([
                'message' => __("Error updating question")." {$validatedData['question']}",
                'success' => false,
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {
        try {
            // Delete quiz
            $question->delete();
        
            // Redirect or return response
            return to_route('questions.index')->with([
                'message' => __("Question deleted successfully!"),
                'success' => true,
            ]);
        } catch (\Exception $e) {
            report($e);
            return to_route('questions.index')->with([
                'message' => __("Error deleting question")." {$question->question}",
                'success' => false,
            ]);
        }
    }
}
