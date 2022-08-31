<div class="card-box">
    <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">Références</h5>
    
    <input hidden id="client-add-url" value="{{ route('client.add') }}">
    <input hidden id="package-add-url" value="{{ route('packages.add') }}">
    
    @if(isset($parent_id))
        <input type="hidden" name="parent_id" id="parent_id" value="{{ $parent_id }}">
        <input type="hidden" name="type" id="type" value="{{ isset($document_type) ? $document_type : 'FactureAvoir' }}">
    @elseif(isset($item->parent_id))
        <input type="hidden" name="parent_id" id="parent_id" value="{{ isset($item->parent_id) ? $item->parent_id : null }}">
        <input type="hidden" name="type" id="type" value="{{ isset($item->type) ? $item->type : $document_type }}">
    @else
        @if(isset($document_type) && $document_type == "FactureAvoir")
            <div class="form-row">
                <div class="col">
                    <div class="form-group">
                        <label for="parent_id">Facture parente</label>
                        <select name="parent_id" class="form-control select2 @error('parent_id')
                            is-invalid
                        @enderror" required id="">
                            <option class="input-reset" value="" selected="">---------</option>
                            @foreach($factures as $cl)
                                <option value='{{$cl->id}}'>{{$cl->reference}} - {{$cl->objet}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <input type="hidden" name="type" id="type" value="{{ isset($item->type) ? $item->type : $document_type }}">
        @else
            <input type="hidden" name="type" id="type" value="{{ isset($item->type) ? $item->type : $document_type }}">
        @endif
    @endif
    <input type="hidden" name="redirect" id="redirect" value="{{ isset($redirect) ? $redirect : route('document.index') }}">

    @if(isset($client) && !empty($client))
    <div class="form-row" id="data-devis" data-devis="{{ App\Models\Document::where('type', 'Devis')->count() + 1 }}"
    data-client-devis="{{ App\Models\Document::where('type', 'Devis')->where('client_id', $client->id)->count() + 1 }}">
    @else
    <div class="form-row" id="data-devis">
    @endif
        <div class="col">
            <div class="form-group">
                <label for="name">N° *</label>
                @if(isset($parent_id) && isset($code))
                    <input type="text"  name="numero" id="numero" class="form-control @error('numero')
                        is-invalid
                    @enderror" value="{{ $code }}" required>
                @else
                    <input type="text"  name="numero" id="numero" class="form-control @error('numero')
                        is-invalid
                    @enderror" value="{{ isset($item->numero) ? $item->numero : $code }}" required>
                @endif
                @if($errors->has('numero'))
                    <div class="error">{{ $errors->first('numero') }}</div>
                @endif
            </div>
        </div>
        
        <div class="col">
            <div class="form-group">
                <label for="email">Ref. Document</label>
                <input type="text" id="reference" name="reference" class="form-control @error('reference')
                    is-invalid
                @enderror" value="{{ isset($item->reference) ? $item->reference : old('reference') }}" />
            </div>
        </div>
        
        <div class="col">
            <div class="form-group">
                <label for="email">Objet</label>
                <input type="text" id="objet" name="objet" class="form-control @error('objet')
                    is-invalid
                @enderror" value="{{ isset($item->objet) ? $item->objet : old('objet') }}"/>
            </div>
        </div>
        
    </div>
    
    @if(isset($client) && $client != null)
        <input type="hidden" name="client_id" value="{{ $client->id }}" />
    @else 
        
        <div class="form-row">
            <div class="col">
                <div class="form-group">
                    <div class="d-flex justify-content-end mt-3">
                        <a href="#" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#createUser"><i class="mdi mdi-plus-circle me-1"></i> Ajouter Client</a>
                    </div>  
                    
                    <label for="client_id">Client</label>
                    <select id="client_id" name="client_id" class="form-control select2 @error('client_id')
                        is-invalid
                    @enderror" @if(isset($item->client_id)) disabled @endif required id="">
                        <option id="option-client-vide" class="input-reset" value="" selected="">---------</option>
                        @foreach($clients as $cl)
                            <option value='{{$cl->id}}'
                            @if(isset($item->client_id) && $item->client_id == $cl->id) 
                                selected 
                            @endif>{{$cl->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    @endif
    
    <div class="form-row">
        <div class="col">
            <div class="form-group">
                <label for="date">Date</label>
                <input type="date" id="date" name="date" class="input-reset form-control @error('date')
                    is-invalid
                @enderror flatpickr-input" value="{{ isset($item->date) ? $item->date : old('date') }}"/>
        </div>
    </div>
        @if((isset($document_type) && $document_type != "Devis") || (isset($item->type) && $item->type != "Devis"))
        <div class="col">
            <div class="form-group">
                <label for="date">Période</label>
                <select name="periode" class="form-control" placeholder="" id="periode" required>
                    <option>Choisir la période</option>
                    
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
        @endif
    </div>
</div>

<!-- <div class="card-box">
    <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">Frais d'installation</h5>

    <div class="form-row mt-3 ml-1">
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="frais_installation_checkbox" name="frais_installation_checkbox"
            @if(isset($item->frais_intallation) && !empty($item->frais_intallation)) checked @endif>
            <label class="form-check-label" for="">Ajouter les frais d'installation</label>
        </div>
    </div>

    <div class="form-row">
        <div class="col">
            <div class="form-group">
                <input id="frais_installation" name="frais_installation" class="input-reset form-control @error('frais_installation')
                    is-invalid
                @enderror" 
                value="{{ isset($item->frais_installation) ? $item->frais_installation : old('frais_installation') }}"
                @if( !(isset($item->frais_intallation) && !empty($item->frais_intallation)) ) disabled @endif/>
            </div>
        </div>
    </div>
</div> -->

<div class="card-box">
    <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">Packages</h5>

    <div class="form-row">
        <div class="col">
            <div class="d-flex justify-content-end mt-2">
                <a href="#" id="btn-create" type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#create"><i class="mdi mdi-plus-circle me-1"></i> Ajouter Package</a>
            </div>   
            @include('document.forms.packages')
        </div>
    </div>
</div>

<div class="card-box">
    <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">Autre produit</h5>

    <div class="form-row">
        <div class="col">
            <div class="d-flex justify-content-end mt-2">
                <a href="#12" id="ajouter-produit" type="button" class="btn btn-primary waves-effect waves-light"><i class="mdi mdi-plus-circle me-1"></i> Ajouter Un Produit</a>
            </div>   
           
            <table class="mt-3 mb-3 table table-sm" id="dataTablePackage">
                <thead>
                    <tr>
                    <th>#</th>
                    <th scope="col">Désignation</th>
                    <th scope="col">Qté</th>
                    <th scope="col">PU HT</th>
                    <th scope="col">Total</th>
                    </tr>
                </thead>
                <tbody id="tbody-produit">
                    @if(isset($document_produits))
                    @foreach($document_produits as $dp)
                        <tr id='ligne-{{ $dp->id }}'>
                            <td>
                                <a href="#{{ $dp->id }}" id="supprimer-{{ $dp->id }}" class="action-icon text-danger supprimer-ligne" title="Supprimer la ligne du produit" data-plugin="tippy" data-tippy-animation="shift-away" data-tippy-inertia="true" data-tippy-duration="[600, 300]" data-tippy-arrow="true"> <i class="mdi mdi-trash-can"></i></a>
                            </td>
                            <td>
                                <textarea type="text" class="form-control" id="objet-produit-{{ $dp->id }}" name="objet-produit-{{ $dp->id }}">{{ $dp->objet ?? '' }}</textarea>
                                <input hidden type="text" class="form-control produit-id" id="update-produit-{{ $dp->id }}" name="update-produit-{{ $dp->id }}" value="{{ $dp->id }}">
                            </td>
                            <td>
                                <input type="number" class="form-control qt-produit" id="qt-produit-{{ $dp->id }}" name="qt-produit-{{ $dp->id }}" value="{{ $dp->quantite ?? '' }}">
                            </td>
                            <td>
                                <input type="number" class="form-control qt-produit" id="mt-produit-{{ $dp->id }}" name="mt-produit-{{ $dp->id }}" value="{{ $dp->montant ?? '' }}">
                            </td>
                            <td>
                                <input id="mttotal-produit-{{ $dp->id }}" type="number" class="form-control qt-packages" value="{{ $dp->quantite * $dp->montant }}" disabled>
                            </td>
                        </tr>  
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card-box">
    <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">Montants</h5>

    @if(isset($item->tva))

    @if ($item->tva > 0)
    <div class="form-row mt-3 ml-1">
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="tva-checkbox" name="tva-checkbox"
            >
            <label class="form-check-label" for="">Sans TVA (18%)</label>
        </div>
    </div>
    @else
    <div class="form-row mt-3 ml-1">
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="tva-checkbox" name="tva-checkbox"
            checked>
            <label class="form-check-label" for="">Sans TVA (18%)</label>
        </div>
    </div>
    @endif

    @else

    <div class="form-row mt-3 ml-1">
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="tva-checkbox" name="tva-checkbox"
>
            <label class="form-check-label" for="">Sans TVA (18%)</label>
        </div>
    </div>
    
    @endif

    
    
    <div class="form-row mt-3">
        <div class="col-4">
            <div class="form-group">
                <label for="montantht">Total HT</label>
                <input type="text" name="montantht" id="montantht" class="form-control @error('montantht')
                    is-invalid
                @enderror" value="{{ isset($item->montantht) ? number_format($item->montantht, 0, ',', ' ') : old('montantht') }}">
                @if ($errors->has('montantht'))
                    <span class="invalid feedback"role="alert">
                        <strong>{{ $errors->first('montantht') }}.</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="col-4">
            <div class="form-group">
                <label for="tva">TVA</label>
                <input type="text" id="tva" name="tva" class="form-control" value="{{ isset($item->tva) ? number_format($item->tva, 0, ',', ' ') : old('tva') }}"/>
            </div>
        </div>
        <div class="col-4">
            <div class="form-group">
                <label for="montantttc">Total TTC</label>
                <input type="text" id="montantttc" name="montantttc" class="form-control @error('montantttc')
                    is-invalid
                @enderror" value="{{ isset($item->montantttc) ? number_format($item->montantttc, 0, ',', ' ') : old('montantttc') }}"/>
                @if ($errors->has('montantttc'))
                    <span class="invalid feedback"role="alert">
                        <strong>{{ $errors->first('montantttc') }}.</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="card-box">
    <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">Autre Information</h5>
    <div class="form-row">
        <div class="col">
            <div class="form-group">
                <label for="validite">Validité</label>
                <input type="number"  name="validite" id="validite" min="0" placeholder="Jour(s)" class="form-control @error('validite')
                    is-invalid
                @enderror" value="{{ isset($item->validite) ? $item->validite : old('validite') }}">
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label for="deali_de_livraison">Délai de livraison</label>
                <input type="number" id="validite" name="deali_de_livraison" placeholder="Jour(s)" min="0" class="form-control @error('montantttc')
                    is-invalid
                @enderror" value="{{ isset($item->validite) ? $item->validite : old('validite') }}" placeholder="nombre de jours"/>
            </div>
        </div>
    </div>
    
    <div class="form-row">
        <div class="col">
            <div class="form-group">
                <label for="condition">Condition</label>
                <select class="select2 form-control" name="condition" placeholder="" id="condition" required>
                    <option>Choisir la condition</option>
                    
                    <option @if(isset($item->condition) && $item->condition == "R") 
                        selected 
                    @endif value="R">
                        A la réception
                    </option>
                    
                    <option @if(isset($item->condition) && $item->condition == "A la commande") 
                        selected 
                    @endif value="A la commande">
                        A la commande
                    </option>
                    
                    <option @if(isset($item->condition) && $item->condition == "Fin du mois") 
                        selected 
                    @endif value="Fin du mois">
                        Fin du mois
                    </option>
                    
                    <option @if(isset($item->condition) && $item->condition == "15 jours") 
                        selected 
                    @endif value="15 jours">
                        15 jours
                    </option>
                    
                    <option @if(isset($item->condition) && $item->condition == "20 jours") 
                        selected 
                    @endif value="20 jours">
                        20 jours
                    </option>
                    
                    <option @if(isset($item->condition) && $item->condition == "30 jours") 
                        selected 
                    @endif value="30 jours">
                        30 jours
                    </option>
                    
                    <option @if(isset($item->condition) && $item->condition == "45 jours") 
                        selected 
                    @endif value="45 jours">
                        45 jours
                    </option>
                    
                    <option @if(isset($item->condition) && $item->condition == "60 jours") 
                        selected 
                    @endif value="60 jours">
                        60 jours
                    </option>
                    
                    <option @if(isset($item->condition) && $item->condition == "90 jours") 
                        selected 
                    @endif value="90 jours">
                        90 jours
                    </option>
                    
                    <option @if(isset($item->condition) && $item->condition == "+30 jours fin de mois") 
                        selected 
                    @endif value="+30 jours fin de mois">
                        30 jours fin de mois
                    </option>
                    
                    <option @if(isset($item->condition) && $item->condition == "+45 jours fin de mois") 
                        selected 
                    @endif value="+45 jours fin de mois">
                        45 jours fin de mois
                    </option>
                    
                    <option @if(isset($item->condition) && $item->condition == "+60 jours fin de mois") 
                        selected 
                    @endif value="+60 jours fin de mois">
                        60 jours fin de mois
                    </option>
                    
                    <option @if(isset($item->condition) && $item->condition == "+11 jours fin de mois le 10") 
                        selected 
                    @endif value="+11 jours fin de mois le 10">
                        30 jours fin de mois le 10
                    </option>
                    
                    <option @if(isset($item->condition) && $item->condition == "+46 jours fin de mois le 10") 
                        selected 
                    @endif value="+46 jours fin de mois le 10">
                        45 jours fin de mois le 10
                    </option>
                    
                    <option @if(isset($item->condition) && $item->condition == "+61 jours fin de mois le 10") 
                        selected 
                    @endif value="+61 jours fin de mois le 10">
                        60 jours fin de mois le 10
                    </option>
                </select>
            </div>
        </div>
    </div>
    
    <div class="form-row">
        <div class="col-12">
            <div class="form-group">
                <label for="summernote-basic">Commentaire</label>
                <textarea class="form-control" id="summernote-basic" name="commentaire">
                    @if(isset($item->commentaire)) 
                        {{ $item->commentaire }}
                    @endif
                </textarea>
            </div>
        </div><!-- end col -->
    </div>
</div>

@if (Auth::user()->fonction->name == 'Commercial')
<div class="card-box">
    <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">Suivi par:</h5>
    <div class="form-row">
        <div class="col-4">
            <div class="form-group">
                <label for="user_id">Commercial</label>
                <select name="user_id" class="form-control" required>
                <option class="input-reset" value="{{Auth::user()->id}}" selected>{{Auth::user()->name}}</option>
            </select>
            </div>
        </div>
        <div class="col-4">
            <div class="form-group">
                <label for="suivi_par">Autre personne</label>
                <input type="text" id="suivi_par" name="suivi_par"  class="form-control"/>
            </div>
        </div>
        <div class="col-4">
            <div class="form-group">
                <label for="contact_personne">Contact de la personne</label>
                <input type="number" id="contact_personne" name="contact_personne"  class="form-control"/>
            </div>
        </div>
    </div>
</div>

@else

<div class="card-box">
    <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">Suivi par:</h5>
    <div class="form-row">
        <div class="col-4">
            <div class="form-group">
                <label for="user_id">Commercial</label>
                <select name="user_id" class="form-control select2">
                <option class="input-reset" value="" selected="">---------</option>
                @foreach($users as $user)
                    <option value='{{$user->id}}'
                    @if(isset($item->user) && $item->user_id == $user->id) 
                        selected 
                    @endif>{{$user->name}}</option>
                @endforeach
            </select>
            </div>
        </div>
        <div class="col-4">
            <div class="form-group">
                <label for="suivi_par">Autre personne</label>
                <input type="text" id="suivi_par" name="suivi_par" value='{{$item->suivi_par ?? ''}}'  class="form-control"/>
            </div>
        </div>
        <div class="col-4">
            <div class="form-group">
                <label for="contact_personne">Contact de la personne</label>
                <input type="number" id="contact_personne" name="contact_personne" value='{{$item->contact_personne ?? ''}}' class="form-control"/>
            </div>
        </div>
    </div>
</div>

@endif


