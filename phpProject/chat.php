<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require_once 'inc/Message.php';
$messageObj = new Message();

// Process form submissions (POST requests)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['logout'])) {
        // Handle logout
        session_destroy();
        header('Location: login.php');
        exit;
    }

    $content = trim($_POST['content']);
    if (!empty($content)) {
        $messageObj->sendMessage($_SESSION['user_id'], $content);
    }

    // Redirect to prevent resubmission on reload
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

// Fetch messages to display
$messages = $messageObj->getMessages();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat App</title>
    <link rel="stylesheet" href="assets/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <div class="chat-container">
        <div class="chat-header">
            <h2>Chat App</h2>
            <form method="POST" style="display:inline;">
                <button type="submit" name="logout" class="logout-button">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </div>
        
        <div class="messages">
            <?php foreach ($messages as $message): ?>
                <div class="<?= $_SESSION['username'] === $message['username'] ? 'message right' : 'message left' ?>">
                    <div class="message-content">
                        <strong><?= htmlspecialchars($message['username']) ?></strong>
                        <p><?= htmlspecialchars($message['content']) ?></p>
                        <small><?= $message['created_at'] ?></small>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <form method="POST" class="message-form">
            <input type="text" name="content" placeholder="Type a message" required>
            <button type="submit" class="send-button">
                <i class="fas fa-paper-plane"></i>
            </button>
        </form>
    </div>
</body>
<script src="assets/main.js"></script>
</html>
