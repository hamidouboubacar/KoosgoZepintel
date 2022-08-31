<div class="form-row">
    <div class="col-sm-12 col-8">
        <label for="name">Nom & Prénom *</label>
        <input type="text" name="name" id="name1" class="form-control input-reset @error('name')
            is-invalid
        @enderror" value="{{ isset($item->name) ? $item->name : old('name') }}" required>
    </div>
</div>

<div class="form-row mt-2">
    <div class="col-6">
        <div class="form-group">
            <label for="email">Email *</label>
            <input type="email" id="email1" name="email" class="form-control input-reset @error('email')
                is-invalid
                @enderror" value="{{ isset($item->email) ? $item->email : old('email') }}" required />
        </div>
    </div>
    <div class="col-6">
        <label for="telephone">Téléphone</label>
        <input type="text" name="telephone" id="telephone1" class="form-control input-reset @error('telephone')
            is-invalid
        @enderror" value="{{ isset($item->telephone) ? $item->telephone : old('telephone') }}">
    </div>

</div>


@if(isset($type_create) && $type_create)
<input hidden name="fonction_id" value="{{ $fonction->id ?? 0 }}">

<div class="form-row mt-2">
    <div class="col-sm-12 col-8">
        <label for="name">Mot de passe</label>
        <input type="password" name="password" id="password" class="form-control input-reset @error('password')
            is-invalid
        @enderror" value="{{ isset($item->password) ? $item->password : old('password') }}" required>
    </div>
</div>
@endif

<!-- <div class="form-row mt-2">
    <div class="col-sm-12 col-8">
        <label for="name">Adresse</label>
        <input type="text" name="name" id="name1" class="form-control @error('name')
            is-invalid
        @enderror" required>
    </div>
</div> -->