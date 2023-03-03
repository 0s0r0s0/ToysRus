<?php require_once 'app/index-code.php';?> 
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    
    <title>ToysRus - Accueil</title>
</head>
<body> 
<div id="container">
<?php require_once 'app/header.php'; ?>
    
        <div class="container-main">
                <div class="title"><h1>Top 3 des ventes</h1></div>
            <div class="container-toys">
                <?php salesTop();?> <!-- Fonction d'affichage du TOP 3 pour la page d'accueil -->
                    
            </div>
        </div>
    
</div>
</body>
</html>