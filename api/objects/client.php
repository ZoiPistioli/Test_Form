<?php
class Client{
    private $conn;
    private $table_name = "clients";

    // object properties
    public $id;
    public $first_name;
    public $last_name;
    public $email;
    public $phone;
    public $category;

    //database connection
    public function __construct($db){
        $this->conn = $db;
    }

// create client
function create(){
// insert record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                first_name=:first_name, last_name=:last_name, email=:email, phone=:phone, category=:category";

    $stmt = $this->conn->prepare($query);

    $this->first_name=htmlspecialchars(strip_tags($this->first_name));
    $this->last_name=htmlspecialchars(strip_tags($this->last_name));
    $this->email=htmlspecialchars(strip_tags($this->email));
    $this->phone=htmlspecialchars(strip_tags($this->phone));
    $this->category=htmlspecialchars(strip_tags($this->category));

    $stmt->bindParam(":first_name", $this->first_name);
    $stmt->bindParam(":last_name", $this->last_name);
    $stmt->bindParam(":email", $this->email);
    $stmt->bindParam(":phone", $this->phone);
    $stmt->bindParam(":category", $this->category);

    // execute query
    if($stmt->execute()){
        
        $query = "SELECT
                cl.id
            FROM
                " . $this->table_name . " cl
            WHERE
                cl.id = LAST_INSERT_ID()";
                $stmt = $this->conn->prepare( $query );
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                return $row["id"];
    }

    return false;
}

// read client info
function readOne(){
    //read single record
    $query = "SELECT
                cl.id, cl.first_name, cl.last_name, cl.email, cl.phone, cl.category
            FROM
                " . $this->table_name . " cl
            WHERE
                cl.id = ?
            LIMIT
                0,1";
    $stmt = $this->conn->prepare( $query );
    // bind id of client to be updated
    $stmt->bindParam(1, $this->id);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // set values
    $this->first_name = $row['first_name'];
    $this->last_name = $row['last_name'];
    $this->email = $row['email'];
    $this->phone = $row['phone'];
    $this->category = $row['category'];
}
// update 
function update(){ 
    $query = "UPDATE
                " . $this->table_name . "
            SET
                first_name = :first_name,
                last_name = :last_name,
                email = :email,
                phone = :phone,
                category = :category
            WHERE
                id = :id";
    $stmt = $this->conn->prepare($query);

    $this->first_name=htmlspecialchars(strip_tags($this->first_name));
    $this->last_name=htmlspecialchars(strip_tags($this->last_name));
    $this->email=htmlspecialchars(strip_tags($this->email));
    $this->phone=htmlspecialchars(strip_tags($this->phone));
    $this->category=htmlspecialchars(strip_tags($this->category));

    $stmt->bindParam(":first_name", $this->first_name);
    $stmt->bindParam(":last_name", $this->last_name);
    $stmt->bindParam(":email", $this->email);
    $stmt->bindParam(":phone", $this->phone);
    $stmt->bindParam(":category", $this->category);
    $stmt->bindParam(':id', $this->id);

    if($stmt->execute()){
        return true;
    }
    return false;
}

// delete client
function delete(){
    $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
    $stmt = $this->conn->prepare($query);
    $this->id=htmlspecialchars(strip_tags($this->id));
    // bind id of record to delete
    $stmt->bindParam(1, $this->id);

    if($stmt->execute()){
        return true;
    }
    return false;
}
}
?>