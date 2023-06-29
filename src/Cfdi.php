<?php

namespace Advans\Api\BovedaXML;

class Cfdi {

    public $id, $uuid, $rfc_emisor, $rfc_receptor, $total, $fecha_emision, $hash, $estado, $cancelable, $created_at, $updated_at;

    public function __construct(array $attributes = null) {
        if ($attributes) {
            foreach ($attributes as $key => $value) {
                if (property_exists($this, $key)) $this->$key = $value;
            }
        }
    }

}