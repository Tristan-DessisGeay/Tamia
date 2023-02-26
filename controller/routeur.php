<?php

require_once('userController.php');
require_once('siteController.php');
require_once('productController.php');

if(isset($_GET['action'])) {
    $action = $_GET['action'];
    if($action=='signup') {
        if(!isset($_SESSION['id_u'])){
            $prenom = '';
            $nom = '';
            $email = '';
            $mdp = '';
            $profilImg = 'assets/image/profil.webp';
            $a = 'createUser';
            $msg = 'Valider';
            $title = 'Oh! Vous êtes nouveau ?';
            $error = 0;
            require_once('view/signup.php');
        }else {
            require_once('view/home.php');
        }
    }else if($action=='signin') {
        if(!isset($_SESSION['id_u'])){
            $error = 0;
            require_once('view/signin.php');
        }else {
            require_once('view/home.php');
        }
    }else if($action=='createUser') {
        UserController::create();
    }else if($action=='signout') {
        if(isset($_SESSION['id_u'])){
            session_destroy();
            header('Location: index.php');
        }else {
            require_once('view/home.php');
        }
    }else if($action=='connect') {
        if(!isset($_SESSION['id_u'])){
            UserController::connect();
        }else {
            require_once('view/home.php');
        }
    }else if($action=='editprofil') {
        if(isset($_SESSION['id_u'])) {
            UserController::edit();
        }else {
            require_once('view/home.php');
        }
    }else if($action=='mysites') {
        if(isset($_SESSION['id_u'])) {
            SiteController::show();
        }else {
            require_once('view/home.php');
        }
    }else if($action=='createSite') {
        if(isset($_SESSION['id_u'])) {
            SiteController::create();
        }else {
            require_once('view/home.php');
        }
    }else if($action=='createdSite') {
        if(isset($_SESSION['id_u'])) {
            SiteController::created();
        }else {
            require_once('view/home.php');
        }
    }else if($action=='updateSite') {
        if(isset($_SESSION['id_u'])) {
            SiteController::update();
        }else {
            require_once('view/home.php');
        }
    }else if($action=='deleteSite') {
        if(isset($_SESSION['id_u'])) {
            SiteController::delete();
        }else {
            require_once('view/home.php');
        }
    }else if($action=='myproducts') {
        if(isset($_SESSION['id_u'])) {
            ProductController::show();
        }else {
            require_once('view/home.php');
        }
    }else if($action=='deleteProduct') {
        if(isset($_SESSION['id_u'])) {
            ProductController::delete();
        }else {
            require_once('view/home.php');
        }
    }else if($action=='createProduct') {
        if(isset($_SESSION['id_u'])) {
            ProductController::create();
        }else {
            require_once('view/home.php');
        }
    }else if($action=='createdProduct') {
        if(isset($_SESSION['id_u'])) {
            ProductController::created();
        }else {
            require_once('view/home.php');
        }
    }else if($action=='updateProduct') {
        if(isset($_SESSION['id_u'])) {
            ProductController::update();
        }else {
            require_once('view/home.php');
        }
    }else if($action=='useProduct') {
        if(isset($_SESSION['id_u'])) {
            ProductController::use();
        }else {
            require_once('view/home.php');
        }
    }
}else {
    require_once('view/home.php');
}

?>