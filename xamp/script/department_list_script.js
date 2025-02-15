document.addEventListener('DOMContentLoaded', function() {
    fetch('php/department_list_process.php')
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                const departments = data.departments;
                let tableHTML = `<table>
                    <thead>
                        <tr>
                            <th>Department No</th>
                            <th>Department Name</th>
                        </tr>
                    </thead>
                    <tbody>`;
                
                departments.forEach(department => {
                    tableHTML += `<tr>
                        <td>${department.department_no}</td>
                        <td>${department.department_name}</td>
                    </tr>`;
                });

                tableHTML += `</tbody></table>`;
                document.getElementById('departmentTableContainer').innerHTML = tableHTML;
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
});
