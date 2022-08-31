<div class="form-row mt-2">
    <div class="col">
        <div class="form-group">
            <label for="email">Date *</label>
            <input type="text" id="date" name="date" class="form-control input-reset @error('date')
                is-invalid
                @enderror" value="{{ isset($item->date) ? $item->date : old('date') }}" required />
        </div>
    </div>
    
    @if(isset($est_commercial) && $est_commercial)
    <input type="hidden" name="commercial_id" value="{{ $user->id }}">
    @else
    <div class="col">
        <label for="telephone">Commercial</label>
        <select name="commercial_id" class="form-control select2 input-reset @error('commercial_id')
        is-invalid
        @enderror" required id="">
            <option class="input-reset" value="" selected="">---------</option>
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
        <label for="name">Tâche</label>
        <textarea name="tache" id="tache" class="form-control input-reset @error('tache')
            is-invalid
        @enderror" required>{{ isset($item->tache) ? $item->tache : old('tache') }}</textarea>
    </div>
</div>

<div class="form-row mt-2">
    <div class="col-sm-12 col-8">
        <label for="name">Résultat attendu</label>
        <textarea name="resultat_attendu" id="resultat_attendu" class="form-control input-reset @error('resultat_attendu')
            is-invalid
        @enderror" required>{{ isset($item->resultat_attendu) ? $item->resultat_attendu : old('resultat_attendu') }}</textarea>
    </div>
</div>