<?php

namespace SceLPI\MercadoPago\Controllers\Checkout\Exceptions;

use Throwable;

class MercadoPagoPaymentRejected extends \Exception {

    public function __construct($response)
    {
        switch( $response->status_detail ) {
            case "pending_review_manual":
            case "pending_contingency":
                $this->message = "Seu pedido demorou muito para ser aprovado, tente novamente";
                break;
            case "cc_rejected_bad_filled_card_number":
                $this->message = "Seu pedido foi recusado: Confira o número do cartão.";
                break;
            case "cc_rejected_bad_filled_date":
                $this->message = "Seu pedido foi recusado: Confira a data de validade do cartão.";
                break;
            case "cc_rejected_bad_filled_other":
                $this->message = "Seu pedido foi recusado: Confira os dados do cartão.";
                break;
            case "cc_rejected_bad_filled_security_code":
                $this->message = "Seu pedido foi recusado: Confira o código de segurança do cartão.";
                break;
            case "cc_rejected_blacklist":
                $this->message = "Seu pedido foi recusado: Pagamento não foi aprovado, cartão foi recusado.";
                break;
            case "cc_rejected_other_reason":
            case "cc_rejected_card_error":
                $this->message = "Seu pedido foi recusado: Não foi possível processar o pagamento.";
                break;
            case "cc_rejected_call_for_authorize":
                $this->message = "Seu pedido foi recusado: O cliente precisa autorizar Mercado Pago com forma de pagamento.";
                break;
            case "cc_rejected_card_disabled":
                $this->message = "Seu pedido foi recusado: Seu cartão não está ativo.";
                break;
            case "cc_rejected_duplicated_payment":
                $this->message = "Seu pedido foi recusado: Pagamento em duplicidade foi recusado.";
                break;
            case "cc_rejected_high_risk":
                $this->message = "Seu pedido foi recusado: Pagamento não foi aceito pela operadora devido problemas de segurança.";
                break;
            case "cc_rejected_insufficient_amount":
                $this->message = "Seu pedido foi recusado: Saldo insuficiente.";
                break;
            case "cc_rejected_invalid_installments":
                $this->message = "Seu pedido foi recusado: Seu cartão não aceita pagamentos parcelados.";
                break;
            case "cc_rejected_max_attempts":
                $this->message = "Seu pedido foi recusado: Número de tentativas de pagamento excedida.";
                break;
            default:
                $this->message = "Seu pedido foi recusado: Motivo desconhecido ({$response->status_detail})";
                break;

        }
    }
}
