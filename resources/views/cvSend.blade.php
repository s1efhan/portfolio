<!DOCTYPE html>
<html lang="de">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="initial-scale=1.0, width=device-width">
    <style>
       .invisible {display:none} table th, td  {color: var(--background-color);border:solid thin;padding:0.5em;}
    </style>
    <link rel="icon" href="/favicon.ico">
    @vite('resources/css/style.scss')
    @vite('resources/js/app.js')
</head>
<body>
    <div>
        <h1>Daten des CV-Download-Formulars</h1>
        <form action="/api/cv-senden" method="post">
            @csrf
            <select name="formularDaten" id="formularDaten">
                @foreach($formularDaten->sortByDesc('created_at') as $daten)
                    @php
                        // Formatierung des Datums
                        $createdYear = date("Y", strtotime($daten->created_at));
                        $currentYear = date("Y");
                        $formattedDate = date("H:i \U\h\\r d.m", strtotime($daten->created_at));
                        if ($createdYear != $currentYear) {
                            $formattedDate .= $createdYear;
                        }
                    @endphp
                    <option value="{{ $daten->id }}">
                        {{ $daten->company }} - {{ $formattedDate }}
                    </option>
                @endforeach
            </select>
            <table>
                <thead>
                    <th>E-Mail</th>
                    <th>Name</th>
                    <th>Unternehmen</th>
                    <th>Position</th>
                    <th>Erstellt am</th>
                    </thead>
                    <tbody>
                @foreach($formularDaten->sortByDesc('created_at') as $daten)
                    @php
                        // Formatierung des Datums
                        $createdYear = date("Y", strtotime($daten->created_at));
                        $currentYear = date("Y");
                        $formattedDate = date("H:i \U\h\\r d.m", strtotime($daten->created_at));

                        if ($createdYear != $currentYear) {
                            $formattedDate .= $createdYear;
                        }
                    @endphp
                    
                    <tr class="invisible" id="row_{{ $daten->id }}">
                        <td>{{ $daten->email }}</td>
                        <td>{{ $daten->name }}</td>
                        <td>{{ $daten->company }}</td>
                        <td>{{ $daten->position }}</td>
                        <td>{{ $formattedDate }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <button type="submit" name="senden" value="senden">Senden</button>
        </form>
    </div>

    <script>
        function highlightRow() {
            var selectedIndex = document.getElementById('formularDaten').selectedIndex;
            var selectedOption = document.getElementById('formularDaten').options[selectedIndex];
            var selectedId = selectedOption.value;
            var rowId = 'row_' + selectedId;
            var row = document.getElementById(rowId);
            
            // Entfernen Sie die Hervorhebung von der vorherigen Zeile
            var previousHighlightedRow = document.querySelector('.visible');
            if (previousHighlightedRow) {
                previousHighlightedRow.classList.remove('visible');
                previousHighlightedRow.classList.add('invisible');
            }
            
            // Hervorheben der ausgewählten Zeile
            if (row) {
                row.classList.add('visible');
                row.classList.remove('invisible');
            }
        }

        // Führen Sie die Funktion beim Laden der Seite aus
        document.addEventListener('DOMContentLoaded', highlightRow);

        // Führen Sie die Funktion auch beim Ändern der Auswahl aus
        document.getElementById('formularDaten').addEventListener('change', highlightRow);
    </script>
</body>
</html>
