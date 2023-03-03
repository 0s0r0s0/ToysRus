<?php 
require_once 'app/index-code.php'; 
require_once 'app/data.php';
?>

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
    <?php require_once 'app/header.php';?>
    
    <main>
    
    
    <?php $request = requestMethod(); // Récupération de la requête serveur pour tester si un id jouet ou magasin est passé dans l'URL
    // Si le résultat de la requête est non défini, $toy_id prend pour valeur none, sinon il récupère l'id du toy
    $toy_id = !isset($request['toy_id']) ? 'none' : $request['toy_id'];  
    // $selected_store récupère soit la valeur store de la requête si existante soit none
    $selected_store = isset($request['store']) ? $request['store'] : 'none';

    
    if ($toy_id != 'none') { // Si $toy_id a une valeur autre que none
        // On assigne à la variable $toy le réultat de la fonction avec en paramètre $toy_id(id d'un jouet)
        $toy = getToyById($toy_id);
        // Si le résultat ne donne pas de résultat (id inexistante) on gére l'erreur
        if(empty($toy)) {
            // Message d'erreur en cas de mauvaise manipulation de l'URL
            echo '<div class="error-url">';
            echo '<p>Oops... Hacker spotted!<br> Veuillez allez faire joujou avec les URL de la <a class="oops" href="https://www.nasa.gov/">NASA</a>!</p>';
            echo '<img class="tonton" src="img/tonton.png">';
            echo '<p>Ou retournez sagement à l\'<a class="accueil" href="/index.php">accueil</a></p>';
            echo '</div>';
            die();
        }

        // $brand prend comme valeur le nom du magasin grace à son id
        $brand = getBrandById($toy['brand_id']);
        // Si aucun magasin n'est sélectionné, le stock est défini par jouet, sinon il est affiné par magasin
        $stock = $selected_store == 'none' ? getStockByToyId($toy_id) : getStockByToyIdAndStoreId($toy_id, $selected_store);
        // Le total du stock prend comme valeur soit le contenu défini dans $stock si existant soit il est défini à 0
        $stock['total'] = isset($stock['total']) ? $stock['total'] : '0';

        if(!empty($toy)) { // Si la variable $toy est définie, on affiche alors le sétail du jouet
            echo '<div class="title"><h1>'.$toy['name'].'</h1></div>';
            echo '<div class="bloc-description">';
                echo '<div class="bloc-l">';
                    echo '<span class="toy-img">';
                        echo '<img src="img/'.$toy['image'].'">';
                    echo '</span>';
                    echo '<span class="toy-price">';
                        // str_replace(valeur à remplacer, valeur de remplacement, cible du remplacement)
                        echo str_replace('.',',',$toy['price']).' €</span>'; 
                        ?>
                        <form method="GET">
                        <select name="store">
                            <option value="none">Quel magasin ?</option>
                            <?php
                                
                                $result = getAllStores();
                                foreach($result as $row) {
                                    echo '<option';
                                    if($row['id'] == $selected_store) { echo ' selected'; }
                                    echo ' value="' . $row['id'] . '">' . $row['city'] . '</option>';
                                }
                            ?>
                        </select>
                            <input type="hidden" name="toy_id" value="<?php echo isset($_GET['toy_id']) ? $_GET['toy_id'] : 'none'; ?>">
                            <input type="submit" value="Ok">
                        </form>

                <?php // Echo du stock, du nom du magasin et de la description du jouet
                    echo '<p class=result-brand-stock><span class="name-brand-stock">Stock:</span> '. $stock['total'] .'</p>';
            
                echo '</div>';
                
                echo '<div class="bloc-r">';
                    echo'<p class="result-brand-stock"><span class="name-brand-stock">Marque:</span> '.$brand['name'].'</p>';
                    echo $toy['description'];
                echo '</div>';
            echo '</div>';
        }
        else {
            echo '<label>Le jouet demandé n\'existe pas :/</label>';
        }
    }
    else {
        echo '<label>Le jouet demandé n\'existe pas :/</label>';
    }
    ?>  


    </main>
    </div>
</body>
</html>
