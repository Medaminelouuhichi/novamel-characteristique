<?php

$to = 'adel.jebara@mel.ind.tn';

if (isset($_POST)) {

    $name = trim(stripslashes($_POST['contactName']));
    $email = trim(stripslashes($_POST['contactEmail']));
    $ComName = trim(stripslashes($_POST['nomSte']));
    $contact_message = trim(stripslashes($_POST['contactMessage']));

    // Check Name
    if (strlen($name) < 2) {
        $error['contactName'] = "Per favore inserisci il tuo nome e cognome.";
    }
    // Check Email
    if (!preg_match('/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*+[a-z]{2}/is', $email)) {
        $error['contactEmail'] = "Si prega di inserire un indirizzo email valido.";
    }
    // Check Message
    if (strlen($contact_message) < 10) {
        $error['contactMessage'] = "Inserisci il tuo messaggio. Deve contenere almeno 10 caratteri.";
    }
    // Subject
    if ($ComName == '') {
        $ComName = "Invio del modulo di contatto";
    }


    // Message
    $message = "<span style='font-size:25px; font-weight:bold;'>E-mail da : </span><span style='font-size:19px;'><i> " . $name . " </i></span><br>";
    $message .= "<span style='font-size:25px; font-weight:bold;'>Indirizzo email : </span><span style='font-size:19px;'><i> " . $email . " </i></span><br>";
    $message .= "<span style='font-size:25px; font-weight:bold;'>Società : </span><span style='font-size:20px;'><b> " . $ComName . " </b></span><br>";
    $message .= "<h3>Messaggio : </h3><p style='font-family: 'Times New Roman', serif;font-size:18px;color:black;'>";
    $message .= $contact_message."</p>";
    $message .= '<br /><br /><br /><hr> <i>Questa email è stata inviata dal formulario di contatto del sito web <a href="http://www.novamel.tn/">NOVAMEL</a>.</i><br>';
    //headers
    // Set From: header
    $from =  $name . " <" . $email . ">";

    // Email Headers
    $header = "From: " . $from . "\r\n";
    $header .= "Reply-To: " . $email . "\r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-Type: text/html; charset=utf-8\r\n";


    if (isset($error)) {
        $response = (isset($error['contactName'])) ? $error['contactName'] . "<br /> \n" : null;
        $response .= (isset($error['contactEmail'])) ? $error['contactEmail'] . "<br /> \n" : null;
        $response .= (isset($error['contactMessage'])) ? $error['contactMessage'] . "<br />" : null;
        echo $response;
    } # end if - no validation error

    else {

        ini_set("sendmail_from", $to);
        $mail = mail($to, $ComName, $message, $header);

        if ($mail) {
            echo "OK";
        } else {
            echo "C'è stato un errore. Riprova.";
        }
    }
}
?>