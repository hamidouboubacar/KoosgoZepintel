@extends('layouts.template.app')

@section('title')
    Bon de commande
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @can('create', 'App\Models\Client')
                    <div class="d-flex justify-content-end my-2">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#createUser"><i class="mdi mdi-plus-circle me-1"></i> Ajouter</button>
                    </div>
                    @endcan
                    <table id="dataTable" class="table table-striped">
                        <thead>
                            <tr>
                                <th>Numéro</th>
                                <th>Client</th>
                                <th>Date</th>
                                <th>Echéance</th>
                                <th style="width: 85px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bonCommandes as $bonCommade)
                                <tr>
                                    <td>{{ $bonCommade->numero ?? '' }}</td>
                                    <td>{{ $bonCommade->client->name ?? '' }} </td>
                                    <td> {{ date('d-m-Y', strtotime($bonCommade->date)) ?? ''}}</td>
                                    <td> {{ date('d-m-Y', strtotime($bonCommade->echeance)) ?? ''}}</td>
                                    <td class="">
                                            <a href="{{ route('bonCommande.show',['bonCommande' => $bonCommade->id])}}" title="Voir" class="action-icon text-secondary"> <i class="mdi mdi-eye"></i></a>                                     
                                            <a class="delete supprimer action-icon text-danger" href="{{ route ('bonCommande.supprimer',['bonCommande' => $bonCommade->id])}}" title="Supprimer"> <i class="mdi mdi-delete"></i></i></a>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @include('bonCommande.modals.modals')
                </div>
    
            </div> <!-- end card-body-->
        </div> <!-- end card-->
    </div> <!-- end col -->
</div>
<!-- end row -->
@endsection

@push('js_files')
<script src="{{ asset('assets/js/app/bonCommance.js') }}"></script>
@endpush
