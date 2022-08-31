<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DataMigration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:load';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Data migration';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if($this->confirm('Voulez-vous continuer?')){
            // load_users();
            // load_clients();
            // load_packages();
            // load_contrats();
            // load_documents();
            load_document_packages();
            // load_paiements();
            // load_offres();
            // load_contrat_selects();
        }
        return 0;
    }
}
