<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ViaCepServices 
{

  /**
   * @param array $resource
   */
  private $resouces = [
    'local' => '/ws/{cep}/json/'
  ];

  /**
   * @param string $resource
   * @param array $params
   * @return string
   */
  public function getEndpoint(string $resource, array $params = [])
  {
    $endpoint = $this->resouces[$resource];

    foreach ($params as $key => $value) {
      $endpoint = str_replace('{'.$key.'}', $value, $endpoint);
    }

    return config('settings.viacepBaseUrl').$endpoint;
  }

  /**
   * @param string|array $ceps
   * @return array
   */
  public function getLocations(string|array $zicodes)
  {
    $this->validateCeps($zicodes);

    $locations = ['locations' => []];

    foreach ($zicodes['success'] as $zicode) {
      $endpoint = $this->getEndpoint('local', ['cep' => $zicode]);
      $response = Http                               :: get($endpoint);
      $json     = $response->json();

      if($json and !isset($json['erro']) ) {
        $locations['locations'][] = $response->json();
      }else{
        $zicodes['errors'][] = $zicode;
      }
    }

    $locations['zipcode_with_errors'] = (isset($zicodes['errors'])) ? $zicodes['errors'] : [];
    return $locations;
  }

  /**
   * Validate if the ceps are valid
   * 
   * @param string|array $ceps
   * @return void
   */
  public function validateCeps(&$zicodes)
  {
      if(is_string($zicodes)) $zicodes = explode(',', $zicodes);

      $aux = ['success' => [], 'errors' => []];

      foreach ($zicodes as $zicode) {
        $zicode = trim(str_replace('-','',$zicode));

        if(strlen($zicode) == 8 && is_numeric($zicode)) {
          $aux['success'][] = $zicode;
          continue;
        }

        $aux['errors'][] = $zicode;
      }

      $zicodes = $aux;
  }

}