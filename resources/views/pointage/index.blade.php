<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Pointage Table</title>
        <style>
            #pointageTable {
                width: 100%;
                border-collapse: collapse;
            }

            #pointageTable th,
            #pointageTable td {
                border: 1px solid #ddd;
                padding: 8px;
                text-align: center;
            }

            button {
                background-color: #007bff;
                color: #fff;
                padding: 7px 15px;
                border: none;
                border-radius: 5px; 
                cursor: pointer;
            }
        </style>
    </head>

        <label for="startDate">Date : </label>
            <input type="date" id="startDate" name="startDate">
            <button type="button" id="filterButton">Filter</button><br><br>
        <body>
            <div style="overflow-x: auto;">
                <form action="{{ route('update.updateAll') }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <table id="pointageTable">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Date</th>
                                <th>Present/Absent</th>
                                <th>Heure Supp</th>
                                <th>Heure Moin</th>
                                <th>Avance</th>
                                <th>Remarque</th>
                            </tr>
                        </thead>
                        <tbody id="pointageTableData">
                            @foreach ($pointages as $pointage)
                            @if($pointage->salarier->active =="Oui")
                                <tr class="pointage-row">
                                    <input type="hidden" name="id_salarier[{{ $pointage->id }}]" value="{{ $pointage->id_salarier }}">
                                    <td>{{ $pointage->salarier->prenom }} {{ $pointage->salarier->nom }}</td>
                                    <td><input type="date" name="date[{{ $pointage->id }}]" value="{{ $pointage->date }}"></td>
                                    <td>
                                        <input type="checkbox" name="presentAbsent[{{ $pointage->id }}]" value="P" 
                                            @if($pointage->presentAbsent =="P") 
                                                checked 
                                            @endif
                                        >P
                                        <input type="checkbox" name="presentAbsent[{{ $pointage->id }}]" value="A"
                                            @if($pointage->presentAbsent =="A") 
                                                checked 
                                            @endif
                                        >A
                                    </td>
                                    <td><input type="text" name="heureSupp[{{ $pointage->id }}]" value="{{ $pointage->heureSupp }}"></td>
                                    <td><input type="text" name="heureMoin[{{ $pointage->id }}]" value="{{ $pointage->heureMoin }}"></td>
                                    <td><input type="text" name="avance[{{ $pointage->id }}]" value="{{ $pointage->avance }}"></td>
                                    <td><input type="text" name="remarque[{{ $pointage->id }}]" value="{{ $pointage->remarque }}"></td>
                                </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table><br>
                    <button type="submit">Update All</button>
                </form>
            </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const startDateInput = document.getElementById('startDate');
                const endDateInput = document.getElementById('endDate');
                const pointageRows = document.querySelectorAll('.pointage-row');
                const filterButton = document.getElementById('filterButton');

                function filterRows() {
                    const selectedDate = startDateInput.value;

                    pointageRows.forEach(row => {
                        const rowDateInput = row.querySelector('input[name^="date"]');
                        const rowDate = rowDateInput.value;

                        if (selectedDate === '' || rowDate === selectedDate) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });

                    document.getElementById('pointageTable').style.width = '100%';
                }


                filterButton.addEventListener('click', filterRows);
                startDateInput.addEventListener('input', filterRows);
                endDateInput.addEventListener('input', filterRows);
            });
        </script>
    </body>
</html>