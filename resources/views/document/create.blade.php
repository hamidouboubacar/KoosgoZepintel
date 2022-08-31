@extends('layouts.template.app')

@section('title')
Nouveau {{ $document_type }}
@endsection
@section('content')


<div class="container-fluid">
    <form action="{{ route('document.store') }}" method="post">
        @csrf
        @include('document.edit')

        <div class="row">
            <div class="col-12">
                <div class="mb-3">
                    <button type="submit" class="btn w-sm btn-success waves-effect waves-light">Enregistrer</button>
                    <a onclick="window.history.back()" href="#" type="button" class="btn w-sm btn-light waves-effect">Annuler</a>
                </div>
            </div> <!-- end col -->
        </div>
    </form>
</div>

@include('client.modals.modals')
@include('packages.modals.modals')

@endsection

@push('js_files')
    <script>
        $('#summernote-basic').summernote();
    </script>
    <script src="{{ asset('assets/js/app/document.js') }}"></script>
    <script src="{{ asset('assets/js/app/client.js') }}"></script>
    <script src="{{ asset('assets/js/app/crud.js') }}"></script>
@endpush
