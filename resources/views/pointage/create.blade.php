<html>
    <head>
        <title>Pointage</title>
        <style>
            body {
                font-family: Arial, sans-serif;
            }

            table {
                border-collapse: collapse;
                width: 100%;
                margin-bottom: 20px;
            }

            th, td {
                border: 1px solid #dddddd;
                text-align: left;
                padding: 8px;
            }

            th {
                background-color: #f2f2f2;
            }

            input[type="date"], input[type="text"] {
                width: 90%;
                padding: 5px;
            }

            input[type="checkbox"] {
                margin-right: 5px;
            }

            button[type="submit"] {
                background-color: #4CAF50;
                color: white;
                padding: 10px 20px;
                border: none;
                cursor: pointer;
                font-size: 16px;
            }

            button[type="submit"]:hover {
                background-color: #45a049;
            }
        </style>
    </head>
    <body>
        <form action="{{ route('pointage.store') }}" method="post">
            @csrf
            <b for="date">Date:</b>
            <input type="date" name="date"/><br><br>
            <table>
                <tr>
                    <th>Nom</th>
                    <th>Présent/Absent</th>
                    <th>Heure Supp</th>
                    <th>Heure Moin</th>
                    <th>Avance</th>
                    <th>Remarque</th>
                </tr>
                @foreach ($salariers as $salarier)
                    @if ($salarier->active =="Oui")
                        <tr>
                            <input type="hidden" name="id_salarier[]" value="{{ $salarier->id }}">
                            <td>{{ $salarier->prenom }} {{ $salarier->nom }}</td>
                            <td>
                                <input type="checkbox" name="presentAbsent[]" value="P" checked/>P
                                <input type="checkbox" name="presentAbsent[]" value="A"/>A
                            </td>
                            <td><input type="text" name="heureSupp[]" /></td>
                            <td><input type="text" name="heureMoin[]" /></td>
                            <td><input type="text" name="avance[]" /></td>
                            <td><input type="text" name="remarque[]" /></td>
                        </tr>
                    @endif
                @endforeach
            </table>
            <button type="submit" style="width:100%">Submit</button>
        </form>
    </body>
</html>