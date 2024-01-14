<?php

namespace App\Http\Controllers;

use App\Http\Requests\Choice\StoreChoiceRequest;
use App\Http\Requests\Choice\UpdateChoiceRequest;
use App\Models\Choice;
use App\Models\Question;

class ChoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Question $question)
    {
        return view('choices.index', [
            'question' => $question,
            'choices' => $question->choices()->latest()->paginate(10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Question $question)
    {
        return view('choices.create', compact('question'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreChoiceRequest $request, Question $question)
    {
        $validatedData = $request->validated();

        try {
            $validatedData["is_correct"] = $request->is_correct ? true: false;
            $validatedData['question_id'] = $question->id;
            $validatedData['tenant_id'] = $question->tenant_id;

            Choice::create($validatedData);

            return to_route('questions.choices.index', $question)->with([
                'message' => __("Choice created successfully!"),
                'success' => true,
            ]);
        } catch (\Exception $e) {
            report($e);
            return to_route('questions.choices.create', $question)->with([
                'message' => __("Error creating choice")." {$validatedData['title']}",
                'success' => false,
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Question $question, Choice $choice)
    {
        return view('choices.edit', compact('choice', 'question'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateChoiceRequest $request, Question $question, Choice $choice)
    {
        $validatedData = $request->validated();

        try {
            $validatedData["is_correct"] = $request->is_correct ? true: false;
            // Update quiz with validated data
            $choice->update($validatedData);

            // Redirect or return response
            return to_route('questions.choices.edit', [$question, $choice])->with([
                'message' => __("Choice updated successfully!"),
                'success' => true,
            ]);
        } catch (\Exception $e) {
            report($e);
            return to_route('questions.choices.edit', [$question, $choice])->with([
                'message' => __("Error updating choice")." {$validatedData['question']}",
                'success' => false,
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question, Choice $choice)
    {
        try {
            $choice->delete();
            $message = __("Choice deleted successfully!");
            $success = true;
        } catch (\Exception $e) {
            report($e);
            $message = __("Error deleting choice")." {$choice->title}";
            $success = false;
        }
        return to_route('questions.choices.index', $question)->with([
            'message' => $message,
            'success' => $success,
        ]);
    }
}
