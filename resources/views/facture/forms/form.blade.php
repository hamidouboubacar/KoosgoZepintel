<div class="form-row">
    <div class="col-6">
        <div class="form-group">
            <label for="name">N° Devis*</label>
            <input type="text"  name="numero_document" id="numero_document" class="form-control" required>
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label for="email">Date</label>
            <input type="email" id="email" name="email" class="form-control"/>
            <input type="hidden" name="type" value="Client" id="type" class="form-control code">
        </div>
    </div>
</div>
<div class="form-row">
    <div class="col-6">
        <label for="ifu">Periode</label>
        <input type="text" name="ifu" id="ifu" class="form-control">
    </div>
<div class="col-6">
    <label for="rccm">Objet</label>
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
            <textarea name="" id="" cols="30" rows="10"></textarea>
        </div>
    </div>
</div>

<div class="form-row">
    <div class="col-6">
        <div class="form-group">
            <label for="pays">Pays </label>
            <select class="form-control" name="pays" id="pays">
                <option value="" disabled >Pays</option>
                <option value="Burkina Faso" selected>Burkina Faso </option>
            </select>
        </div>
    </div>
    <div class="col-6">
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
