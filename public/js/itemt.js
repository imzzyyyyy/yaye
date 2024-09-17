document.addEventListener('DOMContentLoaded', function() {
    // Dropdown functionality
    const toggleButton = document.querySelector('.dropdown-toggle');
    const dropdownMenu = document.querySelector('.dropdown-menu');

    if (toggleButton) {
        toggleButton.addEventListener('click', function(event) {
            event.stopPropagation(); // Prevent event bubbling to close dropdown immediately
            dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
        });

        // Close dropdown if clicked outside specific dropdown
        document.addEventListener('click', function(event) {
            if (!toggleButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
                dropdownMenu.style.display = 'none';
            }
        });
    }

    // Modal functionality
    document.getElementById('open-modal-btn')?.addEventListener('click', openModal);
    document.getElementById('close-modal-btn')?.addEventListener('click', closeModal);
    document.getElementById('save-item-btn')?.addEventListener('click', saveItem);
    document.getElementById('cancel-btn')?.addEventListener('click', function() {
        clearForm('modal-form');
        closeModal();
    });

    // Property and part functionality
    document.getElementById('add-property-btn')?.addEventListener('click', addProperty);
    document.getElementById('add-part-btn')?.addEventListener('click', addPart);

    // Icon selector dropdown
    const iconSelector = document.getElementById('icon-selector');
    const iconList = document.getElementById('icon-list');
    const selectedIconInput = document.getElementById('selected-icon');

    if (iconSelector && iconList) {
        iconSelector.addEventListener('click', function(event) {
            event.stopPropagation();
            iconList.style.display = iconList.style.display === 'block' ? 'none' : 'block';
        });

        // Handle icon selection
        document.querySelectorAll('#icon-list .option').forEach(item => {
            item.addEventListener('click', function() {
                const iconClass = this.getAttribute('data-icon');
                const iconText = this.textContent.trim();
                
                // Update the selected icon display
                iconSelector.innerHTML = `<i class="fa ${iconClass}"></i> <span>${iconText}</span>`;
                
                // Update the hidden input value
                selectedIconInput.value = iconClass;
                
                // Hide the dropdown menu
                iconList.style.display = 'none';
            });
        });

        // Close dropdown if clicked outside
        document.addEventListener('click', function(event) {
            if (!iconSelector.contains(event.target) && !iconList.contains(event.target)) {
                iconList.style.display = 'none';
            }
        });
    }

    // Attach click event listeners to existing sidebar items
    document.querySelectorAll('#item-list .item').forEach(item => {
        item.addEventListener('click', function() {
            editItem(this);
        });
    });
});

// Open modal
function openModal() {
    document.getElementById('modal-container').style.display = 'block';
}

// Close modal
function closeModal() {
    document.getElementById('modal-container').style.display = 'none';
}

// Save item and add it to the sidebar
function saveItem() {
    try {
        const name = document.getElementById('name').value;
        const shortName = document.getElementById('short-name').value;
        const icon = document.getElementById('selected-icon').value;

        console.log('Saving:', name, shortName, icon); // Debugging output

        // Retrieve custom properties
        const properties = [];
        document.querySelectorAll('#properties-body .property-row').forEach(row => {
            const label = row.querySelector('.label-box input').value;
            const value = row.querySelector('.value-box input').value;
            properties.push({ label, value });
        });

        console.log('Properties:', properties); // Debugging output

        if (name && icon) {
            const itemList = document.getElementById('item-list');

            // Check if item already exists
            const existingItem = itemList.querySelector(`.item[data-name="${name}"]`);
            if (existingItem) {
                // Update existing item
                existingItem.dataset.shortName = shortName;
                existingItem.dataset.icon = icon;
                existingItem.dataset.properties = JSON.stringify(properties);
                existingItem.innerHTML = `<span class="icon"><i class="${icon}"></i></span> ${name}`;
            } else {
                // Create new item
                const newItem = document.createElement('div');
                newItem.classList.add('item');
                newItem.dataset.name = name;
                newItem.dataset.shortName = shortName;
                newItem.dataset.icon = icon;
                newItem.dataset.properties = JSON.stringify(properties);
                newItem.innerHTML = `<span class="icon"><i class="${icon}"></i></span> ${name}`;
                itemList.appendChild(newItem);
            }

            // Clear the form
            clearForm('modal-form');

            // Close the modal
            closeModal();
        } else {
            alert('Please fill out all fields.');
        }
    } catch (error) {
        console.error('Error saving item:', error);
        alert('Failed to save item.');
    }
}


