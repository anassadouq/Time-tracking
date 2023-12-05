@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.4/css/buttons.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.4/datatables.min.css"/>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <style>
        table, th, td {
            border: 1px solid black;  
        }
        .paid-cell {
            background-color: greenyellow;
            color: black;
        }
    </style>
        <label>Debut : </label>
            <input type="date" id="debut">
        <label>Fin : </label>
            <input type="date" id="fin">
        <button id="filterButton" class="btn btn-success mx-2 my-1">
            <span class="material-symbols-outlined">touch_app</span>
        Clicker</button>

    <div class="mx-3">
        <h1 class="text-center">{{ $salariers->prenom }} {{ $salariers->nom }}</h1>
            <h1 class="text-center">{{ $salariers->salaire }}dh/jrs</h1>
        <table class="text-center" id="show">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Present / Absent</th>
                    <th>Heure Supp</th>
                    <th>Heure Moin</th>
                    <th>Avance</th>
                    <th>Montant à Ajouter</th>
                    <th>Payer</th>
                    <th>Remarque</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totaleSalaire = 0;
                    $totalSalaireInitial = 0;
                @endphp

                @foreach ($pointages as $pointage)
                    <tr class="dataRow" data-salaire="{{ $salariers->salaire }}" @if(date('D', strtotime($pointage->date)) === 'Sun') style="background-color: #333; color: #fff;" @endif >
                        <td>{{ $pointage->date }}</td>
                        <td>{{ $pointage->presentAbsent }}</td>
                        <td>
                            @if ($pointage->heureSupp)
                                {{ $pointage->heureSupp !== null ? number_format($pointage->heureSupp, 2) : '' }}h
                            @endif
                        </td>
                        <td>
                            @if ($pointage->heureMoin)
                                {{ $pointage->heureMoin !== null ? number_format($pointage->heureMoin, 2) : '' }}h
                            @endif
                        </td>
                        <td>
                            @if($pointage->avance)    
                                {{ $pointage->avance }}DH
                            @endif
                        </td>
                        <td>
                            @if($pointage->montantAjouter)    
                                {{ $pointage->montantAjouter }}DH
                            @endif
                        </td>
                        <td @if ($pointage->payer === 'oui')
                                class="paid-cell"
                            @endif>{{ $pointage->payer }}</td>
                        <td>{{ $pointage->remarque }}</td>
                        <td>
                            <form action="{{ route('pointage.destroy', $pointage['id']) }}" method="POST" id="deletepointageForm{{ $pointage['id'] }}">
                                @csrf
                                @method('DELETE')
                                <a href="{{ route('pointage.edit' ,$pointage['id']) }}" class="btn btn-secondary">
                                    <span class="material-symbols-outlined">edit</span>                                
                                Modifier</a>
                                <button type="button" class="btn btn-danger" onclick="confirmDeletepointage('{{ $pointage['id'] }}')">
                                    <span class="material-symbols-outlined">delete</span>
                                Supprimer</button>
                            </form>
                        </td>
                    </tr>
                    @php
                        if ($pointage->presentAbsent === 'P') {
                            $totaleSalaire += $salariers->salaire;
                        }

                        if ($pointage->avance) {
                            $totaleSalaire -= $pointage->avance;
                        }
                    @endphp
                @endforeach

                @php
                    $totalSalaire = $totalSalaireInitial;
                @endphp
            </tbody>
        </table>
            <table width="15%" class="text-center">
                <tr>
                    <th>Total Solde</th>
                </tr>
                <tr>
                    <td id="cellTotalSalaire"></td>
                </tr>
            </table>
    </div>

    <script>
        function confirmDeletepointage(id) {
            if (confirm("Are you sure you want to delete this pointage?")) {
                document.getElementById("deletepointageForm" + id).submit();
            }
        }

        document.getElementById("filterButton").addEventListener("click", function() {
            var debut = document.getElementById("debut").value;
            var fin = document.getElementById("fin").value;
            var dateDebut = new Date(debut);
            var dateFin = new Date(fin);
            var rows = document.getElementsByClassName("dataRow");
            var filteredTotalSalaire = 0;

            // Perform filtering and calculate the filtered total salaire
            for (var i = 0; i < rows.length; i++) {
                var date = new Date(rows[i].querySelector("td:nth-child(1)").textContent);
                var salaire = parseInt(rows[i].dataset.salaire);
                var presentAbsent = rows[i].querySelector("td:nth-child(2)").textContent;
                var avance = parseInt(rows[i].querySelector("td:nth-child(5)").textContent);
                var heureSupp = parseFloat(rows[i].querySelector("td:nth-child(3)").textContent);
                var heureMoin = parseFloat(rows[i].querySelector("td:nth-child(4)").textContent);
                var montantAjouter = parseFloat(rows[i].querySelector("td:nth-child(6)").textContent);


                if (date >= dateDebut && date <= dateFin) {
                    rows[i].style.display = "";
                    if (presentAbsent === 'P') {
                        filteredTotalSalaire += salaire;
                    }
                    if (avance) {
                        filteredTotalSalaire -= avance;
                    }
                    if (!isNaN(heureSupp)) {
                        filteredTotalSalaire += (heureSupp * salaire) / 8;
                    }
                    if (!isNaN(heureMoin)) {
                        filteredTotalSalaire += (heureMoin * salaire) / 8;
                    }
                    if (montantAjouter) {
                        filteredTotalSalaire += montantAjouter;
                    }
                } else {
                    rows[i].style.display = "none";
                }
            }
            document.getElementById("cellTotalSalaire").textContent = filteredTotalSalaire.toFixed(2) + "DH";
        });



    </script>
    
    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.4/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.4/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.4/js/buttons.print.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#show').DataTable( {
                dom: 'Blfrtip',
                lengthChange: false,
                paging: false,
                buttons: [],
                language: {
                    info: "",
                    infoEmpty: ""
                }
            });
        });
    </script>
@endsection