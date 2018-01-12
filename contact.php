<?php

// configure
$from = 'comercial@atlanticlines.com.br';
$sendTo = 'comercial@atlanticlines.com.br';
$subject = 'Nova mensagem enviada pelo site.';
$fields = array('name' => 'Nome', 'email' => 'Email', 'subject' => 'Assunto', 'message' => 'Mensagem'); // array variable name => Text to appear in the email
$okMessage = 'Formulário de contato enviado com sucesso! Obrigado, iremos responder você em breve!';
$errorMessage = 'Ocorreu um erro ao enviar o formulário. Por favor, tente novamente mais tarde.';

// let's do the sending

try
{
    $emailText = "";

    foreach ($_POST as $key => $value) {

        if (isset($fields[$key])) {
            $emailText .= "$fields[$key]: $value\n";
        }
    }

    $headers = array('Content-Type: text/plain; charset="UTF-8";',
        'From: ' . $from,
        'Reply-To: ' . $from,
        'X-Mailer: PHP/' . phpversion(),
    );
    
    mail($sendTo, $subject, $emailText, implode("\n", $headers));

    $responseArray = array('type' => 'success', 'message' => $okMessage);
}
catch (\Exception $e)
{
    $responseArray = array('type' => 'danger', 'message' => $errorMessage);
}

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $encoded = json_encode($responseArray);

    header('Content-Type: application/json');

    echo $encoded;
}
else {
    echo $responseArray['message'];
}
