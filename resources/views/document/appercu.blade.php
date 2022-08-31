@extends('layouts.template.app')

@section('title')
Aperçu Bon de livraison
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
                                <strong>BON DE LIVRAISON {{ $document->bonLivraison[0]->numero_bl ?? '' }}</strong> <br>
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
                                        <td>{{ $item->package->nom }}</td>
                                        <td>{{ $item->quantite ?? '---' }}</td>
                                        <td>{{number_format($item->prix_unitaire,0,'.',' ')}} F</td>
                                        <td>{{number_format($item->quantite*$item->prix_unitaire ,0,'.',' ')}} F</td>
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
                        <div class="col-8">
                            <div class="button-list">
                                <a href="{{ route('exportBonlivraison', ['document'=>$document->id]) }}" type="button" target="_blank" class="btn btn-info"><span class="btn-label"><i class="mdi mdi-printer"></i></span>Imprimer</a>
                            </div>
                        </div>
                    </div>
    

@endsection