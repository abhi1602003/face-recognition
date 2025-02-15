document.getElementById('studentRegistrationForm').addEventListener('submit', function(event) {
    event.preventDefault();
    
    var formData = new FormData(this);

    fetch('student_register_process.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        const notification = document.getElementById('notification');
        notification.style.display = 'block';
        if (data.status === 'success') {
            notification.classList.add('success');
            notification.classList.remove('error');
        } else {
            notification.classList.add('error');
            notification.classList.remove('success');
        }
        notification.textContent = data.message;
    })
    .catch(error => {
        console.error('Error:', error);
        const notification = document.getElementById('notification');
        notification.style.display = 'block';
        notification.classList.add('error');
        notification.classList.remove('success');
        notification.textContent = 'An error occurred. Please try again.';
    });
});
