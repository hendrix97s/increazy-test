<?php

namespace App\Http\Controllers;

use App\Services\ViaCepServices;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function locations(ViaCepServices $service, string $zicodes)
    {
        $data = $service->getLocations($zicodes);

        if(count($data['locations']) === 0)
            return $this->response(false, 'search.locations', 400, $data);
        return $this->response(true, 'search.locations', 200, $data);
    }

}
