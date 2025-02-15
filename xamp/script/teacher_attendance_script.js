document.getElementById('filterButton').addEventListener('click', function() {
    var attendanceDate = document.getElementById('attendanceDate').value;

    fetch(`teacher_attendance_process.php?date=${attendanceDate}`)
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            var tableBody = document.querySelector('#teacherAttendanceTable tbody');
            tableBody.innerHTML = ''; // Clear previous data

            data.attendance.forEach(record => {
                var row = document.createElement('tr');
                row.innerHTML = `
                    <td>${record.teacher_id}</td>
                    <td>${record.teacher_name}</td>
                    <td>${record.attendance_date}</td>
                    <td>${record.attendance_time}</td>
                `;
                tableBody.appendChild(row);
            });
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
});
