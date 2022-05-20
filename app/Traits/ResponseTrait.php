<?php

namespace App\Traits;

trait ResponseTrait
{

  public function response(bool $success, string $resource, int $code = 200, array $data = [],)
  {
    $message = ($success) ? __("{$resource}.success") : __("{$resource}.fail");
    $response = [
      'success' => $success,
      'message' => $message,
      'data' => $data
    ];

    return response()->json($response, $code);
  }
}