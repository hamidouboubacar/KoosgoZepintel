@extends('layouts.template.app')

@section('title')
Bon de livraison
@endsection
@section('content')


<div class="container-fluid">
    <form action="{{route('livraison.store')}}" method="post">
        @csrf
        @method("PUT")
        
        <div class="card-box">
            <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">NOUVEAU BORDEREAU DE LIVRAISON</h5>
            
            <input type="hidden" name="type" id="type" value="Facture">
        
            @if(isset($client) && !empty($client))
            <div class="form-row" id="data-bon"  data-bon="{{ App\Models\BonLivraison::all()->count() + 1 }}">
            @else
            <div class="form-row" id="data-bon"  data-bon="{{ App\Models\BonLivraison::all()->count() + 1 }}">
            @endif
                <div class="col">
                    <div class="form-group">
                        <label for="name">N° *</label>
                        <input type="text"  name="numero_bl" id="numero_bl"  class="form-control @error('numero_bl')
                            is-invalid
                        @enderror"  required>
                    </div>
                </div>
                
                <div class="col">
                    <div class="form-group">
                        <label for="email">Ref. Document</label>
                        <input type="text" id="reference" name="reference" class="form-control @error('reference')
                            is-invalid
                        @enderror" value="{{ isset($document->reference) ? $document->reference : old('reference') }}" />
                    </div>
                </div>
                
                <div class="col">
                    <div class="col">
                        
                        <input type="hidden" name="client_id" value="{{ $document->client_id }}" />
                        <input type="hidden" name="document_id" value="{{ $document->id }}" />
                        <input type="hidden" name="client_name" id="client_name" value="{{ $document->client->name }}" />
                            <div class="form-row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="client_id">Client</label>
                                        <select name="client_id" class="form-control @error('client_id')
                                            is-invalid
                                        @enderror" @if(isset($document->client_id)) disabled @endif required id="">
                                            @foreach($clients as $cl)
                                                <option  value='{{$cl->id}}'
                                                @if(isset($document->client_id) && $document->client_id == $cl->id) 
                                                    selected 
                                                @endif>{{$cl->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                
                                </div>
                </div>
                
            </div>
            
            @if(isset($client) && $client != null)
                <input type="hidden" name="client_id" value="{{ $client->id }}" />
            @else
            <input type="hidden" name="client_id" value="{{ $document->client_id }}" />
            <input type="hidden" name="client_name" id="client_name" value="{{ $document->client->name }}" />
                <div class="form-row">
                    <div class="col">
                        <div class="form-group">
                            <label for="client_id">Client</label>
                            <select name="client_id" class="form-control @error('client_id')
                                is-invalid
                            @enderror" @if(isset($document->client_id)) disabled @endif required id="">
                                <option class="input-reset" value="" selected="">---------</option>
                                @foreach($clients as $cl)
                                    <option  value='{{$cl->id}}'
                                    @if(isset($document->client_id) && $document->client_id == $cl->id) 
                                        selected 
                                    @endif>{{$cl->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            @endif
            
            <div class="form-row">
                <div class="col">
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" id="date" name="date" class="input-reset form-control @error('date')
                                is-invalid
                            @enderror flatpickr-input" value="{{ isset($document->date) ? $document->date : old('date') }}"/>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="objet">Objet</label>
                        <input type="text" id="objet" name="objet" class="input-reset form-control" value="{{ $document->objet}} "/>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card-box">
            <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">Packages</h5>
        
            <div class="form-row">
                <div class="col">
                    @include('document.forms.packages')
                </div>
            </div>
        </div>        

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
    <script src="{{ asset('assets/js/app/livraison.js') }}"></script>
@endpush
