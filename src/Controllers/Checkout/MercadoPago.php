<?php

namespace SceLPI\MercadoPago\Controllers\Checkout;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MercadoPago extends Controller
{

    private $url = "https://api.mercadopago.com/";
    private $token = "";

    /**
     * @param Request $request
     * @param bool $asObject
     * @return \Illuminate\Http\JsonResponse|array
     */
    public function buscarCliente(ClienteMercadoPago $clienteMercadoPago): ?\StdClass
    {

        $resposta = (new MercadoPagoRequest)
            ->addQueryParam([
                'email' => $clienteMercadoPago->getEmail(),
                'limit' => 100
            ])
            ->setUrl('v1/customers/search')
            ->execute();

        if ( !isset($resposta->error) ) {
            return isset($resposta->results[0]) ? $resposta->results[0] : null;
        }

    }

    public function cadastrarCliente(ClienteMercadoPago $clienteMercadoPago)
    {

        $mp_dados = $this->buscarCliente($clienteMercadoPago);

        if ( $mp_dados ) {
            return $mp_dados;
        }

        $mp = (new MercadoPagoRequest)
            ->setUrl('v1/customers')
            ->setMethod('POST')
            ->setJson($clienteMercadoPago->preparar());

        $resposta = $mp->execute();

        return $resposta;
    }

    public function criarTokenDoCartao(CartaoMercadoPago $cartaoMercadoPago)
    {
        return (new MercadoPagoRequest)
            ->setMethod('POST')
            ->setUrl('v1/card_tokens')
            ->setJson($cartaoMercadoPago->preparar())
            ->execute();
    }

    public function anexarCartaoAoCliente(ClienteMercadoPago $clienteMercadoPago, TokenCartaoMercadoPago $tokenCartaoMercadoPago)
    {
        return (new MercadoPagoRequest)
            ->setMethod('POST')
            ->setUrl('v1/customers/' . $clienteMercadoPago->getId() . '/cards')
            ->setJson($tokenCartaoMercadoPago->preparar())
            ->execute();
    }

    public function buscarCartoesSalvos(ClienteMercadoPago $clienteMercadoPago)
    {

        if (!$clienteMercadoPago->getId()) {
            return response()->json([]);
        }

        $mp = (new MercadoPagoRequest(false))
            ->setUrl('v1/customers/' . $clienteMercadoPago->getId() . "/cards")
            ->setMethod('GET');

        return $mp->execute();
    }

    public function deletarCartao(ClienteMercadoPago $clienteMercadoPago, CartaoMercadoPago $cartaoMercadoPago)
    {
        return (new MercadoPagoRequest(false))
            ->setMethod('DELETE')
            ->setUrl('v1/customers/' . $clienteMercadoPago->getId() . '/cards/' . $cartaoMercadoPago->getId())
            ->execute();
    }

    public function criarCobranca(CobrancaMercadoPago $cobranca) {
        $mp = (new MercadoPagoRequest)
            ->setMethod('POST')
            ->setUrl('v1/payments')
            ->setJson($cobranca->preparar());

        return $mp->execute();
    }

    public function estorno($gatewayId)
    {
        return (new MercadoPagoRequest(false))
            ->setMethod('POST')
            ->setUrl('v1/payments/' . $gatewayId . '/refunds')
            ->execute();
    }

}