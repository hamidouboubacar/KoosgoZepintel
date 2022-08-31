<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    //

    public function index(){
        $this->authorize("viewAny", "App\Models\Role");
        return view("role.index", [
            "roles" => Role::actifs(),
            "users" => User::actifs(),
            "permissions" => Role::actifs(),
        ]);
    }

    public function store(Request $request){
        $this->authorize("create", "App\Models\Role");
        $data = $request->all();
        $code = str_replace(' ', '_', $request->name);
        $code1 = strtolower($code);
        // dd($code1);
        $data = $this->verification();
        $data['created_by'] = Auth::id();
        $data['code'] = $code1;
        $data['description'] = $request->description;
        Role::create($data);
        return back()->with("message", "Enregistré avec succès");
    }

    public function edit(Role $role){
        $this->authorize("update", $role);
        return response()->json($role);
    }

    public function update(Role $role){
        $this->authorize("update", $role);
        $data = request()->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
        ]);
        $code = str_replace(' ', '_', $role->name);
        $code1 = strtolower($code);
        $role->code = $code1;
        $role->description = $role->description;
        $role->update($data);
        return back()->with("message", "Modifié avec succès");

    }

    public function delete(Role $role){
        $this->authorize("delete", $role);
        $role->etat = 0;
        $role->save();
        return back()->with("message", "Supprimé avec succès");
    }


    private function verification(){
        return request()->validate([
            'name' => 'required',
            'description' => 'nullable',
        ]);
    }
}
