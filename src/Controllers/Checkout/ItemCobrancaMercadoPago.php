<?php

namespace SceLPI\MercadoPago\Controllers\Checkout;

class ItemCobrancaMercadoPago {
    /** @var float  */
    private $precoUnitario = 0.0;
    /** @var int  */
    private $descricao = 0;
    /** @var int  */
    private $quantidade = 0;

    /**
     * @param float $precoUnitario
     * @return ItemCobrancaMercadoPago
     */
    public function setPrecoUnitario(float $precoUnitario): ItemCobrancaMercadoPago
    {
        $this->precoUnitario = $precoUnitario;
        return $this;
    }

    /**
     * @return float
     */
    public function getPrecoUnitario(): float
    {
        return $this->precoUnitario;
    }

    /**
     * @param int $descricao
     * @return ItemCobrancaMercadoPago
     */
    public function setDescricao(string $descricao): ItemCobrancaMercadoPago
    {
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * @return int
     */
    public function getDescricao(): int
    {
        return $this->descricao;
    }

    /**
     * @param int $quantidade
     * @return ItemCobrancaMercadoPago
     */
    public function setQuantidade(int $quantidade): ItemCobrancaMercadoPago
    {
        $this->quantidade = $quantidade;
        return $this;
    }

    /**
     * @return int
     */
    public function getQuantidade(): int
    {
        return $this->quantidade;
    }

    /**
     * @return float
     */
    public function getValorTotal(): float
    {
        return $this->getQuantidade()*$this->getPrecoUnitario();
    }
}