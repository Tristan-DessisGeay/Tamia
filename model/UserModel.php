<?php

require_once('bdd.php');

class UserModel {
    private $id_u;
    private $nom_u;
    private $prenom_u;
    private $email_u;
    private $password_u;
    private $image_profil_u;

    public function build($args) {
        foreach($args as $arg => $val) {
            $this->set($arg, $val);
        }
    }

    public function get($attr) {
        return $this->$attr;
    }

    public function set($attr, $val) {
        $this->$attr = $val;
    }

    public function saveSQL() {
        if($this->id_u==null) {
            $sql = "
                INSERT INTO utilisateurs (nom_u, prenom_u, email_u, password_u, image_profil_u) 
                VALUES (:nom_u, :prenom_u, :email_u, :password_u, :image_profil_u);
            ";
            $re = BDD::$pdo->prepare($sql);
            $values = array(
                'nom_u' => $this->nom_u,
                'prenom_u' => $this->prenom_u,
                'email_u' => $this->email_u,
                'password_u' => $this->password_u,
                'image_profil_u' => $this->image_profil_u
            );
        }else {
            $sql = "
                UPDATE utilisateurs 
                SET nom_u=:nom_u, prenom_u=:prenom_u, email_u=:email_u, password_u=:password_u, image_profil_u=:image_profil_u 
                WHERE id_u=:id_u;
            ";
            $re = BDD::$pdo->prepare($sql);
            $values = array(
                'nom_u' => $this->nom_u,
                'prenom_u' => $this->prenom_u,
                'email_u' => $this->email_u,
                'password_u' => $this->password_u,
                'image_profil_u' => $this->image_profil_u,
                'id_u' => $this->id_u
            );
        }
        $re->execute($values);
        if($this->id_u==null) {
            $sql = "SELECT max(id_u) FROM utilisateurs;";
            $re = BDD::$pdo->query($sql);
            $this->id_u = $re->fetch()[0];
        }
    }

    public function saveSession() {
        $_SESSION['id_u'] = $this->id_u;
        $_SESSION['prenom_u'] = $this->prenom_u;
        $_SESSION['nom_u'] = $this->nom_u;
        $_SESSION['email_u'] = $this->email_u;
        $_SESSION['password_u'] = $this->password_u;
        $_SESSION['image_profil_u'] = $this->image_profil_u;
    }

    public static function testConnect($email_u, $password_u) {
        $sql = "SELECT * FROM utilisateurs WHERE email_u=:email_u AND password_u=:password_u;";
        $re = BDD::$pdo->prepare($sql);
        $values = array(
            'email_u' => $email_u,
            'password_u' => $password_u
        );
        $re->execute($values);
        $re->setFetchMode(PDO::FETCH_CLASS, 'UserModel');
        $out = $re->fetchAll();
        if (empty($out)) return false;
        return $out[0];
    }

    public static function testExistsByEmail($email_u) {
        $sql = "SELECT count(*) FROM utilisateurs WHERE email_u=:email_u;";
        $re = BDD::$pdo->prepare($sql);
        $values = array(
            'email_u' => $email_u
        );
        $re->execute($values);
        if($re->fetchAll()[0][0]>=1) return true;
        return false;
    }
}

?>