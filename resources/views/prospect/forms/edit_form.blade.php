<div class="form-row">
    <div class="col-6">
        <div class="form-group">
            <label for="name">Société/Nom *</label>
            <input type="text"  name="name" id="name1" class="form-control" required>
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email1" name="email" class="form-control"/>
        </div>
    </div>
</div>
<div class="form-row">
    <div class="col-6">
        <label for="ifu">Ifu</label>
        <input type="text" name="ifu" id="ifu1" class="form-control">
    </div>
<div class="col-6">
    <label for="rccm">Rccm</label>
    <input type="text" name="rccm" id="rccm1" class="form-control">
</div>
</div>

<div class="form-row">
    <div class="col-6">
        <div class="form-group">
            <label for="telephone">Téléphone </label>
            <input type="text" id="telephone1" name="telephone" placeholder="+226 xx xx xx" class="form-control" />
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label for="adresse">Adresse </label>
            <input type="text" id="adresse1" name="adresse" class="form-control" />
        </div>
    </div>
</div>

<div class="form-row">
    <div class="col-6">
        <div class="form-group">
            <label for="pays">Pays </label>
            <select class="form-control" name="pays" id="pays1">
                <option value="" disabled >Pays</option>
                <option value="Burkina Faso" selected>Burkina Faso </option>
            </select>
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label for="ville">Ville </label>
            <select class="form-control" name="ville"  placeholder="" id="ville1" >
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
            <input type="text" id="numero_paiement1" name="numero_paiement" placeholder="+226 xx xx xx" class="form-control" />
        </div>
    </div>
</div>

<input type="hidden" name="user_id" value="{{ $user_id }}" id="user_id1" class="form-control" edi required>
