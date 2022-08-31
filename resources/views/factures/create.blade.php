@extends('layouts.template.app')

@section('title')
{{ $title }}
@endsection

@section('content')
<div class="container-fluid">
    <form action="{{ route('factures.store') }}" method="post" id="formUpdate">
        @csrf
        @include('factures.edit')

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

@endsection
@push('js_files')
    <script src="{{ asset('assets/js/app/document.js') }}"></script>
@endpush
