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
                            @can('create', 'App\Models\Package')
                            <div class="d-flex justify-content-end my-2">
                                <button id="btn-create" type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#create"><i class="mdi mdi-plus-circle me-1"></i> Ajouter {{$title}}</button>
                            </div>    
                            @endcan
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="myTable1" class="table dataTable table-centered table-nowrap table-striped">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Débit</th>
                                    <th>Montant</th>
                                    <th style="width: 85px;">Actions</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Nom</th>
                                    <th>Débit</th>
                                    <th>Montant</th>
                                    <th style="width: 85px;">Actions</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($packages as $item)
                                    <tr>
                                        <td>{{ $item->nom ?? ''}}</td>
                                        <td>{{ $item->debit_ascendant.' Mbps' ?? ''}}</td>
                                        <td>{{ number_format($item->montant, 0, ',', ' ').' FCFA' ?? ''}}</td>

                                        <td class="">
                                            @can('update', $item)
                                            <a href="{{ route('packages.edit', $item->id) }} " class="edit action-icon text-primary" title="Modifier" data-plugin="tippy" data-tippy-animation="shift-away" data-tippy-inertia="true" data-tippy-duration="[600, 300]" data-tippy-arrow="true"> <i class="mdi mdi-square-edit-outline"></i></a>
                                           @endcan
                                            @can('delete', $item)
                                            <a href="{{ route ('packages.destroy', $item)}} " class="delete action-icon text-danger" title="Supprimer" data-plugin="tippy" data-tippy-animation="shift-away" data-tippy-inertia="true" data-tippy-duration="[600, 300]" data-tippy-arrow="true"> <i class="mdi mdi-delete"></i></a>                
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

    @include('packages.modals.modals')
</div>
@endsection
@push('js_files')
    <script src="{{ asset('assets/js/app/crud.js') }}"></script>
@endpush

