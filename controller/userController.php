<?php 
require_once('model/UserModel.php');

class UserController {
    public static function create() {
        if(
            (isset($_SESSION['id_u'])&&$_POST['email']!=$_SESSION['email_u']&&!UserModel::testExistsByEmail($_POST['email']))
            ||
            (isset($_SESSION['id_u'])&&$_POST['email']==$_SESSION['email_u'])
            ||
            (!isset($_SESSION['id_u'])&&!UserModel::testExistsByEmail($_POST['email']))
        ) {
            $user = new UserModel();
            $user->build(array(
                'id_u' => isset($_SESSION['id_u']) ? $_SESSION['id_u'] : null, 
                'nom_u' => $_POST['nom'], 
                'prenom_u' => $_POST['prenom'], 
                'email_u' => $_POST['email'], 
                'password_u' => $_POST['mdp'], 
                'image_profil_u' => $_POST['profilImg']
            ));
            $user->saveSQL();
            $user->saveSession();
            $msg = isset($_SESSION['id_u']) ? 'Les informations de votre compte ont été mises à jour !' : 'Votre compte a été créé avec succès !';
            $msg2 = isset($_SESSION['id_u']) ? 'Accédez à vos sites' : 'Créer votre premier site';
            require_once('view/signupSucced.php');
        }else {
            $prenom = $_POST['prenom'];
            $nom = $_POST['nom'];
            $email = $_POST['email'];
            $mdp = $_POST['mdp'];
            $profilImg = $_POST['profilImg'];
            if(isset($_SESSION['id_u'])) {
                $a = 'createUser';
                $msg = 'Mettre à jour';
                $title = 'Mes informations';
            }else {
                $a = 'createUser';
                $msg = 'Valider';
                $title = 'Oh! Vous êtes nouveau ?';
            }
            $error = 1;
            require_once('view/signup.php');
        }
    }
    public static function connect() {
        $user = UserModel::testConnect($_POST['email'], $_POST['mdp']);
        if($user) {
            $user->saveSession();
            header('Location: index.php?action=mysites');
        }else {
            $error = 1;
            require_once('view/signin.php');
        }
    }
    public static function edit() {
        $prenom = $_SESSION['prenom_u'];
        $nom = $_SESSION['nom_u'];
        $email = $_SESSION['email_u'];
        $mdp = $_SESSION['password_u'];
        $profilImg = $_SESSION['image_profil_u'];
        $a = 'createUser';
        $msg = 'Mettre à jour';
        $title = 'Voici les informations de votre compte';
        $error = 0;
        require_once('view/signup.php');
    }
}

?>