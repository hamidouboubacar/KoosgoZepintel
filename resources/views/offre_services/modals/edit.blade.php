<div class="form-group mt-2">
    <label for="nomfonction">Numéro de l'offre <sup class="text-danger">*</sup></label>
    @if(isset($numero_offre))
        <input type="text" name="numero_offre" id="numero_offre" readonly class="form-control @error('numero_offre')
            is-invalid
        @enderror" value="{{ isset($numero_offre) ? $numero_offre : old('numero_offre') }}" required>
    @else
        <input type="text" name="numero_offre" id="numero_offre" readonly class="input-reset form-control @error('numero_offre')
            is-invalid
        @enderror" value="{{ isset($item->numero_offre) ? $item->numero_offre : old('numero_offre') }}" required>
    @endif
</div>

<div class="form-row">
    <div class="col">
        <label for="nomfonction">Objet <sup class="text-danger">*</sup></label>
        <input type="text" name="objet" id="objet" class="input-reset form-control @error('objet')
            is-invalid
        @enderror" value="{{ isset($item->objet) ? $item->objet : old('objet') }}" required>
    </div>

    <div class="col">
        <label for="">Client / Prospect</label>
        <select name="client_id" class="form-control select2 @error('nom')
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

<div class="form-row mt-2">
    <div class="col">
        <label for="contenu">Contenu</label>
        <textarea name="contenu" id="contenu" class="input-reset contenu form-control @error('contenu')
            is-invalid
        @enderror" required>{{ isset($item->contenu) ? $item->contenu : old('contenu') }}</textarea>
    </div>
</div>