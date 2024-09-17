document.addEventListener('DOMContentLoaded', function() {
    // Event listeners for modal operations
    document.getElementById('openModalButton').addEventListener('click', openModal);
    document.querySelector('.close').addEventListener('click', closeModal);

    window.onclick = function(event) {
        if (event.target === document.getElementById('myModal')) {
            closeModal();
        }
    };

    document.getElementById('addDepartmentForm').addEventListener('submit', async function(event) {
        event.preventDefault();
        await saveDepartment();
    });

    loadDepartments();

    function openModal() {
        document.getElementById('modalTitle').innerText = 'ADD NEW DEPARTMENT';
        document.getElementById('submitButton').innerText = 'Add Department';
        document.getElementById('departmentId').value = '';
        document.getElementById('departmentName').value = '';
        document.getElementById('departmentStatus').value = 'Active';
        document.getElementById('myModal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('myModal').style.display = 'none';
    }

    async function saveDepartment() {
        const departmentId = document.getElementById('departmentId').value;
        const departmentName = document.getElementById('departmentName').value;
        const departmentStatus = document.getElementById('departmentStatus').value;

        try {
            const response = await fetch(departmentId ? `/departments/${departmentId}` : '/departments', {
                method: departmentId ? 'PUT' : 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    name: departmentName,
                    status: departmentStatus
                })
            });

            const result = await response.json();
            if (response.ok) {
                closeModal();
                updateDepartmentList(result.department, departmentId !== '');
            } else {
                console.error('Failed to save department:', result.message);
                alert('Error: ' + result.message);
            }
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred while saving the department. Please check the console for more details.');
        }
    }

    function updateDepartmentList(department, isUpdate) {
        const tableBody = document.getElementById('departmentTableBody');

        if (isUpdate) {
            // If updating, update the existing row
            const row = tableBody.querySelector(`tr[data-id="${department.id}"]`);
            if (row) {
                row.innerHTML = `
                    <td>${department.id}</td>
                    <td>${department.name}</td>
                    <td><div class="status-box ${department.status === 'Active' ? 'status-active' : 'status-inactive'}">${department.status}</div></td>
                    <td>
                        <button class="action-button" onclick="editDepartment(${department.id}, '${department.name}', '${department.status}')">
                            <i class="fas fa-pencil-alt action-icon"></i>
                        </button>
                        <button class="action-button" onclick="deleteDepartment(${department.id})">
                            <i class="fas fa-trash-alt action-icon"></i>
                        </button>
                    </td>
                `;
            }
        } else {
            // If adding new, append the new row
            const row = document.createElement('tr');
            row.setAttribute('data-id', department.id);
            row.innerHTML = `
                <td>${department.id}</td>
                <td>${department.name}</td>
                <td><div class="status-box ${department.status === 'Active' ? 'status-active' : 'status-inactive'}">${department.status}</div></td>
                <td>
                        <button class="action-button" onclick="editDepartment(${department.id}, '${department.name}', '${department.status}')">
                            <i class="fas fa-pencil-alt action-icon"></i>
                        </button>
                        <button class="action-button" onclick="deleteDepartment(${department.id})">
                            <i class="fas fa-trash-alt action-icon"></i>
                        </button>
                    </td>
            `;
            tableBody.appendChild(row);
        }
    }

    async function loadDepartments() {
        try {
            const response = await fetch('/departments');
            const departments = await response.json();

            const tableBody = document.getElementById('departmentTableBody');
            tableBody.innerHTML = '';

            departments.forEach(department => {
                updateDepartmentList(department, false);
            });
        } catch (error) {
            console.error('Error loading departments:', error);
        }
    }

    window.editDepartment = function(id, name, status) {
        document.getElementById('modalTitle').innerText = 'EDIT DEPARTMENT';
        document.getElementById('submitButton').innerText = 'Update Department';
        document.getElementById('departmentId').value = id;
        document.getElementById('departmentName').value = name;
        document.getElementById('departmentStatus').value = status;
        document.getElementById('myModal').style.display = 'block';
    }

    window.deleteDepartment = async function(id) {
        if (confirm('Are you sure you want to delete this department?')) {
            try {
                const response = await fetch(`/departments/${id}`, {
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
                    console.error('Failed to delete department:', result.message);
                    alert('Error: ' + result.message);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred while deleting the department.');
            }
        }
    }
});
