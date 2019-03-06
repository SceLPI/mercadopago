<?php

namespace SceLPI\MercadoPago\Controllers\Checkout\Exceptions;

use Throwable;

class MercadoPagoFalhaNoEstorno extends \Exception {

    public function __construct($response)
    {
        $responseJson = json_decode($response->error)->cause[0];
        $this->message = "Código do erro: " . $responseJson->code . ". Mensagem: ";
        switch($responseJson->code) {
            case 2000:
                $this->message .= "Pagamento não encontrado";
                break;
            case 2063:
                $this->message .= "Estorno não permitiro para pagamento com o status atual";
                break;
            default:
                $this->message .= $responseJson->description;
        }
    }
}
