<?php

namespace App\Http\Controllers;

use App\Models\Pointage;
use Illuminate\Http\Request;

class UpdateController extends Controller
{
    public function updateAll(Request $request)
    {
        $data = $request->validate([
            'id_salarier.*' => 'required|exists:salariers,id',
            'date.*' => 'required',
            'presentAbsent.*' => 'required|in:P,A',
            'heureSupp.*' => 'nullable',
            'heureMoin.*' => 'nullable',
            'avance.*' => 'nullable',
            'remarque.*' => 'nullable',
        ]);
        
        foreach ($data['id_salarier'] as $pointageId => $id_salarier) {
            $pointages = Pointage::findOrFail($pointageId);
            $pointages->update([
                'id_salarier' => $id_salarier,
                'date' => $data['date'][$pointageId],
                'presentAbsent' => $data['presentAbsent'][$pointageId],
                'heureSupp' => $data['heureSupp'][$pointageId],
                'heureMoin' => $data['heureMoin'][$pointageId],
                'avance' => $data['avance'][$pointageId],
                'remarque' => $data['remarque'][$pointageId],
            ]);
        }
        return redirect('/');
    }
}