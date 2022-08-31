<div class="card-box">
    <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">Références</h5>

    <div class="form-row">
        <div class="col">
            <div class="form-group">
                <label for="name">N° Facture*</label>
                <input type="text"  name="numero" id="numero" class="form-control @error('numero')
                    is-invalid
                @enderror" value="{{ isset($item->numero) ? $item->numero : old('numero') }}" required>
            </div>
        </div>
        
        <div class="col">
            <div class="form-group">
                <label for="email">Ref. Facture</label>
                <input type="text" id="reference" name="reference" class="form-control @error('reference')
                    is-invalid
                @enderror" value="{{ isset($item->reference) ? $item->reference : old('reference') }}"/>
            </div>
        </div>
        
        <div class="col">
            <div class="form-group">
                <label for="type">Type</label>
                <select name="type" class="form-control @error('type')
                    is-invalid
                @enderror" required id="">
                    <option class="input-reset" value="" selected="">---------</option>
                    @foreach($facture_types as $ft)
                        <option value='{{$ft->id}}'
                        @if(isset($item->type) && $item->type == $ft->id) 
                            selected 
                        @endif>{{$ft->nom}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    
    <div class="form-row">
        <div class="col">
            <div class="form-group">
                <label for="client_id">Client</label>
                <select name="client_id" class="form-control @error('client_id')
                    is-invalid
                @enderror" required id="">
                    <option class="input-reset" value="" selected="">---------</option>
                    @foreach($clients as $client)
                        <option value='{{$client->id}}'
                        @if(isset($item->client_id) && $item->client_id == $client->id) 
                            selected 
                        @endif>{{$client->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    
    <div class="form-row">
        <div class="col">
                <div class="form-group">
                    <label for="date">Date</label>
                    <input type="date" id="date" name="date" class="input-reset form-control @error('date')
                        is-invalid
                    @enderror flatpickr-input" value="{{ isset($item->date) ? $item->date : old('date') }}"/>
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label for="date">Période</label>
                <input type="date" id="periode" name="periode" class="input-reset form-control @error('periode')
                    is-invalid
                @enderror flatpickr-input" value="{{ isset($item->periode) ? $item->periode : old('periode') }}"/>
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

<div class="card-box">
    <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">Montants</h5>

    <div class="form-row mt-3 ml-1">
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="tva-checkbox" name="tva-checkbox"
            @if(isset($item->tva)) checked @endif>
            <label class="form-check-label" for="">Avec TVA (18%)</label>
        </div>
    </div>
    
    <div class="form-row mt-3">
        <div class="col-4">
            <div class="form-group">
                <label for="montantht">Total HT</label>
                <input type="text" name="montantht" id="montantht" class="form-control @error('montantht')
                    is-invalid
                @enderror" value="{{ isset($item->montantht) ? $item->montantht : old('montantht') }}">
                @if ($errors->has('montantht'))
                    <span class="invalid feedback"role="alert">
                        <strong>{{ $errors->first('montantht') }}.</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="col-4">
            <div class="form-group">
                <label for="tva">TVA</label>
                <input type="text" id="tva" name="tva" class="form-control" value="{{ isset($item->tva) ? $item->tva : old('tva') }}"/>
            </div>
        </div>
        <div class="col-4">
            <div class="form-group">
                <label for="montantttc">Total TTC</label>
                <input type="text" id="montantttc" name="montantttc" class="form-control @error('montantttc')
                    is-invalid
                @enderror" value="{{ isset($item->montantttc) ? $item->montantttc : old('montantttc') }}"/>
                @if ($errors->has('montantttc'))
                    <span class="invalid feedback"role="alert">
                        <strong>{{ $errors->first('montantttc') }}.</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>
</div>