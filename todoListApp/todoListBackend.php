<?php

// Define the database connection constants
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'todoListApp');

require "databaseConfiguration.php";

class TodoListManager {
    private $conn;

    public function __construct() {
        // Create a new instance of the DatabaseConnection class
        $databaseConnection = new DatabaseConnection(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        // Connect to the database
        $databaseConnection->connect();

        // Get the database connection
        $this->conn = $databaseConnection->getConnection();
    }

    public function addTodoItem($todoItem) {
        $query = "INSERT INTO todolist (todoItem, todoStatus) VALUES (:createTodo, 1)";
        $stmt = $this->conn->prepare($query);
        try {
            $stmt->execute([
                ":createTodo" => $todoItem,
            ]);
            return 'Added Successfully!';
        } catch (PDOException $ex) {
            return 'Something went wrong';
        }
    }

    public function getTodoItems() {
        $query = "SELECT t.todoId, t.todoItem, s.yourStatus AS statusWord 
                  FROM todolist t 
                  JOIN status s ON t.todoStatus = s.statusId";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function updateTodoItem($todoID, $todoItem) {
        $query = "UPDATE todolist SET todoItem=:param1 WHERE todoId=:todoID";
        $stmt = $this->conn->prepare($query);
        try {
            $stmt->execute([
                ':param1' => $todoItem,
                ':todoID' => $todoID,
            ]);
            return 'Updated Successfully!';
        } catch (PDOException $ex) {
            return 'Something went wrong';
        }
    }

    public function deleteTodoItem($todoID) {
        $query = "DELETE FROM todolist WHERE todoId = :todoID";
        $stmt = $this->conn->prepare($query);
        try {
            $stmt->execute([
                ":todoID" => $todoID
            ]);
            return 'Deleted Successfully!';
        } catch (PDOException $ex) {
            return 'Something went wrong';
        }
    }

    public function markTodoItemAsFinished($todoID) {
        $query = "UPDATE todolist SET todoStatus = :finishedStatus WHERE todoId = :todoID";
        $stmt = $this->conn->prepare($query);
        try {
            $stmt->execute([
                ':finishedStatus' => 2,
                ':todoID' => $todoID,
            ]);
            return 'Marked as Finished!';
        } catch (PDOException $ex) {
            return 'Something went wrong';
        }
    }

    public function removeTodoItem($todoID) {
        $query = "DELETE FROM todolist WHERE todoId = :todoID";
        $stmt = $this->conn->prepare($query);
        try {
            $stmt->execute([
                ":todoID" => $todoID
            ]);
            return 'Removed Successfully!';
        } catch (PDOException $ex) {
            return 'Something went wrong';
        }
    }
}

$todoListManager = new TodoListManager();

// Logic for adding a todo item
if (isset($_POST['addTodo'])) {
    $todoItem = $_POST['createTodo'];
    $message = $todoListManager->addTodoItem($todoItem);
    $todolists = $todoListManager->getTodoItems();
}

// Logic for updating a todo item
if (isset($_POST['updateTodo'])) {
    $todoID = $_GET['UpdateTodoListId'];
    $todoItem = $_POST['todoItem'];
    $message = $todoListManager->updateTodoItem($todoID, $todoItem);
    $todolists = $todoListManager->getTodoItems();
}

// Logic for deleting a todo item
if (isset($_POST['deleteTodo'])) {
    $todoID = $_GET['DeleteTodoListId'];
    $message = $todoListManager->deleteTodoItem($todoID);
    $todolists = $todoListManager->getTodoItems();
}

// Logic for marking a todo item as finished
if (isset($_POST['finishedTodo'])) {
    $todoID = $_GET['FinishedTodoListId'];
    $message = $todoListManager->markTodoItemAsFinished($todoID);
    $todolists = $todoListManager->getTodoItems();
}

// Logic for removing a finished todo item
if (isset($_POST['removeTodo'])) {
    $todoID = $_GET['RemoveTodoListId'];
    $message = $todoListManager->removeTodoItem($todoID);
    $todolists = $todoListManager->getTodoItems();
}

$todolists = $todoListManager->getTodoItems();

?>
