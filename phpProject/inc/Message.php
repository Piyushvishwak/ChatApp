<?php
require_once 'DB.php';

class Message {
    private $conn;

    public function __construct() {
        $db = new DB();
        $this->conn = $db->connect();
    }

    public function sendMessage($userId, $content) {
        $stmt = $this->conn->prepare("INSERT INTO messages (user_id, content) VALUES (:user_id, :content)");
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':content', $content);
        return $stmt->execute();
    }

    public function getMessages() {
        $stmt = $this->conn->prepare("
            SELECT messages.content, messages.created_at, users.username
            FROM messages
            JOIN users ON messages.user_id = users.id
            ORDER BY messages.created_at ASC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
