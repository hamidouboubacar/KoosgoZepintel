<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize("viewAny", "App\Models\Package");
        $title = "Package";
        $packages = Package::latest()->orderBy('id', 'desc')->get();
        return view("packages.index", compact("packages", "title"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize("create", "App\Models\Package");
        // 1. La validation
        $this->validate($request, [
            "nom" => 'bail|required|string|max:255',
            "debit_ascendant" => 'bail|required|integer',
            "montant" => 'bail|required|integer',
        ]);

        // 3. On enregistre les informations du Post
        Package::create([
            "nom" => $request->nom,
            "debit_ascendant" => $request->debit_ascendant,
            "debit_descendant" => $request->debit_descendant,
            "montant" => $request->montant,
        ]);

        // 4. On retourne vers tous les posts : route("posts.index")
        return back()->with("message", "Enregistrement effectué avec succès !");
    }
    
    /**
     * Add a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request)
    {
        // 1. La validation
        $this->validate($request, [
            "nom" => 'bail|required|string|max:255',
            "debit_ascendant" => 'bail|required|integer',
            "montant" => 'bail|required|integer',
        ]);

        // 3. On enregistre les informations du Post
        $package = Package::create([
            "nom" => $request->nom,
            "debit_ascendant" => $request->debit_ascendant,
            "debit_descendant" => $request->debit_descendant,
            "montant" => $request->montant,
        ]);
        
        $template = <<<EOD
            <tr>
                <td>
                    <div class="form-check">
                        <input class="form-check-input packages-checkbox" type="checkbox" value="{{$package->id}}" name="package-checkbox-{{$package->id}}" id="package-{{$package->id}}">
                        <label class="form-check-label" for="customCheck1">&nbsp;</label>
                    </div>
                </td>
                <td>$package->nom</td>
                <td>
                    <input type="number" class="form-control qt-packages" id="qt-package-$package->id" name="qt-package-$package->id" value="1">
                    <input type="hidden" class="form-control qt-packages" id="mt-package-$package->id" value="$package->montant">
                </td>
                <td id="prix-unitaire-package-$package->id">$package->montant FCFA</td>
                <td id="mttotal-package-$package->id">$package->montant FCFA</td>
            </tr>
        EOD;

        // 4. On retourne vers tous les posts : route("posts.index")
        return response()->json([
            "data" => $template,
            "result" => true
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function show(Package $package)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function edit(Package $package)
    {
        $this->authorize("update", $package);
        $item = $package;
        return view("packages.modals.edit", compact("item"));
        // return response()->json($package);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Package $package)
    {
        $this->authorize("update", $package);
        // 1. La validation
        $this->validate($request, [
            "nom" => 'bail|required|string|max:255',
            "debit_ascendant" => 'bail|required|integer',
            "montant" => 'bail|required|integer',
        ]);

        // 3. On enregistre les informations du Post
        $package->update([
            "nom" => $request->nom,
            "debit_ascendant" => $request->debit_ascendant,
            "debit_descendant" => $request->debit_descendant,
            "montant" => $request->montant,
        ]);
        
        return back()->with("message", "Modification effectuée avec succès !");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function destroy(Package $package)
    {
        $this->authorize("delete", $package );
        $package->delete();
        return back()->with("message", "Suppression effectuée avec succès!");
    }
}
