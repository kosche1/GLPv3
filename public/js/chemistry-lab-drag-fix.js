/**
 * Chemistry Lab Drag and Drop Fix
 *
 * This file provides a simplified drag and drop implementation for the Chemistry Lab
 * that works independently of Matter.js to ensure basic functionality.
 */

document.addEventListener('DOMContentLoaded', function() {
    console.log('Chemistry Lab Drag Fix loaded');

    // Check if we're on a chemistry lab page
    const labBench = document.querySelector('.lab-bench');
    if (!labBench) {
        console.log('No lab bench found, skipping Chemistry Lab Drag Fix');
        return;
    }

    // Initialize the drag and drop functionality
    initDragAndDrop();

    /**
     * Initialize drag and drop functionality
     */
    function initDragAndDrop() {
        try {
            console.log('Initializing drag and drop functionality');

            // Make chemicals draggable
            const chemicalItems = document.querySelectorAll('.chemical-item');
            chemicalItems.forEach(item => {
                makeItemDraggable(item, 'chemical');
            });

            // Make equipment draggable
            const equipmentItems = document.querySelectorAll('.equipment-item');
            equipmentItems.forEach(item => {
                makeItemDraggable(item, 'equipment');
            });

            // Make lab bench a drop target
            setupDropTarget(labBench);

            console.log('Drag and drop initialization complete');
        } catch (error) {
            console.error('Error initializing drag and drop:', error);
        }
    }

    /**
     * Make an item draggable
     */
    function makeItemDraggable(item, type) {
        try {
            // Add draggable attribute
            item.setAttribute('draggable', 'true');

            // Add visual indicator
            item.classList.add('cursor-grab');
            item.addEventListener('mousedown', () => {
                item.classList.remove('cursor-grab');
                item.classList.add('cursor-grabbing');
            });

            item.addEventListener('mouseup', () => {
                item.classList.remove('cursor-grabbing');
                item.classList.add('cursor-grab');
            });

            // Add dragstart event listener
            item.addEventListener('dragstart', (event) => {
                try {
                    // Get item ID
                    const itemId = type === 'chemical'
                        ? item.getAttribute('data-chemical')
                        : item.getAttribute('data-equipment');

                    if (!itemId) {
                        console.error(`No data-${type} attribute found on dragged item`);
                        return;
                    }

                    // Set drag data
                    event.dataTransfer.setData('text/plain', JSON.stringify({
                        type: type,
                        id: itemId
                    }));

                    // Set drag image - using a simpler approach to avoid issues
                    try {
                        // Create a simple drag image
                        const dragImage = document.createElement('div');
                        dragImage.textContent = type === 'chemical' ? 'Chemical' : 'Equipment';
                        dragImage.style.position = 'absolute';
                        dragImage.style.top = '-1000px';
                        dragImage.style.backgroundColor = type === 'chemical' ? '#3b82f6' : '#6b7280';
                        dragImage.style.color = 'white';
                        dragImage.style.padding = '8px';
                        dragImage.style.borderRadius = '4px';
                        dragImage.style.zIndex = '9999';
                        document.body.appendChild(dragImage);

                        // Try to set the drag image, but don't fail if it doesn't work
                        try {
                            event.dataTransfer.setDragImage(dragImage, 0, 0);
                        } catch (e) {
                            console.log('Could not set drag image, using default');
                        }

                        // Remove the drag image after a short delay
                        setTimeout(() => {
                            if (dragImage.parentNode) {
                                document.body.removeChild(dragImage);
                            }
                        }, 10);
                    } catch (error) {
                        console.error('Error setting drag image:', error);
                        // Continue with default drag image
                    }

                    console.log(`Drag started: ${type} - ${itemId}`);
                } catch (error) {
                    console.error(`Error in ${type} dragstart handler:`, error);
                }
            });

            // We'll handle clicks in the chemistry-lab-pour.js file
            // This is just for drag and drop functionality
        } catch (error) {
            console.error('Error making item draggable:', error);
        }
    }

    /**
     * Set up drop target
     */
    function setupDropTarget(target) {
        try {
            // Add dragover event listener
            target.addEventListener('dragover', (event) => {
                event.preventDefault(); // Allow drop
                target.classList.add('drag-over');
            });

            // Add dragleave event listener
            target.addEventListener('dragleave', () => {
                target.classList.remove('drag-over');
            });

            // Add drop event listener
            target.addEventListener('drop', (event) => {
                try {
                    event.preventDefault();
                    target.classList.remove('drag-over');

                    // Get drop data
                    const dataText = event.dataTransfer.getData('text/plain');
                    if (!dataText) {
                        console.error('No data found in drop event');
                        return;
                    }

                    const data = JSON.parse(dataText);
                    if (!data || !data.type || !data.id) {
                        console.error('Invalid data format in drop event');
                        return;
                    }

                    // Get drop coordinates
                    const rect = target.getBoundingClientRect();
                    const x = event.clientX - rect.left;
                    const y = event.clientY - rect.top;

                    // Create item at drop location
                    createItem(data.type, data.id, x, y);

                    console.log(`Item dropped: ${data.type} - ${data.id} at (${x}, ${y})`);
                } catch (error) {
                    console.error('Error in drop handler:', error);
                }
            });
        } catch (error) {
            console.error('Error setting up drop target:', error);
        }
    }

    /**
     * Create an item in the lab bench
     */
    function createItem(type, id, x, y) {
        try {
            // Remove placeholder if it exists
            const placeholder = labBench.querySelector('.placeholder');
            if (placeholder) {
                placeholder.remove();
            }

            // Create item element
            const item = document.createElement('div');
            item.classList.add('lab-item', `lab-${type}`);
            item.setAttribute(`data-${type}`, id);
            item.setAttribute('data-type', type);

            // Set position
            if (x && y) {
                item.style.position = 'absolute';
                item.style.left = `${x}px`;
                item.style.top = `${y}px`;
            } else {
                // Default to center if no coordinates provided
                item.style.position = 'absolute';
                item.style.left = '50%';
                item.style.top = '50%';
                item.style.transform = 'translate(-50%, -50%)';
            }

            // Set appearance based on type and id
            try {
                if (type === 'chemical') {
                    let color, symbol, name;
                    switch (id) {
                        case 'water':
                            color = '#3b82f6'; // blue-500
                            symbol = 'H₂O';
                            name = 'Water';
                            break;
                        case 'hcl':
                            color = '#eab308'; // yellow-500
                            symbol = 'HCl';
                            name = 'Hydrochloric Acid';
                            break;
                        case 'naoh':
                            color = '#a855f7'; // purple-500
                            symbol = 'NaOH';
                            name = 'Sodium Hydroxide';
                            break;
                        case 'phenolphthalein':
                            color = '#f9a8d4'; // pink-300
                            symbol = 'Ph';
                            name = 'Phenolphthalein';
                            break;
                        default:
                            color = '#6b7280'; // gray-500
                            symbol = id;
                            name = id;
                    }

                    // Use a simpler HTML structure to avoid rendering issues
                    item.innerHTML = `
                        <div class="chemical-visual">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center" style="background-color: ${color}">
                                <span class="text-sm font-bold text-black">${symbol}</span>
                            </div>
                            <div class="chemical-label">${name}</div>
                        </div>
                    `;
                } else if (type === 'equipment') {
                    // Use a simpler approach for equipment visualization
                    let equipmentHTML = '';
                    let name = '';

                    switch (id) {
                        case 'beaker':
                            name = 'Beaker';
                            equipmentHTML = `<div class="w-16 h-16 border-2 border-gray-300 rounded-md flex items-center justify-center">
                                <span class="text-gray-300">Beaker</span>
                            </div>`;
                            break;
                        case 'test-tube':
                            name = 'Test Tube';
                            equipmentHTML = `<div class="w-16 h-16 border-2 border-gray-300 rounded-md flex items-center justify-center">
                                <span class="text-gray-300">Test Tube</span>
                            </div>`;
                            break;
                        case 'bunsen-burner':
                            name = 'Bunsen Burner';
                            equipmentHTML = `<div class="w-16 h-16 border-2 border-gray-300 rounded-md flex items-center justify-center">
                                <span class="text-gray-300">Burner</span>
                            </div>`;
                            break;
                        case 'pipette':
                            name = 'Pipette';
                            equipmentHTML = `<div class="w-16 h-16 border-2 border-gray-300 rounded-md flex items-center justify-center">
                                <span class="text-gray-300">Pipette</span>
                            </div>`;
                            break;
                        default:
                            name = id;
                            equipmentHTML = `<div class="w-16 h-16 bg-gray-700 rounded-lg flex items-center justify-center">
                                <span class="text-sm font-bold text-white">${id}</span>
                            </div>`;
                    }

                    item.innerHTML = `
                        <div class="equipment-visual">
                            ${equipmentHTML}
                            <div class="equipment-label">${name}</div>
                        </div>
                    `;
                }
            } catch (error) {
                console.error('Error setting item appearance:', error);

                // Fallback to a simple representation
                item.innerHTML = `
                    <div class="fallback-visual">
                        <div class="w-12 h-12 bg-gray-700 rounded-lg flex items-center justify-center">
                            <span class="text-sm font-bold text-white">${type}</span>
                        </div>
                        <div class="fallback-label">${id}</div>
                    </div>
                `;
            }

            // Make the item draggable within the lab bench
            makeLabItemDraggable(item);

            // Add to lab bench
            labBench.appendChild(item);

            // Trigger a custom event that the main chemistry-lab.js can listen for
            const event = new CustomEvent('lab-item-created', {
                detail: { type, id, x, y, element: item }
            });
            labBench.dispatchEvent(event);

            return item;
        } catch (error) {
            console.error('Error creating item:', error);
            return null;
        }
    }

    /**
     * Make a lab item draggable within the lab bench
     */
    function makeLabItemDraggable(item) {
        try {
            let isDragging = false;
            let startX, startY;
            let offsetX, offsetY;

            item.classList.add('cursor-grab');

            item.addEventListener('mousedown', (event) => {
                isDragging = true;
                item.classList.remove('cursor-grab');
                item.classList.add('cursor-grabbing');

                // Calculate offset
                const rect = item.getBoundingClientRect();
                offsetX = event.clientX - rect.left;
                offsetY = event.clientY - rect.top;

                // Remember start position
                startX = event.clientX;
                startY = event.clientY;

                // Bring to front
                item.style.zIndex = '100';
            });

            document.addEventListener('mousemove', (event) => {
                if (!isDragging) return;

                // Calculate new position
                const labBenchRect = labBench.getBoundingClientRect();
                const x = event.clientX - labBenchRect.left - offsetX;
                const y = event.clientY - labBenchRect.top - offsetY;

                // Constrain to lab bench
                const maxX = labBenchRect.width - item.offsetWidth;
                const maxY = labBenchRect.height - item.offsetHeight;

                const constrainedX = Math.max(0, Math.min(x, maxX));
                const constrainedY = Math.max(0, Math.min(y, maxY));

                // Update position
                item.style.left = `${constrainedX}px`;
                item.style.top = `${constrainedY}px`;
            });

            document.addEventListener('mouseup', () => {
                if (!isDragging) return;

                isDragging = false;
                item.classList.remove('cursor-grabbing');
                item.classList.add('cursor-grab');

                // Reset z-index
                item.style.zIndex = '';

                // Trigger a custom event that the main chemistry-lab.js can listen for
                const event = new CustomEvent('lab-item-moved', {
                    detail: {
                        type: item.getAttribute('data-type'),
                        id: item.getAttribute(`data-${item.getAttribute('data-type')}`),
                        element: item
                    }
                });
                labBench.dispatchEvent(event);
            });
        } catch (error) {
            console.error('Error making lab item draggable:', error);
        }
    }
});
