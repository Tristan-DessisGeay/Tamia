<?php

require_once('bdd.php');

class ProductModel {
    private $id_s;
    private $id_p;
    private $libelle_p;
    private $image_url_p;
    private $event_p;
    private $saving_p;
    private $frequence_p;
    private $eventlist_p;
    private $path_p;

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

    public static function getProducts($search, $num_page, $path_p, $order, $id_s) {
        $sql = "
            SELECT * FROM produits 
            WHERE libelle_p LIKE :search AND ";
        if($path_p!='Tous les produits') {
            $sql .= 'path_p=:path_p AND ';
        }
        $sql .= "id_s=:id_s 
                ORDER BY ";
        if($order=='c') {
            $sql .= 'id_p DESC ';
        }else if($order=='a') {
            $sql .= 'libelle_p ASC ';
        }else{
            $sql .= 'libelle_p ASC, id_p DESC ';
        }
        $sql .= 'LIMIT 16 OFFSET '.($num_page * 16).';';
        $re = BDD::$pdo->prepare($sql);
        $values = array(
            'search' => '%'.$search.'%',
            'id_s' => $id_s
        );
        if($path_p!='Tous les produits') {
            $values['path_p'] = $path_p;
        }
        
        $re->execute($values);
        $re->setFetchMode(PDO::FETCH_CLASS, 'ProductModel');
        $out = $re->fetchAll();
        
        return array($out, ProductModel::getTotalOfPages($search, $path_p, $id_s), (!empty($out)) ? $num_page+1 : 0);
    }

    public static function getTotalOfPages($search, $path_p, $id_s) {
        $sql = "
        SELECT COUNT(*) FROM produits 
        WHERE id_s=:id_s AND ";
        if($path_p!='Tous les produits') {
            $sql .= 'path_p=:path_p AND ';
        }
        $sql .= 'libelle_p LIKE :search;';
        $re = BDD::$pdo->prepare($sql);
        $values = array(
            'search' => '%'.$search.'%',
            'id_s' => $id_s
        );
        if($path_p!='Tous les produits') {
            $values['path_p'] = $path_p;
        }
        $re->execute($values);
        $out = $re->fetchAll();
        $result = intdiv(intval($out[0][0]), 16);
        if(intval($out[0][0]) % 16 != 0) $result = $result+1;
        return $result;
    }

    public static function getLibelleFromID($id_p) {
        $sql = "SELECT libelle_p FROM produits WHERE id_p=:id_p";
        $re = BDD::$pdo->prepare($sql);
        $values = array(
            'id_p' => $id_p
        );
        $re->execute($values);
        $out = $re->fetchAll();
        return $out[0][0];
    }

    public static function deleteFromID($id_p) {
        $libelle = ProductModel::getLibelleFromID($id_p);
        $sql = "DELETE FROM produits WHERE id_p=:id_p";
        $re = BDD::$pdo->prepare($sql);
        $values = array(
            'id_p' => $id_p
        );
        $re->execute($values);
        return $libelle;
    }

    public static function testUserEtProduitCorrects($id_u, $id_p) {
        $sql = "
            SELECT * FROM produits, utilisateurs, sites  
            WHERE utilisateurs.id_u=sites.id_u AND 
            sites.id_s=produits.id_s AND 
            produits.id_p=:id_p AND 
            utilisateurs.id_u=:id_u
        ";
        $re = BDD::$pdo->prepare($sql);
        $values = array(
            'id_p' => $id_p,
            'id_u' => $id_u
        );
        $re->execute($values);
        if(empty($re->fetchAll())) return false;
        return true;
    }

    public static function getAllPathsFromSiteID($id_s) {
        $sql = "
            SELECT DISTINCT path_p FROM produits 
            WHERE id_s=:id_s 
            AND path_p<>'Tous les produits' 
        ";
        $re = BDD::$pdo->prepare($sql);
        $values = array(
            'id_s' => $id_s
        );
        $re->execute($values);
        $out = $re->fetchAll();
        return $out;
    }

    public function saveSQL() {
        if($this->id_p==null) {
            $sql = '
                INSERT INTO produits (id_s, libelle_p, image_url_p, event_p, frequence_p, eventlist_p, path_p) 
                VALUES (:id_s, :libelle_p, :image_url_p, :event_p, :frequence_p, :eventlist_p, :path_p);
            ';
            $re = BDD::$pdo->prepare($sql);
            $values = array(
                'id_s' => $this->id_s,
                'libelle_p' => $this->libelle_p,
                'image_url_p' => $this->image_url_p,
                'event_p' => $this->event_p,
                'frequence_p' => $this->frequence_p,
                'eventlist_p' => $this->eventlist_p,
                'path_p' => $this->path_p
            );
        }else {
            $sql = '
                UPDATE produits SET 
                libelle_p=:libelle_p, image_url_p=:image_url_p, path_p=:path_p 
                WHERE id_p=:id_p;
            ';
            $re = BDD::$pdo->prepare($sql);
            $values = array(
                'id_p' => $this->id_p,
                'libelle_p' => $this->libelle_p,
                'image_url_p' => $this->image_url_p,
                'path_p' => $this->path_p
            );
        }
        $re->execute($values);
        if($this->id_p==null) {
            $sql = "SELECT max(id_p) FROM produits;";
            $re = BDD::$pdo->query($sql);
            $this->id_p = $re->fetch()[0];
        }
    }

    public static function getProductFromID($id_p) {
        $sql = 'SELECT * FROM produits WHERE id_p=:id_p';
        $re = BDD::$pdo->prepare($sql);
        $values = array(
            'id_p' => $id_p
        );
        $re->execute($values);
        $re->setFetchMode(PDO::FETCH_CLASS, 'ProductModel');
        $out = $re->fetchAll();
        return $out[0];
    }

}

?>