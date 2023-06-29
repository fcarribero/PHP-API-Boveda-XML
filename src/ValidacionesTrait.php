<?php

namespace Advans\Api\BovedaXML;

trait ValidacionesTrait {
    private function validUUID($uuid) {
        return preg_match('/^[0-9a-f]{8}-([0-9a-f]{4}-){3}[0-9a-f]{12}$/i', $uuid);
    }

    private function validRfc($rfc_emisor) {
        return preg_match('/^[A-ZÑ&]{3,4}[0-9]{6}[A-Z0-9]{3}$/', $rfc_emisor);
    }

    private function validFecha($fecha) {
        return preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $fecha);
    }
}