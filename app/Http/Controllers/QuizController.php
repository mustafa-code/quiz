<?php

namespace App\Http\Controllers;

use App\Http\Requests\Quiz\StoreQuizRequest;
use App\Http\Requests\Quiz\UpdateQuizRequest;
use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $quizzes = Quiz::latest()->paginate(10);
        return view('quizzes.index', compact('quizzes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tenants = auth()->user()->tenants->map(function($tenant){
            return [
                'id' => $tenant->id,
                'name' => $tenant->name . "( {$tenant->domains()->first()->domain} )",
            ];
        });
        $quizTypeOptions = [
            [
                'id' => 'in-time',
                'name' => 'In Time',
            ],
            [
                'id' => 'out-of-time',
                'name' => 'Out of Time',
            ],
        ];
        return view('quizzes.create', compact('tenants', 'quizTypeOptions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreQuizRequest $request)
    {
        $validatedData = $request->validated();

        try {
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
        $tenants = auth()->user()->tenants->map(function($tenant){
            return [
                'id' => $tenant->id,
                'name' => $tenant->name . "( {$tenant->domains()->first()->domain} )",
            ];
        });
        $quizTypeOptions = [
            [
                'id' => 'in-time',
                'name' => 'In Time',
            ],
            [
                'id' => 'out-of-time',
                'name' => 'Out of Time',
            ],
        ];
        return view('quizzes.edit', compact('quiz', 'tenants', 'quizTypeOptions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateQuizRequest $request, Quiz $quiz)
    {
        $validatedData = $request->validated();

        try {
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
