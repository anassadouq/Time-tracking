<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit salarier</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
        <style>
            .my-form {
                width: 100%;
                max-width: 700px;
                margin: auto;
                padding: 20px;
                border: 1px solid #ddd;
                border-radius: 5px;
                margin-top: 20px;
                margin-bottom: 20px;
                background-color: white;
            }
            label{
                font-weight : bold;
            }

            input[type="text"]{
                width: 100%;
                padding: 8px;
                border: 1px solid #ccc;
                border-radius: 3px;
            }
        </style>
    </head>
    <body>
        <form action="{{ route('salarier.update', $salarier) }}" class="my-form container" method="post">
            @csrf
            @method('PUT')
            <div class="mb-2">
                <label for="sexe" class="form-label">Sexe :</label>
                <input type="checkbox" name="sexe" value="H" {{ $salarier->sexe == 'H' ? 'checked' : '' }}> H
                <input type="checkbox" name="sexe" value="F" {{ $salarier->sexe == 'F' ? 'checked' : '' }}> F
            </div>
            <div class="mb-2">
                <label for="nom" class="form-label">Nom :</label>
                <input type="text" name="nom" class="form-control" value="{{ $salarier->nom }}">
            </div>
            <div class="mb-2">
                <label for="cin" class="form-label">Cin :</label>
                <input type="text" name="cin" class="form-control" value="{{ $salarier->cin }}">
            </div>
            <div class="mb-2">
                <label for="tel" class="form-label">Téléphone :</label>
                <input type="text" name="tel" class="form-control" value="{{ $salarier->tel }}">
            </div>
            <div class="mb-2">
                <label for="adresse" class="form-label">Adresse :</label>
                <input type="text" name="adresse" class="form-control" value="{{ $salarier->adresse }}">
            </div>
            <div class="mb-2">
                <label for="salaire" class="form-label">Salaire</label>
                <input type="text" name="salaire" class="form-control" value="{{ $salarier->salaire }}">
            </div>
            
            <div class="mb-2">
                <label for="dateEntree" class="form-label">Date Entrée :</label>
                <input type="date" name="dateEntree" class="form-control" value="{{ $salarier->dateEntree }}">
            </div>
            <div class="mb-2">
                <label for="Actif" class="form-label">Actif :</label>
                <input type="checkbox" name="active" value="Oui" {{ $salarier->active == 'Oui' ? 'checked' : '' }}> Oui
                <input type="checkbox" name="active" value="Non" {{ $salarier->active == 'Non' ? 'checked' : '' }}> Non
            </div>
            <button type="submit" class="form-control btn btn-secondary">
                <span class="material-symbols-outlined">edit</span> 
            Modifier</button>    
        </form>
    </body>
</html>