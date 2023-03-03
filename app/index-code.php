<?php

// Lance le config.php
require_once 'config.php';

// Lance le database.php
require_once 'database.php';

// Lance le data.php
require_once 'data.php';

// Crée une variable pour la méthode de requête
$request = requestMethod();


// function de récupération des marques avec un paramètre($default) facultatif(=) qui aura TRUE comme valeur définie si paramètre non précisé
function brandsGetAll(bool $default = true): array {

    // On déclare une variable de type array
    $array_brands=[];

    // On se connecte à la BDD
    $mysql = dbConnect();

    // On prépare la requête (sous requête qui fait le compte des jouets par marque sous alias total)
    $q_brands = 'SELECT brands.id, brands.name, (SELECT COUNT(*) FROM toys WHERE brand_id = brands.id ) as total FROM brands ';

    // On lance la requête / on "die" si la requête foire
    $r_brands = mysqli_query($mysql, $q_brands) or die('Erreur de requête !<br>'.$q_brands . '<br>'.mysqli_error());

    // On teste si la requête n'est pas vide
    if ( ! $r_brands ) {
        return $array_brands;
    }

    // On boucle pour récupérer les éléments($ev_brands) et les récupère en tableau associatif(mysqli_fetch_assoc) dans $array_brands
    while ( $ev_brands = mysqli_fetch_assoc($r_brands) ) {
        // Si $default = false, la liste des marques ne sera pas recréer
        if($default) { 
            echo'<li><a href="/list.php?brands='.$ev_brands['id'].'">'.$ev_brands['name'] . ' (' .  $ev_brands['total'] . ')' . '</a></li>';
        } 
  
        $array_brands[] = $ev_brands;
    }

    // On récupère le tableau associatif
    return $array_brands;
   
}

// Fonction de récupération des informations sur les magasins
function getAllStores(): array {
        // On déclare une variable de type array
        $array_stock=[];

        // On se connecte à la BDD
        $mysql = dbConnect();
    
        // On prépare la requête
        $q_stock = 'SELECT id, city FROM stores;'; 
    
        // On lance la requête / on "die" si la requête foire
        $r_stock = mysqli_query($mysql, $q_stock) or die('Erreur de requête !<br>'.$q_stock . '<br>'.mysqli_error());
     
        // On teste si la requête n'est pas vide
        if ( ! $r_stock ) {
            return $array_stock;
        }
    
        // On boucle pour récupérer les éléments($ev_brands) et les récupère en tableau associatif(mysqli_fetch_assoc) dans $array_brands
        while ( $ev_stock = mysqli_fetch_assoc($r_stock) ) {         
            $array_stock[] = $ev_stock;
        } 
    
        // On récupère le tableau associatif
        return $array_stock;
}

// Fonction similaire à la précédante, crée un tableau asso avec les détails de chaque jouet
function toysDetails(string $optional_id = 'none'): array {

    $array_toysDetails = [];

    $mysql = dbConnect();
    $q_details = 'SELECT toys.id, toys.name, `description`, `image`, `price`, brands.name AS `brands` FROM `toys` JOIN `brands` ON toys.brand_id = brands.id';
    if($optional_id != 'none') {
        $q_details .= ' WHERE toys.brand_id = ' . $optional_id;
    }
    $q_details .= ';';
    $r_details = mysqli_query($mysql, $q_details) or die('Erreur de requête !<br>'.$q_details . '<br>'.mysqli_error());
   

    if ( ! $r_details ) {
        return $array_toysDetails;
    }

    while( $ev_details = mysqli_fetch_assoc($r_details) ) {
        echo '<div class="toy">';
            echo '<a href="detail.php?toy_id='.$ev_details['id'].'">';
             
                    echo '<div class="toy-img">';
                        echo '<img src="img/'.$ev_details['image'].'">';
                    echo '</div>';
                    echo '<p class="toy-name">'.$ev_details['name'].'</p>';
                    echo '<p class="toy-price">';
                        echo str_replace('.',',',$ev_details['price']).' €</p>';
            echo '</a>';
        echo '</div>';
        
        $array_toysDetails[] = $ev_details;
    }

    return $array_toysDetails;

}
 
// Fonction qui donne le Top 3 des ventes
function salesTop(): array {

    $array_salesTop = [];

    $mysql = dbConnect();
    $q_sales = 'SELECT toys.id,`image`,`price`,`toy_id`, SUM(`quantity`) AS total,toys.name FROM `toys` JOIN `sales` ON toys.id = sales.toy_id GROUP BY toy_id ORDER BY total DESC LIMIT 3';
    $r_sales = mysqli_query($mysql, $q_sales) or die('Erreur de requête !<br>'.$q_sales . '<br>'.mysqli_error());
    

    if ( ! $r_sales ) {
        return $array_salesTop;
    }

    while( $ev_sales = mysqli_fetch_assoc($r_sales)   ) { 
        echo '<div class="toy">';
            echo '<a href="detail.php?toy_id='.$ev_sales['toy_id'].'">';
                 
                    echo '<span class="toy-img">';  
                        echo '<img src="img/'.$ev_sales['image'].'">';
                    echo '</span>';  
                    echo '<p class="toy-name">'.$ev_sales['name'].'</p>';
                    echo '<p class="toy-price">';
                        echo str_replace('.',',',$ev_sales['price']).' €</p>';
              
            echo '</a>';
        echo '</div>';

    $array_salesTop[] = $ev_sales;
    }

    return $array_salesTop;
}

// Fonction => id des jouets
function getToyById(string $id): array {
    
    $mysql = dbConnect();
    
    $query = mysqli_query($mysql, 'SELECT * FROM toys WHERE id = ' . $id . ';');
    $fetch = [];
    
    if($query) {
        $fetch = mysqli_fetch_array($query);
    }
    
    $result = !empty($fetch) ? $fetch : [];
    
    return $result;
}

// Fonction => id des magasins
function getBrandById(string $id): array {
    
    $mysql = dbConnect();
    
    $query = mysqli_query($mysql, 'SELECT * FROM brands WHERE id = ' . $id . ';');
    $fetch = mysqli_fetch_array($query);
    
    $result = !empty($fetch) ? $fetch : [];
    
    return $result;
}

// Fonction => id du jouet
function getStockByToyId(string $id): array {
    
    $mysql = dbConnect();
    
    $query = mysqli_query($mysql, 'SELECT toy_id, SUM(`quantity`) AS total FROM stock WHERE toy_id = ' .$id . ' GROUP BY toy_id ;');
    $fetch = mysqli_fetch_array($query);
    
    $result = !empty($fetch) ? $fetch : [];
    
    return $result;
}

// Fonction complémentaire => Récupère le stock par id du jouet et par id du magasin
function getStockByToyIdAndStoreId(string $toy_id, string $store_id): array {
    $mysql = dbConnect();
    
    $query = mysqli_query($mysql, 'SELECT toy_id, SUM(`quantity`) AS total FROM stock WHERE toy_id = ' . $toy_id . ' AND store_id = ' . $store_id . ' GROUP BY toy_id ;');
    $fetch = mysqli_fetch_array($query);
    
    $result = !empty($fetch) ? $fetch : [];
    
    return $result;
}

// Fermeture de la connection à la BDD 
dbClose();