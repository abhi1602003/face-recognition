// Function to update student details
function updateStudent() {
    const studentUSN = document.getElementById('studentUSN').value; // Get student USN from the input field outside the form

    const formData = new FormData(document.getElementById('updateStudentForm'));
    formData.set('studentUSN', studentUSN); // Set the student USN in the FormData object

    fetch('student_update.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        console.log("Response data:", data);
        if (data.status === 'success') {
            alert('Student record updated successfully.');
            // Optionally, update UI or perform other actions upon success
        } else {
            alert('Failed to update student record. Please try again.');
        }
    })
    .catch(error => {
        console.error("Fetch error:", error);
        alert('Failed to update student record. Please try again.');
    });
}



// Function to handle form submission
document.getElementById('updateStudentForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent default form submission
    updateStudent(); // Call the updateStudent function
});

// Function to search for a student
function searchStudent() {
    var studentUSN = document.getElementById('studentUSN').value;
    console.log('Searching for student with USN:', studentUSN);

    fetch('student_search.php?studentUSN=' + studentUSN)
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();  // Parse response as JSON
    })
    .then(data => {
        console.log('Response data:', data);
        if (data.status === 'success') {
            document.getElementById('studentInfo').innerHTML = `
                <p>Name: ${data.student.student_name}</p>
                <p>USN: ${data.student.student_usn}</p>
                <p>Phone: ${data.student.student_phone}</p>
                <p>Semester: ${data.student.semester}</p>
                <p>Department No: ${data.student.department_no}</p>
            `;
            document.getElementById('updateName').value = data.student.student_name;
            document.getElementById('updatePhone').value = data.student.student_phone;
            document.getElementById('updateSemester').value = data.student.semester;
            document.getElementById('updateDepartmentNo').value = data.student.department_no;
            document.getElementById('deleteButton').setAttribute('data-student-name', data.student.student_name);
            loadStudentImage(studentUSN);
        } else {
            document.getElementById('studentInfo').innerHTML = data.message;
            document.getElementById('studentImage').src = '';
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        // Handle specific errors or show a generic message to the user
        document.getElementById('studentInfo').innerHTML = 'Failed to fetch student data. Please try again.';
        document.getElementById('studentImage').src = '';
    });
}

// Function to load student image
function loadStudentImage(studentUSN) {
    var imagePath = 'uploads/' + studentUSN + '.png';
    document.getElementById('studentImage').src = imagePath;
}

// Function to delete student
function deleteStudent() {
    var studentUSN = document.getElementById('studentUSN').value;
    var studentName = document.getElementById('deleteButton').getAttribute('data-student-name');
    
    fetch('student_delete.php?studentUSN=' + studentUSN, {
        method: 'GET'
    })
    .then(response => response.json())  // Parse response as JSON
    .then(data => {
        console.log('Response data:', data);
        alert(`Student details for ${studentName} deleted successfully.`);
        document.getElementById('studentInfo').innerHTML = data.message;
    })
    .catch(error => {
        console.error('Fetch error:', error);
        // Handle specific errors or show a generic message to the user
        alert('Failed to delete student record. Please try again.');
    });
}
