<?php

require_once('bdd.php');

class SiteModel {
    private $id_s;
    private $id_u;
    private $libelle_s;
    private $image_url_s;
    private $propertyid_s;

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

    public static function getSitesFromUserID($id_u) {
        $sql = "SELECT * FROM sites WHERE id_u=".$id_u;
        $re = BDD::$pdo->query($sql);
        $re->setFetchMode(PDO::FETCH_CLASS, 'SiteModel');
        $out = $re->fetchAll();
        if(empty($out)) return false;
        return $out;
    }

    public function saveSQL() {
        if($this->id_s==null) {
            $sql = "
                INSERT INTO sites (id_u, libelle_s, image_url_s, propertyid_s) 
                VALUES (:id_u, :libelle_s, :image_url_s, :propertyid_s);
            ";
            $re = BDD::$pdo->prepare($sql);
            $values = array(
                'id_u' => $this->id_u,
                'libelle_s' => $this->libelle_s,
                'image_url_s' => $this->image_url_s,
                'propertyid_s' => $this->propertyid_s
            );
        }else {
            $sql = "
                UPDATE sites 
                SET libelle_s=:libelle_s, image_url_s=:image_url_s, propertyid_s=:propertyid_s 
                WHERE id_s=:id_s;
            ";
            $re = BDD::$pdo->prepare($sql);
            $values = array(
                'libelle_s' => $this->libelle_s,
                'image_url_s' => $this->image_url_s,
                'propertyid_s' => $this->propertyid_s,
                'id_s' => $this->id_s
            );
        }
        $re->execute($values);
        if($this->id_s==null) {
            $sql = "SELECT max(id_s) FROM sites;";
            $re = BDD::$pdo->query($sql);
            $this->id_s = $re->fetch()[0];
        }
    }

    public static function testUserEtSiteCorrects($id_u, $id_s) {
        $sql = "SELECT * FROM sites WHERE id_u=:id_u AND id_s=:id_s;";
        $re = BDD::$pdo->prepare($sql);
        $values = array(
            'id_u' => $id_u,
            'id_s' => $id_s
        );
        $re->execute($values);
        if(empty($re->fetchAll())) return false;
        return true;
    }

    public static function getSiteFromID($id_s) {
        $sql = "SELECT * FROM sites WHERE id_s=:id_s";
        $re = BDD::$pdo->prepare($sql);
        $values = array(
            'id_s' => $id_s
        );
        $re->execute($values);
        $re->setFetchMode(PDO::FETCH_CLASS, 'SiteModel');
        $out = $re->fetchAll();
        return $out[0];
    }

    public static function getLibelleFromID($id_s) {
        $sql = "SELECT libelle_s FROM sites WHERE id_s=:id_s";
        $re = BDD::$pdo->prepare($sql);
        $values = array(
            'id_s' => $id_s
        );
        $re->execute($values);
        return $re->fetchAll()[0][0];
    }

    public static function deleteFromID($id_s) {
        $libelle = SiteModel::getLibelleFromID($id_s);
        $sql = "DELETE FROM sites WHERE id_s=:id_s";
        $re = BDD::$pdo->prepare($sql);
        $values = array(
            'id_s' => $id_s
        );
        $re->execute($values);
        return $libelle;
    }
}

?>