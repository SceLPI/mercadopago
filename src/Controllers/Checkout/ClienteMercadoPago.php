<?php

namespace SceLPI\MercadoPago\Controllers\Checkout;

use Illuminate\Http\Request;

class ClienteMercadoPago {

    /** @var string  */
    private $id = "";
    /** @var string  */
    private $primeiroNome = "";
    /** @var string  */
    private $ultimoNome = "";
    /** @var string  */
    private $telefone = "";
    /** @var string  */
    private $cpf = "";
    /** @var string  */
    private $cnpj = "";
    /** @var string  */
    private $identificadorInterno = "";
    /** @var string  */
    private $email = "";

    public function __construct(Request $request = null)
    {
        if ( $request != null ) {
            $this->setDadosFromRequest($request);
        }
    }

    private function setDadosFromRequest(Request $request)
    {
        $this->id = $request->get('id');
        $this->primeiroNome = $request->get('primeiro_nome');
        $this->ultimoNome = $request->get('ultimo_nome');
        $this->telefone = $request->get('telefone');
        $this->cpf = $request->get('cpf');
        $this->cnpj = $request->get('cnpj');
        $this->identificadorInterno = $request->get('identificador_interno');
    }

    /**
     * @param string $id
     * @return ClienteMercadoPago
     */
    public function setId(?string $id): ClienteMercadoPago
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $primeiroNome
     * @return ClienteMercadoPago
     */
    public function setPrimeiroNome(string $primeiroNome): ClienteMercadoPago
    {
        $this->primeiroNome = $primeiroNome;
        return $this;
    }

    /**
     * @return string
     */
    public function getPrimeiroNome(): string
    {
        return $this->primeiroNome;
    }

    /**
     * @param string $ultimoNome
     * @return ClienteMercadoPago
     */
    public function setUltimoNome(string $ultimoNome): ClienteMercadoPago
    {
        $this->ultimoNome = $ultimoNome;
        return $this;
    }

    /**
     * @return string
     */
    public function getUltimoNome(): string
    {
        return $this->ultimoNome;
    }

    /**
     * @param string $telefone
     * @return ClienteMercadoPago
     */
    public function setTelefone(?string $telefone): ClienteMercadoPago
    {
        $this->telefone = $telefone;
        return $this;
    }

    /**
     * @return string
     */
    public function getTelefone(): ?string
    {
        return $this->telefone;
    }

    private function getTelefoneDDD(): string {
        return substr(preg_replace("/\D/", "", $this->getTelefone()),0,2);
    }

    private function getTelefoneNumero(): string {
        return substr(preg_replace("/\D/", "", $this->getTelefone()),2);
    }

    /**
     * @param string $cpf
     * @return ClienteMercadoPago
     */
    public function setCpf(string $cpf): ClienteMercadoPago
    {
        $this->cpf = $cpf;
        return $this;
    }

    /**
     * @return string
     */
    public function getCpf(): string
    {
        return $this->cpf;
    }

    /**
     * @param string $cnpj
     * @return ClienteMercadoPago
     */
    public function setCnpj(string $cnpj): ClienteMercadoPago
    {
        $this->cnpj = $cnpj;
        return $this;
    }

    /**
     * @return string
     */
    public function getCnpj(): string
    {
        return $this->cnpj;
    }

    /**
     * @param string $identificadorInterno
     * @return ClienteMercadoPago
     */
    public function setIdentificadorInterno(string $identificadorInterno): ClienteMercadoPago
    {
        $this->identificadorInterno = $identificadorInterno;
        return $this;
    }

    /**
     * @param string $email
     * @return ClienteMercadoPago
     */
    public function setEmail(string $email): ClienteMercadoPago
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getIdentificadorInterno(): string
    {
        return $this->identificadorInterno;
    }

    /**
     * @return array
     */
    public function preparar(): array
    {
        return [
            "email" => $this->getEmail(),
            "first_name" => $this->getPrimeiroNome(),
            "last_name" => $this->getUltimoNome(),
            "phone" => [
                "area_code" => $this->getTelefoneDDD(),
                "number" => $this->getTelefoneNumero()
            ],
            "identification" => [
                "type" => $this->getCpf() ? 'CPF' : $this->getCnpj() ? 'CNPJ' : "",
                "number" => $this->getCpf() ?: $this->getCnpj() ?: 0
            ],
            "description" => $this->getIdentificadorInterno()
        ];
    }
}
