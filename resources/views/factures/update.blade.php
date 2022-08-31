@extends('layouts.template.app')

@section('title')
{{ $title }}
@endsection

@section('content')
<div class="container-fluid">
    <form action="{{ route('factures.update', $item) }}" method="post" id="formUpdate">
        @csrf
        @method("PUT")
                    
        @if($item == "FactureAvoir")
            <div class="card-box">
                <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">Facture parente</h5>
            </div>
        @endif
        
        @include('factures.edit')

        <div class="row">
            <div class="col-12">
                <div class="text-center mb-3">
                    <a href="{{ route('factures.index') }}" type="button" class="btn w-sm btn-light waves-effect">Annuler</a>
                    <button type="submit" class="btn w-sm btn-success waves-effect waves-light">Enregistrer</button>
                </div>
            </div> <!-- end col -->
        </div>
    </form>
</div>

@endsection
@push('js_files')
    <script src="{{ asset('assets/js/app/document.js') }}"></script>
@endpush
