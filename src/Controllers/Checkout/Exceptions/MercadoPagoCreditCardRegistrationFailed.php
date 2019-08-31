<?php

namespace SceLPI\MercadoPago\Controllers\Checkout\Exceptions;

use Throwable;

class MercadoPagoCreditCardRegistrationFailed extends \Exception {

    public function __construct($response)
    {
        $error = json_decode($response->error)->cause[0];
        if (is_array($error)) {
            $error = $error[0];
        }
        $this->message = "Código do erro: " . $error->code . ". ";
        switch( $error->code ) {
            case "E204":
                $this->message .= "Mês de expiração inválido.";
                break;
            case "E205":
                $this->message .= "Ano de expiração inválido.";
                break;
            case "100":
                $this->message .= "Credenciais MP Inválidas.";
	            break;
            case "101":
                $this->message .= "Usuário já existe.";
	            break;
            case "102":
            case "103":
            case "104":
            case "105":
            case "106":
            case "117":
            case "113":
            case "114":
            case "115":
            case "116":
            case "118":
            case "123":
            case "124":
            case "125":
            case "126":
            case "127":
            case "200":
            case "201":
            case "202":
            case "203":
            case "204":
            case "205":
            case "206":
            case "207":
            case "208":
                $this->message .= "Parametro de compra inválido.";
	            break;
            case "107":
            case "108":
                $this->message .= "Nome do usuário deve possuir 2 palavras no mínimo.";
	            break;
            case "109":
                $this->message .= "Código de área do telefone inválido.";
	            break;
            case "110":
                $this->message .= "Número do telefone inválido.";
	            break;
            case "111":
            case "112":
                $this->message .= "CPF do usuário inválido.";
	            break;
            case "119":
            case "121":
            case "122":
                $this->message .= "Os dados do cartão são inválidos.";
	            break;
            case "120":
                $this->message .= "Cartão não encontrado.";
	            break;
            case "128":
                $this->message .= "Seu email não foi aceito para o pagamento";
	            break;
            case "129":
                $this->message .= "Você ultrapassou o número máximo de cartões.";
	            break;
            case "140":
                $this->message .= "Dados do dono do cartão inválido.";
	            break;
            case "card-106":
                $this->message .= "Nome no cartão inválido.";
                break;
            default:
                $this->message .= "Não foi possível salvar o cartão. " . $error->description;
                break;

        }
    }
}
