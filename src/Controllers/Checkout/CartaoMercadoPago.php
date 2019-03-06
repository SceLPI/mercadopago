<?php

namespace SceLPI\MercadoPago\Controllers\Checkout;

use Illuminate\Http\Request;

class CartaoMercadoPago {

    /** @var string  */
    private $id = "";
    /** @var string */
    private $numero;
    /** @var string */
    private $ano;
    /** @var string */
    private $mes;
    /** @var string */
    private $nome;
    /** @var string */
    private $codigoDeSeguranca;
    /** @var string */
    private $cpf;

    public function __construct(Request $request = null)
    {
        if ( $request != null ) {
            $this->setDadosFromRequest($request);
        }
    }

    private function setDadosFromRequest(Request $request)
    {
        $dadosMercadoPago = $request->get('mercadopago');
        $dadosCartao = $dadosMercadoPago['cartao'];
        $this->id = array_key_exists('id', $dadosCartao) ?  $dadosCartao['id'] : null;
        $this->numero = preg_replace("/\D/", "", array_key_exists('numero', $dadosCartao) ? $dadosCartao['numero'] : null);
        $this->ano = array_key_exists('validade_ano', $dadosCartao) ? $dadosCartao['validade_ano'] : null;
        $this->mes = array_key_exists('validade_mes', $dadosCartao) ? $dadosCartao['validade_mes'] : null;
        $this->nome = array_key_exists('nome', $dadosCartao) ? $dadosCartao['nome'] : null;
        $this->cpf = preg_replace("/\D/", "", array_key_exists('cpf', $dadosCartao) ? $dadosCartao['cpf'] : null);
        $this->codigoDeSeguranca = array_key_exists('codigo_seguranca', $dadosCartao) ? $dadosCartao['codigo_seguranca'] : null;

    }

    /**
     * @param string $id
     * @return CartaoMercadoPago
     */
    public function setId(string $id): CartaoMercadoPago
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param mixed $numero
     * @return cartaoMercadoPago
     */
    public function setNumero($numero): CartaoMercadoPago
    {
        $this->numero = $numero;
        return $this;
    }

    /**
     * @param mixed $ano
     * @return cartaoMercadoPago
     */
    public function setAno($ano): CartaoMercadoPago
    {
        $this->ano = $ano;
        return $this;
    }

    /**
     * @param mixed $mes
     * @return cartaoMercadoPago
     */
    public function setMes($mes): CartaoMercadoPago
    {
        $this->mes = $mes;
        return $this;
    }

    /**
     * @param mixed $nome
     * @return cartaoMercadoPago
     */
    public function setNome($nome): CartaoMercadoPago
    {
        $this->nome = $nome;
        return $this;
    }

    /**
     * @param mixed $codigoDeSeguranca
     * @return cartaoMercadoPago
     */
    public function setCodigoDeSeguranca($codigoDeSeguranca): CartaoMercadoPago
    {
        $this->codigoDeSeguranca = $codigoDeSeguranca;
        return $this;
    }

    /**
     * @param mixed $cpf
     * @return cartaoMercadoPago
     */
    public function setCpf(string $cpf): CartaoMercadoPago
    {
        $this->cpf = $cpf;
        return $this;
    }

    public function preparar() {
        if ( $this->getId() ) {
            return [
                "card_id" => $this->getId(),
                "security_code" => $this->codigoDeSeguranca . ""
            ];
        }
        return [
            "card_number" => preg_replace("/\D/", "", $this->numero),
            "expiration_year" => $this->ano,
            "expiration_month" => $this->mes,
            "cardholder" => [
                "name" => $this->nome,
                "identification" => [
                    "type" => "CPF",
                    "number" => preg_replace("/\D/", "", $this->cpf)
                ]
            ],
            "security_code" => $this->codigoDeSeguranca . ""
        ];
    }
}
