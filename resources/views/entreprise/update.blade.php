@extends('layouts.template.app')

@section('title')
Informations de Netforce
@endsection

@section('content')
<div class="container-fluid">
    <form action="{{ route('entreprise.updateSave', ['entreprise'=>$entreprise]) }}" method="POST" id="formUpdate" enctype="multipart/form-data">
        @csrf
        <div class="form-row">
            <div class="col-6">
                <div class="form-group">
                    <label for="name">Nom *</label>
                    <input type="text"  name="name" id="name" value="{{$entreprise->name ?? ''}}" class="form-control" required>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="forme_juridique">Forme juridique</label>
                    <input type="text" id="forme_juridique" value="{{$entreprise->forme_juridique ?? ''}}" name="forme_juridique" class="form-control"/>
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col-12">
                <label for="ifu">Activite</label>
                <input type="text" name="activite" id="activite" value="{{$entreprise->activite ?? ''}}" class="form-control">
            </div>
        </div>
        
        <div class="form-row">
            <div class="col-6">
                <div class="form-group">
                    <label for="telephone">Téléphone </label>
                    <input type="text" id="telephone1" name="telephone" value="{{$entreprise->telephone ?? ''}}" placeholder="+226 xx xx xx" class="form-control" />
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="adresse">Adresse </label>
                    <input type="text" id="adresse1" name="adresse" value="{{$entreprise->adresse ?? ''}}" class="form-control" />
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col-6">
                <label for="ifu">IFU</label>
                <input type="text" name="ifu" id="ifu" value="{{$entreprise->ifu ?? ''}}" class="form-control">
            </div>
        <div class="col-6">
            <label for="rccm">RCCM</label>
            <input type="text" name="rccm" id="rccm" value="{{$entreprise->rccm ?? ''}}" class="form-control">
        </div>
        </div>
        
        <div class="form-row">
            <div class="col-6">
                <div class="form-group">
                    <label for="email">email </label>
                    <input type="email" id="email" name="email" value="{{$entreprise->email ?? ''}}" class="form-control" />
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="adrewebsse">Web </label>
                    <input type="text" id="web" name="web"  value="{{$entreprise->web ?? ''}}" class="form-control" />
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col-6">
                <label for="ifu">Banque</label>
                <input type="text" name="banque" id="banque" value="{{$entreprise->banque ?? ''}}" class="form-control">
            </div>
        <div class="col-6">
            <label for="compte">Compte</label>
            <input type="text" name="compte" id="compte" value="{{$entreprise->compte ?? ''}}" class="form-control">
        </div>
        </div>
        
        <div class="form-row">
            <div class="col-6">
                <div class="form-group">
                    <label for="logo">Logo </label>
                    <input type="file" id="logo" name="logo" value="{{$entreprise->logo ?? ''}}" class="form-control" />
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="entete">Entête </label>
                    <input type="file" id="entete" name="entete" value="{{$entreprise->entete ?? ''}}" class="form-control" />
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col-6">
                <div class="form-group">
                    <label for="logo">Pied de page </label>
                    <input type="file" id="pieddepage" name="pieddepage" value="{{$entreprise->pieddepage ?? ''}}" class="form-control" />
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="signature">Signature </label>
                    <input type="file" id="signature" name="signature" value="{{$entreprise->signature ?? ''}}" class="form-control" />
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col-6">
                <div class="form-group">
                    <label for="fax">Fax </label>
                    <input type="text" id="fax" name="fax" value="{{$entreprise->fax ?? ''}}" class="form-control" />
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="rib">RIB </label>
                    <input type="text" id="rib" name="rib" value="{{$entreprise->rib ?? ''}}" class="form-control" />
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col-6">
                <div class="form-group">
                    <label for="bic">BIC </label>
                    <input type="text" id="bic" name="bic" value="{{$entreprise->bic ?? ''}}" class="form-control" />
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="tva">TVA </label>
                    <input type="text" id="tva" name="tva" value="{{$entreprise->tva ?? ''}}" class="form-control" />
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
      
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
            <button type="submit" class="btn btn-primary">Enregistrer</button>
        </div>
    </form>
</div>

@endsection