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
                                <a href="{{ route('document.create', ['type' => 'FactureAvoir', 'redirect' => url()->current()]) }}" id="btn-create" type="button" class="btn btn-primary waves-effect waves-light"><i class="mdi mdi-plus-circle me-1"></i> Ajouter {{$title}}</a>
                            </div>    
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="dataTable" class="table table-centered table-nowrap table-striped">
                            <thead>
                                <tr>
                                    <th>Reference</th>
                                    <th>Date</th>
                                    <th>Client</th>
                                    <th>TVA</th>
                                    <th>Montant TTC</th>
                                    <th>Montant HT</th>
                                    <th style="width: 85px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($factures as $item)
                                    <tr>
                                        <td>{{ $item->numero ?? '---' }}</td>
                                        <td>{{ $item->date ?? '---' }}</td>
                                        <td>{{ $item->client->name ?? '---' }}</td>
                                        <td>{{ $item->tva ?? '---'}}</td>
                                        <td>{{ $item->montantttc ?? '---' }}</td>
                                        <td>{{ $item->montantht ?? '---' }}</td>

                                        <td class="">
                                            <a href="{{ route('document.edit', ['document' => $item, 'type' => 'FactureAvoir', 'redirect' => url()->current()]) }} " class="action-icon text-primary" title="Modifier" data-plugin="tippy" data-tippy-animation="shift-away" data-tippy-inertia="true" data-tippy-duration="[600, 300]" data-tippy-arrow="true"> <i class="mdi mdi-square-edit-outline"></i></a>
                                            <a href="{{ route ('document.destroy', $item)}} " class="delete action-icon text-danger" title="Supprimer" data-plugin="tippy" data-tippy-animation="shift-away" data-tippy-inertia="true" data-tippy-duration="[600, 300]" data-tippy-arrow="true"> <i class="mdi mdi-delete"></i></a> 
                                            <a href="{{ route('exportDevis', ['document'=>$item->id, 'sans_signature' => 1]) }}" type="button" target="_blank" class="action-icon text-warning" title="Imprimer"> <i class="mdi mdi-file"></i></a>               
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

