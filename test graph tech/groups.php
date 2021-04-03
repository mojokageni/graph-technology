<?php
declare(strict_types=1);
namespace MoreTalk;
include(realpath(dirname(__DIR__)). '/db/db_connect.php');
include_once(realpath(dirname(__DIR__)). '/helpers/data/sanitize_data.php');

use PDO, PDOException;

interface GroupStructure {
    public function createGroups();

}
class Groups implements GroupStructure  {
    public $con;
    public$id;
    public  $Group_id;
    public $Groupname;
    public $whips;
    public $user_id;
    public $username;
    public $messages;
     public $token;




    public function __construct($conn){
        $this->conn = $conn;
    }

    /**
     * This function creates a new Group, sanitize the data received
     * Insert it into the database and return a boolean statement
     * @return bool
     */
    public function createGroup():bool{
      $$this->id=sanitize_data($$this->id);
        $this->Group_id = 'mtu'. md5(uniqid());
        $this->username = sanitize_data($this->username);
        $this->user_id = sanitize_data($this->user_id);
        $this->groupname = sanitize_data($this->groupname);
      $this->whips=sanitize_data($this->whips);
          $this->messages=sanitize_data($this->messages);


        $query = 'INSERT INTO Groups  user_id=:id,username=:username,user_id: id, message: message url: url, time: time';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':Group_id', $this->Group_id);
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':user_id', $this->user_id);


        try {
            $stmt->execute();
            return true;
        }catch (PDOException $e) {
            //debugging purposes
            //should return false
            echo json_encode($e);
        }

    }
