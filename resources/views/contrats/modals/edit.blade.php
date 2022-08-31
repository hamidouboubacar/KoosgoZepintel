<div class="form-row">
    <div class="col">
        <label for="">Société/Nom</label>
        <select name="client_id" class="form-control select2 @error('client_id')
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
    <div class="col">
        <label for="">Numéro du contrat</label>
        <input type="text" name="num_contrat"  id="num_contrat" class="form-control @error('num_contrat')
            is-invalid
        @enderror" value="{{ $num_contrat }}">
        @if ($errors->has('num_contrat'))
            <span class="invalid feedback"role="alert">
                <strong>{{ $errors->first('num_contrat') }}.</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group mt-3">
    <!-- <h5>Packages</h5> -->
    <label for="">Package</label> <br>
    @foreach($packages as $package)
        <div class="form-check form-check-inline">
            <input class="input-reset form-check-input" type="checkbox" id="package_{{ $package->id }}" name="package_{{ $package->id }}" value="{{ $package->id }}" 
            @if(isset($contrat_packages) && in_array($package->id, $contrat_packages)) checked @endif>
            <label class="form-check-label" for="">{{ $package->nom }}</label>
        </div>
    @endforeach
</div>

<div class="form-group">
    <label for="">Date d'effet</label>
    <input type="text" name="date"  id="date" required class="input-reset form-control flatpickr-input @error('date')
        is-invalid
    @enderror" value="{{ isset($item->date) ? $item->date : old('date') }}">
</div>
