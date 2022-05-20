<?php

namespace Tests\Unit;

use App\Services\ViaCepServices;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ViaCepServicesTest extends TestCase
{

    /** @test */
    public function when_system_requires_get_endpoints_method()
    {
        $services = new ViaCepServices();    
        $endpoint = $services->getEndpoint('local', ['cep' => '13606536']);
        $this->assertEquals('https://viacep.com.br/ws/13606536/json/', $endpoint);
    }

    /** @test */
    public function when_system_requires_get_locations_method()
    {
        $ceps = '13606-536, 13605342, 13604098, 1360088x';
        $services = new ViaCepServices();
        $result = $services->getLocations($ceps);
        $this->assertIsArray($result);
        $this->assertEquals(3, count($result['locations']));
        $this->assertEquals(1, count($result['zipcode_with_errors']));
    }
}
