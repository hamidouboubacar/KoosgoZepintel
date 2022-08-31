@extends('layouts.template.app')
@section('title')
    Permissions
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-sm">
                                @can('create', 'App\Models\Role')
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-primary mb-2" data-toggle="modal" data-target="#modelId"><i class="mdi mdi-plus-circle me-1"></i> Nouvelle permission</button>
                                </div>
                            @endcan
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-centered table-nowrap table-striped" id="myTable1">
                                <thead>
                                    <tr>
                                        <th>Nom</th>
                                        <th>Code</th>
                                        <th>Description</th>
                                        <th style="width: 85px;">Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Nom</th>
                                        <th>Code</th>
                                        <th>Description</th>
                                        <th style="width: 85px;">Action</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach ($roles as $role)
                                    <tr>
                                        <td> {{ $role->name }}</td>
                                        <td> {{ $role->code }}</td>
                                        <td> {{ $role->description }}</td>
                                        <td>
                                            @can('update', $role)
                                            <a href="{{ route('role.edit', ['role'=> $role->id]) }}" title="Modifier" class="edit action-icon text-primary" data-plugin="tippy" data-tippy-animation="shift-away" data-tippy-inertia="true" data-tippy-duration="[600, 300]" data-tippy-arrow="true"><i class="mdi mdi-square-edit-outline"></i></a>
                                            @endcan
                                            @can('delete', $role)
                                            <a class="delete supprimer action-icon text-danger" href="{{ route ('role.supprimer',['role' => $role->id])}} " title="Supprimer" data-plugin="tippy" data-tippy-animation="shift-away" data-tippy-inertia="true" data-tippy-duration="[600, 300]" data-tippy-arrow="true"> <i class="mdi mdi-delete"></i></i></a>
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

    </div>

    @include('role.forms.modal')
@endsection

@push('js_files')
    <script src="{{ asset('assets/js/app/role.js') }}"></script>
@endpush

