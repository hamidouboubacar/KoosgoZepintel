<div class="form-row mt-2">
    <div class="col">
        <div class="form-group">
            <label for="email">Date *</label>
            <input type="text" id="date" name="date" class="input-reset form-control @error('date')
                is-invalid
                @enderror" value="{{ isset($item->date) ? $item->date : old('date') }}" required />
        </div>
    </div>
    @if(isset($est_commercial) && $est_commercial)
    <input type="hidden" name="commercial_id" value="{{ $user->id }}">
    @else
    <div class="col">
        <label for="telephone">Commercial</label>
        <select name="commercial_id" class="input-reset select2 form-control @error('commercial_id')
        is-invalid
        @enderror" required id="">
            <option value="" selected="">---------</option>
            @foreach($commercials as $commercial)
                <option value='{{$commercial->id}}'
                @if(isset($item->commercial_id) && $item->commercial_id == $commercial->id) 
                    selected 
                @endif>{{$commercial->name}}</option>
            @endforeach
        </select>
    </div>
    @endif

</div>

<div class="form-row mt-2">
    <div class="col-sm-12 col-8">
        <label for="name">Client</label>
        <select id="client_id" name="client_id" class="input-reset select2 form-control @error('client_id')
        is-invalid
        @enderror" required id="">
            <option value="" selected="">---------</option>
            @foreach($clients as $client)
                <option value='{{$client->id}}'
                @if(isset($item->client_id) && $item->client_id == $client->id) 
                    selected 
                @endif>{{$client->name}} ({{$client->type}})</option>
            @endforeach
        </select>
    </div>
</div>