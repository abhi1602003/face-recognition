// Function to fetch teacher information
function fetchTeacherInfo() {
    var teacherId = document.getElementById('teacherId').value;
    fetch(`fetch_teacher_info.php?teacherId=${teacherId}`)
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                document.getElementById('teacherIdHidden').value = data.teacher.teacher_id;
                document.getElementById('teacherInfo').innerHTML = `
                    <p>Name: ${data.teacher.teacher_name}</p>
                    <p>Post: ${data.teacher.teacher_post}</p>
                    <p>Department No: ${data.teacher.department_no}</p>
                    <img src="${data.teacher.teacher_image}" alt="Teacher Image" width="100">
                `;
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

function handleTeacherRegistration(event) {
    event.preventDefault(); // Prevent form submission

    var teacherId = document.getElementById('teacherIdHidden').value;
    var newPassword = document.getElementById('newPassword').value;
    var confirmPassword = document.getElementById('confirmPassword').value;

    if (newPassword !== confirmPassword) {
        alert('Passwords do not match');
        return;
    }

    var formData = new FormData();
    formData.append('teacherId', teacherId);
    formData.append('newPassword', newPassword);

    fetch('teacher_login_registration_process.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert('Teacher login successfully registered');
            document.getElementById('teacherRegistrationForm').reset();
            document.getElementById('teacherInfo').innerHTML = '';
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while registering teacher login');
    });
}

// Ensure to correctly bind the event listener
document.getElementById('teacherRegistrationForm').addEventListener('submit', handleTeacherRegistration);

