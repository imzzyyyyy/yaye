document.addEventListener('DOMContentLoaded', function () {
    // Event listeners for modal operations
    document.getElementById('openModalButton').addEventListener('click', openModal);
    document.querySelector('.close').addEventListener('click', closeModal);

    window.onclick = function (event) {
        if (event.target === document.getElementById('myModal')) {
            closeModal();
        }
    };

    document.getElementById('addTechnicianForm').addEventListener('submit', async function (event) {
        event.preventDefault();
        await saveTechnician();
    });

    // Load technicians when the page loads
    loadTechnicians();

    function openModal() {
        document.getElementById('modalTitle').innerText = 'ADD NEW TECHNICIAN';
        document.getElementById('submitButton').innerText = 'Add Technician';
        document.getElementById('technicianId').value = '';
        document.getElementById('technicianName').value = '';
        document.getElementById('technicianStatus').value = 'Active';
        document.getElementById('myModal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('myModal').style.display = 'none';
    }

    async function saveTechnician() {
        const technicianId = document.getElementById('technicianId').value;
        const technicianName = document.getElementById('technicianName').value;
        const technicianStatus = document.getElementById('technicianStatus').value;

        try {
            const response = await fetch(technicianId ? `/technicians/${technicianId}` : '/technicians', {
                method: technicianId ? 'PUT' : 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    name: technicianName,
                    status: technicianStatus
                })
            });

            const result = await response.json();
            if (response.ok) {
                closeModal();
                // Update the technician list immediately
                updateTechnicianList(result.technician, !!technicianId);
            } else {
                console.error('Failed to save technician:', result.message);
                alert('Error: ' + result.message);
            }
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred while saving the technician. Please check the console for more details.');
        }
    }

    function updateTechnicianList(technician, isUpdate) {
        const tableBody = document.getElementById('technicianTableBody');
        let row = document.querySelector(`tr[data-id="${technician.id}"]`);

        if (isUpdate) {
            // If updating, update the existing row
            if (row) {
                row.innerHTML = `
                    <td>${technician.id}</td>
                    <td class="technician-name">${technician.name}</td>
                    <td><div class="status-box ${technician.status === 'Active' ? 'status-active' : 'status-inactive'}">${technician.status}</div></td>
                    <td>
                        <button class="action-button" onclick="editTechnician(${technician.id}, '${technician.name}', '${technician.status}')">
                            <i class="fas fa-pencil-alt action-icon"></i>
                        </button>
                        <button class="action-button" onclick="deleteTechnician(${technician.id})">
                            <i class="fas fa-trash-alt action-icon"></i>
                        </button>
                    </td>
                `;
            }
        } else {
            // If adding new, append the new row
            row = document.createElement('tr');
            row.setAttribute('data-id', technician.id);
            row.innerHTML = `
                <td>${technician.id}</td>
                <td class="technician-name">${technician.name}</td>
                <td><div class="status-box ${technician.status === 'Active' ? 'status-active' : 'status-inactive'}">${technician.status}</div></td>
                <td>
                    <button class="action-button" onclick="editTechnician(${technician.id}, '${technician.name}', '${technician.status}')">
                        <i class="fas fa-pencil-alt action-icon"></i>
                    </button>
                    <button class="action-button" onclick="deleteTechnician(${technician.id})">
                        <i class="fas fa-trash-alt action-icon"></i>
                    </button>
                </td>
            `;
            tableBody.appendChild(row);
        }
    }

    async function loadTechnicians() {
        try {
            const response = await fetch('/technicians');
            const technicians = await response.json();

            const tableBody = document.getElementById('technicianTableBody');
            tableBody.innerHTML = '';

            technicians.forEach(technician => {
                updateTechnicianList(technician, false);
            });
        } catch (error) {
            console.error('Error loading technicians:', error);
        }
    }

    window.editTechnician = function (id, name, status) {
        document.getElementById('modalTitle').innerText = 'EDIT TECHNICIAN';
        document.getElementById('submitButton').innerText = 'Update Technician';
        document.getElementById('technicianId').value = id;
        document.getElementById('technicianName').value = name;
        document.getElementById('technicianStatus').value = status;
        document.getElementById('myModal').style.display = 'block';
    }

    window.deleteTechnician = async function (id) {
        if (confirm('Are you sure you want to delete this technician?')) {
            try {
                const response = await fetch(`/technicians/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });

                const result = await response.json();
                if (response.ok) {
                    // Remove the deleted row from the table
                    const row = document.querySelector(`tr[data-id="${id}"]`);
                    if (row) {
                        row.remove();
                    }
                } else {
                    console.error('Failed to delete technician:', result.message);
                    alert('Error: ' + result.message);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred while deleting the technician.');
            }
        }
    }
});
