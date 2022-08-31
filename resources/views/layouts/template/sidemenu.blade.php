<div id="sidebar-menu">

    <ul id="side-menu">

        <li class="menu-title">Navigation</li>

        <li id="close-setting-theme"></li>
        @can('viewAny', "App\Models\Client")
        <li>
            <a href="#sidebarclient" data-toggle="collapse">
                <i class="text-primary mr-2" data-feather="users"></i>
                <span> Clients/Prospects </span>
                <span class="menu-arrow"></span>
            </a>
            <div class="collapse" id="sidebarclient">
                <ul class="nav-second-level">
                    <li>
                        <a href="{{ route('client.index') }}">Clients</a>
                    </li>
                    <li>
                        <a href="{{ route('prospect.index') }}">Prospects</a>
                    </li>
                </ul>
            </div>

        </li> 
         <li>
             @endcan
             @can('viewAny', "App\Models\Contrat")
            <a href="#sidebarContrat" data-toggle="collapse">
                <i class="text-primary mr-2" data-feather="file-minus"></i>
                <span> Contrats </span>
                <span class="menu-arrow"></span>
            </a>
            <div class="collapse" id="sidebarContrat">
                <ul class="nav-second-level">
                    <li>
                        <a href="{{ route('contrats.index') }}">Liste Contrats</a>
                    </li>
                </ul>
            </div>
            @endcan
        </li>
        @can('viewAny', "App\Models\Package")
        <li>
            <a href="#sidebarCatalogue" data-toggle="collapse">
                <i class="text-primary mr-2" data-feather="list"></i>
                <span> Packages </span>
                <span class="menu-arrow"></span>
            </a>
            <div class="collapse" id="sidebarCatalogue">
                <ul class="nav-second-level">
                    <li>
                        <a href="{{ route('packages.index') }}">Liste Packages</a>
                    </li>
                    @can('viewAny', "App\Models\OffreService")
                    <li>
                        <a href="{{ route('offre_services.index') }}">Liste Offres de service</a>
                    </li>
                    @endcan
                </ul>
            </div>

        </li>
        @endcan
        
        @can('viewAny',"App\Models\Document")
        <li>
            <a href="#sidebarVente" data-toggle="collapse">
                <i class="text-primary mr-2" data-feather="shopping-cart"></i>
                <span> Ventes </span>
                <span class="menu-arrow"></span>
            </a>
            <div class="collapse" id="sidebarVente">
                <ul class="nav-second-level">
                    <li>
                        <a href="{{ route('document.index') }}">Devis</a>
                    </li>
                    @can('viewResume',"App\Models\Document")
                    <li>
                        <a href="{{ route('factures.index') }}">Facture</a>
                    </li>
                    <li>
                        <a href="{{ route('factures.avoir') }}">Facture Avoir</a>
                    </li>
                    @endcan
                    <li>
                        <a href="{{route('bonCommande.index')}}">Bon de commande</a>
                    </li>
                    @can('viewResume',"App\Models\Document")
                    <li>
                        <a href="{{ route('paiement.index') }}">Paiements</a>
                    </li>
                    @endcan
                    <li>
                        <a href="{{ route('rapportJournalier') }}">Rapport journalier</a>
                    </li>  
                    <li>
                        <a href="{{ route('rapportHebdomadaire') }}">Rapport hebdomadaire</a>
                    </li>
                    <li>
                        <a href="{{ route('rapportMensuel') }}">Rapport mensuel</a>
                    </li>
                    @can('viewResume',"App\Models\Document")
                    <li>
                        <a href="{{ route('resume') }}">Résumés</a>
                    </li>
                    @endcan
                </ul>
            </div>

        </li>
        @endcan

        @can('viewAny', "App\Models\Refacturation")
        <li>
            <a href="{{ route('refacturation.index') }}">
                <i class="text-primary mr-2" data-feather="refresh-ccw"></i>
                <span> Refacturation </span>
            </a>
        </li>
@endcan

@can('viewAny',"App\Models\Commercial")
        <li>
            <a href="#sidebarCommerciale" data-toggle="collapse">
                <i class="text-primary mr-2" data-feather="user"></i>
                <span> Force de vente </span>
                <span class="menu-arrow"></span>
            </a>
            <div class="collapse" id="sidebarCommerciale">
                <ul class="nav-second-level">
                    @can('viewReste',"App\Models\Commercial")
                    <li>
                        <a href="{{ route('commercials.index') }}">Liste Commerciaux</a>
                    </li>
                    @endcan
                    <li>
                        <a href="{{ route('planning_taches.index') }}">Planning des tâches</a>
                    </li>
                    <li>
                        <a href="{{ route('planning_rdvs.index') }}">Planning des RDV</a>
                    </li>
                    <li>
                        <a href="{{ route('commercials.statistiques') }}">Statistiques</a>
                    </li>
                </ul>
            </div>

        </li>
        @endcan

        @can('viewAny', "App\Models\Statistique")
        <li>
            <a href="#sidebarStatistique" data-toggle="collapse">
                <i class="text-primary mr-2" data-feather="pie-chart"></i>
                <span> Statistiques </span>
                <span class="menu-arrow"></span>
            </a>
            <div class="collapse" id="sidebarStatistique">
                <ul class="nav-second-level">
                    <li>
                        <a href="{{ route('statistiques.index') }}">Graphes</a>
                    </li>
                </ul>
                <ul class="nav-second-level">
                    <li>
                        <a href="{{ route('statistiques.ventes') }}">Ventes</a>
                    </li>
                </ul>
                <ul class="nav-second-level">
                    <li>
                        <a href="{{ route('statistiques.tva') }}">TVA</a>
                    </li>
                </ul>
                <ul class="nav-second-level">
                    <li>
                        <a href="{{ route('statistiques.clients') }}">Clients</a>
                    </li>
                </ul>
                <ul class="nav-second-level">
                    <li>
                        <a href="{{ route('statistiques.packages') }}">Packages</a>
                    </li>
                </ul>
            </div>

        </li>
        @endcan
        @can('viewAny', "App\Models\User")
        <li>
            <a href="#sidebarEcommerce" data-toggle="collapse">
                <i class="text-primary mr-2" data-feather="settings"></i>
                <span> Paramètres </span>
                <span class="menu-arrow"></span>
            </a>
            <div class="collapse" id="sidebarEcommerce">
                <ul class="nav-second-level">

                    @can('viewAny', "App\Models\Entreprise")
                     <li>
                        <a href="{{ route('entreprise.index') }}">Netforce</a>
                    </li>
                    @endcan
                    @can('viewAny', "App\Models\Role")
                    <li>
                       <a href="{{ route('role.index') }}">Permissions</a>
                   </li>
                   @endcan
                    @can('viewAny', "App\Models\Fonction")
                    <li>
                        <a href="{{ route('fonction.index') }}">Fonctions</a>
                    </li>
                    @endcan

                    @can('viewAny', "App\Models\User")
                    <li>
                        <a href="{{ route('user.index') }}">Utilisateurs</a>
                    </li>
                    @endcan
                </ul>
            </div>

        </li>
        @endcan
    </ul>
</div>
</li>
