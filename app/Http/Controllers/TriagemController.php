<?php

namespace App\Http\Controllers;

use App\Models\Triagem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request as Req;
use Inertia\Inertia;

class TriagemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $triagems = Triagem::query()
            ->when(Req::input('search'), function($query, $search){
                $query->where('classificacao', 'like', '%'.$search.'%')
                    ->OrWhere('observacao', 'like', '%'.$search.'%');
            })->orderBy('created_at', 'desc')
            ->paginate(8)
            ->withQueryString();

            return Inertia::render('Triagems/index', ['triagems' => $triagems]);
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
            'classificacao' => 'required|string|max:200',
            'observacao' => 'required|string|max:500',
        ]);
        // Triagem::create($request->all());
        Triagem::create(
            [
                'classificacao' => $request->input('classificacao'),
                'observacao' => $request->input('observacao'),
                'atendimento_id' => fake()->numberBetween(1,10),
                'user_id' => Auth::user()->id
            ]
        );
        return redirect()->route('triagems.index')->with('message', 'Triagem registrado com sucesso');
    }

    /**
     * Display the specified resource.
     */
    public function show(Triagem $triagem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Triagem $triagem)
    {
        return redirect()->route('triagem.index', ['triagem' => $triagem]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Triagem $triagem)
    {
        $request->validate([
            'classificacao' => 'required|string|max:200',
            'observacao' => 'required|string|max:500',
        ]);
        $triagem->classificacao = $request->classificacao;
        $triagem->observacao = $request->observacao;
        $triagem->save();
        return redirect()->route('triagems.index')->with('message', 'Triagem atualizados com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Triagem $triagem)
    {
        $triagem->delete();
        return redirect()->route('triagems.index')->with('message', 'Triagem removido com sucesso');
    }
}
