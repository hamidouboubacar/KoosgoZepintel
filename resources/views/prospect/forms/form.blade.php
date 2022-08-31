<div class="form-row">
    <div class="col-6">
        <div class="form-group">
            <label for="name">Société/Nom *</label>
            <input type="text"  name="name" id="name" class="form-control" required>
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" class="form-control"/>
            <input type="hidden" name="type" value="Prospect" id="type" class="form-control code">
        </div>
    </div>
</div>

<div class="form-row">
    <div class="col-6">
        <label for="ifu">IFU</label>
        <input type="text" name="ifu" id="ifu" class="form-control">
    </div>
<div class="col-6">
    <label for="rccm">RCCM</label>
    <input type="text" name="rccm" id="rccm" class="form-control">
</div>
</div>

<div class="form-row">
    <div class="col-6">
        <div class="form-group">
            <label for="telephone">Téléphone </label>
            <input type="text" id="telephone" name="telephone" placeholder="+226 xx xx xx" class="form-control" />
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label for="adresse">Adresse </label>
            <input type="text" id="adresse" name="adresse" class="form-control" />
        </div>
    </div>
</div>

<div class="form-row">
    <div class="col-6">
        <div class="form-group">
            <label for="telephone">Longitude </label>
            <input type="text" id="longitude" name="longitude" class="form-control" />
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label for="adresse">Latitude </label>
            <input type="text" id="latitude" name="latitude" class="form-control" />
        </div>
    </div>
</div>

<div class="form-row">
    <div class="col-2">
        <div class="form-group">
            <label for="recurrence">Client  récurrent</label>
            <input type="checkbox" id="recurrence" name="recurrence" class="form-control" />
        </div>
    </div>
    <div class="col-10">
        <div class="form-group">
            <label for="pays">Pays </label>
            <select class="form-control" name="pays" id="pays">
                <option value="" disabled >Pays</option>
                <option value="Burkina Faso" selected>Burkina Faso </option>
            </select>
        </div>
    </div>
</div>

<div class="form-row">    
    <div class="col-12">
        <div class="form-group">
            <label for="ville">Ville </label>
            <select class="form-control" name="ville"  placeholder="" id="ville" >
                <option value="Ouagadougou" selected>Ouagadougou</option>
                <option value="Bobo dioulasso">Bobo dioulasso</option>
                <option value="Koudougou">Koudougou</option>
                <option value="Dedougou">Dedougou</option>
                <option value="Kaya">Kaya</option>
                <option value="Tenkodogo">Tenkodogo</option>
                <option value="Ouahigouya">Ouahigouya</option>
                <option value="Manga">Manga</option>
                <option value="Gaoua">Gaoua</option>
                <option value="Banfora">Banfora</option>
                <option value="Fada N'Gourma">Fada N'Gourma</option>
                <option value="Ziniaré">Ziniaré</option>
                <option value="Dori">Dori</option>
            </select>
        </div>
    </div>
</div>

<div class="form-row">
    <div class="col">
        <div class="form-group">
            <label for="telephone">Numéro de paiement </label>
            <input type="text" id="numero_paiement" name="numero_paiement" placeholder="+226 xx xx xx" class="form-control" />
        </div>
    </div>
</div>

<input type="hidden" name="user_id" value="{{ isset($user_id) ? $user_id : '' }}" id="user_id" class="form-control" edi>
