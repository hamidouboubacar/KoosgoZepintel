@extends('layouts.template.app')

@section('title')
    Utilisateurs
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-sm">
                                @can('ajouterPermission', 'App\Models\User')
                                <div style="float:left;">
                                    <button class="btn btn-secondary" data-toggle="modal" data-target="#createPermission">Attribuer une permission</button>
                                  </div>
                                  @endcan
                                @can('create', 'App\Models\User')
                                <div class="d-flex justify-content-end my-2">
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#createUser"><i class="mdi mdi-plus-circle me-1"></i> Nouvel utilisateur</button>
                                </div>
                                @endcan
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-centered table-nowrap table-striped" id="myTable1">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nom & Prénom</th>
                                        <th>Email</th>
                                        <th>Contact</th>
                                        <th>Poste</th>
                                        <th style="width: 85px;">Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nom & Prénom</th>
                                        <th>Email</th>
                                        <th>Contact</th>
                                        <th>Poste</th>
                                        <th style="width: 85px;">Action</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach ($users as $us)
                                    <tr>
                                        <td>{{ $us->id ?? '' }}</td>
                                        <td>{{ $us->name ?? '' }} </td>
                                        <td>{{ $us->email ?? ''}}</td>
                                        <td> {{ $us->telephone ?? ''}}</td>
                                        <td> {{ $us->fonction->name ?? ''}}</td>
                                        <td class="">
                                            @can('update', $us)
                                            <a href="{{ route('user.edit', ['user'=> $us->id]) }}" title="Modifier l'utilisateur" class="edit action-icon text-primary" data-plugin="tippy" data-tippy-animation="shift-away" data-tippy-inertia="true" data-tippy-duration="[600, 300]" data-tippy-arrow="true"> <i class="mdi mdi-square-edit-outline"></i></a>
                                            @endcan
                                            @can('delete', $us)
                                            <a class="delete supprimer action-icon text-danger" href="{{ route ('user.supprimer',['user' => $us->id])}} " title="Supprimer" data-plugin="tippy" data-tippy-animation="shift-away" data-tippy-inertia="true" data-tippy-duration="[600, 300]" data-tippy-arrow="true"> <i class="mdi mdi-delete"></i></i></a>
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
        @include('user.modals.modals')
        @include('user.modals.permission')

    </div>
@endsection

@push('js_files')
    <script src="{{ asset('assets/js/app/user.js') }}"></script>
@endpush
