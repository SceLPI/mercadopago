<?php

namespace SceLPI\MercadoPago\Controllers\Checkout\Exceptions;

use Throwable;

class MercadoPagoPaymentFailed extends \Exception {

    public function __construct($response)
    {
        $error = json_decode($response->error)->cause[0];
        if (is_array($error)) {
            $error = $error[0];
        }
        $this->message = "Código do erro: " . $error->code . ". ";
        switch( $error->code ) {
            case "3012":
            case "3013":
            case "3032":
                $this->message .= "Código de verificação do cartão inválido.";
                break;
            case "3015":
            case "3016":
            case "3033":
                $this->message .= "Número do cartão inválido.";
                break;
            case "3017":
            case "3018":
            case "3019":
            case "3020":
            case "3021":
            case "3022":
            case "3023":
                $this->message .= "Problemas com os dados do cartão cadastrado. ";
                break;
            case "3029":
            case "3030":
                $this->message .= "Mês ou ano de vencimento do cartão inválido.";
                break;
            default:
                $this->message .= "Falha ao processar pagamento. " . $error->description;
                break;

        }
    }

}
