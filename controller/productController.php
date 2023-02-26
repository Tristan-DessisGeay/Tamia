<?php

require_once('model/ProductModel.php');
require_once('model/SiteModel.php');

class ProductController {
    public static function show() {
        if(SiteModel::testUserEtSiteCorrects($_SESSION['id_u'], $_GET['id_s'])) {
            if(isset($_GET['search'])) {
                $search = $_GET['search'];
            }else {
                $search = '';
            }
            if(isset($_GET['num_page'])) {
                $num_page = intval($_GET['num_page'])-1;
            }else {
                $num_page = 0;
            }
            if(isset($_GET['path_p'])) {
                $path_p = rtrim($_GET['path_p'], '/');
            }else {
                $path_p = 'Tous les produits';
            }
            if(isset($_GET['order'])) {
                $order = $_GET['order'];
            }else {
                $order = 'c';
            }
            list($products, $totalPage, $currentPage) = ProductModel::getProducts($search, $num_page, $path_p, $order, $_GET['id_s']);
            $libelle = SiteModel::getLibelleFromID($_GET['id_s']);
            $currentPath = $path_p.'/';
            $orderC = ($order=='c'||$order=='ca') ? 'checked' : '';
            $orderA = ($order=='a'||$order=='ca') ? 'checked' : '';
            $paths = ProductModel::getAllPathsFromSiteID($_GET['id_s']);
            $paths_dict = array();
            $paths_dict['Tous les produits/'] = [[], true, true];
            foreach($paths as $path_p) {
                // echo '<br>'.$path_p[0].'<br>Content: ';
                $pp= explode("/", $path_p[0]);
                for($i=0;$i<count($pp);$i++) {
                    $label = '';
                    for($j=0;$j<=$i;$j++) $label.=$pp[$j].'/';
                    // echo $pp[$i].';';
                    if(array_key_exists($label, $paths_dict)) {
                        // echo 5;
                        if($i==count($pp)-1) $paths_dict[$label][1] = true;
                        if($i+1<count($pp)&&!in_array($label.$pp[$i+1].'/', $paths_dict[$label][0])) {
                            // echo 6;
                            array_push($paths_dict[$label][0], $label.$pp[$i+1].'/');
                        }
                    }else {
                        // echo 7;
                        $paths_dict[$label] = [($i+1<count($pp)) ? [$label.$pp[$i+1].'/'] : [], ($i==count($pp)-1) ? true : false, ($i==0) ? true : false];
                    }
                }
            }
            // echo '<br>>Test<<br>';
            // foreach($paths_dict as $path_p => $values) {
            //     echo $path_p.' -> '.implode(';', $values[0]).' - '.$values[1].' - '.$values[2].'<br>';
            // }
            require_once('view/myproducts.php');
        }else {
            require_once('view/home.php');
        }
    }
    public static function delete() {
        if(ProductModel::testUserEtProduitCorrects($_SESSION['id_u'], $_GET['id_p'])) {
            $libelle = ProductModel::deleteFromID($_GET['id_p']);
            $msg = 'Votre produit "'.$libelle.'" a été supprimé avec succès !';
            $params = 'action=myproducts&id_s='.$_GET['id_s'].'&order='.$_GET['order'].'&search='.$_GET['search'];
            require_once('view/productDeleteSucced.php');
        }else {
            require_once('view/home.php');
        }
    }
    public static function created() {
        if(!isset($_POST['id_p'])) {
            $product = new ProductModel();
            $product->build(array(
                'id_s' => $_POST['id_s'],
                'id_p' => null,
                'libelle_p' => $_POST['libelle'],
                'image_url_p' => $_POST['image_url'],
                'path_p' => $_POST['path'],
                'event_p' => $_POST['event'],
                'frequence_p' => $_POST['frequence'],
                'eventlist_p' => $_POST['eventlist']
            ));
            $product->saveSQL();
            $msg = 'Votre nouveau produit : "'.$_POST['libelle'].'" a été créé avec succès !';
            $id_p = $product->get('id_p');
            require_once('view/createdProductSucced.php');
        }else {
            $product = new ProductModel();
            $product->build(array(
                'id_s' => $_POST['id_s'],
                'id_p' => $_POST['id_p'],
                'libelle_p' => $_POST['libelle'],
                'image_url_p' => $_POST['image_url'],
                'path_p' => $_POST['path'],
                'frequence_p' => $_POST['frequence']
            ));
            $product->saveSQL();
            $msg = 'Votre produit : "'.$_POST['libelle'].'" a été mis à jour !';
            $id_p = $product->get('id_p');
            require_once('view/createdProductSucced.php');
        }
    }
    public static function create() {
        $msg = 'Valider';
        $title = 'Créons un nouveau produit !';
        $libelle = '';
        $image_url = 'assets/image/noisette.jpg';
        $event = '';
        $frequence = 2;
        $eventlist = '';
        $path_p = 'Tous les produits';
        require_once('view/createProduct.php');
    }
    public static function update() {
        if(ProductModel::testUserEtProduitCorrects($_SESSION['id_u'], $_GET['id_p'])) {
            $product = ProductModel::getProductFromID($_GET['id_p']);
            $msg = 'Mettre à jour';
            $title = 'Voici les informations de votre produit';
            $libelle = $product->get('libelle_p');
            $image_url = $product->get('image_url_p');
            $path_p = $product->get('path_p');
            require_once('view/createProduct.php');
        }else {
            require_once('view/home.php');
        }
    }
    public static function use() {
        if(ProductModel::testUserEtProduitCorrects($_SESSION['id_u'], $_GET['id_p'])) {
            $product = ProductModel::getProductFromID($_GET['id_p']);
            $image_url = $product->get('image_url_p');
            $libelle = $product->get('libelle_p');
            $siteLibelle = SiteModel::getLibelleFromID($product->get('id_s'));
            $frequence = ['Journalière', 'Hebdomadaire', 'Mensuelle'][$product->get('frequence_p')-1];
            $eventlist_p = explode(';', $product->get('eventlist_p'));
            require_once('view/useProduct.php');
        }else {
            require_once('view/home.php');
        }
    }
}

?>