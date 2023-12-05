<?php

namespace App\Http\Controllers;

use App\Models\Salarier;
use App\Http\Requests\StoreSalarierRequest;
use App\Http\Requests\UpdateSalarierRequest;

class SalarierController extends Controller
{
    public function index()
    {
        return view('salarier.index', [
            'salariers' => Salarier::all()
        ]);
    }

    public function create()
    {
        return view('salarier.create');
    }

    public function store(StoreSalarierRequest $request)
    {
        $salarier = new Salarier();
        $salarier->sexe = $request->sexe;
        $salarier->nom = $request->nom;
        $salarier->cin = $request->cin;
        $salarier->tel = $request->tel;
        $salarier->adresse = $request->adresse;
        $salarier->salaire = $request->salaire;
        $salarier->dateEntree = $request->dateEntree;
        $salarier->active = $request->active;

        $salarier->save();
        return to_route('salarier.index');
    }

    public function show(Salarier $salarier)
    {
        return view('salarier.show', compact('salarier'));
    }

    public function edit(Salarier $salarier)
    {
        return view('salarier.edit', compact('salarier'));
    }

    public function update(UpdateSalarierRequest $request, Salarier $salarier)
    {
        $salarier->update($request->all());
        return to_route('salarier.index');
    }

    public function destroy($id)
    {
        $salarier = Salarier::findOrFail($id);
        $salarier->delete();

        return redirect()->route('salarier.index')
            ->with('success', 'Le salarier a été supprimé avec succès.');
    }
}