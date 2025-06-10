<?php
function sendReservationConfirmation($clientEmail, $name, $phone, $origin, $destination, $date, $time, $passengers, $luggage, $babySeat, $pet, $vehicleType, $totalPrice, $comment = '') {
    // Email au client
    $subjectClient = "✅ Confirmation de votre réservation - Hopyou.net";

    $messageClient = '
    <html>
      <body style="font-family: Arial, sans-serif; line-height: 1.6;">
        <h2 style="color: #28a745;">Bonjour ' . htmlspecialchars($name) . ',</h2>
        <p>Merci pour votre demande de réservation. Voici les détails :</p>

        <ul>
          <li><strong>Téléphone :</strong> ' . htmlspecialchars($phone) . '</li>
          <li><strong>Adresse de départ :</strong> ' . htmlspecialchars($origin) . '</li>
          <li><strong>Adresse d\'arrivée :</strong> ' . htmlspecialchars($destination) . '</li>
          <li><strong>Date :</strong> ' . htmlspecialchars($date) . '</li>
          <li><strong>Heure :</strong> ' . htmlspecialchars($time) . '</li>
          <li><strong>Passagers :</strong> ' . intval($passengers) . '</li>
          <li><strong>Bagages :</strong> ' . intval($luggage) . '</li>
          <li><strong>Type de véhicule :</strong> ' . htmlspecialchars($vehicleType) . '</li>
          <li><strong>Prix total :</strong> <strong>' . floatval($totalPrice) . ' €</strong></li>
          <li><strong>Options sélectionnées :</strong><br>
            - Siège bébé : ' . ($babySeat ? 'Oui' : 'Non') . '<br>
            - Animal de compagnie : ' . ($pet ? 'Oui' : 'Non') . '
          </li>
          <li><strong>Commentaire :</strong> ' . (!empty($comment) ? htmlspecialchars($comment) : 'Aucun commentaire') . '</li>
        </ul>

        <p>Nous reviendrons vers vous rapidement pour confirmer votre réservation.</p>
        <p>Cordialement,<br><strong>Hopyou.net</strong></p>
      </body>
    </html>';

    // En-têtes
    $headers = "From: contact@hopyou.net\r\n";
    $headers .= "Reply-To: contact@hopyou.net\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    // Envoi de l'email au client
    mail($clientEmail, $subjectClient, $messageClient, $headers);
}

function sendAdminNotification($adminEmail, $name, $email, $phone, $origin, $destination, $date, $time, $passengers, $luggage, $babySeat, $pet, $vehicleType, $totalPrice, $comment = '') {
    // Email à toi (admin)
    $subjectAdmin = "🚨 Nouvelle réservation reçue - Hopyou.net";

    $messageAdmin = '
    <html>
      <body style="font-family: Arial, sans-serif; line-height: 1.6;">
        <h2 style="color: #007bff;">Nouvelle réservation</h2>
        <p>Une nouvelle réservation vient d\'être effectuée par :</p>

        <ul>
          <li><strong>Nom complet :</strong> ' . htmlspecialchars($name) . '</li>
          <li><strong>Email :</strong> ' . htmlspecialchars($email) . '</li>
          <li><strong>Téléphone :</strong> ' . htmlspecialchars($phone) . '</li>
          <li><strong>Adresse de départ :</strong> ' . htmlspecialchars($origin) . '</li>
          <li><strong>Adresse d\'arrivée :</strong> ' . htmlspecialchars($destination) . '</li>
          <li><strong>Date :</strong> ' . htmlspecialchars($date) . '</li>
          <li><strong>Heure :</strong> ' . htmlspecialchars($time) . '</li>
          <li><strong>Passagers :</strong> ' . intval($passengers) . '</li>
          <li><strong>Bagages :</strong> ' . intval($luggage) . '</li>
          <li><strong>Type de véhicule :</strong> ' . htmlspecialchars($vehicleType) . '</li>
          <li><strong>Prix total :</strong> <strong>' . floatval($totalPrice) . ' €</strong></li>
          <li><strong>Options sélectionnées :</strong><br>
            - Siège bébé : ' . ($babySeat ? 'Oui' : 'Non') . '<br>
            - Animal de compagnie : ' . ($pet ? 'Oui' : 'Non') . '
          </li>
          <li><strong>Commentaire :</strong> ' . (!empty($comment) ? htmlspecialchars($comment) : 'Aucun commentaire') . '</li>
        </ul>
      </body>
    </html>';

    // En-têtes
    $headers = "From: contact@hopyou.net\r\n";
    $headers .= "Reply-To: $email <$email>\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    // Envoi de l'email à l'admin
    mail($adminEmail, $subjectAdmin, $messageAdmin, $headers);
}
?>