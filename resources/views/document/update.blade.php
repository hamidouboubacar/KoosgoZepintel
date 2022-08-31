@extends('layouts.template.app')

@section('title')
Modifier {{ $item->type }}
@endsection
@section('content')


<div class="container-fluid">
    <form action="{{ route('document.update', $item) }}" method="post">
        @csrf
        @method("PUT")
        
        <div class="row">
            <div class="col-12">
                <div class="mb-3">
                    @if($item->type == 'Facture')
                        <a href="{{ route('document.create', ['type' => 'FactureAvoir', 'redirect' => isset($redirect) ? $redirect : route('document.index'), 'parent_id' => $item->id]) }}" class="btn w-sm btn-dark waves-effect waves-light">Créer une facture d'avoir</a>
                    @endif
                </div>
            </div> <!-- end col -->
        </div>
        
        @if($item->type == "FactureAvoir" && isset($parent) && $parent != null)
            <div class="card-box">
                <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">
                    Facture parente
                    <a href="{{ route('document.edit', ['document' => $parent, 'type' => 'Facture', 'redirect' => url()->current()]) }} " target="_blank" class="action-icon text-primary"> <i class="mdi mdi-square-edit-outline"></i></a>
                </h5>
                <div class="form-row">
                
                    <div class="col">
                        <div class="form-group">
                            <label for="name">N° *</label>
                            <input type="text" class="form-control" value="{{ isset($parent->numero) ? $parent->numero : '' }}" disabled>
                        </div>
                    </div>
                    
                    <div class="col">
                        <div class="form-group">
                            <label>Ref. Document</label>
                            <input type="text" class="form-control" value="{{ isset($parent->reference) ? $parent->reference : '' }}" disabled/>
                        </div>
                    </div>
                    
                    <div class="col">
                        <div class="form-group">
                            <label>Objet</label>
                            <input type="text" class="form-control" value="{{ isset($parent->objet) ? $parent->objet : '' }}" disabled/>
                        </div>
                    </div>
                    
                </div>
            </div>
        @endif
        
        @include('document.edit')

        <div class="row">
            <div class="col-12">
                <div class="mb-3">
                    <button type="submit" class="btn w-sm btn-success waves-effect waves-light">Enregistrer</button>
                    @if($item->type == 'Facture')
                        <a href="{{ route('document.create', ['type' => 'FactureAvoir', 'redirect' => isset($redirect) ? $redirect : route('document.index'), 'parent_id' => $item->id]) }}" class="btn w-sm btn-dark waves-effect waves-light">Créer une facture d'avoir</a>
                    @endif
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
