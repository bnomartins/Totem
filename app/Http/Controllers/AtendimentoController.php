<?php

namespace App\Http\Controllers;

use App\Models\Atendimento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request as Req;
use Inertia\Inertia;

class AtendimentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $atendimentos = Atendimento::query()
            ->when(Req::input('search'), function($query, $search){
                $query->where('senha', 'like', '%'.$search.'%')
                    ->OrWhere('status', 'like', '%'.$search.'%');
            })->orderBy('created_at', 'desc')
            ->paginate(8)
            ->withQueryString();

            return Inertia::render('Atendimentos/index', ['atendimentos' => $atendimentos]);
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
            'senha' => 'required|string|max:200',
        ]);
        // Atendimento::create($request->all());
        Atendimento::create(
            [
                'senha' => $request->input('senha'),
                'paciente_id' => fake()->numberBetween(1,10),
                'user_id' => Auth::user()->id
            ]
        );
        return redirect()->route('atendimentos.index')->with('message', 'Atendimento registrado com sucesso');
    }

    /**
     * Display the specified resource.
     */
    public function show(Atendimento $atendimento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Atendimento $atendimento)
    {
        return redirect()->route('pacientes.index', ['paciente' => $paciente]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Atendimento $atendimento)
    {
        $request->validate([
            'senha' => 'required|string|max:200',
        ]);
        $atendimento->senha = $request->senha;
        $atendimento->save();
        return redirect()->route('atendimentos.index')->with('message', 'Atendimento atualizados com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Atendimento $atendimento)
    {
        $atendimento->delete();
        return redirect()->route('atendimentos.index')->with('message', 'Atendimento removido com sucesso');
    }
}
