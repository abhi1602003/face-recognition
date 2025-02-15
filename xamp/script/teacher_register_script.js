document.getElementById('teacherRegisterForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const formData = new FormData(this);

    fetch('teacher_register_process.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.text();  // Read the response as text first
    })
    .then(text => {
        console.log('Response text:', text);  // Log the response text
        let data;
        try {
            data = JSON.parse(text);  // Try to parse the text as JSON
        } catch (error) {
            throw new Error('Response is not valid JSON: ' + text);  // Include the response text in the error message
        }

        const notification = document.getElementById('notification');
        notification.style.display = 'block';
        notification.className = data.status === 'success' ? 'success' : 'error';
        notification.textContent = data.message;
    })
    .catch(error => {
        console.error("Error:", error);
        const notification = document.getElementById('notification');
        notification.style.display = 'block';
        notification.className = 'error';
        notification.textContent = 'An error occurred. Please try again.';
    });
});
