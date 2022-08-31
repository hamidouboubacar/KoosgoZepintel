<?php

namespace App\Http\Controllers;

use App\Models\Fonction;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Str;

class UserController extends Controller
{
    //
    public function index(){
        $this->authorize("viewAny", "App\Models\User");
        $users = User::where('etat', 1)->where('whoIs', 'NetForce')->get();
        $fonctions = Fonction::actifs()->get();
        return view("user.index",[ 'users'=> $users, 'fonctions'=> $fonctions, "roles" => Role::actifs(),]);
    }

    public function store()
    {
        $this->authorize("create", "App\Models\User");
        $data = $this->verifierInformation();
        // generation du mot de passe
        $password = Str::random(8);
        $data['mail_variable'] = $password;
        $hashed_password = Hash::make($password);
        $data['password'] = $hashed_password;
        $data['whoIs'] = "NetForce";
        User::create($data);
            // Mail::send('email.email-template', $data, function($message) use ($data) {
            //     $message->to($data['email'])
            //     ->subject('Mot de passe UFR');
            //   });
        return back()->with("message", "Enregistré avec succès");
    }

    public function permission(Request $request){
        $this->authorize("ajouterPermission", "App\Models\User");
        $data = $this->verifierPermission();
        $count = count($data['role_id']);
        $user = User::find($data['user_id']);
        for ($i=0;$i<$count;$i++) {
            $user->permissions()->attach($data['user_id'], [
                'role_id' => $request->role_id[$i],
            ]);
        }
        return back()->with('message', "Ajoutée avec succès");
    }


    public function edit(User $user){
        $this->authorize("update", $user);
        return response()->json($user);
    }

    public function update(User $user){
        $this->authorize("update", $user);
        $data = request()->validate([
            'name' => 'required|string',
        ]);
        $user->update($data);
        return back()->with("message", "Modifié avec succès");

    }

    public function delete(User $user){
        $this->authorize("delete", $user);
        $user->etat=0;
        $user->save();
        return back()->with("message", "La user '$user->name' est supprimée avec succès!");
    }

    private function verifierInformation()
    {
        $this->authorize("ajouterPermission", "App\Models\User");
        return request()->validate([
            'name' => 'required|string|max:300',
            'email' => 'required|email',
            'fonction_id' => 'required|string',
            'telephone' => 'required|string',
            '' => 'nullable',
        ]);
    }

    private function verifierPermission(){
        return request()->validate([
            'user_id' => 'required',
            'role_id' => 'required',
        ]);
    }

    public function login(Request $request) {
        $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);
        $email = $request->email;
        $password = $request->password;

        if(Auth::attempt(['email' => $email, 'password' => $password])) {
            return response()->json([
                'success' => true,
                'token' => User::where('email', $email)->where('fonction_id', Fonction::where('name', 'Client')->first()->id)->first()->token
            ]);
        } else {
            return response()->json([
                'success' => false
            ]);
        }
    }
}
