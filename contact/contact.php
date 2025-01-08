<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération et sécurisation des données
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $subject = htmlspecialchars(trim($_POST['subject']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Vérification de l'adresse e-mail
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Adresse e-mail invalide.";
        exit;
    }

    // Adresse e-mail de réception
    $to = "contact@hopyou.net"; // Remplacez par votre adresse e-mail Hostinger

    // Sujet de l'e-mail
    $email_subject = "Nouveau message de contact : " . $subject;

    // Contenu de l'e-mail
    $email_body = "Vous avez reçu un nouveau message de contact.\n\n";
    $email_body .= "Nom : $name\n";
    $email_body .= "Email : $email\n";
    $email_body .= "Message :\n$message\n";

    // En-têtes de l'e-mail
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Envoi de l'e-mail
    if (mail($to, $email_subject, $email_body, $headers)) {
        echo "Merci, votre message a été envoyé avec succès.";
    } else {
        echo "Erreur : votre message n'a pas pu être envoyé. Veuillez réessayer.";
    }
} else {
    echo "Méthode non autorisée.";
}
?>



