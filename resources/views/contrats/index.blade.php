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
                        @can('create', 'App\Models\Contrat')
                        <div class="col-sm">
                            <div class="d-flex justify-content-end my-2">
                                <button id="btn-create" type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#create"><i class="mdi mdi-plus-circle me-1"></i> Ajouter {{$title}}</button>
                            </div>    
                        </div>
                        @endcan
                    </div>

                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap table-striped" id="myTable1">
                            <thead>
                                <tr>
                                    <th>Numéro du contrat</th>
                                    <th>Société</th>
                                    <th>Date Effet</th>
                                    <th>Date Expiration</th>
                                    <th>Etat</th>
                                    <th style="width: 85px;">Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Numéro du contrat</th>
                                    <th>Société</th>
                                    <th>Date Effet</th>
                                    <th>Date Expiration</th>
                                    <th>Etat</th>
                                    <th style="width: 85px;">Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($contrats as $item)
                                    <tr>
                                        <td>{{ $item->num_contrat ?? ''}}</td>
                                        <td>{{ $item->name ?? ''}}</td>
                                        <td>{{ $item->date ?? ''}}</td>
                                        <td>{{ $item->date_expiration ?? '---'}}</td>
                                        <td>{!! $item->getStatExpiration() !!}</td>

                                        <td>
                                            @can('view', $item)
                                            <a href="{{ route('contrats.renouveller', $item) }} " class="action-icon text-dark" title="Renouveller Contrat" data-plugin="tippy" data-tippy-animation="shift-away" data-tippy-inertia="true" data-tippy-duration="[600, 300]" data-tippy-arrow="true"> <i class="mdi mdi-autorenew"></i></a>
                                            @endcan
                                            @can('update', $item)
                                            <a href="{{ route('contrats.edit', $item) }} " class="edit action-icon text-primary" title="Modifier" data-plugin="tippy" data-tippy-animation="shift-away" data-tippy-inertia="true" data-tippy-duration="[600, 300]" data-tippy-arrow="true"> <i class="mdi mdi-square-edit-outline"></i></a>
                                            @endcan
                                            @can('delete', $item)
                                            <a href="{{ route('contrats.destroy', $item)}} " class="delete action-icon text-danger" title="Supprimer" data-plugin="tippy" data-tippy-animation="shift-away" data-tippy-inertia="true" data-tippy-duration="[600, 300]" data-tippy-arrow="true"> <i class="mdi mdi-delete"></i></a>
                                            @endcan
                                            @can('view', $item)
                                            <a href="{{ route('contrats.edit_contrat_content', $item)}} " class="action-icon text-warning" title="Télécharger" data-plugin="tippy" data-tippy-animation="shift-away" data-tippy-inertia="true" data-tippy-duration="[600, 300]" data-tippy-arrow="true"> <i class="mdi mdi-file"></i></a>
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

    @include('contrats.modals.modals')
</div>
@endsection
@push('js_files')
    <!-- Init js -->
    <!-- <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
    <script src="{{ asset('assets/libs/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form-summernote.init.js') }}"></script>
    <script src="{{ asset('assets/libs/quill/quill.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form-quilljs.init.js') }}"></script>
    <script src="{{ asset('assets/js/app/document.js') }}"></script> -->
    <script src="{{ asset('assets/js/app/crud.js') }}"></script>
    <script src="{{ asset('assets/js/app/contrat.js') }}"></script>
    <script>
        console.log("test")
        $('#date').flatpickr();
        $('#contenu').summernote();
    </script>
@endpush

