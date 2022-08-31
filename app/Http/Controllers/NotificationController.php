<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Contrat;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function show(Notification $notification)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function edit(Notification $notification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Notification $notification)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notification $notification)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function getNotifications(Request $request)
    {
        $now = \Carbon\Carbon::now();
        $date45 = $now->copy()->addDays(45);
        $contrat_expirations = Contrat::where('date_expiration', '<', $now->toDateString())->get();
        $contrat_presque_expirations = Contrat::whereBetween('date_expiration', [$now->toDateString(), $date45->toDateString()])->get();
        $nb_exp = count($contrat_expirations);
        $nb_pres_exp = count($contrat_presque_expirations);
        $route_contrat = route('contrats.index');
        if($nb_exp > 0 || $nb_pres_exp > 0) $content = <<<EOD
            <a class="nav-link dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                <i class="fe-bell noti-icon"></i>
                <span class="badge badge-danger rounded-circle noti-icon-badge">1</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-lg">

                <!-- item-->
                <div class="dropdown-item noti-title">
                    <h5 class="m-0">
                        Notification
                    </h5>
                </div>

                <div>
                    <a href="$route_contrat" class="dropdown-item notify-item">
                        <div class="notify-icon bg-primary">
                            <i class="mdi mdi-comment-account-outline"></i>
                        </div>
                        <p class="notify-details">Contrat</p>
                        <p class="text-muted mb-0 user-msg">
                            <small>
                                $nb_exp Contrat(s) expiré(s) <br>
                                $nb_pres_exp Contrat(s) presque expiré(s)
                            </small>
                        </p>
                    </a>
                </div>

            </div>
        EOD;
        else $content = "";

        return response()->json(['content' => $content]);
    }
}
