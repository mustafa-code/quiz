<?php

namespace App\Http\Controllers;

use App\Http\Requests\Choice\StoreChoiceRequest;
use App\Http\Requests\Choice\UpdateChoiceRequest;
use App\Models\Choice;

class ChoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('choices.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreChoiceRequest $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Choice $choice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateChoiceRequest $request, Choice $choice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Choice $choice)
    {
        //
    }
}
