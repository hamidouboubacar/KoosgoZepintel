@extends('layouts.template.app')

@section('title')
Réglements
@endsection

@section('content')
    <div class="container-fluid">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                
                    @can('create', 'App\Models\Client')
                    <div class="row mb-2">
                        <div class="col-sm">
                            <div class="d-flex justify-content-end my-2">
                                <button class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#createUser"><i class="mdi mdi-plus-circle me-1"></i> Ajouter Client</button>
                            </div>   
                        </div>
                    </div>
                    @endcan
                    <form method="POST" action="{{ route('reglement.search') }}" class="d-flex mb-3" id="form">
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
                    <table id="myTable1">
                        <thead>
                            <tr>
                                <th>Facture</th>
                                <th>Client</th>
                                <th>Montant payé</th>
                                <th>Reste</th>
                                <th>Période</th>
                                <th>Date</th>
                                <th>Mode de paiement</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Facture</th>
                                <th>Client</th>
                                <th>Montant payé</th>
                                <th>Reste</th>
                                <th>Période</th>
                                <th>Date</th>
                                <th>Mode de paiement</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($paiements as $paiement)
                                <tr>
                                    <td> {{ $paiement->document->numero ?? ''}}</td>
                                    <td> {{ $paiement->document->client->name ?? ''}}</td>
                                    <td>{{number_format($paiement->montant_payer,0,'.',' ')}} F</td>
                                    <td> {{number_format($paiement->reste,0,'.',' ')}} F</td>
                                    <td> {{ $paiement->document->periode ?? ''}}</td>
                                    <td> {{ $paiement->date_paiement ?? ''}}</td>
                                    <td> {{ $paiement->mode_paiement ?? ''}}</td>
                                
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @include('client.modals.modals')
                </div>
    
            </div> <!-- end card-body-->
        </div> <!-- end card-->
    </div> <!-- end col -->
</div>
<!-- end row -->
@endsection

@push('js_files')
    <script src="{{ asset('assets/js/app/client.js') }}"></script>
@endpush
