
<?php require_once 'app/index-code.php'; ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    
    <title>ToysRus - Jouets</title>
</head>

<body> 
    <div id="container">
        <?php require_once 'app/header.php'; ?>
        
        <div class="container-main">
            
            <div class="title">
                <h1>Les jouets</h1>
                <form method="GET"> <!-- Formulaire en méthode GET -->
                    <select name="brands">
                        <option value="none">Quelle marque ?</option> <!-- Valeur par défaut none -->
                        <?php
                            $result = brandsGetAll(false); // Fonction déjà appelée dans le header, juste pour rappel / Le false empêche de recréer les ul
                            foreach($result as $row) { // Boucle qui crée la liste des marques
                                 // Elle parcourt l'array $result qui contient le résultat de la fonction brandsGetAll
                                echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>'; // Donne comme value l'id du magasin et affiche son nom
                            }
                        ?>
                    </select>
                    <input type="submit" value="Ok"> <!-- Bouton submit -->
                </form>
            </div>
        
            <div class="container-toys">
                <?php 
                    // $brand_id se voit assigner le résultat de la requête GET(magasin) du form si elle n'est pas vide, sinon la valeur est none
                    $brand_id = isset($request['brands']) ? $request['brands'] : 'none'; 
                    // On vérifie que cette valeur est un entier, sinon on force le passage en none
                    $brand_id = is_numeric($brand_id) ? $brand_id : 'none';
                    toysDetails($brand_id); // On passe en paramètre dans la fonction l'id du magasin
                ?>
            </div>

        </div>
        
    </div>  
</body>
</html>