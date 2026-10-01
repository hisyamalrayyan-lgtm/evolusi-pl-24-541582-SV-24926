<?php

namespace App\Http\Controllers;

use App\Models\Tugas;
use Illuminate\Http\Request;

class TugasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tugas = Tugas::all();

        if (request()->expectsJson()) {
            return response()->json($tugas);
        }

        return $tugas->toArray();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return ['form' => 'create tugas'];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'     => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'status'    => 'in:pending,selesai',
        ]);

        $tugas = Tugas::create($validated);

        return response()->json($tugas, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tugas $tugas)
    {
        return response()->json($tugas);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tugas $tugas)
    {
        return ['form' => 'edit tugas', 'data' => $tugas];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tugas $tugas)
    {
        $validated = $request->validate([
            'judul'     => 'sometimes|required|string|max:255',
            'deskripsi' => 'nullable|string',
            'status'    => 'in:pending,selesai',
        ]);

        $tugas->update($validated);

        return response()->json($tugas);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tugas $tugas)
    {
        $tugas->delete();

        return response()->json(['message' => 'Tugas deleted successfully']);
    }
}