// Clear form fields
function clearForm(formId) {
    document.getElementById(formId)?.reset();
    document.getElementById('properties-body').innerHTML = ''; // Clear property rows
    document.getElementById('icon-selector').innerHTML = `<i class="fa fa-icon-placeholder"></i> <span>Select Icon</span>`; // Reset icon display
}

// Edit item
function editItem(itemElement) {
    console.log('Item clicked:', itemElement);
    
    const name = itemElement.dataset.name;
    const shortName = itemElement.dataset.shortName;
    const icon = itemElement.dataset.icon;
    const properties = JSON.parse(itemElement.dataset.properties || '[]');

    console.log('Data:', { name, shortName, icon, properties });

    document.getElementById('name').value = name;
    document.getElementById('short-name').value = shortName;
    document.getElementById('selected-icon').value = icon;
    document.getElementById('icon-selector').innerHTML = `<i class="${icon}"></i> <span>${name}</span>`;

    const body = document.getElementById('properties-body');
    body.innerHTML = '';
    properties.forEach(property => {
        const newRow = document.createElement('div');
        newRow.classList.add('property-row');
        newRow.innerHTML = `
            <div class="label-box"><input type="text" name="label" value="${property.label}" placeholder="Label"></div>
            <div class="value-box"><input type="text" name="value" value="${property.value}" placeholder="Value"></div>
            <div class="name-box"><input type="checkbox" name="name"></div>
            <div class="required-box"><input type="checkbox" name="required"></div>
            <div class="delete-box"><button class="remove-btn" onclick="removeProperty(this)"><i class="fas fa-trash"></i></button></div>
        `;
        body.appendChild(newRow);
    });

    openModal();
}


// Add new property row
function addProperty() {
    const body = document.getElementById('properties-body');
    const newRow = document.createElement('div');
    newRow.classList.add('property-row');

    newRow.innerHTML = `
        <div class="label-box"><input type="text" placeholder="label"></div>
        <div class="value-box"><input type="text" placeholder="value"></div>
        <div class="name-box"><input type="checkbox"></div>
        <div class="required-box"><input type="checkbox"></div>
        <div class="delete-box"><button class="remove-btn" onclick="removeProperty(this)"><i class="fas fa-trash"></i></button></div>
    `;

    body.appendChild(newRow);

    // Add event listener to the 'value' field to trigger new input creation
    const valueField = newRow.querySelector('input[name="value"]') || newRow.querySelector('.value-box input');
    const valueContainer = newRow.querySelector('.value-container') || newRow.querySelector('.value-box');

    valueField.addEventListener('input', function() {
        if (valueField.value !== '' && !valueContainer.querySelector('.extra-value')) {
            // Create a new input field dynamically
            const newValueField = document.createElement('input');
            newValueField.type = 'text';
            newValueField.name = 'value';
            newValueField.classList.add('autocomplete-input', 'extra-value');
            newValueField.placeholder = 'Value';

            // Append the new input field into the same container
            valueContainer.appendChild(newValueField);

            // Add event listener for the newly added input
            newValueField.addEventListener('input', function() {
                if (newValueField.value !== '') {
                    addNewValueField(valueContainer);
                }
            });
        }
    });
}

function addNewValueField(container) {
    // Create another input field dynamically if one doesn't exist already
    if (!container.querySelector('.extra-value:last-of-type').value) return; // Prevent creating extra input fields if the last one is empty

    const newValueField = document.createElement('input');
    newValueField.type = 'text';
    newValueField.name = 'value';
    newValueField.classList.add('autocomplete-input', 'extra-value');
    newValueField.placeholder = 'Value';

    container.appendChild(newValueField);

    // Add event listener to keep adding input fields when typing in the new one
    newValueField.addEventListener('input', function() {
        if (newValueField.value !== '') {
            addNewValueField(container);
        }
    });
}

function removeProperty(button) {
    const row = button.closest('.property-row');
    row.remove();
}

// Add new part row
function addPart() {
    const body = document.getElementById('parts-body');
    const newRow = document.createElement('div');
    newRow.classList.add('part-row');

    newRow.innerHTML = `
        <div class="partname-box"><input type="text" placeholder="Part Name"></div>
        <div class="name-box"><input type="checkbox"></div>
        <div class="required-box"><input type="checkbox"></div>
        <div class="delete-box"><button class="remove-btn" onclick="removePart(this)"><i class="fas fa-trash"></i></button></div>
    `;

    body.appendChild(newRow);

    // Add remove button functionality
    newRow.querySelector('.remove-btn').addEventListener('click', function() {
        removePart(this);
    });
}

// Remove part
function removePart(button) {
    const row = button.closest('.part-row');
    row.remove();
}
