<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $depart = htmlspecialchars(trim($_POST['depart']));
    $arrivee = htmlspecialchars(trim($_POST['arrivee']));
    $personnes = intval($_POST['personnes']);
    $bagages = intval($_POST['bagages']);
    $date = htmlspecialchars(trim($_POST['date']));
    $time = htmlspecialchars(trim($_POST['time']));
    
    // Vérification de la catégorie
    if (isset($_POST['category'])) {
        $category = htmlspecialchars(trim($_POST['category']));
    } else {
        echo "Erreur : veuillez sélectionner une catégorie.";
        exit;
    }

    // Adresse de réception
    $to = "contact@hopyou.net";

    // Sujet de l'email
    $subject = "Nouvelle demande de devis";

    // Contenu de l'email
    $message = "Vous avez reçu une nouvelle demande de devis :\n\n";
    $message .= "Nom complet : $name\n";
    $message .= "Adresse e-mail : $email\n";
    $message .= "Numéro de téléphone : $phone\n";
    $message .= "Adresse de départ : $depart\n";
    $message .= "Adresse d'arrivée : $arrivee\n";
    $message .= "Nombre de personnes : $personnes\n";
    $message .= "Nombre de bagages : $bagages\n";
    $message .= "Date : $date\n";
    $message .= "Heure : $time\n";
    $message .= "Catégorie choisie : $category\n";

    // Envoi de l'email
    $headers = "From: contact@hopyou.net\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    if (mail($to, $subject, $message, $headers)) {
        header("Location: merci.html");
        exit;
    } else {
        echo "Erreur : votre message n'a pas pu être envoyé. Veuillez réessayer.";
    }
}
