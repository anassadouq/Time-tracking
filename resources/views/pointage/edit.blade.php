<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

<style>
    #t{
        width: 350px;
    }
</style>
<form action="{{ route('pointage.update',$pointage) }}" class="container" method="post">
    <center>
        <table>
            @csrf
            @method('PUT')
            <tr>
                <td><b>Date</b></td>
                <td> : <input type="date" id="t" name="date" value="{{ $pointage->date }}" class="my-4"></td>
            </tr>
            <tr>
                <td><b>Présent/Absent</b></td>
                <td>
                    : <input type="checkbox" name="presentAbsent" class="my-4" value="P" {{ $pointage->presentAbsent == 'P' ? 'checked' : '' }}> P
                    <input type="checkbox" name="presentAbsent" value="A" {{ $pointage->presentAbsent == 'A' ? 'checked' : '' }}> A
                </td>
            </tr>
            <tr>
                <td><b>Heure Supp</b></td>
                <td> : <input type="text" id="t" name="heureSupp" value="{{ $pointage->heureSupp }}" class="my-4"></td>
            </tr>
            <tr>
                <td><b>Heure Moin</b></td>
                <td> : <input type="text" id="t" name="heureMoin" value="{{ $pointage->heureMoin }}" class="my-4"></td>
            </tr>
            <tr>
                <td><b>Avance</b></td>
                <td> : <input type="text" id="t" name="avance" value="{{ $pointage->avance }}" class="my-4"></td>
            </tr>
            <tr>
                <td><b>Remarque</b></td>
                <td> : <input type="text" id="t" name="remarque" value="{{ $pointage->remarque }}" class="my-4">            
                <button class="btn btn-secondary mx-2">
                    <span class="material-symbols-outlined">edit</span>    
                Modifier</button>        
                </td>
            </tr>
        </table>      
    </center>   
</form>