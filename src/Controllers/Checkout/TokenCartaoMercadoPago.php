<?php

namespace SceLPI\MercadoPago\Controllers\Checkout;

use Illuminate\Http\Request;

class TokenCartaoMercadoPago {
    /** @var string  */
    private $token = "";
    /** @var string  */
    private $codigoSerguranca = "";

    public function __construct(Request $request = null)
    {
        if ( $request != null ) {
            $this->setDadosFromRequest($request);
        }
    }

    private function setDadosFromRequest(Request $request)
    {
        $this->token = $request->get('token');
        $this->codigoSerguranca = $request->get('codigo_seguranca');
    }

    /**
     * @param string $token
     * @return TokenCartaoMercadoPago
     */
    public function setToken(string $token): TokenCartaoMercadoPago
    {
        $this->token = $token;
        return $this;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @param string $codigoSerguranca
     * @return TokenCartaoMercadoPago
     */
    public function setCodigoSerguranca(string $codigoSerguranca): TokenCartaoMercadoPago
    {
        $this->codigoSerguranca = $codigoSerguranca;
        return $this;
    }

    /**
     * @return string
     */
    public function getCodigoSerguranca(): string
    {
        return $this->codigoSerguranca;
    }

    public function preparar(): array
    {
        return [
            "token" => $this->getToken(),
            "security_code" => $this->getCodigoSerguranca()
        ];
    }
}