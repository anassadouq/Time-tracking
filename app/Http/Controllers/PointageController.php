<?php
namespace App\Http\Controllers;

use App\Models\Pointage;
use App\Models\Salarier;
use Illuminate\Http\Request;
use App\Http\Requests\StorePointageRequest;
use App\Http\Requests\UpdatePointageRequest;

class PointageController extends Controller
{
    public function index()
    {
        $pointages = Pointage::all();
        $salariers = Salarier::all();
        return view('pointage.index', compact('pointages', 'salariers'));
    }

    public function accueil()
    {
        $pointages = Pointage::all();
        $salariers = Salarier::all();
        return view('pointage.accueil', compact('pointages', 'salariers'));
    }

    public function create()
    {
        $salariers = Salarier::all();
        return view('pointage.create', compact('salariers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_salarier' => 'required|array',
            'id_salarier.*' => 'required|exists:salariers,id',
            'date' => 'required|date',
            'presentAbsent.*' => '',
            'heureSupp.*' => '',
            'heureMoin.*' => '',
            'avance.*' => '',
            'remarque.*' => '',
        ]);
    
        foreach ($data['id_salarier'] as $key => $id_salarier) {
            Pointage::create([
                'id_salarier' => $id_salarier,
                'date' => $data['date'],
                'presentAbsent' => $data['presentAbsent'][$key],
                'heureSupp' => $data['heureSupp'][$key],
                'heureMoin' => $data['heureMoin'][$key],
                'avance' => $data['avance'][$key],
                'remarque' => $data['remarque'][$key],
            ]);
        }
        return redirect('/');
    }    

    public function show($id_salarier)
    {
        $salariers = Salarier::find($id_salarier);
        $pointages = Pointage::where('id_salarier', $id_salarier)->get();
        return view('pointage.show', compact('pointages', 'salariers'));
    } 

    public function edit(Pointage $pointage)
    {
        return view('pointage.edit', compact('pointage'));
    }

    public function update(UpdatePointageRequest $request, Pointage $pointage)
    {
        $pointage->update($request->all());
        return redirect('/');
    }
     
    public function listePointage()
    {
        $pointages = Pointage::orderBy('date')->get();
        $salariers = Salarier::all();
        
        return view('pointage.liste_pointage', [
            'pointages' => $pointages,
            'salariers' => $salariers
        ]);
    }     

    public function destroy($id)
    {
        $pointage = Pointage::findOrFail($id);
        $salarierId = $pointage->id_salarier; // Get the salarier ID before deleting the pointage
        $pointage->delete();
    
        // Redirect to the same page with the salarier ID
        return redirect()->route('pointage.show', ['salarierId' => $salarierId])
            ->with('success', 'Le pointage a été supprimé avec succès.');
    }
}