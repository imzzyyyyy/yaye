document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('openModalButton').addEventListener('click', function() {
        document.getElementById('myModal').style.display = 'block';
        document.getElementById('modalTitle').textContent = 'ADD NEW USER';
        document.getElementById('userId').value = '';
        document.getElementById('addUserForm').reset();
    });

    document.querySelector('.modal .close').addEventListener('click', function() {
        document.getElementById('myModal').style.display = 'none';
    });

    document.getElementById('addUserForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const userId = document.getElementById('userId').value;
        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;
        const status = document.getElementById('status').value;

        const requestData = {
            username: username,
            status: status
        };

        if (password) {
            requestData.password = password;
        }

        const url = userId ? `/users/${userId}` : '/users';
        const method = userId ? 'PUT' : 'POST';

        fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(requestData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (userId) {
                    updateUserRow(userId, username, status);
                } else {
                    addUserRow(data.user);
                }
            } else {
                alert('Failed to save user.');
            }
        });

        document.getElementById('myModal').style.display = 'none';
    });

    function updateUserRow(id, username, status) {
        const row = document.querySelector(`tr[data-id="${id}"]`);
        row.querySelector('.username-cell').textContent = username;
        const statusCell = row.querySelector('.status-cell');
        statusCell.textContent = status;
        statusCell.className = `status-box ${status === 'Active' ? 'status-active' : 'status-inactive'} status-cell`;
    }

    function addUserRow(user) {
        const tableBody = document.getElementById('userTableBody');
        const newRow = document.createElement('tr');
        newRow.setAttribute('data-id', user.id);
        newRow.innerHTML = `
            <td>${tableBody.children.length + 1}</td>
            <td class="username-cell">${user.username}</td>
            <td class="status-box ${user.status === 'Active' ? 'status-active' : 'status-inactive'} status-cell">${user.status}</td>
            <td>${new Date(user.created_at).toLocaleDateString()}</td>
            <td>
                <button onclick="editUser('${user.id}', '${user.username}', '${user.status}')" class="action-button">
                    <i class="fas fa-pencil-alt action-icon"></i> 
                </button>
                <button onclick="deleteUser('${user.id}')" class="action-button">
                    <i class="fas fa-trash-alt action-icon"></i> 
                </button>
            </td>
        `;
        tableBody.appendChild(newRow);
    }

    function deleteUser(id) {
        if (confirm('Are you sure you want to delete this user?')) {
            fetch(`/users/${id}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    removeUserRow(id);
                } else {
                    alert('Failed to delete user.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to delete user.');
            });
        }
    }
    

    function removeUserRow(id) {
        const row = document.querySelector(`tr[data-id="${id}"]`);
        row.parentNode.removeChild(row);
        document.querySelectorAll('#userTableBody tr').forEach((row, index) => {
            row.children[0].textContent = index + 1;
        });
    }
});

function editUser(id, username, status) {
    document.getElementById('myModal').style.display = 'block';
    document.getElementById('modalTitle').textContent = 'EDIT USER';
    document.getElementById('userId').value = id;
    document.getElementById('username').value = username;
    document.getElementById('status').value = status;
    document.getElementById('password').value = '';
}
