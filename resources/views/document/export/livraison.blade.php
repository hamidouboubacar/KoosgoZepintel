<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous" />
        <title>{{ $document->numero }}</title>
    <style>
        .table-custom,
        .table-custom1 {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            border-width: 1px;
            border-style: solid;
            border-color: #ddd;
            border: 1px solid #ddd;
        }

        .table-custom th,
        .table-custom td {
            border: 1px solid #ddd;
            /*padding: 12px;*/
            word-wrap: break-word;
        }

        .table-custom1 th,
        .table-custom1 td {
            border: 1px solid #ddd;
            /* padding: 15px; */
            word-wrap: break-word;
            width: 50%;
        }

        .remise {
            display: flex;
            text-align: end;
            justify-content: flex-end;
        }

        @page {
            margin: 0cm 0cm;
        }
          

        body {
            margin-top: 3cm;
            margin-left: 2cm;
            margin-right: 2cm;
            margin-bottom: 2cm;
            font-size: 14.8px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        header {
            position: fixed;
            top: 0cm;
            left: 0cm;
            right: 0cm;
            height: 3cm;
        }

        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;
        }

        .container .table-custom .table-custom1 .remise .table {
            font-family: 'arial';
            font-size: 9px;

        }

        body {
            font-family: 'Noto Sans', 'sans-serif';
            font-size: 13px;
             height: 100vh;
        }
    </style>
</head>
<body>
    <header>
        @php
        $image = explode('public/', $entreprise->entete);
     @endphp
   <img src="{{ public_path('storage/'.$image[1]) }}" width="100%" height="150px"/>
    </header>
    <main>
        
        <br/><br/>
        <br/>
        <p style="text-align: right;">{{ date('d-m-Y', strtotime($document->date)) }}</p>
        <div style="text-align: center">
            <h1>BON DE LIVRAISON</h1>
            <p>N° {{ $document->bonLivraison[0]->numero_bl }}</p>
        </div>
        <div>
  
            @if ($document->client->name)
            <strong>CLIENT: </strong> {{ $document->client->name }}<br />
            @endif
            @if ($document->client->adresse)
            <strong>Adresse</strong> {{ $document->client->adresse }} <br />
            @endif
            @if ($document->client->telephone)
            <strong>TEL:</strong> {{ $document->client->telephone }} <br />
            @endif
            @if ($document->client->email)
            <strong>EMAIL:</strong> {{ $document->client->email }}<br />
            @endif
            @if ($document->client->ifu)
            <strong>IFU: </strong> {{ $document->client->ifu }}<br />
            @endif
            @if ($document->client->rccm)
            <strong>RCCM: </strong> {{ $document->client->rccm }}<br />
            @endif
            <br>
            <strong>Objet: </strong> {{ $document->objet }} 
            
        </div>
        <br>
        <br>
        <table class="table-custom">
            <thead>
                <tr>
                    <th style="text-align: center">N°</th>
                    <th style="text-align: center">Désignation</th>
                    <th style="text-align: center">Qté</th>
                    <th style="text-align: center">Prix Unitaire</th>
                    <th style="text-align: center">Montant</th>
                </tr>
            </thead>
            <tbody class="table">
                @php
                $n=1;
                @endphp
                @foreach($selections as $selection)
                <tr>
                    <td style="width: 10%;">{{$n}}</td>
                    <td style="width: 45%;">{{$selection->package->nom}}</td>
                    <td style="width: 5%;">{{$selection->quantite}}</td>
                    <td>{{number_format($selection->prix_unitaire ,0,'.',' ')}} F</td>
                    <td>{{number_format($selection->quantite*$selection->prix_unitaire ,0,'.',' ')}} F</td>
                </tr>
                @php
                    $n++;
                @endphp
                @endforeach

                @foreach ($facture_produits_ as $item)
                    <tr>
                        <td>{{ $n?? '---' }}</td>
                        <td>{{ $item->objet }}</td>
                        <td>{{ $item->quantite ?? '---' }}</td>
                        <td>{{number_format($item->montant ,0,'.',' ')}} F</td>
                        <td>{{number_format($item->quantite*$item->montant ,0,'.',' ')}} F</td>
                    </tr>
                    @php
                $n++;
                @endphp
                @endforeach
            </tbody>
        </table>
        <br>
        <br>  <br>
        <div align="right"><strong>Reception&nbsp;&nbsp;</strong></div>
     
        @php
        $imagePieddepage = explode('public/', $entreprise->pieddepage);
        @endphp
        <footer> <img src="{{ public_path('storage/'.$imagePieddepage[1]) }}" style="width: 800px; height: 75px;"/></footer>
      
  </main>
</body>
  </html>