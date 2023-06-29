# advans/php-api-boveda-xml

[![Latest Stable Version](https://img.shields.io/packagist/v/advans/php-api-boveda-xml?style=flat-square)](https://packagist.org/packages/advans/php-api-boveda-xml)
[![Total Downloads](https://img.shields.io/packagist/dt/advans/php-api-boveda-xml?style=flat-square)](https://packagist.org/packages/advans/php-api-boveda-xml)

## Instalación usando Composer

```sh
$ composer require advans/php-api-boveda-xml
```

## Ejemplo

````
$config = new \Advans\Api\BovedaXML\Config([
    'base_url' => '*************************',
    'key' => '**********************'
]);
$service_lrfc = new \Advans\Api\BovedaXML\BovedaXML($config);

$response = $service_lrfc->getByUUID('000000000000-0000-0000-0000-0000000000000000');
````

## Configuración

| Parámetro | Valor por defecto | Descripción |
| :--- | :--- | :--- |
| base_url | null | URL de la API |
| key | null | API Key |
