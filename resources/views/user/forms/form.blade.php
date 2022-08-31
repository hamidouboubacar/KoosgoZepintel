<div class="form-row">
    <div class="col-sm-12 col-8">
        <label for="name">
            @isset($is_partenaire)
                Nom *
            @else
                Nom & Prénom *
            @endisset
            </label>
        <input type="text" value="{{ $user->name ??''}}"  name="name" id="name" class="form-control @error('name')
            is-invalid
        @enderror" required>
    </div>
</div>

<div class="form-row">
    {{-- <div class="col-6">
        <label for="phone">Téléphone</label>
        <input type="text" name="contact" value="{{ $user->contact ??''}}" id="contact" class="form-control @error('contact')
            is-invalid
        @enderror">
    </div> --}}
    <div class="col-6">
        <div class="form-group">
            <label for="email">Email *</label>
            <input type="email" id="email" value="{{ $user->email ??''}}" name="email" class="form-control @error('email')
                is-invalid
                @enderror" required />
                @if($errors->has('email'))
                    <p class="help-block"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                    </p>
            @enderror
        </div>
    </div>    <div class="col-6">
        <div class="form-group">
            <label for="telephone">Téléphone </label>
            <input type="text" id="email" value="{{ $user->telephone ??''}}" name="telephone" placeholder="+226 xx xx xx" class="form-control @error('telephone')
                is-invalid
                @enderror" required />
                @if($errors->has('email'))
                    <p class="help-block"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                    </p>
            @enderror
        </div>
    </div>
</div>


<div class="form-row">
    <div class="col-12">
        <label for="fonction_id">Poste</label>
        <select name="fonction_id" id="fonction_id" required class="form-control">
            <option value="">Choisir la fonction</option>
            @foreach ($fonctions as $fonction)
                <option value="{{$fonction->id}} ">{{$fonction->name}} </option>
            @endforeach
        </select>

    </div>
</div>




