<?php
namespace App\models;
use App\models\database;

//include_once 'database.php';
class cheking{
    private $db;

    public function __construct() {
        $this->db = database::getInstance();
    }

    // function to check email on database
    function checkEmail($email){
        $requet = 'SELECT CIN , email FROM users WHERE email = ?';
        $stm = $this->db->query($requet, [$email]);
        return $stm->fetch();
    }
    function checkPassword($email){
        $requet = 'SELECT password_hash FROM users WHERE email = ?';
        $stm = $this->db->query($requet, [$email]);
        return $stm->fetch();
    }
    
    function getCIN($email){
        $requet = 'SELECT CIN FROM users WHERE email = ?';
        $stm = $this->db->query($requet, [$email]);
        return $stm->fetch();
    }
}