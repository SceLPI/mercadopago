<?php

namespace SceLPI\MercadoPago\Controllers\Checkout;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7;
use SceLPI\MercadoPago\Controllers\Checkout\Exceptions\MercadoPagoInvalidMethodCalledException;
use SceLPI\MercadoPago\Controllers\Checkout\Exceptions\MercadoPagoNotConfiguredException;

class MercadoPagoRequest {

    private $token = null;
    private $key = null;
    private $application = null;

    private $baseUrl = "https://api.mercadopago.com/";

    private $method = 'GET';
    private $url = null;
    private $query = null;
    private $json = null;
    private $asObject = true;

    private $error = false;
    private $trace;
    private $response;

    public function __construct($asObject = true)
    {
        $this->check();
        $this->query = [
            'access_token' => $this->token
        ];

        $this->asObject = $asObject;
    }

    /**
     * @param mixed $json
     * @return MercadoPagoRequest
     */
    public function setJson($json)
    {
        $this->json = $json;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getJson() : array
    {
        return $this->json;
    }

    /**
     * @param mixed $url
     * @return MercadoPagoRequest
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUrl() : string
    {
        return $this->url;
    }

    /**
     * @param string $method
     * @return MercadoPagoRequest
     */
    public function setMethod(string $method): MercadoPagoRequest
    {
        if (!in_array($method, ['GET', 'POST', 'PUT', 'DELETE'])) {
            throw new MercadoPagoInvalidMethodCalledException("The methods should be GET, POST, PUT or DELETE");
        }
        $this->method = $method;
        return $this;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param array $header
     * @return MercadoPagoRequest
     */
    public function addQueryParam(array $header): MercadoPagoRequest
    {
        $this->query = array_merge($this->query, $header);
        return $this;
    }

    private function setError($trace)
    {
        $this->error = true;
        $this->trace = $trace;
    }

    /**
     * @return bool
     */
    public function getError() {
        return $this->error;
    }

    /**
     * @return \StdClass|array
     */
    public function execute() {
        $cliente = new Client([
            'base_uri' => $this->baseUrl,
        ]);

        $parameters = [
            'query' => $this->query
        ];

        if ( $this->json ) {
            $parameters['json'] = $this->json;
        }

        $requisicao = null;

        try {
            $requisicao = $cliente->request($this->method, $this->url, $parameters);
        } catch (ClientException $e) {

            $this->setError((object)[
                "request" => Psr7\str($e->getRequest()),
                "error" => (string)$e->getResponse()->getBody()
            ]);

            $this->response = $this->trace;
        } catch (\Exception $e) {
            if ( array_key_exists('binary_mode',$parameters['json']) ) {
                print_r( $e->getMessage() );
                exit;
            }
        }

        if ( !$this->error ) {
            $resposta = (string)$requisicao->getBody();
            $object = json_decode($resposta);
            $this->response = $object;
        }

        return $this->response;
    }


    public function check()
    {
        if (env('APP_ENV') === 'production') {
            if (!env('MP_APP') ||
                !env('MP_KEY') ||
                !env('MP_TOKEN') ) {
                throw new MercadoPagoNotConfiguredException("Do you have configured the MercadoPago vars on ENV? (MP_APP, MP_KEY, MP_TOKEN)");
            }
            $this->application = env('MP_APP');
            $this->key = env('MP_KEY');
            $this->token = env('MP_TOKEN');
            return;
        }


        if ( !env('MP_SANDBOX_APP') ||
            !env('MP_SANDBOX_KEY') ||
            !env('MP_SANDBOX_TOKEN') ) {
            throw new MercadoPagoNotConfiguredException("Do you have configured the MercadoPago vars on ENV? (MP_SANDBOX_APP, MP_SANDBOX_KEY, MP_SANDBOX_TOKEN)");
        }
        $this->application = env('MP_SANDBOX_APP');
        $this->key = env('MP_SANDBOX_KEY');
        $this->token = env('MP_SANDBOX_TOKEN');
    }
}