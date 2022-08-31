<div class="modal fade" id="sendMailRefacturations" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">E-mail groupés</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('sendMailGroupe') }}">
                    @csrf
                    @method("PUT")
                    <div class="form-row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="email">Objet</label>
                                <input type="text" id="objet" name="objet" class="form-control"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-row mt-2">
                        <div class="col">
                            <label for="contenu">Message</label>
                            <textarea name="contenu" id="contenu" class="input-reset contenu form-control @error('contenu')
                                is-invalid
                            @enderror">{{ isset($item->contenu) ? $item->contenu : old('contenu') }}</textarea>
                        </div>
                    </div>

                    <input type="hidden" id="refacturation_id" name="refacturation_id">

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary">Envoyer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>