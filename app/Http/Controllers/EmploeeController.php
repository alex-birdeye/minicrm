<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmploee;
use App\Http\Requests\UpdateEmploee;
use App\Models\Emploee;
use Illuminate\Http\Request;

class EmploeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Emploee::with('company')->latest()->paginate(10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEmploee $request)
    {
        $request->validated();

        Emploee::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Emploee  $emploee
     * @return \Illuminate\Http\Response
     */
    public function show(Emploee $emploee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Emploee  $emploee
     * @return \Illuminate\Http\Response
     */
    public function edit(Emploee $emploee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Emploee  $emploee
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEmploee $request, Emploee $emploee)
    {
        $request->validated();

        $emploee->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Emploee  $emploee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Emploee $emploee)
    {
        $emploee->delete();
    }
}
