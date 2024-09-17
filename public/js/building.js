document.addEventListener('DOMContentLoaded', function () {
    // Event listeners for modal operations
    document.getElementById('openModalButton').addEventListener('click', openModal);
    document.querySelector('.close').addEventListener('click', closeModal);

    window.onclick = function (event) {
        if (event.target === document.getElementById('myModal')) {
            closeModal();
        }
    };

    document.getElementById('addBuildingForm').addEventListener('submit', async function (event) {
        event.preventDefault();
        await saveBuilding();
    });

    loadBuildings();

    function openModal() {
        document.getElementById('modalTitle').innerText = 'ADD NEW BUILDING';
        document.getElementById('submitButton').innerText = 'Add Building';
        document.getElementById('buildingId').value = '';
        document.getElementById('buildingName').value = '';
        document.getElementById('buildingStatus').value = 'Active';
        document.getElementById('myModal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('myModal').style.display = 'none';
    }

    async function saveBuilding() {
    const buildingId = document.getElementById('buildingId').value;
    const buildingName = document.getElementById('buildingName').value;
    const buildingStatus = document.getElementById('buildingStatus').value;

    try {
        const response = await fetch(buildingId ? `/buildings/${buildingId}` : '/buildings', {
            method: buildingId ? 'PUT' : 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                name: buildingName,
                status: buildingStatus
            })
        });

        const result = await response.json();
        if (response.ok) {
            closeModal();
            updateBuildingList(result.building, buildingId);
        } else {
            console.error('Failed to save building:', result.message);
            alert('Error: ' + result.message);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred while saving the building. Please check the console for more details.');
    }
}

    function updateBuildingList(building, isUpdate) {
        if (isUpdate) {
            // If updating, update the existing row
            const row = document.querySelector(`tr[data-id="${building.id}"]`);
            row.innerHTML = `
                <td>${building.id}</td>
                <td>${building.name}</td>
                <td><div class="status-box ${building.status === 'Active' ? 'status-active' : 'status-inactive'}">${building.status}</div></td>
                <td>
                    <button class="action-button" onclick="editBuilding(${building.id}, '${building.name}', '${building.status}')">
                        <i class="fas fa-pencil-alt action-icon"></i>
                    </button>
                    <button class="action-button" onclick="deleteBuilding(${building.id})">
                        <i class="fas fa-trash-alt action-icon"></i>
                    </button>
                </td>
            `;
        } else {
            // If adding new, append the new row
            const tableBody = document.getElementById('buildingTableBody');
            const row = document.createElement('tr');
            row.setAttribute('data-id', building.id);
            row.innerHTML = `
                <td>${building.id}</td>
                <td>${building.name}</td>
                <td><div class="status-box ${building.status === 'Active' ? 'status-active' : 'status-inactive'}">${building.status}</div></td>
                <td>
                    <button class="action-button" onclick="editBuilding(${building.id}, '${building.name}', '${building.status}')">
                        <i class="fas fa-pencil-alt action-icon"></i>
                    </button>
                    <button class="action-button" onclick="deleteBuilding(${building.id})">
                        <i class="fas fa-trash-alt action-icon"></i>
                    </button>
                </td>
            `;
            tableBody.appendChild(row);
        }
    }

    async function loadBuildings() {
        try {
            const response = await fetch('/buildings');
            const buildings = await response.json();

            const tableBody = document.getElementById('buildingTableBody');
            tableBody.innerHTML = '';

            buildings.forEach(building => {
                updateBuildingList(building, false);
            });
        } catch (error) {
            console.error('Error loading buildings:', error);
        }
    }

    window.editBuilding = function (id, name, status) {
        document.getElementById('modalTitle').innerText = 'EDIT BUILDING';
        document.getElementById('submitButton').innerText = 'Update Building';
        document.getElementById('buildingId').value = id;
        document.getElementById('buildingName').value = name;
        document.getElementById('buildingStatus').value = status;
        document.getElementById('myModal').style.display = 'block';
    }

    window.deleteBuilding = async function (id) {
        if (confirm('Are you sure you want to delete this building?')) {
            try {
                const response = await fetch(`/buildings/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });

                const result = await response.json();
                if (response.ok) {
                    // Remove the deleted row from the table
                    const row = document.querySelector(`tr[data-id="${id}"]`);
                    row.remove();
                } else {
                    console.error('Failed to delete building:', result.message);
                    alert('Error: ' + result.message);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred while deleting the building.');
            }
        }
    }
});
