document.addEventListener('DOMContentLoaded', function() {
    // Event listeners for modal operations
    document.getElementById('openModalButton').addEventListener('click', openModal);
    document.getElementsByClassName('close')[0].addEventListener('click', closeModal);

    window.onclick = function(event) {
        if (event.target == document.getElementById('myModal')) {
            closeModal();
        }
    };

    document.getElementById('addGroupForm').addEventListener('submit', async function(event) {
        event.preventDefault();
        await saveGroup();
    });

    // Initialize groups on page load
    loadGroups();

    function openModal() {
        document.getElementById('modalTitle').innerText = 'ADD NEW GROUP';
        document.getElementById('submitButton').innerText = 'Add Group';
        document.getElementById('groupId').value = '';
        document.getElementById('groupName').value = '';
        document.getElementById('groupLevel').value = '';
        document.getElementById('groupStatus').value = 'Active';
        document.getElementById('myModal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('myModal').style.display = 'none';
    }

    async function saveGroup() {
        const groupId = document.getElementById('groupId').value;
        const groupName = document.getElementById('groupName').value;
        const groupLevel = document.getElementById('groupLevel').value;
        const groupStatus = document.getElementById('groupStatus').value;

        try {
            const url = groupId ? `/groups/${groupId}` : '/groups';
            const method = groupId ? 'PUT' : 'POST';

            const response = await fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    name: groupName,
                    level: groupLevel,
                    status: groupStatus
                })
            });

            const result = await response.json();
            if (result.success) {
                closeModal();
                await loadGroups();
            } else {
                console.error('Error saving group: ' + result.message);
            }
        } catch (error) {
            console.error('Failed to save group: ' + error.message);
        }
    }

    async function loadGroups() {
        try {
            const response = await fetch('/groups');
            const groups = await response.json();
            const tableBody = document.getElementById('groupTableBody');
            tableBody.innerHTML = '';

            groups.forEach((group, index) => {
                const newRow = document.createElement('tr');
                newRow.setAttribute('data-id', group.id);
                newRow.innerHTML = `
                    <td>${index + 1}</td>
                    <td class="group-name">${group.name}</td>
                    <td class="group-level">${group.level}</td>
                    <td class="group-status">
                        <div class="status-box ${group.status === 'Active' ? 'status-active' : 'status-inactive'}">${group.status}</div>
                    </td>
                    <td>
                        <button class="action-button" onclick="editGroup(${group.id}, '${group.name.replace(/'/g, "\\'")}', ${group.level}, '${group.status}')">
                            <i class="fas fa-pencil-alt action-icon"></i>
                        </button>
                        <button class="action-button" onclick="deleteGroup(${group.id})">
                            <i class="fas fa-trash-alt action-icon"></i>
                        </button>
                    </td>
                `;
                tableBody.appendChild(newRow);
            });
        } catch (error) {
            console.error('Failed to load groups: ' + error.message);
        }
    }

    window.editGroup = function(id, name, level, status) {
        document.getElementById('modalTitle').innerText = 'EDIT GROUP';
        document.getElementById('submitButton').innerText = 'Update Group';
        document.getElementById('groupId').value = id;
        document.getElementById('groupName').value = name;
        document.getElementById('groupLevel').value = level;
        document.getElementById('groupStatus').value = status;
        document.getElementById('myModal').style.display = 'block';
    };

    window.deleteGroup = async function(id) {
        if (confirm('Are you sure you want to delete this group?')) {
            try {
                const response = await fetch(`/groups/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });

                const result = await response.json();
                if (result.success) {
                    await loadGroups();
                } else {
                    console.error('Error deleting group: ' + result.message);
                }
            } catch (error) {
                console.error('Failed to delete group: ' + error.message);
            }
        }
    };
});
