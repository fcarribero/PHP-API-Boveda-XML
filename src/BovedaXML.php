<?php


namespace Advans\Api\BovedaXML;

class BovedaXML {
    use ValidacionesTrait;

    protected $config;

    public function __construct(Config $config) {
        $this->config = $config;
    }

    /**
     * @param $xml
     * @return Cfdi
     * @throws BovedaXMLException
     */
    public function uploadXML($xml): Cfdi {
        return new Cfdi(json_decode($this->call('', 'POST', $xml, [
            'Content-Type: text/xml',
        ]), true));
    }

    /**
     * @param $uuid
     * @return Cfdi
     * @throws BovedaXMLException
     */
    public function getByUUID($uuid): Cfdi {
        if (!$this->validUUID($uuid)) throw new BovedaXMLException('UUID inválido');

        return new Cfdi(json_decode($this->call('uuid/' . strtoupper($uuid)), true));
    }

    /**
     * @param $uuid
     * @return bool|string
     * @throws BovedaXMLException
     */
    public function getXMLByUUID($uuid) {
        if (!$this->validUUID($uuid)) throw new BovedaXMLException('UUID inválido');

        return $this->call('uuid/' . strtoupper($uuid) . '/xml');
    }

    /**
     * @param $rfc_emisor
     * @param $fecha
     * @return Cfdi[]
     * @throws BovedaXMLException
     */

    public function getByRfcEmisor($rfc_emisor, $fecha) {
        if (!$this->validRfc($rfc_emisor)) throw new BovedaXMLException('RFC emisor inválido');
        if (!$this->validFecha($fecha)) throw new BovedaXMLException('Fecha inválida');

        $list_json = json_decode($this->call('rfc-emisor/' . $rfc_emisor . '/' . $fecha), true);
        $list_obj = [];
        foreach ($list_json as $item) {
            $list_obj[] = new Cfdi($item);
        }
        return $list_obj;
    }

    /**
     * @param $rfc_receptor
     * @param $fecha
     * @return Cfdi[]
     * @throws BovedaXMLException
     */
    public function getByRfcReceptor($rfc_receptor, $fecha): array {
        if (!$this->validRfc($rfc_receptor)) throw new BovedaXMLException('RFC receptor inválido');
        if (!$this->validFecha($fecha)) throw new BovedaXMLException('Fecha inválida');

        $list_json = json_decode($this->call('rfc-receptor/' . $rfc_receptor . '/' . $fecha), true);
        $list_obj = [];
        foreach ($list_json as $item) {
            $list_obj[] = new Cfdi($item);
        }
        return $list_obj;
    }

    protected function call($method, $verb = 'GET', $params = null, $headers = []) {
        $verb = strtoupper($verb);
        $url = $this->config->base_url . $method . ($verb == 'GET' && $params ? '?' . http_build_query($params) : '');
        $curl = curl_init();
        $postfields = null;
        if ($verb == 'POST') {
            $postfields = gettype($params) == 'array' ? json_encode($params) : $params;
        }
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $verb,
            CURLOPT_POSTFIELDS => $postfields,
            CURLOPT_HTTPHEADER => array_merge($headers, [
                'Authorization: Bearer ' . $this->config->key
            ]),
        ]);

        $result = @curl_exec($curl);
        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if ($http_code != 200) {
            throw new BovedaXMLException('El servicio regresó un código de error ' . $http_code . ' ' . $result, $http_code);
        }
        curl_close($curl);
        return $result;
    }


}