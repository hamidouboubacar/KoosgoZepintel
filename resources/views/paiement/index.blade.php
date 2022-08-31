@extends('layouts.template.app')

@section('title')
    Paiements
@endsection

@section('content')
    <div class="container-fluid">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('paiement.search') }}" class="d-flex mb-3" id="form">
                        @csrf
                        <div class="form-group">
                            <label for="date_debut">Date de début</label>
                            <input type="date" name="date_debut" id="date_debut" value="{{ $debut ?? '' }}" class="form-control"
                                placeholder="" aria-describedby="helpId" required>
                        </div>
                        <div class="form-group ml-2">
                            <label for="date_fin">Date de fin</label>
                            <input type="date" name="date_fin" value="{{ $fin ?? '' }}" id="date_fin" class="form-control"
                                placeholder="" aria-describedby="helpId" required>
                        </div>
                        <div class="form-group ml-2 mt-3">
                            <button type="submit" class="btn btn-primary">Rechercher</button>
                        </div>
                    </form>
                    <table id="myTable1" class="table table-striped">
                        <thead>
                            <tr>
                                <th>Facture</th>
                                <th>Date de paiement</th>
                                <th>Client</th>
                                <th>Période</th>
                                <th>Mode de règl.</th>
                                <th>Montant</th>
                                <th>Reste</th>
                                <th>Commercial</th>
                                <th style="width: 85px;">Actions</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Facture</th>
                                <th>Date de paiement</th>
                                <th>Client</th>
                                <th>Période</th>
                                <th>Mode de règl.</th>
                                <th>Montant</th>
                                <th>Reste</th>
                                <th>Commercial</th>
                                <th style="width: 85px;">Actions</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($paiements as $item)
                                <tr>
                                    <td>{{ $item->document->numero ?? '' }}</td>
                                    <td>{{ $item->date_paiement ?? '' }} </td>
                                    <td> {{ $item->document->client->name ?? ''}}</td>
                                    <td> {{ $item->document->periode ?? ''}}</td>
                                    <td> {{ $item->mode_paiement ?? ''}}</td>
                                    <td> {{number_format($item->montant_payer,0,'.',' ')}} F</td>
                                    <td> {{number_format($item->document->reste_a_payer,0,'.',' ')}} F</td>
                                    <td> {{ $item->user->name ?? ''}}</td>
                                    <td class="">
                                            <a href="#" title="Voir"  class="action-icon text-secondary"> <i class="mdi mdi-printer"></i></a>
                                            <a class="delete supprimer action-icon text-danger" href="{{ route ('paiement.supprimer',['paiement' => $item->id])}} " title="Supprimer"> <i class="mdi mdi-delete"></i></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
    
            </div> <!-- end card-body-->
        </div> <!-- end card-->
    </div> <!-- end col -->
@endsection
