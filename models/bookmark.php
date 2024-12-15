<?php

class bookmark{
    private $id;
    private $title;
    private $link;
    private $dateAdded;
    private $dbConnection;
    private $dbTable ='bookmarks';

    public function __construct($dbConnection) 
    {
        $this->dbConnection = $dbConnection;
    }
    public function getID() {
        return $this ->id;
    }
    public function gettitle() {
        return $this-> title;
    }
    public function getdateAdded() {
        return $this->dateAdded;
    }
    public function getlink() {
        return $this ->link;
    }
    public function setId($id) {
        $this->id = $id;
    }
    public function settitle($title) {
        $this->title= $title;
    }
    public function setlink($link) {
        $this->link= $link;
    }
    public function setDateAdded($dateAdded) {
        $this->dateAdded = $dateAdded;
    }


    public function create() {
        $query = "INSERT INTO ". $this->dbTable ." (title, link, date_added) VALUES(:title_name, :link_url, now());";
        $stmt = $this->dbConnection->prepare($query);
        if ($stmt->execute([
            ':title_name' => $this->title,
            ':link_url' => $this->link,
        ])) {
            return true;
        } else {
            printf("Error: %s", $stmt-> error);
            return false;
        }

    }
    public function readOne() {
        $query = "SELECT * FROM ". $this->dbTable ." WHERE id=:id";
        $stmt = $this->dbConnection->prepare($query);
        $stmt-> bindParam(":id", $this->id);
        if($stmt->execute()&& $stmt->rowCount()==1){
            $result = $stmt->fetch(PDO::FETCH_OBJ);
            $this->id= $result->id;
            $this->title= $result->title;
            $this->link= $result->link;
            $this->dateAddded= $result->date_added;
            return true;
        }
        return false;
    }

    public function readAll(){
        $query = "SELECT * FROM ".$this->dbTable;
        $stmt = $this->dbConnection->prepare($query);
        if ($stmt->execute() && $stmt->rowCount() > 1) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return [];
    }


    public function update() {
        $query= "UPDATE ".$this->dbTable." SET ";
        $firstField = true;


        if (empty($this->link) && empty($this->title)) {
            return false;
        }
        if (isset($this->title)) {
            if (!$firstField) {
                $query .= ", ";
            }
            $query .= "title = :title_name";
            $firstField = false;

        }
        if (isset($this->link)) {
            if (!$firstField) {
                $query .= ", ";
            }
            $query .= "link = :link";
            $firstField = false;
        }

        $query .=" WHERE id=:id";

        $stmt =$this->dbConnection->prepare($query);
        if (isset($this->title)) {
            $stmt->bindParam(":title_name", $this->title);
        }
        if (isset($this->link)) {
            $stmt->bindParam(":link", $this->link);
        }
        $stmt->bindParam(":id", $this->id);
        if($stmt->execute() && $stmt->rowCount()==1) {
            return true;
        }
        return false;
    }

    public function delete() {
        $query = "DELETE FROM ".$this->dbTable. " WHERE id=:id";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(":id", $this->id);
        if($stmt->execute() && $stmt-> rowCount()==1) {
            return true;
        }
        return false;

    }
}
