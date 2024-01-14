<?php

namespace App\Http\Controllers;

use App\Http\Requests\Quiz\StoreQuizRequest;
use App\Http\Requests\Quiz\UpdateQuizRequest;
use App\Models\Quiz;
use App\Services\QuizService;
use App\Services\TenantService;

class QuizController extends Controller
{

    private TenantService $tenantService;
    private QuizService $quizService;

    public function __construct(TenantService $tenantService, QuizService $quizService)
    {
        $this->tenantService = $tenantService;
        $this->quizService = $quizService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tenants = auth()->user()->tenants->pluck('id');
        $quizzes = Quiz::whereIn("tenant_id", $tenants)->latest()->paginate(10);
        return view('quizzes.index', compact('quizzes'));
    }

    public function getQuizzesByTenant($tenant_id)
    {
        // TODO: Use select2 ajax for better performance, but for simplicity, we are using this.
        $quizzes = Quiz::where("tenant_id", $tenant_id)->latest()->get();
        // TODO: Use macro for stander response format.
        return response()->json($quizzes);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tenants = $this->tenantService->forLookup(auth()->user()->tenants);
        $quizTypeOptions = $this->quizService->quizTypes();
        return view('quizzes.create', compact('tenants', 'quizTypeOptions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreQuizRequest $request)
    {
        $validatedData = $request->validated();

        try {
            // Remove start_time and end_time if quiz_type is out-of-time
            if ($validatedData['quiz_type'] === 'out-of-time') {
                $validatedData['start_time'] = null;
                $validatedData['end_time'] = null;
            }
            Quiz::create($validatedData);
        
            return to_route('quizzes.index')->with([
                'message' => __("Quiz created successfully!"),
                'success' => true,
            ]);
        } catch (\Exception $e) {
            report($e);
            return to_route('quizzes.index')->with([
                'message' => __("Error creating quiz")." {$validatedData['title']}",
                'success' => false,
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Quiz $quiz)
    {
        $tenants = $this->tenantService->forLookup(auth()->user()->tenants);
        $quizTypeOptions = $this->quizService->quizTypes();
        return view('quizzes.edit', compact('quiz', 'tenants', 'quizTypeOptions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateQuizRequest $request, Quiz $quiz)
    {
        $validatedData = $request->validated();

        try {
            // Remove start_time and end_time if quiz_type is out-of-time
            if ($validatedData['quiz_type'] === 'out-of-time') {
                $validatedData['start_time'] = null;
                $validatedData['end_time'] = null;
            }

            // Update quiz with validated data
            $quiz->update($validatedData);

            // Redirect or return response
            return to_route('quizzes.edit', $quiz)->with([
                'message' => __("Quiz updated successfully!"),
                'success' => true,
            ]);
        } catch (\Exception $e) {
            report($e);
            return to_route('quizzes.index')->with([
                'message' => __("Error updating quiz")." {$validatedData['title']}",
                'success' => false,
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quiz $quiz)
    {
        try {
            // Delete quiz
            $quiz->delete();
        
            // Redirect or return response
            return to_route('quizzes.index')->with([
                'message' => __("Quiz deleted successfully!"),
                'success' => true,
            ]);
        } catch (\Exception $e) {
            report($e);
            return to_route('quizzes.index')->with([
                'message' => __("Error deleting quiz")." {$quiz->title}",
                'success' => false,
            ]);
        }
    }
}
