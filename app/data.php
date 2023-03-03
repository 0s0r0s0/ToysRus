<?php

// Fonction méthode de requête
function requestMethod(): array {

    // Déclaration d'une variable array vide
    $r_method = [];

    // Test si la méthode est GET et dans ce cas renvoie $_GET(contenu de la requête GET) à $r_method(tableau) 
    if($_SERVER['REQUEST_METHOD'] === 'GET') {
        $r_method = $_GET;
    }
    // Test si la méthode est POST et renvoie donc $_POST
    else if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $r_method = $_POST;
    }
    
    // Retourne le tableau avec la requête GET ou POST / Tableau vide si ni GET ni POST
    return $r_method;
}