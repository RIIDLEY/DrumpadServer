<?php

class ModelDrum
{


    /**
     * Attribut contenant l'instance PDO
     */
    private $bd;


    /**
     * Attribut statique qui contiendra l'unique instance de Model
     */
    private static $instance = null;


    /**
     * Constructeur : effectue la connexion à la base de données.
     */
    private function __construct()
    {

        try {
            include 'Utils/credentialsDrum.php';
            $this->bd = new PDO($dsn, $login, $mdp);
            $this->bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->bd->query("SET nameS 'utf8'");
        } catch (PDOException $e) {
            die('Echec connexion, erreur n°' . $e->getCode() . ':' . $e->getMessage());
        }
    }


    /**
     * Méthode permettant de récupérer un modèle car le constructeur est privé (Implémentation du Design Pattern Singleton)
     */
    public static function getModel()
    {

        if (is_null(self::$instance)) {
            self::$instance = new ModelDrum();
        }
        return self::$instance;
    }

    public function addNewClient($infos)
        {

            try {
                //Préparation de la requête
                $requete = $this->bd->prepare('INSERT INTO client (pseudo, mdp, mail) VALUES (:pseudo, :mdp, :mail)');

                //Remplacement des marqueurs de place par les valeurs
                $marqueurs = ['pseudo', 'mdp', 'mail'];
                foreach ($marqueurs as $value) {
                    $requete->bindValue(':' . $value, $infos[$value]);
                }

                //Exécution de la requête
                return $requete->execute();
            } catch (PDOException $e) {
                die('Echec addNewClient, erreur n°' . $e->getCode() . ':' . $e->getMessage());
            }
        }

        public function getClient($pseudo)
        {

            try {
                $requete = $this->bd->prepare('Select mdp from client WHERE pseudo = :pseudo');
                $requete->bindValue(':pseudo', $pseudo);
                $requete->execute();
                return $requete->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                die('Echec getClient, erreur n°' . $e->getCode() . ':' . $e->getMessage());
            }
        }

        public function addNewMuique($infos)
            {

                try {
                    //Préparation de la requête
                    $requete = $this->bd->prepare('INSERT INTO musique (musique, createur) VALUES (:musique, :createur)');

                    //Remplacement des marqueurs de place par les valeurs
                    $marqueurs = ['musique', 'createur'];
                    foreach ($marqueurs as $value) {
                        $requete->bindValue(':' . $value, $infos[$value]);
                    }

                    //Exécution de la requête
                    return $requete->execute();
                } catch (PDOException $e) {
                    die('Echec addNewMuique, erreur n°' . $e->getCode() . ':' . $e->getMessage());
                }
            }

            public function getNbMusique($id)
            {

                try {
                    $requete = $this->bd->prepare('Select count(*) from musique WHERE createur = :id');
                    $requete->bindValue(':id', $id);
                    $requete->execute();
                    return $requete->fetch(PDO::FETCH_ASSOC);
                } catch (PDOException $e) {
                    die('Echec getNbMusique, erreur n°' . $e->getCode() . ':' . $e->getMessage());
                }
            }

            public function updateEtoile($etoile,$musique)
            {

                try {
                    $r = "UPDATE musique Set " . $etoile . "=". $etoile . "+1 where musique='" . $musique . "'";
                    $requete = $this->bd->prepare($r);
                    return $requete->execute();
                } catch (PDOException $e) {
                    die('Echec updateEtoile, erreur n°' . $e->getCode() . ':' . $e->getMessage());
                }
            }

            public function getEtoile($etoile,$id)
            {

                try {
                  $a = "sum(";
                  $r = "SELECT ". $a . $etoile . ") from musique WHERE createur = '" . $id . "'";
                    $requete = $this->bd->prepare($r);
                    $requete->execute();
                    return $requete->fetch(PDO::FETCH_ASSOC);
                } catch (PDOException $e) {
                    die('Echec getEtoile, erreur n°' . $e->getCode() . ':' . $e->getMessage());
                }
            }

            public function getArtiste($musique)
            {
                try {
                    $requete = $this->bd->prepare('Select createur from musique WHERE musique = :musique');
                    $requete->bindValue(':musique', $musique);
                    $requete->execute();
                    return $requete->fetch(PDO::FETCH_ASSOC);
                } catch (PDOException $e) {
                    die('Echec getArtiste, erreur n°' . $e->getCode() . ':' . $e->getMessage());
                }
            }


            public function getMusiqueArray()
            {
                try {
                    $requete = $this->bd->prepare('Select musique from musique');
                    $requete->execute();
                    return $requete->fetchAll(PDO::FETCH_COLUMN);
                } catch (PDOException $e) {
                    die('Echec getMusiqueArray, erreur n°' . $e->getCode() . ':' . $e->getMessage());
                }
            }

            public function getClientArray()
            {
                try {
                    $requete = $this->bd->prepare('Select pseudo from client');
                    $requete->execute();
                    return $requete->fetchAll(PDO::FETCH_COLUMN);
                } catch (PDOException $e) {
                    die('Echec getClientArray, erreur n°' . $e->getCode() . ':' . $e->getMessage());
                }
            }

            public function getEtoileArray($musique)
            {
                try {
                    $requete = $this->bd->prepare('Select 1etoile,2etoile,3etoile,4etoile,5etoile from musique where musique = :musique');
                    $requete->bindValue(':musique', $musique);
                    $requete->execute();
                    return $requete->fetchAll(PDO::FETCH_ASSOC);
                } catch (PDOException $e) {
                    die('Echec getEtoileArray, erreur n°' . $e->getCode() . ':' . $e->getMessage());
                }
            }
}
