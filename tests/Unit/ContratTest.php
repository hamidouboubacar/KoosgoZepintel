<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Contrat;
use App\Models\Client;
use App\Models\Package;
use App\Models\ContratPackage;

class ContratTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        $contrat = Contrat::find(15);
        $item = $contrat;
        $clients = Client::latest()->get();
        $packages = Package::latest()->get();
        $contrat_packages = ContratPackage::where("contrat_id", $contrat->id)->get('package_id')->toArray();
        $num_contrat = $contrat->num_contrat;
        $this->assertTrue(true);
    }
}
