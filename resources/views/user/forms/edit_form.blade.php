<div class="form-row">
    <div class="col-sm-12 col-8">
        <label for="name">
            @isset($is_partenaire)
                Nom *
            @else
                Nom & Prénom *
            @endisset
            </label>
        <input type="text" name="name" id="name1" class="form-control @error('name')
            is-invalid
        @enderror" required>
    </div>
</div>

<div class="form-row">
    <div class="col-6">
        <div class="form-group">
            <label for="email">Email *</label>
            <input type="email" id="email1" name="email" class="form-control @error('email')
                is-invalid
                @enderror" required />
        </div>
    </div>
    <div class="col-6">
        <label for="telephone">Téléphone</label>
        <input type="text" name="telephone" id="telephone1" class="form-control @error('telephone')
            is-invalid
        @enderror">
    </div>

</div>
<div class="form-row">
    <div class="col-12">
        <label for="fonction_id">Poste</label>
        <select name="fonction_id" id="fonction_id1" required class="form-control">
            <option value="">Choisir la fonction</option>
            @foreach ($fonctions as $fonction)
                <option value="{{$fonction->id}}" {{ ($fonction->fonction_id) == $fonction->id ? 'selected' : ' '}}>{{$fonction->name}}</option>

            @endforeach
        </select>

    </div>
</div>


<input type="hidden" name="code" id="code1" class="form-control" edi required>
