@extends('layouts.template.app')

@section('title')
Liste des fonctions
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-sm">
                                @can('create', 'App\Models\Fonction')
                                <div class="d-flex justify-content-end my-2">
                                    <button id="btn-create" type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#create"><i class="mdi mdi-plus-circle me-1"></i> Ajouter une nouvelle fonction</button>
                                </div>
                                @endcan
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-centered table-nowrap table-striped" id="myTable1">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Fonction</th>
                                        <th style="width: 85px;">Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Fonction</th>
                                        <th style="width: 85px;">Action</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach ($fonctions as $fonction)
                                        <tr>
                                            <td>{{ $fonction->id ?? '' }} </td>
                                            <td>{{ $fonction->name ?? ''}}</td>

                                            <td>
                                                @can('update', $fonction)
                                                
                                                <a href="{{ route('fonction.edit', ['fonction'=> $fonction->id]) }}" title="Modifier la fonction" class="edit action-icon text-primary" data-plugin="tippy" data-tippy-animation="shift-away" data-tippy-inertia="true" data-tippy-duration="[600, 300]" data-tippy-arrow="true"> <i class="mdi mdi-square-edit-outline"></i></a>
                                                @endcan
                                                @can('update', $fonction)
                                                <a class="delete supprimer action-icon text-danger" href="{{ route ('fonction.supprimer',['fonction' => $fonction->id])}} " title="Supprimer" data-plugin="tippy" data-tippy-animation="shift-away" data-tippy-inertia="true" data-tippy-duration="[600, 300]" data-tippy-arrow="true"> <i class="mdi mdi-delete"></i></i></a>
                                                @endcan
                                            </td>

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
    </div>

    @include('fonction.modals.modals')
</div>
@endsection
@push('js_files')
    <script src="{{ asset('assets/js/app/fonction.js') }}"></script>
@endpush

