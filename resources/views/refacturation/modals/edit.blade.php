
<div class="modal fade" id="createRefacturation" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Refacturation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('refacturation.store') }}" method="post" id="create-user-form">
                    @csrf
                    <div class="form-row">
                        <div class="col-sm-12 col-12">
                            <label for="clients">Clients *
                                </label>
                                <div class="checkbox checkbox-primary mb-2">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" onclick="tousClients()" type="checkbox" id="myCheck" name="tva-checkbox">
                                        <label class="form-check-label" for="">Tous les clients</label>
                                    </div>
                                    <div style="display: none" id="displayDiv"><Strong><h3>Tous les clients ont ete sélectionnés</h3></Strong></div>
                                </div>
                                <div style="display" id="select_id">
                                <select selected class="orm-control select2" name="clients[]" placeholder="" multiple id="clients" required>
                                    <option>Choisir les clients</option>
                                     @foreach($documents as $document)
                                        @if ($document)
                                            @if ($document->client->type == 'Client' || $document->client->type == 'Prospect' )
                                                <option value='{{$document->client_id}}' class="option">{{$document->client->name}}</option>
                                            @endif
                                        @endif
                                     @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="date">Date</label>
                                <input type="date" id="date" name="date" class="input-reset form-control @error('date')
                                is-invalid
                            @enderror flatpickr-input" value="{{ isset($item->date) ? $item->date : old('date') }}"/>
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="periode">Période</label>
                            <select name="periode" class="form-control" placeholder="" id="periode" required>
                                <option></option>
                                
                                <option @if(isset($item->periode) && $item->periode == "1") 
                                    selected 
                                @endif value="1">
                                    Janvier
                                </option>
                                
                                <option @if(isset($item->periode) && $item->periode == "2") 
                                    selected 
                                @endif value="2">
                                Février 
                                </option>
                                
                                <option @if(isset($item->periode) && $item->periode == "3") 
                                    selected 
                                @endif value="3">
                                    Mars
                                </option>
                                
                                <option @if(isset($item->periode) && $item->periode == "4") 
                                    selected 
                                @endif value="4">
                                    Avril
                                </option>
                                
                                <option @if(isset($item->periode) && $item->periode == "5") 
                                    selected 
                                @endif value="5">
                                    Mai
                                </option>
                                
                                <option @if(isset($item->periode) && $item->periode == "6") 
                                    selected 
                                @endif value="6">
                                    Juin
                                </option>
                                
                                <option @if(isset($item->periode) && $item->periode == "7") 
                                    selected 
                                @endif value="7">
                                    Juillet
                                </option>
                                
                                <option @if(isset($item->periode) && $item->periode == "8") 
                                    selected 
                                @endif value="8">
                                    Août
                                </option>
                                
                                <option @if(isset($item->periode) && $item->periode == "9") 
                                    selected 
                                @endif value="9">
                                Septembre
                                </option>
                                
                                <option @if(isset($item->periode) && $item->periode == "10") 
                                    selected 
                                @endif value="10">
                                   Octobre
                                </option>
                                
                                <option @if(isset($item->periode) && $item->periode == "11") 
                                    selected 
                                @endif value="11">
                                    Novembre
                                </option>
                                
                                <option @if(isset($item->periode) && $item->periode == "12") 
                                    selected 
                                @endif value="12">
                                    Décembre
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
