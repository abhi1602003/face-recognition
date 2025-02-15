document.getElementById('departmentLoginRegistrationForm').addEventListener('submit', function(event) {
    event.preventDefault();
    
    var formData = new FormData(this);

    fetch('department_login_registration_process.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        document.open();
        document.write(data);
        document.close();
    })
    .catch(error => {
        console.error('Error:', error);
    });
});
