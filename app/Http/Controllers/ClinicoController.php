<?php

namespace App\Http\Controllers;

use App\Models\Clinico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request as Req;

use Inertia\Inertia;

class ClinicoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $clinicos = Clinico::all()->reverse();
        // $clinicos = Clinico::paginate(5)
        //     ->through(fn($clinico) => [
        //         'id' => $clinico->id,
        //         'nome' => $clinico->nome,
        //         'cpf' => $clinico->cpf,
        //     ]);
        $clinicos = Clinico::query()
            ->when(Req::input('search'), function($query, $search){
                $query->where('diagnostico', 'like', '%'.$search.'%')
                    ->OrWhere('observacao', 'like', '%'.$search.'%');
            })->orderBy('created_at', 'desc')
                ->paginate(8)
            ->withQueryString();

        return Inertia::render('Clinicos/index', ['clinicos' => $clinicos]);
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
    public function store(Request $request)
    {
        $request->validate([
            'diagnostico' => 'required|string|max:200',
            'observacao' => 'required|max:1000',
        ]);
        Clinico::create(
            [
                'diagnostico' => $request->input('diagnostico'),
                'observacao' => $request->input('observacao'),
                'atendimento_id' => fake()->numberBetween(1,10),
                'user_id' => Auth::user()->id
            ]
        );
        return redirect()->route('clinicos.index')->with('message', 'Consulta cadastrada com sucesso');
    }

    /**
     * Display the specified resource.
     */
    public function show(Clinico $clinico)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Clinico $clinico)
    {
        return redirect()->route('clinicos.index', ['clinico' => $clinico]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Clinico $clinico)
    {
        $request->validate([
            'diagnostico' => 'required|string|max:200',
            'observacao' => 'required|max:1000'
        ]);
        $clinico->diagnostico = $request->diagnostico;
        $clinico->observacao = $request->observacao;
        $clinico->save();
        return redirect()->route('clinicos.index')->with('message', 'Os dados da consulta foram atualizados com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Clinico $clinico)
    {
        $clinico->delete();
        return redirect()->route('clinicos.index')->with('message', 'Os dados da consulta foram removidos');
    }
}
