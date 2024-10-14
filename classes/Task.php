<?php 

class Task {

    private $conn;
    private $table = "tasks";

    public $id;
    //TODO: use task setter
    public $task;
    public $is_completed;
    public $created_at;

    public function __construct($db) {
        //insert statement???
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO {$this->table} (task) VALUES (?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $this->task);
        return $stmt->execute();
    }

    public function read(){
        $query = "SELECT id, created_at, is_completed, task FROM {$this->table} ORDER BY created_at DESC";
        $result = $this->conn->query($query);
        return $result;
    }

    public function update() {
        $query = "UPDATE {$this->table} SET is_completed = {$this->is_completed} WHERE id=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $this->id);
        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM {$this->table} WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $this->id);
        return $stmt->execute();
    }


}