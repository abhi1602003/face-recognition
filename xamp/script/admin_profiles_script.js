document.addEventListener('DOMContentLoaded', function() {
    // Fetch admin details from the server
    fetchAdminDetails();
});

function fetchAdminDetails() {
    // Fetch admin details from the server using AJAX or fetch API
    // Example:
    fetch('fetch_admin_details.php')
    .then(response => response.json())
    .then(data => {
        // Update the UI with admin details
        displayAdminDetails(data);
    })
    .catch(error => {
        console.error('Error fetching admin details:', error);
    });
}

function displayAdminDetails(admin) {
    // Update the UI with admin details
    const adminDetailsContainer = document.getElementById('adminDetails');

    // Clear previous content
    adminDetailsContainer.innerHTML = '';

    // Create elements to display admin details
    const adminName = document.createElement('h3');
    adminName.textContent = `Name: ${admin.name}`;

    const adminMessages = document.createElement('p');
    adminMessages.textContent = `Messages: ${admin.messages}`;

    const adminEmail = document.createElement('p');
    adminEmail.textContent = `Email: ${admin.email}`;

    const adminPhone = document.createElement('p');
    adminPhone.textContent = `Phone Number: ${admin.phone}`;

    // Append elements to the container
    adminDetailsContainer.appendChild(adminName);
    adminDetailsContainer.appendChild(adminMessages);
    adminDetailsContainer.appendChild(adminEmail);
    adminDetailsContainer.appendChild(adminPhone);
}
