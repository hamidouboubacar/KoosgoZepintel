@extends('layouts.template.app')

@section('title')
    Prospects
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @can('create', 'App\Models\Client')
                    <div class="d-flex justify-content-end my-2">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#createUser"><i class="mdi mdi-plus-circle me-1"></i> Ajouter un prospect</button>
                    </div>
                    @endcan
                    <table id="dataTable" class="table table-striped" data-client="{{ App\Models\Client::where('type', 'Client')->count() + 1 }}"
                    data-prospect="{{ App\Models\Client::where('type', 'Prospect')->count() + 1 }}"
                    >
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Nom & Prénom</th>
                                <th>Contact</th>
                                <th>Ville</th>
                                <th>Commercial</th>
                                <th style="width: 85px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($prospects as $prospect)
                                <tr>
                                    <td>{{ $prospect->code_client ?? '' }}</td>
                                    <td>{{ $prospect->name ?? '' }} </td>
                                    <td> {{ $prospect->telephone ?? ''}}</td>
                                    <td> {{ $prospect->ville ?? ''}}</td>
                                    <td> {{ $prospect->user->name ?? ''}}</td>
                                    <td class="">
                                        
                                            <a href="{{ route('prospect.show', ['prospect'=>$prospect->id]) }}" title="Voir" class="action-icon text-secondary"> <i class="mdi mdi-eye"></i></a>
                                            @can('update', $prospect)
                                            <a href="{{ route('prospect.edit', ['prospect'=> $prospect->id]) }}" title="Modifier le prospect" class="edit action-icon text-primary"> <i class="mdi mdi-square-edit-outline"></i></a>
                                            @endcan
                                            @can('delete', $prospect)
                                            <a class="supprimer action-icon text-danger" href="{{ route ('prospect.supprimer',['prospect' => $prospect->id])}} " title="Supprimer"> <i class="mdi mdi-delete"></i></a>
                                            @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @include('prospect.modals.modals')
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
