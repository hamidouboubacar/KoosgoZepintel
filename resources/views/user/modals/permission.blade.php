
<div class="modal fade" id="createPermission" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Permission</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('user.permission') }}" method="post" id="create-user-form">
                    @csrf
                    <div class="form-row">
                        <div class="col-6">
                            <label for="fonction_id">Utilisateur</label>
                            <select name="user_id" id="user_id" required class="form-control" required>
                                <option value="">Choisir l'utilisateur</option>
                                @foreach ($users as $user)
                                    <option value="{{$user->id}} ">{{$user->name}} </option>
                                @endforeach
                            </select>

                        </div>
                         <div class="col-6">
                            <label for="fonction_id">Rôles</label>
                            <select name="role_id[]" id="role_id" required class="form-control" multiple required>
                                <option value="">Choisir les rôles</option>
                                @foreach ($roles as $role)
                                    <option value="{{$role->id}} ">{{$role->name}} </option>
                                @endforeach
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

