## TO RUN PROJETC

1. Run the compose install  command
2. Run the cp .env.example .env command
3. Run the ./vendor/bin/sail up command
4. Run the ./vendor/bin/sail php artisan key:generate command

# DOCUMENTATION TO API


## SEARCH LOCATIONS

**Description:** this endpoint has the function of returning a list of locations from the zip code or a list of zip codes.

**Methos:** ```GET```

**Endpoint:** ```{host}/api/search/local/{ceps}```

## Params

| Name | Type | Example | 
| --- |  :-- | :-- |
| ceps | String | 13605-342,13604098,1360088x |

## Response 200
``` json
{
  "success": true,
  "message": "Locations successfully retrieved",
  "data": {
    "locations": [
      {
        "cep": "13606-536",
        "logradouro": "Avenida Luiz Carlos Tunes",
        "complemento": "(Branco) - lado ímpar",
        "bairro": "Jardim Morumbi",
        "localidade": "Araras",
        "uf": "SP",
        "ibge": "3503307",
        "gia": "1820",
        "ddd": "19",
        "siafi": "6165"
      }
    ],
    "zipcode_with_errors": [
      
    ]
  }
}
```

## Response 400

``` json
{
  "success": false,
  "message": "Fail to retrieve locations",
  "data": {
    "locations": [
      
    ],
    "zipcode_with_errors": [
      "13600000"
    ]
  }
}
```
