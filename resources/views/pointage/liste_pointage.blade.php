@extends('layouts.app')
@section('content')
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
            <title>Liste Pointage</title>
        </head>
        <body>
            <style>
                #tableWrapper.hidden {
                    display: none;
                }

                .black-cell {
                    background-color: #333;
                    color: white;
                }
                table, th, td {
                    border: 1px solid;
                }
                .paid-cell {
                    background-color: greenyellow;
                    color: black;
                }
                #totalSalariesList {
                    list-style-type: none;
                    margin: 20px;
                    padding: 0;
                }

                #totalSalariesList li {
                    margin-bottom: 10px;
                    border: 1px solid #ddd;
                    padding: 8px;
                    background-color: #f7f7f7;
                    border-radius: 5px;
                }
            </style>    

            <label>Debut : </label>
            <input type="date" id="debut">
            <label>Fin : </label>
            <input type="date" id="fin">
            <button id="filterButton" class="btn btn-dark text-light mx-2">
                <span class="material-symbols-outlined">touch_app</span>            
            Clicker</button> <br><br>

            <table class="hidden text-center mx-2" width="98%" id="tableWrapper">
                <thead>
                    <tr>
                        <th>Salarie</th>
                        @php
                            $dates = [];
                        @endphp
                        @foreach ($pointages as $pointage)
                            @if (!in_array($pointage->date, $dates))
                                <th data-date="{{ date('Y-m-d', strtotime($pointage->date)) }}" id="date">
                                    {{ date('l d/m/y', strtotime($pointage->date)) }}
                                </th>
                                @php
                                    $dates[] = $pointage->date;
                                @endphp
                            @endif
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($salariers as $salarier)
                        @if($salarier->active =="Oui")
                            <tr>
                                <td class="nom-salarier">
                                    {{ $salarier->prenom }} {{ $salarier->nom }}<br>
                                    <span class="salaire">{{ $salarier->salaire }} DH/jrs</span><br>
                                    {{ ($salarier->salaire) / 8 }} DH/h
                                </td>

                                @php
                                    $dates = [];
                                    $totalSalaire = 0;
                                @endphp
                                @foreach ($pointages as $pointage)
                                    @if ($pointage->id_salarier == $salarier->id && !in_array($pointage->date, $dates))
                                        @php
                                            $cellDate = date('Y-m-d', strtotime($pointage->date));
                                        @endphp
                                        <td data-date="{{ $cellDate }}" data-presentAbsent="{{ $pointage->presentAbsent }}" data-avance="{{ $pointage->avance }}" data-heureSupp="{{ $pointage->heureSupp }}" data-heureMoin="{{ $pointage->heureMoin }}" data-montantAjouter="{{ $pointage->montantAjouter }}"
                                            @if ($pointage->payer === 'oui')
                                                class="paid-cell"
                                            @endif
                                            @if (date('N', strtotime($pointage->date)) == 7)
                                                class="black-cell"
                                            @endif>     
                                        <span style="font-weight: {{ ($pointage->presentAbsent === 'A' && date('N', strtotime($pointage->date)) != 7) ? 'bold' : 'normal' }}; color: {{ ($pointage->presentAbsent === 'A' && date('N', strtotime($pointage->date)) != 7) ? 'red' : 'inherit' }}">
                                                {{ $pointage->presentAbsent }}
                                            </span>
                                            <hr>
                                            @if($pointage->heureSupp)
                                                <span style="font-weight:bold;color:green">
                                                    +{{ $pointage->heureSupp }}h
                                                </span>
                                            @endif

                                            @if($pointage->heureMoin)
                                                <span style="font-weight:bold;color:orange">
                                                    {{ $pointage->heureMoin }}h
                                                </span>
                                            @endif
                                            <br> 
                                            @if($pointage->avance)
                                                avance : {{ $pointage->avance }}
                                            @endif
                                            <br>
                                            @if($pointage->montantAjouter)
                                                màa : {{ $pointage->montantAjouter }}
                                            @endif   
                                            @if($pointage->remarque)
                                                {{ $pointage->remarque }}
                                            @endif                                               
                                        </td>

                                        @php
                                            $dates[] = $pointage->date;
                                            // Calculer le total de salaire pour ce pointage et l'ajouter au totalSalaire
                                            if ($pointage->presentAbsent === 'P') {
                                                $totalSalaire += $salarier->salaire;
                                            }
                                            if ($pointage->avance) {
                                                $totalSalaire -= $pointage->avance;
                                            }
                                            if ($pointage->heureSupp) {
                                                $totalSalaire += ($pointage->heureSupp * $salarier->salaire)/8;
                                            }
                                            if ($pointage->heureMoin) {
                                                $totalSalaire += ($pointage->heureMoin * $salarier->salaire)/8;
                                            }
                                            if ($pointage->montantAjouter) {
                                                $totalSalaire += $pointage->montantAjouter;
                                            }
                                        @endphp
                                    @endif
                                @endforeach
                            </tr>
                            <tr>
                                @php
                                    $totalSalaire = 0;
                                    $dates = [];
                                @endphp

                                @foreach ($pointages as $pointage)
                                    @if ($pointage->id_salarier == $salarier->id && !in_array($pointage->date, $dates))
                                        @php
                                            $dates[] = $pointage->date;
                                            if ($pointage->presentAbsent === 'P') {
                                                $totalSalaire += $salarier->salaire;
                                            }
                                            if ($pointage->avance) {
                                                $totalSalaire -= $pointage->avance;
                                            }
                                            if ($pointage->heureSupp) {
                                                $totalSalaire += ($pointage->heureSupp * $salarier->salaire)/8;
                                            }
                                            if ($pointage->heureMoin) {
                                                $totalSalaire += ($pointage->heureMoin * $salarier->salaire)/8;
                                            }
                                            if ($pointage->montantAjouter) {
                                                $totalSalaire += $pointage->montantAjouter;
                                            }
                                        @endphp
                                    @endif
                                @endforeach
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>

            <ul id="totalSalariesList"></ul>
            
            <script>
                document.getElementById("filterButton").addEventListener("click", function() {
                    var debut = new Date(document.getElementById("debut").value);
                    var fin = new Date(document.getElementById("fin").value);
                    filterData(debut, fin);
                    calculateTotalSalaire(debut, fin);
                    calculateTotalGeneralSalaire(debut, fin); // Ajout du calcul du total général

                    // Show the table wrapper and salary results after filtering
                    var tableWrapper = document.getElementById("tableWrapper");
                    tableWrapper.classList.remove("hidden");
                    document.getElementById("totalSalariesList").style.display = "block";
                });

                function filterData(debut, fin) {
                    var rows = document.querySelectorAll("tr");
                    for (var i = 0; i < rows.length; i++) {
                        var row = rows[i];
                        var salarierCell = row.querySelector(".nom-salarier");
                        var cells = row.querySelectorAll("td");
                        if (salarierCell) {
                            var salarier = salarierCell.textContent;
                            if (salarier) {
                                if (row.style.display === "none") {
                                    row.style.display = "table-row";
                                }
                                if (cells.length > 0) {
                                    var showRow = false;
                                    for (var j = 0; j < cells.length; j++) {
                                        var cell = cells[j];
                                        var cellDate = new Date(cell.getAttribute("data-date"));
                                        if (cellDate >= debut && cellDate <= fin) {
                                            cell.style.display = "table-cell";
                                            showRow = true;
                                        } else {
                                            cell.style.display = "none";
                                        }
                                    }
                                    if (showRow) {
                                        salarierCell.style.display = "table-cell";
                                    } else {
                                        salarierCell.style.display = "none";
                                        row.style.display = "none";
                                    }
                                }
                            }
                        }
                    }
                    var headers = document.querySelectorAll("th[data-date]");
                    for (var k = 0; k < headers.length; k++) {
                        var header = headers[k];
                        var headerDate = new Date(header.getAttribute("data-date"));
                        if (headerDate >= debut && headerDate <= fin) {
                            header.style.display = "table-cell";
                        } else {
                            header.style.display = "none";
                        }
                    }
                }

                function calculateTotalSalaire(debut, fin) {
                    var totalSalaries = []; // Array to store total salaries
                    var totalSalariesList = document.getElementById("totalSalariesList"); // Get the <ul> element
                    totalSalariesList.innerHTML = ""; // Clear the list before updating

                    var rows = document.querySelectorAll("tr");
                    for (var i = 0; i < rows.length; i++) {
                        var row = rows[i];
                        var salarierCell = row.querySelector(".nom-salarier");
                        var cells = row.querySelectorAll("td");
                        var totalSalaire = 0;
                        if (salarierCell) {
                            var salarier = salarierCell.textContent;
                            if (salarier) {
                                for (var j = 0; j < cells.length; j++) {
                                    var cell = cells[j];
                                    var cellDate = new Date(cell.getAttribute("data-date"));
                                    if (cellDate >= debut && cellDate <= fin) {
                                        // Your existing calculations for salary
                                        var presentAbsent = cell.getAttribute("data-presentAbsent");
                                        var avance = parseFloat(cell.getAttribute("data-avance")) || 0;
                                        var heureSupp = parseFloat(cell.getAttribute("data-heureSupp")) || 0;
                                        var heureMoin = parseFloat(cell.getAttribute("data-heureMoin")) || 0;
                                        var montantAjouter = parseFloat(cell.getAttribute("data-montantAjouter")) || 0;

                                        if (presentAbsent === 'P') {
                                            totalSalaire += parseFloat(salarierCell.querySelector(".salaire").textContent);
                                        }
                                        if (avance) {
                                            totalSalaire -= avance;
                                        }
                                        if (heureSupp) {
                                            totalSalaire += (heureSupp * parseFloat(salarierCell.querySelector(".salaire").textContent)) / 8;
                                        }
                                        if (heureMoin) {
                                            totalSalaire += (heureMoin * parseFloat(salarierCell.querySelector(".salaire").textContent)) / 8;
                                        }
                                        if (montantAjouter) {
                                            totalSalaire += montantAjouter;
                                        }
                                    }
                                }
                                if (totalSalaire > 0) {
                                    totalSalaries.push({ name: salarier, totalSalaire: totalSalaire.toFixed(2) });
                                }
                            }
                        }
                    }

                    // Update the <ul> list with employee names and total salaries
                    for (var k = 0; k < totalSalaries.length; k++) {
                        var listItem = document.createElement("li");
                        listItem.innerHTML = totalSalaries[k].name + " - Salaire Total: " + '<strong>' + totalSalaries[k].totalSalaire + 'DH</strong>';
                        totalSalariesList.appendChild(listItem);
                    }
                }

                function calculateTotalGeneralSalaire(debut, fin) {
                    var totalGeneralSalaire = 0;

                    var rows = document.querySelectorAll("tr");
                    for (var i = 0; i < rows.length; i++) {
                        var row = rows[i];
                        var salarierCell = row.querySelector(".nom-salarier");
                        var cells = row.querySelectorAll("td");
                        var totalSalaire = 0;
                        if (salarierCell) {
                            var salarier = salarierCell.textContent;
                            if (salarier) {
                                for (var j = 0; j < cells.length; j++) {
                                    var cell = cells[j];
                                    var cellDate = new Date(cell.getAttribute("data-date"));
                                    if (cellDate >= debut && cellDate <= fin) {
                                        // Your existing calculations for salary
                                        var presentAbsent = cell.getAttribute("data-presentAbsent");
                                        var avance = parseFloat(cell.getAttribute("data-avance")) || 0;
                                        var heureSupp = parseFloat(cell.getAttribute("data-heureSupp")) || 0;
                                        var heureMoin = parseFloat(cell.getAttribute("data-heureMoin")) || 0;
                                        var montantAjouter = parseFloat(cell.getAttribute("data-montantAjouter")) || 0;

                                        if (presentAbsent === 'P') {
                                            totalSalaire += parseFloat(salarierCell.querySelector(".salaire").textContent);
                                        }
                                        if (avance) {
                                            totalSalaire -= avance;
                                        }
                                        if (heureSupp) {
                                            totalSalaire += (heureSupp * parseFloat(salarierCell.querySelector(".salaire").textContent)) / 8;
                                        }
                                        if (heureMoin) {
                                            totalSalaire += (heureMoin * parseFloat(salarierCell.querySelector(".salaire").textContent)) / 8;
                                        }
                                        if (montantAjouter) {
                                            totalSalaire += montantAjouter;
                                        }
                                    }
                                }
                                if (totalSalaire > 0) {
                                    totalGeneralSalaire += totalSalaire;
                                }
                            }
                        }
                    }

                    // Affichez le salaire général total sous la table
                    var totalGeneralElement = document.createElement("p");
                    totalGeneralElement.innerHTML = "Total Général : " + '<strong>' + totalGeneralSalaire.toFixed(2) + ' DH</strong>';
                    document.body.appendChild(totalGeneralElement);
                }
            </script>
        </body>
    </html>
@endsection