@extends('layouts.template.app')

@section('title')
{{ $title }}
@endsection

@section('content')
<div class="container-fluid">
<div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm">
                            @can('create', 'App\Models\OffreService')
                            <div class="d-flex justify-content-end my-2">
                                <button id="btn-create" type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#create"><i class="mdi mdi-plus-circle me-1"></i> Ajouter {{$title}}</button>
                            </div>    
                            @endcan
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="myTable1" class="table table-centered table-nowrap table-striped">
                            <thead>
                                <tr>
                                    <th>Numero Offre</th>
                                    <th>Objet</th>
                                    <th>Client</th>
                                    <th style="width: 85px;">Actions</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Numero Offre</th>
                                    <th>Objet</th>
                                    <th>Client</th>
                                    <th style="width: 85px;">Actions</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($offreServices as $item)
                                    <tr>
                                        <td>{{ $item->numero_offre ?? ''}}</td>
                                        <td>{{ $item->objet ?? ''}}</td>
                                        <td>{{ $item->client->name ?? ''}}</td>

                                        <td class="">
                                            @can('view', $item)
                                            <a href="{{ route('offre_services.mail', $item->id) }} " class="action-icon text-dark" title="Envoyer par mail" data-plugin="tippy" data-tippy-animation="shift-away" data-tippy-inertia="true" data-tippy-duration="[600, 300]" data-tippy-arrow="true"> <i class="mdi mdi-email"></i></a>
                                            <a href="{{ route('offre_services.download', $item)}} " class="action-icon text-warning" title="Télécharger" data-plugin="tippy" data-tippy-animation="shift-away" data-tippy-inertia="true" data-tippy-duration="[600, 300]" data-tippy-arrow="true"> <i class="mdi mdi-file"></i></a>
                                            @endcan
                                            @can('update', $item)
                                            <a href="{{ route('offre_services.edit', $item->id) }} " class="edit action-icon text-primary" title="Modifier" data-plugin="tippy" data-tippy-animation="shift-away" data-tippy-inertia="true" data-tippy-duration="[600, 300]" data-tippy-arrow="true"> <i class="mdi mdi-square-edit-outline"></i></a>
                                            @endcan
                                            @can('delete', $item)
                                            <a href="{{ route ('offre_services.destroy', $item)}} " class="delete action-icon text-danger" title="Supprimer" data-plugin="tippy" data-tippy-animation="shift-away" data-tippy-inertia="true" data-tippy-duration="[600, 300]" data-tippy-arrow="true"> <i class="mdi mdi-delete"></i></a>                
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
    <!-- end row -->

    @include('offre_services.modals.modals')
</div>
@endsection
@push('js_files')
    <script src="{{ asset('assets/js/app/crud.js') }}"></script>
    <script>
        $('#contenu').summernote();
    </script>
@endpush

