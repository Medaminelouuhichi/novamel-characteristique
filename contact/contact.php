<?php

$to = 'adel.jebara@mel.ind.tn';

if (isset($_POST)) {

    $name = trim(stripslashes($_POST['contactName']));
    $email = trim(stripslashes($_POST['contactEmail']));
    $ComName = trim(stripslashes($_POST['nomSte']));
    $contact_message = trim(stripslashes($_POST['contactMessage']));

    // Check Name
    if (strlen($name) < 2) {
        $error['contactName'] = "S'il vous plaît entrez votre nom et prénom.";
    }
    // Check Email
    if (!preg_match('/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*+[a-z]{2}/is', $email)) {
        $error['contactEmail'] = "S'il vous plaît, mettez une adresse email valide.";
    }
    // Check Message
    if (strlen($contact_message) < 10) {
        $error['contactMessage'] = "Veuillez entrer votre message. Il doit avoir au moins 10 caractères.";
    }
    // Subject
    if ($ComName == '') {
        $ComName = "Soumission du formulaire de contact";
    }


    // Message
    $message = "<span style='font-size:25px; font-weight:bold;'>E-mail de : </span><span style='font-size:19px;'><i> " . $name . " </i></span><br>";
    $message .= "<span style='font-size:25px; font-weight:bold;'>Adresse e-mail : </span><span style='font-size:19px;'><i> " . $email . " </i></span><br>";
    $message .= "<span style='font-size:25px; font-weight:bold;'>Société : </span><span style='font-size:20px;'><b> " . $ComName . " </b></span><br>";
    $message .= "<h3>Message : </h3>";
    $message .= "<p style='font-family: 'Times New Roman', serif;font-size:18px;color:black;'>" . $contact_message . "</p>";
    $message .= '<br /><br /><br /><hr> <i>Cet e-mail a été envoyé depuis le formulaire de contact de site web <a href="http://www.novamel.tn/">NOVAMEL</a>.</i><br>';

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
            echo "Une erreur s'est produite. Veuillez réessayer.";
        }
    }
}
?>