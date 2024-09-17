document.addEventListener('DOMContentLoaded', function () {
    const apiUrl = '/facilities'; // Base URL for resourceful routes

    // Event listeners for modal operations
    document.getElementById('openModalButton').addEventListener('click', openModal);
    document.querySelector('.close').addEventListener('click', closeModal);

    window.onclick = function (event) {
        if (event.target === document.getElementById('myModal')) {
            closeModal();
        }
    };

    document.getElementById('addFacilityForm').addEventListener('submit', async function (event) {
        event.preventDefault();
        await saveFacility();
    });

    // Load facilities when the page loads
    loadFacilities();

    function openModal() {
        document.getElementById('modalTitle').innerText = 'ADD NEW FACILITY';
        document.getElementById('submitButton').innerText = 'Add Facility';
        document.getElementById('facilityId').value = '';
        document.getElementById('facilityName').value = '';
        document.getElementById('facilityStatus').value = 'Active';
        document.getElementById('myModal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('myModal').style.display = 'none';
    }

    async function saveFacility() {
        const facilityId = document.getElementById('facilityId').value;
        const facilityName = document.getElementById('facilityName').value;
        const facilityStatus = document.getElementById('facilityStatus').value;
    
        try {
            const response = await fetch(facilityId ? `${apiUrl}/${facilityId}` : apiUrl, {
                method: facilityId ? 'PUT' : 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    name: facilityName,
                    status: facilityStatus
                })
            });
    
            const result = await response.json();
            if (response.ok) {
                closeModal();
                updateFacilityList(result.facility, !!facilityId);
            } else {
                console.error('Failed to save facility:', result.message);
                alert('Error: ' + result.message);
            }
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred while saving the facility. Please check the console for more details.');
        }
    }
    

    function updateFacilityList(facility, isUpdate) {
        const tableBody = document.getElementById('facilityTableBody');
        if (isUpdate) {
            const row = document.querySelector(`tr[data-id="${facility.id}"]`);
            if (row) {
                row.innerHTML = `
                    <td>${facility.id}</td>
                    <td>${facility.name}</td>
                    <td><div class="status-box ${facility.status === 'Active' ? 'status-active' : 'status-inactive'}">${facility.status}</div></td>
                    <td>
                        <button class="action-button" onclick="editFacility(${facility.id}, '${facility.name}', '${facility.status}')">
                            <i class="fas fa-pencil-alt action-icon"></i>
                        </button>
                        <button class="action-button" onclick="deleteFacility(${facility.id})">
                            <i class="fas fa-trash-alt action-icon"></i>
                        </button>
                    </td>
                `;
            }
        } else {
            const row = document.createElement('tr');
            row.setAttribute('data-id', facility.id);
            row.innerHTML = `
                <td>${facility.id}</td>
                <td>${facility.name}</td>
                <td><div class="status-box ${facility.status === 'Active' ? 'status-active' : 'status-inactive'}">${facility.status}</div></td>
                <td>
                    <button class="action-button" onclick="editFacility(${facility.id}, '${facility.name}', '${facility.status}')">
                        <i class="fas fa-pencil-alt action-icon"></i>
                    </button>
                    <button class="action-button" onclick="deleteFacility(${facility.id})">
                        <i class="fas fa-trash-alt action-icon"></i>
                    </button>
                </td>
            `;
            tableBody.appendChild(row);
        }
    }
    

    async function loadFacilities() {
        try {
            const response = await fetch(apiUrl);
            const facilities = await response.json();

            const tableBody = document.getElementById('facilityTableBody');
            tableBody.innerHTML = '';

            facilities.forEach(facility => {
                updateFacilityList(facility, false);
            });
        } catch (error) {
            console.error('Error loading facilities:', error);
        }
    }

    window.editFacility = function (id, name, status) {
        document.getElementById('modalTitle').innerText = 'EDIT FACILITY';
        document.getElementById('submitButton').innerText = 'Update Facility';
        document.getElementById('facilityId').value = id;
        document.getElementById('facilityName').value = name;
        document.getElementById('facilityStatus').value = status;
        document.getElementById('myModal').style.display = 'block';
    }
    
    window.deleteFacility = async function (id) {
        if (confirm('Are you sure you want to delete this facility?')) {
            try {
                const response = await fetch(`${apiUrl}/${id}`, {
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
                    console.error('Failed to delete facility:', result.message);
                    alert('Error: ' + result.message);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred while deleting the facility.');
            }
        }
    }
    
});
