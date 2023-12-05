<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create salarier</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <style>
        label {
            font-weight: bold;
        }
        
        .my-form {
            width: 100%;
            max-width: 600px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-top: 20px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form method="POST" action="{{ route('salarier.store') }}" class="my-form">
                    @csrf
                    <div>
                        <label for="sexe" class="form-label">Sexe :</label>
                        <input type="radio" name="sexe" value="H"> H
                        <input type="radio" name="sexe" value="F"> F
                    </div>
                    <div>
                        <label for="nom" class="form-label">Nom :</label>
                        <input type="text" placeholder="Nom Salarié" name="nom" class="form-control" required>
                    </div>
                    <div>
                        <label for="cin" class="form-label">Cin :</label>
                        <input type="text" placeholder="Cin Salarié" name="cin" class="form-control" required>
                    </div>
                    <div>
                        <label for="tel" class="form-label">Téléphone :</label>
                        <input type="text" placeholder="Téléphone Salarié" name="tel" class="form-control" required>
                    </div>
                    <div>
                        <label for="adresse" class="form-label">Adresse :</label>
                        <input type="text" placeholder="Adresse Salarié" name="adresse" class="form-control" required>
                    </div>
                    <div>
                        <label for="salaire" class="form-label">Salaire :</label>
                        <input type="text" placeholder="Salaire en DH" name="salaire" class="form-control" required>
                    </div>
                    <div>
                        <label for="dateEntree" class="form-label">Date Entrée :</label>
                        <input type="date" name="dateEntree" class="form-control" required>
                    </div>
                    <div>
                        <label for="actif" class="form-label">Actif :</label><br>
                        <input type="checkbox" name="active" value="Oui"> Oui
                        <input type="checkbox" name="active" value="Non"> Non
                    </div>
                    <button type="submit" class="form-control btn btn-primary my-2">Créer salarier</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>