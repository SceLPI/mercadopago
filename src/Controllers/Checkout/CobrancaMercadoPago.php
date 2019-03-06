<?php

namespace SceLPI\MercadoPago\Controllers\Checkout;

class CobrancaMercadoPago {

    /** @var float  */
    private $valor = 0.0;
    /** @var string  */
    private $pagadorId = "";
    /** @var int  */
    private $parcelas = 1;
    /** @var string  */
    private $descricao = "";
    /** @var bool  */
    private $binario = true;
    /** @var ItemCobrancaMercadoPago[]  */
    private $items = [];
    /** @var string  */
    private $token = "";

    /**
     * @param int $valor
     * @return CobrancaMercadoPago
     */
    public function setValor(float $valor): CobrancaMercadoPago
    {
        $this->valor = $valor;
        return $this;
    }

    /**
     * @return int
     */
    public function getValor(): float
    {
        return $this->valor;
    }

    /**
     * @param string $payerId
     * @return CobrancaMercadoPago
     */
    public function setPagadorId(string $payerId): CobrancaMercadoPago
    {
        $this->pagadorId = $payerId;
        return $this;
    }

    /**
     * @return string
     */
    public function getPagadorId(): string
    {
        return $this->pagadorId;
    }

    /**
     * @param int $parcelas
     * @return CobrancaMercadoPago
     */
    public function setParcelas(int $parcelas): CobrancaMercadoPago
    {
        $this->parcelas = $parcelas;
        return $this;
    }

    /**
     * @return int
     */
    public function getParcelas(): int
    {
        return $this->parcelas;
    }

    /**
     * @param string $descricao
     * @return CobrancaMercadoPago
     */
    public function setDescricao(string $descricao): CobrancaMercadoPago
    {
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescricao(): string
    {
        return $this->descricao;
    }

    /**
     * @param bool $binario
     * @return CobrancaMercadoPago
     */
    public function setBinario(bool $binario): CobrancaMercadoPago
    {
        $this->binario = $binario;
        return $this;
    }

    /**
     * @return bool
     */
    public function isBinario(): bool
    {
        return $this->binario;
    }

    /**
     * @param ItemCobrancaMercadoPago $item
     * @return CobrancaMercadoPago
     */
    public function addItem(ItemCobrancaMercadoPago $item): CobrancaMercadoPago
    {
        $this->items[] = $item;
        return $this;
    }

    /**
     * @param ItemCobrancaMercadoPago[] $items
     * @return CobrancaMercadoPago
     */
    public function setItems(ItemCobrancaMercadoPago ...$items): CobrancaMercadoPago
    {
        $this->items = $items;
        return $this;
    }

    /**
     * @return ItemCobrancaMercadoPago[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param string $token
     * @return CobrancaMercadoPago
     */
    public function setToken(string $token): CobrancaMercadoPago
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
     * @return array
     */
    public function preparar() : array {
        $return = [];
        if ( count($this->getItems()) ) {
            $return['transaction_amount'] = 0;
            foreach( $this->getItems() as $item) {
                $return['transaction_amount'] += $item->totalAmmount();
            }
        } else {
            $return['transaction_amount'] = $this->getValor();
        }
        $return['token'] = $this->getToken();
        $return['payer'] = [];
        $return['payer']['id'] = $this->getPagadorId();
        $return['installments'] = $this->getParcelas();
        $return['description'] = $this->getDescricao();
        $return['binary_mode'] = $this->isBinario();

        return $return;
    }

}