function searchTeacher() {
    const teacherId = document.getElementById('teacherId').value;
    // Send an AJAX request to the server to get teacher details by ID
    fetch(`teacher_details_update_process.php?teacherId=${teacherId}`)
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                // Display teacher details
                displayTeacherDetails(data.teacherDetails);
            } else {
                // Display error message if teacher not found
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
}
function updateTeacher(event) {
    event.preventDefault();

    const teacherId = document.getElementById('teacherId').value;

    // Initialize FormData to collect form data
    const formData = new FormData();

    // Check each checkbox and append corresponding form data
    if (document.getElementById('updateNameCheckbox').checked) {
        const teacherName = document.getElementById('updateName').value;
        formData.append('teacherName', teacherName);
    }
    if (document.getElementById('updatePhoneCheckbox').checked) {
        const teacherPhone = document.getElementById('updatePhone').value;
        formData.append('teacherPhone', teacherPhone);
    }
    if (document.getElementById('updatePostCheckbox').checked) {
        const teacherPost = document.getElementById('updatePost').value;
        formData.append('teacherPost', teacherPost);
    }
    if (document.getElementById('updateDepartmentNoCheckbox').checked) {
        const departmentNo = document.getElementById('updateDepartmentNo').value;
        formData.append('departmentNo', departmentNo);
    }
    if (document.getElementById('updateImageCheckbox').checked) {
        const teacherImage = document.getElementById('updateImage').files[0];
        formData.append('teacherImage', teacherImage);
    }

    // Append teacherId to formData
    formData.append('teacherId', teacherId);

    // Send POST request to update_teacher_process.php
    fetch('update_teacher_process.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert(data.message);
            // Optionally, update displayed teacher details
            displayTeacherDetails(data.updatedDetails);
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

// Add event listener to form submit
document.getElementById('updateTeacherForm').addEventListener('submit', updateTeacher);

function displayTeacherDetails(teacherDetails) {
    const teacherInfoDiv = document.getElementById('teacherInfo');
    teacherInfoDiv.innerHTML = `
        <p><strong>Teacher ID:</strong> ${teacherDetails.teacher_id}</p>
        <p><strong>Teacher Name:</strong> ${teacherDetails.teacher_name}</p>
        <p><strong>Teacher Phone:</strong> ${teacherDetails.teacher_phone}</p>
        <p><strong>Teacher Post:</strong> ${teacherDetails.teacher_post}</p>
        <p><strong>Department No:</strong> ${teacherDetails.department_no}</p>
    `;
}

function deleteTeacher() {
    const teacherId = document.getElementById('teacherId').value;
    if (confirm('Are you sure you want to delete this teacher?')) {
        // Send an AJAX request to delete teacher by ID
        fetch(`delete_teacher_process.php?teacherId=${teacherId}`)
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Display success message and clear teacher details
                    alert(data.message);
                    document.getElementById('teacherInfo').innerHTML = '';
                } else {
                    // Display error message if deletion fails
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }
}
function searchTeacherimg() {
    var teacherId = document.getElementById('teacherId').value;
    var imagePath = 'uploads/' +teacherId+ '.png';
    console.log("Image path:", imagePath); // Check the path in the browser console
    document.getElementById('teacherImage').src = imagePath;
}

function searchTeacherupdate()
{
// Add event listener to the form for submit event
document.getElementById('updateTeacherForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the default form submission

    // Fetch form values
    const teacherId = document.getElementById('teacherId').value;
    const teacherName = document.getElementById('updateName').value;
    const teacherPhone = document.getElementById('updatePhone').value;
    const teacherPost = document.getElementById('updatePost').value;
    const departmentNo = document.getElementById('updateDepartmentNo').value;

    // Prepare data to send via fetch API
    const formData = new FormData();
    formData.append('teacherId', teacherId);
    formData.append('teacherName', teacherName);
    formData.append('teacherPhone', teacherPhone);
    formData.append('teacherPost', teacherPost);
    formData.append('departmentNo', departmentNo);

    // Send an AJAX request to update teacher details
    fetch('update_teacher_process.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            // Display success message
            alert(data.message);
        } else {
            // Display error message
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
});

}