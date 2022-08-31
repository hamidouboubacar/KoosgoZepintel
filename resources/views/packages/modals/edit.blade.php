<div class="form-group mt-2">
    <label for="nomfonction">Nom <sup class="text-danger">*</sup></label>
    <input type="text" name="nom"  id="nom" required class="input-reset form-control @error('nom')
        is-invalid
    @enderror" value="{{ isset($item->nom) ? $item->nom : old('nom') }}">
</div>

<div class="form-row mt-2">
    <div class="col">
        <label for="nomfonction">Débit Ascendant (Mbps) <sup class="text-danger">*</sup></label>
        <input type="number" name="debit_ascendant"  id="debit_ascendant" required class="input-reset form-control @error('debit')
            is-invalid
        @enderror" value="{{ isset($item->debit_ascendant) ? $item->debit_ascendant : old('debit_ascendant') }}">
    </div>
    
    <div class="col">
        <label for="nomfonction">Débit Descendant (Mbps)</label>
        <input type="number" name="debit_descendant"  id="debit_descendant" class="input-reset form-control @error('debit')
            is-invalid
        @enderror" value="{{ isset($item->debit_descendant) ? $item->debit_descendant : old('debit_descendant') }}">
    </div>
</div>

<div class="form-group mt-2">
    <label for="nomfonction">Montant (FCFA) <sup class="text-danger">*</sup></label>
    <input type="number" name="montant"  id="montant" required class="input-reset form-control @error('montant')
        is-invalid
    @enderror" value="{{ isset($item->montant) ? $item->montant : old('montant') }}">
</div>