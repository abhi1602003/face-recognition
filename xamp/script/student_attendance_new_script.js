function filterAttendance() {
    const semester = document.getElementById('semester').value;
    const attendanceDate = document.getElementById('attendanceDate').value;
  
    // Construct the filtered URL here
    let filteredUrl = 'student_attendance_process.php';
    if (semester) {
      filteredUrl += `?semester=${semester}`;
    }
    if (attendanceDate) {
      filteredUrl += (semester ? '&' : '?') + `attendanceDate=${attendanceDate}`;
    }
  
    fetch(filteredUrl)
      .then(response => response.json())
      .then(data => {
        displayAttendanceData(data);
      })
      .catch(error => {
        console.error('Error filtering attendance:', error);
      });
  }
  

function displayAttendanceData(data) {
    const tableBody = document.querySelector('.attendance-table table tbody');
    tableBody.innerHTML = ''; // Clear existing table rows

    data.forEach(attendance => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${attendance.student_usn}</td>
            <td>${attendance.student_name}</td>
            <td>${attendance.attendance_date}</td>
            <td>${attendance.attendance_time}</td>
            <td>${attendance.semester}</td>
        `;
        tableBody.appendChild(row);
    });
}

document.addEventListener('DOMContentLoaded', function() {
    fetchAttendanceData();
});

function fetchAttendanceData() {
    fetch('student_attendance_process.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            displayAttendanceData(data);
        })
        .catch(error => {
            console.error('Error fetching attendance data:', error);
        });
}
