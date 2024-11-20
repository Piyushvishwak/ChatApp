// JavaScript for sending a message via AJAX
document.querySelector('#send-btn').addEventListener('click', function (e) {
    e.preventDefault();
    const messageInput = document.querySelector('#message-input');
    const message = messageInput.value.trim();

    if (message) {
        // Prevent repeated submissions
        document.querySelector('#send-btn').disabled = true;

        fetch('send_message.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `message=${encodeURIComponent(message)}`,
        })
        .then(response => response.text())
        .then(data => {
            if (data === 'success') {
                messageInput.value = ''; // Clear input
                document.querySelector('#send-btn').disabled = false;
            } else {
                alert('Failed to send message.');
            }
        })
        .catch(err => console.error(err));
    }
});
