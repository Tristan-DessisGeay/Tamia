<?php

require_once('model/SiteModel.php');

class SiteController {
    public static function show() {
        $sites = SiteModel::getSitesFromUserID($_SESSION['id_u']);
        require_once('view/mysites.php');
    }
    public static function created() {
        if(!isset($_GET['id_s'])) {
            $site = new SiteModel();
            $site->build(array(
                'id_s' => null,
                'id_u' => $_SESSION['id_u'],
                'libelle_s' => $_POST['libelle'],
                'image_url_s' => $_POST['image'],
                'propertyid_s' => $_POST['propertyid']
            ));
            $site->saveSQL();
            $msg = 'Votre nouveau site : "'.$_POST['libelle'].'" a été créé avec succès !';
            $msg2 = 'Créer votre premier produit';
            require_once('view/signupSucced.php');
        }else {
            $site = new SiteModel();
            $site->build(array(
                'id_s' => $_GET['id_s'],
                'libelle_s' => $_POST['libelle'],
                'image_url_s' => $_POST['image'],
                'propertyid_s' => $_POST['propertyid']
            ));
            $site->saveSQL();
            $msg = 'Votre site : "'.$_POST['libelle'].'" a été mis à jour !';
            $msg2 = 'Accéder aux produits';
            require_once('view/signupSucced.php');
        }
    }
    public static function create() {
        $libelle = '';
        $image = 'assets/image/site.png';
        $propertyid = '';
        $a = 'createdSite';
        $msg = 'Valider';
        $title = 'Créons un nouveau site !';
        require_once('view/createSite.php');
    }
    public static function update() {
        if(SiteModel::testUserEtSiteCorrects($_SESSION['id_u'], $_GET['id_s'])) {
            $site = SiteModel::getSiteFromID($_GET['id_s']);
            $libelle = $site->get('libelle_s');
            $image = $site->get('image_url_s');
            $propertyid = $site->get('propertyid_s');
            $a = 'createdSite&id_s='.$_GET['id_s'];
            $msg = 'Mettre à jour';
            $title = 'Voici les informations de votre site';
            require_once('view/createSite.php');
        }else {
            require_once('view/home.php');
        }
    }
    public static function delete() {
        if(SiteModel::testUserEtSiteCorrects($_SESSION['id_u'], $_GET['id_s'])) {
            $libelle = SiteModel::deleteFromID($_GET['id_s']);
            $msg = 'Votre site "'.$libelle.'" a été supprimé avec succès !';
            require_once('view/siteDeleteSucced.php');
        }else {
            require_once('view/home.php');
        }
    }
}

?>