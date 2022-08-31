@extends('layouts.template.app')

@section('title')
Aperçu document
@endsection
@section('content')
   <!-- start page title -->
   <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Accueil</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Client</a></li>
                        <li class="breadcrumb-item active">Affichage Document</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->
                    <div class="form-row">
                        <div class="col-4">
                            <div class="form-group">
                                De
                                <address>
                                <strong>Groupe NetFroce SARL</strong> <br>
                                Ouagadougou, Quartier Tanghin, Rue <br>
                                Nongr-Massombr <br>
                                Tel: +226 74266200 <br>
                                Email: finance@netforce-group.com <br>
                                </address>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                A
                                <address>
                                <strong>{{ $client->name ?? '' }}</strong> <br>
                                @if ($client->adresse)
                                Adresse:  {{ $client->adresse ?? '' }} <br>
                                @endif
                                @if ($client->telephone)
                                Tel: {{ $client->telephone ?? '' }} <br>
                                @endif
                                @if ($client->email)
                                Email: {{ $client->email ?? '' }} <br>
                                @endif
                                @if ($client->ifu)
                                IFU: {{ $client->ifu ?? '' }} <br>
                                @endif
                                @if ($client->rccm)
                                RCCM: {{ $client->rccm ?? '' }} <br>
                                @endif
                                @if ($client->longitude)
                                Longitue: {{ $client->longitude ?? '' }} <br>
                                @endif
                                @if ($client->latitude)
                                Latitude: {{ $client->latitude ?? '' }} <br>
                                @endif
                                
                                </address>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <address>
                                <strong>{{ $document->type ?? '' }} {{ $document->numero ?? '' }}</strong> <br>
                                <strong>Objet:</strong> {{ $document->objet ?? '' }} <br>
                                <strong>Date:</strong> {{$document->date}} <br>
                                </address>
                            </div>
                        </div>
                    </div>

                    <br>
                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Désignation</th>
                                    <th>Quantié</th>
                                    <th>Prix Unitaire</th>
                                    <th>Montant</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $n=1;
                                @endphp
                                @foreach ($facture_packages_ as $item)
                                    <tr>
                                        <td>{{ $n?? '---' }}</td>
                                        <td>{{ $item->nom_package ?? $item->package->nom  }}</td>
                                        <td>{{ $item->quantite ?? '---' }}</td>
                                        <td>{{number_format($item->prix_unitaire ,0,'.',' ')}} F</td>
                                        <td>{{number_format($item->quantite*$item->prix_unitaire ,0,'.',' ')}} F</td>
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
                    </div>
                    <br>

                    <div class="row">
                        <div class="col-6">
                            <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                            <strong>Conditions de vente: </strong><br />
                            <strong>Commentaire:</strong><br /> {{$document->commentaire}}

                        </div>
                        <div class="col-6">
                        <div class="table-responsive">
                          @if ($document->total_versement == 0)
                          <table class="table">
                                @if ($document->remise !=0 )
                                <tr>
                                    <th style="width:50%">REMISE:</th>
                                    <td>{{number_format($document->remise,0,'.',' ')}} F</td>
                                </tr>
                                @endif
                                @if ($document->tva !=0 )
                                <tr>
                                    <th>MONTANT HT:</th>
                                    <td>{{number_format($document->montantht,0,'.',' ')}} F</td>
                                </tr>
                                <tr>
                                    <th>TVA 18%:</th>
                                    <td>{{number_format($document->tva,0,'.',' ')}} F</td>
                                </tr>
                                <tr>
                                    <th>MONTANT TTC:</th>
                                    <td>{{number_format($document->montantttc,0,'.',' ')}} F</td>
                                </tr>
                                @else
                                <tr>
                                    <th>TVA (Exonor&eacute;)</th>
                                    <td> 0 F</td>
                                </tr>
                                <tr>
                                    <th>MONTANT TTC:</th>
                                    <td>{{number_format($document->montantttc,0,'.',' ')}} F</td>
                                </tr>
                                @endif
                          </table>
                          @else
                          <table class="table">
                              @if ($document->tva !=0)
                              <tr>
                                <th>MONTANT TTC:</th>
                                <td>{{number_format($document->montantttc,0,'.',' ')}} F</td>
                              </tr>
                              @else
                              <tr>
                                <th>TOTAL:</th>
                                <td>{{number_format($document->montantttc,0,'.',' ')}} F</td>
                            </tr>
                              @endif
                              <tr>
                                <th>TOT. Versé:</th>
                                <td>{{number_format(intval($document->total_versement),0,'.',' ')}} F</td>
                            </tr>
                            <tr>
                                <th>Reste à payer:</th>
                                <td>{{number_format($document->reste_a_payer,0,'.',' ')}} F</td>
                            </tr>
                          </table>

                          @endif

                        </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                                <strong>Paiement: Groupe NetForce</strong><br />  
                                Banque: <br/>
                                N° compte: N° <br/>
                                Monnaie: XOF<br />
                            </p>
                        </div>
                        <div class="col-6">
                            Arret&eacute;e la présente &agrave; la somme de: <strong style="text-transform: capitalize;"> {{$montant_en_chiffre}}  Francs CFA</strong>
                            <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                                @if ($document->user != null)
                                <strong>Votre commerciale: {{$document->user->name}} ({{$document->user->telephone ?? '+226 xx xx xx'}}) </strong><br /> 
                                @else
                                <strong>Suivi par: {{$document->suivi_par}} ({{$document->contact_personne ?? '+226 xx xx xx'}}) </strong><br /> 
                                @endif
                             </p>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-8">
                            <div class="button-list">
                                <a type="button" href="{{ route('exportDevis', ['document'=>$document->id, 'sans_signature' => 0]) }}" target="_blank" class="btn btn-success"><span class="btn-label"><i class="mdi mdi-printer"></i></span>Imprimer sans sign.</a>
                                <a href="{{ route('exportDevis', ['document'=>$document->id, 'sans_signature' => 1]) }}" type="button" target="_blank" class="btn btn-info"><span class="btn-label"><i class="mdi mdi-printer"></i></span>Imprimer avec entete et sign.</a>
                                <a type="button" href="{{ route('exportDevis', ['document'=>$document->id, 'sans_signature' => 2]) }}" target="_blank"  class="btn btn-primary"><span class="btn-label"><i class="mdi mdi-printer"></i></span>Imprimer sans entete</a>
                            </div>
                        </div>
                        <div class="col-4">
                            @if ($document->type == 'Devis')
                            <a type="button" href="{{ route('document.facturer', ['document'=> $document->id]) }}" title="Facturer"   class="btn btn-light"><span class="btn-label"><i class="mdi mdi-credit-card"></i></span>Facturer</a>
                            @else
                                @if ($document->reste_a_payer != 0)
                                <a href="{{ route('document.paiement', ['document'=> $document->id]) }}" type="button"  class="btn btn-secondary" class="page-title-right"><span class="btn-label"><i class="mdi mdi-cash"></i></span>Payer</a>
                                @else
                                
                                @endif
                            @endif
                        
                        </div>
                    </div>
    

@endsection