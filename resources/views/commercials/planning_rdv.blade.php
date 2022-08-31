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
                            <div class="d-flex justify-content-end my-2">
                                <button id="btn-create" type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#create"><i class="mdi mdi-plus-circle me-1"></i> Ajouter {{$title}}</button>
                            </div>    
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="myTable1" class="table table-centered table-nowrap table-striped">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Commerciale</th>
                                    <th>Client</th>
                                    <th style="width: 85px;">Actions</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Date</th>
                                    <th>Commerciale</th>
                                    <th>Client</th>
                                    <th style="width: 85px;">Actions</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($plannings as $item)
                                    <tr>
                                        <td>{{ $item->date ?? ''}}</td>
                                        <td>{{ $item->name ?? '---'}}</td>
                                        <td>{{ $item->name1 ?? '---'}}</td>

                                        <td class="">
                                            <a href="{{ route('planning_rdvs.edit', $item->id) }} " class="edit action-icon text-primary" title="Modifier" data-plugin="tippy" data-tippy-animation="shift-away" data-tippy-inertia="true" data-tippy-duration="[600, 300]" data-tippy-arrow="true"> <i class="mdi mdi-square-edit-outline"></i></a>
                                            <a href="{{ route ('planning_rdvs.destroy', $item->id)}} " class="delete action-icon text-danger" title="Supprimer" data-plugin="tippy" data-tippy-animation="shift-away" data-tippy-inertia="true" data-tippy-duration="[600, 300]" data-tippy-arrow="true"> <i class="mdi mdi-delete"></i></a>                
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

    @include('commercials.modals.modal_planning_rdv')
</div>
@endsection
@push('js_files')
    <script src="{{ asset('assets/js/app/crud.js') }}"></script>
    <script>
        $('#date').flatpickr();
    </script>
@endpush

