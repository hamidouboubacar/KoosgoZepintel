@extends('layouts.template.app')

@section('title')
{{ $title }}
@endsection

@section('content')
<div class="col-md-12 card card-body">
    <form action="{{ route('articles.store') }}" method="post" id="formid">
        @csrf
        <div class="form-group mt-2">
            <label for="">Groupe<sup class="text-danger">*</sup></label>
            <!-- <input type="text" name="" id="" class="form-control" required> -->
            <select name="" class="form-control" required="" id="">
                <option value="" selected="">---------</option>
                @foreach($groupes as $item)
                    <option value='{{$item->id}}'>{{$item->nom}}</option>
                @endforeach
            </select>
            <div class="invalid-feedback">
                <!-- message d'erreur -->
            </div>
        </div>
        
        <div class="form-group mt-2">
            <label for="">Nature<sup class="text-danger">*</sup></label>
            <select name="" class="form-control" required="" id="">
                <option value="" selected="">---------</option>
                @foreach($natures as $item)
                    <option value='{{$item->id}}'>{{$item->nom}}</option>
                @endforeach
            </select>
            <div class="invalid-feedback">
                <!-- message d'erreur -->
            </div>
        </div>
        
        <div class="form-group mt-2">
            <label for="">Désignation<sup class="text-danger">*</sup></label>
            <input type="text" name="" id="" class="form-control" required>
            <div class="invalid-feedback">
                <!-- message d'erreur -->
            </div>
        </div>
        
        <div class="form-group mt-2">
            <label for="">Caractéristiques<sup class="text-danger">*</sup></label>
            <textarea name="" id="" class="form-control" required></textarea>
            <div class="invalid-feedback">
                <!-- message d'erreur -->
            </div>
        </div>
        
        <div class="form-row mt-2">
            <div class="col">
                <label for="id_datecollecte">Quantité<sup class="f-required">*</sup></label>
                <input type="text" name="" id="" class="form-control" required>
                <div class="invalid-feedback">
                </div>
            </div>

            <div class="col">
                <label for="id_idagentcollecte">Unité</label>
                <select name="" class="form-control" required="" id="">
                    <option value="" selected="">---------</option>
                    @foreach($natures as $item)
                        <option value='{{$item->id}}'>{{$item->nom}}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback">
                </div>
            </div>
            
            <div class="col">
                <label for="id_datecollecte">PUHT<sup class="f-required">*</sup></label>
                <input type="text" name="" id="" class="form-control" required>
                <div class="invalid-feedback">
                </div>
            </div>
        </div>
        
        <div class="form-group mt-2">
            <label for="">Fournisseur<sup class="text-danger">*</sup></label>
            <select name="" class="form-control" required="" id="">
                <option value="" selected="">---------</option>
                @foreach($natures as $item)
                    <option value='{{$item->id}}'>{{$item->nom}}</option>
                @endforeach
            </select>
            <div class="invalid-feedback">
                <!-- message d'erreur -->
            </div>
        </div>
        
        <div class="form-row mt-2">
            <div class="col">
                <label for="id_datecollecte">Prix d'achat HT</label>
                <input type="number" name="" id="" class="form-control" required>
                <div class="invalid-feedback">
                </div>
            </div>

            <div class="col">
                <label for="id_datecollecte">Coef Multiplicateur</label>
                <input type="number" name="" id="" class="form-control" required>
                <div class="invalid-feedback">
                </div>
            </div>
            
            <div class="col">
                <label for="id_datecollecte">Pourcentage de Marge</label>
                <input type="number" name="" id="" class="form-control" required>
                <div class="invalid-feedback">
                </div>
            </div>
            
            <div class="col">
                <label for="id_datecollecte">Marge brute</label>
                <input type="number" name="" id="" class="form-control" required>
                <div class="invalid-feedback">
                </div>
            </div>
            
            <div class="col">
                <label for="id_datecollecte">Prix U. HT</label>
                <input type="number" name="" id="" class="form-control" required>
                <div class="invalid-feedback">
                </div>
            </div>
        </div>
        
        <div class="form-row mt-2">
            <div class="col">
                <label for="id_datecollecte">Quantité Stockée</label>
                <input type="number" name="" id="" class="form-control" required>
                <div class="invalid-feedback">
                </div>
            </div>

            <div class="col">
                <label for="id_datecollecte">Quantité Min.</label>
                <input type="number" name="" id="" class="form-control" required>
                <div class="invalid-feedback">
                </div>
            </div>
        </div>
        
        <div class="mt-2">
            <button type='submit' class="btn btn-success" id="myBtn">Enregistrer</button>
        </div>
    </form>
</div>
@endsection
@push('js_files')
    
@endpush

