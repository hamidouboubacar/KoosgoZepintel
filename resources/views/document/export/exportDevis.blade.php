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
    @if ($sans_signature == 1 || $sans_signature == 0)
    <header>
        @php
            $image = explode('public/', $entreprise->entete);
         @endphp
       <img src="{{ public_path('storage/'.$image[1]) }}" width="100%" height="150px"/>
    </header>
    @endif
    <main>
        <br/><br/><br/>
        <p style="text-align: right;">{{ date('d-m-Y', strtotime($document->date)) }}</p>
        <div style="text-align: center">
            @if ($document->type == 'Devis')
            <h1>Facture Proforma</h1>
            <p>N° {{ $document->numero }}</p>
            @elseif ($document->type == 'FactureAvoir')
            <h1>Facture d'Avoir</h1>
            <small>N° {{ $document->numero }}</small><br>
            <small>Référence: {{ $document->reference ?? ''}}</small>
            @else
            <h1>FACTURE</h1>
            <small>N° {{ $document->numero }}</small><br>
            @if ($document->reference)
            <small>Référence: {{ $document->reference ?? ''}}</small>
            @endif
            <br>
            <strong>Période: {{ $document->perio }}  {{ date('Y', strtotime($document->date))  }}</strong>
            @endif 
        </div>
  
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
            @if ($document->user)
            <strong>Suivi par: {{$document->user->name}} ({{$document->user->telephone ?? '+226 xx xx xx'}})</strong><br />
            @else 
            <strong>Suivi par: {{$document->suivi_par}} ({{$document->contact_personne ?? '+226 xx xx xx'}})</strong><br />
            @endif
            <br>
            <strong>Objet: </strong> {{ $document->objet }} 
            <br>
        </div>
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
                @foreach($document->documentPackages as $selection)
                <tr>
                    <td style="width: 10%; text-align: center">{{$n}}</td>
                    <td style="width: 45%;">{{$selection->nom_package ?? $selection->package->nom}}</td>
                    <td style="width: 5%; text-align: center">{{$selection->quantite}}</td>
                    <td style="text-align: center">{{number_format($selection->prix_unitaire ,0,'.',' ')}} F</td>
                    <td style="text-align: center">{{number_format($selection->quantite*$selection->prix_unitaire ,0,'.',' ')}} F</td>
                </tr>
                @php
                    $n++;
                @endphp
                @endforeach
 
                @foreach ($facture_produits_ as $item)
                    <tr>
                        <td style="text-align: center">{{ $n ?? '---' }}</td>
                        <td>{{ $item->objet }}</td>
                        <td style="text-align: center">{{ $item->quantite ?? '---' }}</td>
                        <td style="text-align: center">{{number_format($item->montant ,0,'.',' ') }} F</td>
                        <td style="text-align: center">{{number_format($item->quantite*$item->montant ,0,'.',' ')}} F</td>
                    </tr>
                    @php
                $n++;
                @endphp
                @endforeach
            </tbody>
        </table>
        <br>
        <div class="remise">
            
            <table align="right" class="table-custom1" style="width: 40%; text-align: center;">
                @if($document == 'Facture')
                <tr>
                    <th>MONTANT HT :</th>
                    <td>{{number_format($document->montantht,0,'.',' ')}} F</td>
                </tr>
                <tr>
                    <th>TVA 18% :</th>
                    <td>{{number_format($document->tva,0,'.',' ')}} F</td>
                </tr>
                <tr>
                    <th>MONTANT TTC :</th>
                    <td>{{number_format($document->montantttc,0,'.',' ')}} F</td>
                </tr>
            @else
            <tr>
                <th>MONTANT HT :</th>
                <td>{{number_format($document->montantht,0,'.',' ')}} F</td>
            </tr>
            <tr>
                <th>TVA 18% :</th>
                <td>{{number_format($document->tva,0,'.',' ')}} F</td>
            </tr>
            <tr>
                <th>MONTANT TTC :</th>
                <td>{{number_format($document->montantttc,0,'.',' ')}} F</td>
            </tr>
            @endif
            </table>
        </div>
        <br />
        <p>
            Arr&ecirc;t&eacute;e la présente
            @if($document->type == 'Devis')
            Facture Proforma
            @else
            Facture
            @endif

            &agrave; la somme de : <strong>{{$total}} ({{number_format($document->montantttc,0,'.',' ')}}) Francs CFA TTC</strong>
        </p>

        @if ($document->commentaire)
        <p>
            <strong>Commentaire: </strong> {{$document->commentaire}}
        </p>  
        @endif
      

        @if($document->type == 'Devis')
        <div align="right"><strong>La direction commerciale &nbsp;&nbsp;</strong></div>
        @else
        <div align="right"><strong>La direction Générale &nbsp;&nbsp;</strong></div>
        @endif
        @if ($sans_signature == 1)
        <div style="text-align: right;">
            @php
            $imageSignature = explode('public/', $entreprise->signature);
            @endphp
            <img src="{{ public_path('storage/'.$imageSignature[1]) }}"  style="width: 245px; height: 120px;">
       </div>  
       @if ($user)
       <div style="text-align: right;">
       <strong>{{$user->name}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong><br /> 
       </div> 
       @else 
       <div style="text-align: right;">
       <strong>{{$document->suivi_par}} </strong><br /> 
       </div> 
       @endif
        @endif
        
        @if ($sans_signature == 1 || $sans_signature == 0)
        @php
        $imagePieddepage = explode('public/', $entreprise->pieddepage);
        @endphp
        <footer> <img src="{{ public_path('storage/'.$imagePieddepage[1]) }}" style="width: 800px; height: 75px;"/></footer>
        @endif

       
        

  </main>
</body>
  </html>