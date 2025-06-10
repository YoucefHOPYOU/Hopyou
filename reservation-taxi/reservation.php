<?php
require_once 'config.php';
require_once 'send-email.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $origin = $_POST['origin'];
    $destination = $_POST['destination'];
    $date = $_POST['date'];
    $time = substr($date, 11);         // Extrait l'heure depuis datetime-local
    $dateOnly = substr($date, 0, 10);   // Extrait la date seule
    $passengers = intval($_POST['passengers']);
    $luggage = intval($_POST['luggage']);
    $babySeat = isset($_POST['babySeat']) ? 1 : 0;
    $pet = isset($_POST['pet']) ? 1 : 0;
    $comment = $_POST['comment'] ?? '';
    $vehicleType = $_POST['vehicleType'];
    $totalPrice = floatval($_POST['totalPrice']);

    try {
        // Insère dans la base de données (remplace ... par les champs réels)
        $stmt = $pdo->prepare("INSERT INTO reservations_taxi_vtc (
                    name, email, phone, origin, destination, date, time, passengers,
                    luggage, baby_seat, pet, comment, vehicle_type, total_price
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->execute([
            $name, $email, $phone, $origin, $destination, $dateOnly, $time,
            $passengers, $luggage, $babySeat, $pet, $comment, $vehicleType, $totalPrice
        ]);

        // Envoyer les emails
        sendReservationConfirmation(
            $email,
            $name,
            $phone,
            $origin,
            $destination,
            $dateOnly,
            $time,
            $passengers,
            $luggage,
            $babySeat,
            $pet,
            $vehicleType,
            $totalPrice,
            $comment
        );

        sendAdminNotification(
            "contact@hopyou.net",
            $name,
            $email,
            $phone,
            $origin,
            $destination,
            $dateOnly,
            $time,
            $passengers,
            $luggage,
            $babySeat,
            $pet,
            $vehicleType,
            $totalPrice,
            $comment
        );

        // Rediriger vers la page de confirmation
        header("Location: confirmation.html");
        exit();
    } catch (PDOException $e) {
        die("Erreur lors de l'enregistrement : " . $e->getMessage());
    }
} else {
    http_response_code(405);
    echo "Méthode HTTP non autorisée.";
}
?>