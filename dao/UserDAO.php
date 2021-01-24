<?php
include_once('../class/User.php');
include_once('ConnectionMysqliDAO.php');
require_once('../Exception/PDOException.php');
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

error_reporting(E_ALL);
ini_set("display_errors", 1);

class UserDAO extends ConnectionMysqliDAO {


    public function addUser(User $user)
    {   
        try {
            $newConnect = new ConnectionMysqliDAO();
            $db = $newConnect->connect(); 

            $pseudo = $user->getPseudo();
            $email = $user->getEmail();
            $nom = $user->getNom();
            $prenom = $user->getPrenom();
            $photo = $user->getPhoto();
            $photoNull = "";
            $mdp = $user->getMdp();
            $profil = 'utilisateur';

            $stmt = $db->prepare("INSERT INTO user VALUES (NULL,:pseudo,:email,:nom,:prenom,:photo,:mdp,:profil)");           
            
            
            $stmt->bindParam(':pseudo', $pseudo);           
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':prenom', $prenom);
            if(!empty($photo) && $photo!=null){
                $stmt->bindParam(':photo', $photo);
            }elseif (empty($photo) && $photo ==null){
              $stmt->bindParam(':photo', $photoNull);          
            } 
            $stmt->bindParam(':mdp', $mdp);
            $stmt->bindParam(':profil', $profil);

            $stmt->execute();

            $db = null;
            $stmt = null;           
        } 
        catch (PDOException $e){
            echo 'Echec de la connexion : '.$e->getMessage();
        }         
    }

    public function researchUserByEmail($email)
    {
        try
        {
            $newConnect = new ConnectionMysqliDAO();
            $db = $newConnect->connect();

            $query = "SELECT * FROM user WHERE email = :email LIMIT 1";
            $stmt = $db->prepare($query);
            $stmt->bindParam(":email", $email);
            $stmt->execute();
            $userEmail = $stmt->fetch();
            if(!empty ($userEmail))
            {
            $user = new User();
            $user->setId($userEmail['id'])
                ->setPseudo($userEmail['pseudo'])
                ->setEmail($userEmail['email'])
                ->setNom($userEmail['nom'])
                ->setPrenom($userEmail['prenom'])
                ->setPhoto($userEmail['photo'])
                ->setMdp($userEmail['mdp'])
                ->setProfil($userEmail['profil']);
            } else {
                $user = null;
            }
            return $user;
        }
        catch (PDOException $e) {
            print "erreur !: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    function editUser(object $user) 
    {
        try
        {
            $pseudo = $user->getPseudo();
            $email= $user->getEmail();
            $nom= $user->getNom();
            $prenom = $user->getPrenom();
            $photo = $user->getPhoto();
            
            $newConnect = new ConnectionMysqliDAO();
            $db = $newConnect->connect();
            
            
            if(!empty($photo) && $photo!=null){
                $stmt = $db->prepare( "UPDATE user SET pseudo = :pseudo , email= :email , nom= :nom, prenom= :prenom, photo = :photo where email = :email"); 
            }elseif(empty($photo) && $photo ==null){
                $stmt = $db->prepare( "UPDATE user SET pseudo = :pseudo , email= :email , nom= :nom, prenom= :prenom where email = :email");             
            }
            $stmt->bindParam(':pseudo', $pseudo);           
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':prenom', $prenom);
            if(!empty($photo) && $photo!=null){
                $stmt->bindParam(':photo', $photo);
            }
            

            $stmt->execute();
            
            $db = null;
            $stmt = null; 
        }
        catch (PDOException $e) {
            print "erreur !: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    static public function researchUserById(Int $id) {
        try {
            $newConnect = new ConnectionMysqliDAO();
            $db = $newConnect->connect();

            $query = "SELECT * FROM user WHERE id = :id";
            $stmt = $db->prepare($query);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            $userId = $stmt->fetch();
            
            $user = new User();
            $user->setId($userId['id'])
                ->setPseudo($userId['pseudo'])
                ->setEmail($userId['email'])
                ->setNom($userId['nom'])
                ->setPrenom($userId['prenom'])
                ->setPhoto($userId['photo'])
                ->setMdp($userId['mdp'])
                ->setProfil($userId['profil']);
               
            return $user;
            
        } catch (PDOException $e) {
            print "erreur !: " . $e->getMessage() . "<br/>";
            die();
        }
    }
}

