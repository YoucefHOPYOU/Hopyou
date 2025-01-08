<?php
// Tableau des redirections
$redirects = [
    "/ancienne-page-1.html" => "https://www.hopyou.net/nouvelle-page-1.html",
    "/ancienne-page-2.html" => "https://www.hopyou.net/nouvelle-page-2.html",
    "/ancienne-page-3.html" => "https://www.hopyou.net/nouvelle-page-3.html",
    "/taxi-gare-de-lest.html" => "https://www.hopyou.net/taxi-gare-de-l-est.html",
    "/taxi-gare-de-l%27est.html" => "https://www.hopyou.net/taxi-gare-de-l-est.html",
    "/taxi-gare-de-l%2527est.html" => "https://www.hopyou.net/taxi-gare-de-l-est.html",
];

// Décoder l'URL demandée
$request_uri = urldecode($_SERVER['REQUEST_URI']);

// Vérifie si l'URL demandée doit être redirigée
if (array_key_exists($request_uri, $redirects)) {
    header("Location: " . $redirects[$request_uri], true, 301);
    exit;
}

// Si aucune redirection n'est définie, afficher une erreur 404
header("HTTP/1.0 404 Not Found");
echo "Page introuvable.";
exit;
?>

