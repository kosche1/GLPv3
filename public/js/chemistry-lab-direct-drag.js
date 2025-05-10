/**
 * Chemistry Lab Direct Drag and Drop
 *
 * This file implements a simplified direct drag and drop functionality
 * for the Chemistry Lab, allowing chemicals to be dragged directly onto equipment.
 */

document.addEventListener('DOMContentLoaded', function() {
    console.log('Chemistry Lab Direct Drag and Drop loaded');

    // Check if we're on a chemistry lab page
    const labBench = document.querySelector('.lab-bench');
    if (!labBench) {
        console.log('No lab bench found, skipping Chemistry Lab Direct Drag and Drop');
        return;
    }

    // Add a status display to show the last action
    const statusDisplay = document.createElement('div');
    statusDisplay.id = 'chemistry-status-display';
    statusDisplay.style.position = 'fixed';
    statusDisplay.style.bottom = '20px';
    statusDisplay.style.left = '50%';
    statusDisplay.style.transform = 'translateX(-50%)';
    statusDisplay.style.backgroundColor = 'rgba(0, 0, 0, 0.7)';
    statusDisplay.style.color = 'white';
    statusDisplay.style.padding = '10px 20px';
    statusDisplay.style.borderRadius = '8px';
    statusDisplay.style.zIndex = '9999';
    statusDisplay.style.textAlign = 'center';
    statusDisplay.style.fontWeight = 'bold';
    statusDisplay.style.fontSize = '14px';
    statusDisplay.style.boxShadow = '0 4px 8px rgba(0, 0, 0, 0.2)';
    statusDisplay.style.display = 'none';
    document.body.appendChild(statusDisplay);

    // Function to update status display
    window.updateChemistryStatus = function(message) {
        statusDisplay.textContent = message;
        statusDisplay.style.display = 'block';

        // Auto-hide after 5 seconds
        setTimeout(() => {
            statusDisplay.style.opacity = '0';
            statusDisplay.style.transition = 'opacity 0.5s ease';
            setTimeout(() => {
                statusDisplay.style.display = 'none';
                statusDisplay.style.opacity = '1';
                statusDisplay.style.transition = '';
            }, 500);
        }, 5000);
    };

    // Initialize the functionality
    initDirectDragAndDrop();

    /**
     * Initialize direct drag and drop functionality
     */
    function initDirectDragAndDrop() {
        try {
            console.log('Initializing direct drag and drop');

            // Make all chemical items draggable
            setupChemicalDragging();

            // Set up equipment as drop targets
            setupEquipmentDropTargets();

            // Add a mutation observer to handle dynamically added items
            setupMutationObserver();

            // Debug buttons removed as functionality is working

            console.log('Direct drag and drop initialized');
        } catch (error) {
            console.error('Error initializing direct drag and drop:', error);
        }
    }

    /**
     * Set up chemical items for dragging
     */
    function setupChemicalDragging() {
        try {
            const chemicalItems = document.querySelectorAll('.chemical-item');
            console.log(`Setting up ${chemicalItems.length} chemical items for dragging`);

            chemicalItems.forEach(item => {
                // Make it draggable
                item.setAttribute('draggable', 'true');

                // Add drag indicator
                const dragIndicator = document.createElement('div');
                dragIndicator.textContent = 'Drag me';
                dragIndicator.className = 'drag-indicator';
                dragIndicator.style.position = 'absolute';
                dragIndicator.style.top = '0';
                dragIndicator.style.right = '0';
                dragIndicator.style.backgroundColor = 'rgba(59, 130, 246, 0.8)';
                dragIndicator.style.color = 'white';
                dragIndicator.style.padding = '2px 5px';
                dragIndicator.style.borderRadius = '4px';
                dragIndicator.style.fontSize = '10px';
                dragIndicator.style.zIndex = '100';
                dragIndicator.style.opacity = '0';
                dragIndicator.style.transition = 'opacity 0.3s ease';

                // Make sure the item has relative positioning for absolute child positioning
                item.style.position = 'relative';
                item.appendChild(dragIndicator);

                // Show indicator on hover
                item.addEventListener('mouseenter', () => {
                    dragIndicator.style.opacity = '1';
                });

                item.addEventListener('mouseleave', () => {
                    dragIndicator.style.opacity = '0';
                });

                // Add drag start handler
                item.addEventListener('dragstart', function(event) {
                    console.log('Chemical drag started');

                    // Get chemical ID
                    const chemicalId = item.getAttribute('data-chemical');
                    if (!chemicalId) {
                        console.error('No chemical ID found');
                        return;
                    }

                    // Set drag data with multiple MIME types for better compatibility
                    const data = JSON.stringify({
                        type: 'chemical',
                        id: chemicalId
                    });

                    // Use both application/json and text/plain for maximum compatibility
                    event.dataTransfer.setData('application/json', data);
                    event.dataTransfer.setData('text/plain', data);

                    // Set effectAllowed to all possible operations
                    event.dataTransfer.effectAllowed = 'all';

                    // Create a small, fixed-size drag image with CSS class
                    const dragImage = document.createElement('div');
                    dragImage.className = 'chemical-drag-image';
                    dragImage.textContent = chemicalId.toUpperCase();
                    dragImage.style.backgroundColor = getChemicalColor(chemicalId);
                    document.body.appendChild(dragImage);

                    // Set the drag image
                    event.dataTransfer.setDragImage(dragImage, 20, 20);

                    // Remove the drag image element after it's been used
                    setTimeout(() => {
                        if (dragImage.parentNode) {
                            document.body.removeChild(dragImage);
                        }
                    }, 100);

                    // Add visual feedback
                    item.classList.add('dragging');

                    // Highlight all droppable equipment to make them more visible
                    highlightDroppableEquipment(true);

                    console.log(`Dragging chemical: ${chemicalId}`);
                });

                // Add drag end handler
                item.addEventListener('dragend', function() {
                    item.classList.remove('dragging');

                    // Remove highlighting from equipment
                    highlightDroppableEquipment(false);
                });
            });
        } catch (error) {
            console.error('Error setting up chemical dragging:', error);
        }
    }

    /**
     * Set up equipment items as drop targets
     */
    function setupEquipmentDropTargets() {
        try {
            // Find all equipment items on the bench
            const equipmentItems = document.querySelectorAll('.lab-item[data-type="equipment"]');
            console.log(`Found ${equipmentItems.length} equipment items on bench`);

            equipmentItems.forEach(item => {
                makeEquipmentDroppable(item);
            });

            // Also check for equipment in the equipment table
            const equipmentTable = document.querySelector('.equipment-table');
            if (equipmentTable) {
                const tableEquipment = equipmentTable.querySelectorAll('.lab-item[data-type="equipment"]');
                console.log(`Found ${tableEquipment.length} equipment items in table`);

                tableEquipment.forEach(item => {
                    makeEquipmentDroppable(item);
                });
            }
        } catch (error) {
            console.error('Error setting up equipment drop targets:', error);
        }
    }

    /**
     * Make an equipment item droppable
     */
    function makeEquipmentDroppable(item) {
        try {
            // Check if it's a beaker or test tube
            const equipmentType = item.getAttribute('data-equipment');
            if (equipmentType !== 'beaker' && equipmentType !== 'test-tube') {
                return;
            }

            console.log(`Making ${equipmentType} droppable`);

            // Skip if already made droppable
            if (item.hasAttribute('data-direct-droppable')) {
                return;
            }

            // Mark as droppable
            item.setAttribute('data-direct-droppable', 'true');

            // Add subtle visual indicator
            item.style.outline = '1px dashed rgba(16, 185, 129, 0.3)';

            // Add dragover handler with enhanced visual feedback
            item.addEventListener('dragover', function(event) {
                event.preventDefault();
                event.stopPropagation();

                // Set dropEffect to copy to show a "+" cursor
                event.dataTransfer.dropEffect = 'copy';

                // Add visual feedback
                item.classList.add('drag-over');

                // Increase the size of the drop target for easier targeting
                item.style.transform = 'scale(1.1)';
                item.style.zIndex = '100';
                item.style.boxShadow = '0 0 15px rgba(16, 185, 129, 0.7)';
            });

            // Add dragleave handler to reset styles
            item.addEventListener('dragleave', function() {
                item.classList.remove('drag-over');

                // Reset the styles
                item.style.transform = '';
                item.style.zIndex = '';
                item.style.boxShadow = '';
            });

            // Add drop handler
            item.addEventListener('drop', function(event) {
                event.preventDefault();
                event.stopPropagation();

                console.log('Drop event on equipment');

                // Reset all visual styles
                item.classList.remove('drag-over');
                item.style.transform = '';
                item.style.zIndex = '';
                item.style.boxShadow = '';

                try {
                    // Try to get the drop data from multiple MIME types
                    let dataText = event.dataTransfer.getData('application/json');

                    // If application/json fails, try text/plain
                    if (!dataText) {
                        dataText = event.dataTransfer.getData('text/plain');
                        console.log('Using text/plain data instead of application/json');
                    }

                    // If both fail, try to get all available types and use the first one
                    if (!dataText) {
                        const types = event.dataTransfer.types;
                        console.log('Available data types:', types);

                        if (types && types.length > 0) {
                            dataText = event.dataTransfer.getData(types[0]);
                            console.log(`Using data from type: ${types[0]}`);
                        }
                    }

                    if (!dataText) {
                        console.error('No data in drop event');
                        showNotification('Drop failed: No data found', true);
                        return;
                    }

                    // Try to parse the data
                    let data;
                    try {
                        data = JSON.parse(dataText);
                    } catch (parseError) {
                        console.error('Error parsing drop data:', parseError);
                        console.log('Raw data:', dataText);

                        // If parsing fails, try to use the raw text as a chemical ID
                        if (typeof dataText === 'string' && dataText.trim()) {
                            data = { type: 'chemical', id: dataText.trim() };
                            console.log('Created data object from raw text:', data);
                        } else {
                            showNotification('Drop failed: Invalid data format', true);
                            return;
                        }
                    }

                    if (!data || data.type !== 'chemical') {
                        console.log('Not a chemical, ignoring');
                        return;
                    }

                    const chemicalId = data.id;
                    console.log(`Chemical ${chemicalId} dropped on ${equipmentType}`);

                    // Pour the chemical
                    pourChemical(chemicalId, item);
                } catch (error) {
                    console.error('Error handling drop:', error);
                }
            });
        } catch (error) {
            console.error('Error making equipment droppable:', error);
        }
    }

    /**
     * Pour a chemical into equipment
     */
    function pourChemical(chemicalId, equipmentItem) {
        try {
            console.log(`Pouring ${chemicalId} into equipment`);

            // Get equipment type
            const equipmentType = equipmentItem.getAttribute('data-equipment');

            // Check if equipment already contains something
            const currentContents = equipmentItem.getAttribute('data-contains');

            if (currentContents && currentContents !== '') {
                // Mix chemicals
                console.log(`Mixing ${currentContents} with ${chemicalId}`);

                // Create a status message for this action
                let statusMessage;

                // If mixing the same chemical, don't show a notification
                if (currentContents === chemicalId) {
                    // Skip notification for adding the same chemical
                    statusMessage = `Added more ${getChemicalName(chemicalId)} to ${equipmentType}`;
                } else if (currentContents === 'mixture') {
                    statusMessage = `Added ${getChemicalName(chemicalId)} to mixture`;
                } else {
                    statusMessage = `Mixed ${getChemicalName(currentContents)} with ${getChemicalName(chemicalId)}`;
                    // Only show notification for actual mixing of different chemicals
                    showNotification(statusMessage);
                }
                if (window.updateChemistryStatus) {
                    window.updateChemistryStatus(statusMessage);
                }

                // Update equipment contents
                equipmentItem.setAttribute('data-contains', 'mixture');

                // Update visual indicator
                updateEquipmentVisual(equipmentItem, 'mixture');
            } else {
                // Pour new chemical
                console.log(`Pouring ${chemicalId} into empty ${equipmentType}`);

                // Show notification and update status display
                const statusMessage = `Poured ${getChemicalName(chemicalId)} into ${equipmentType}`;
                showNotification(statusMessage);
                if (window.updateChemistryStatus) {
                    window.updateChemistryStatus(statusMessage);
                }

                // Update equipment contents
                equipmentItem.setAttribute('data-contains', chemicalId);

                // Update visual indicator
                updateEquipmentVisual(equipmentItem, chemicalId);
            }

            // Add pour animation
            addPourAnimation(equipmentItem);
        } catch (error) {
            console.error('Error pouring chemical:', error);
        }
    }

    /**
     * Update the visual appearance of equipment after pouring
     */
    function updateEquipmentVisual(equipmentItem, chemicalId) {
        try {
            // Find or create container indicator
            let containerIndicator = equipmentItem.querySelector('.container-indicator');
            if (!containerIndicator) {
                containerIndicator = document.createElement('div');
                containerIndicator.className = 'container-indicator';
                containerIndicator.style.position = 'absolute';
                containerIndicator.style.bottom = '0';
                containerIndicator.style.left = '0';
                containerIndicator.style.width = '100%';
                containerIndicator.style.height = '0';
                containerIndicator.style.transition = 'height 0.5s ease, background-color 0.5s ease';
                containerIndicator.style.borderBottomLeftRadius = '4px';
                containerIndicator.style.borderBottomRightRadius = '4px';
                containerIndicator.style.zIndex = '5';
                equipmentItem.appendChild(containerIndicator);
            }

            // Update indicator
            containerIndicator.style.backgroundColor = getChemicalColor(chemicalId);
            containerIndicator.style.height = '50%';

            // Find or create container label
            let containerLabel = equipmentItem.querySelector('.container-label');
            if (!containerLabel) {
                containerLabel = document.createElement('div');
                containerLabel.className = 'container-label';
                containerLabel.style.position = 'absolute';
                containerLabel.style.bottom = '-20px';
                containerLabel.style.left = '50%';
                containerLabel.style.transform = 'translateX(-50%)';
                containerLabel.style.fontSize = '10px';
                containerLabel.style.color = 'white';
                containerLabel.style.backgroundColor = 'rgba(0, 0, 0, 0.5)';
                containerLabel.style.padding = '2px 6px';
                containerLabel.style.borderRadius = '4px';
                containerLabel.style.whiteSpace = 'nowrap';
                containerLabel.style.zIndex = '6';
                equipmentItem.appendChild(containerLabel);
            }

            // Update label
            containerLabel.textContent = getChemicalName(chemicalId);
        } catch (error) {
            console.error('Error updating equipment visual:', error);
        }
    }

    /**
     * Add pour animation
     */
    function addPourAnimation(equipmentItem) {
        try {
            // Add pulse effect
            equipmentItem.classList.add('pour-pulse');

            // Create ripple effect
            const ripple = document.createElement('div');
            ripple.className = 'pour-ripple';
            ripple.style.position = 'absolute';
            ripple.style.top = '50%';
            ripple.style.left = '50%';
            ripple.style.transform = 'translate(-50%, -50%)';
            ripple.style.backgroundColor = 'rgba(16, 185, 129, 0.3)';
            ripple.style.borderRadius = '50%';
            ripple.style.width = '0';
            ripple.style.height = '0';
            ripple.style.animation = 'ripple 0.8s ease-out forwards';
            equipmentItem.appendChild(ripple);

            // Remove effects after animation
            setTimeout(() => {
                equipmentItem.classList.remove('pour-pulse');
                if (ripple.parentNode) {
                    ripple.parentNode.removeChild(ripple);
                }
            }, 1000);
        } catch (error) {
            console.error('Error adding pour animation:', error);
        }
    }

    /**
     * Set up mutation observer to handle dynamically added items
     */
    function setupMutationObserver() {
        try {
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.type === 'childList' && mutation.addedNodes.length > 0) {
                        mutation.addedNodes.forEach(function(node) {
                            if (node.nodeType === 1) { // Element node
                                // Check for new equipment items
                                if (node.classList.contains('lab-item') &&
                                    node.getAttribute('data-type') === 'equipment') {
                                    console.log('New equipment item detected');
                                    makeEquipmentDroppable(node);
                                }

                                // Check for new chemical items
                                const chemicalItems = node.querySelectorAll('.chemical-item');
                                if (chemicalItems.length > 0) {
                                    console.log('New chemical items detected');
                                    setupChemicalDragging();
                                }
                            }
                        });
                    }
                });
            });

            // Start observing the lab bench
            observer.observe(document.body, { childList: true, subtree: true });
            console.log('Mutation observer set up');
        } catch (error) {
            console.error('Error setting up mutation observer:', error);
        }
    }

    // Debug button function removed as functionality is working properly

    /**
     * Show notification
     */
    function showNotification(message, isError = false) {
        try {
            const notification = document.createElement('div');
            notification.textContent = message;
            notification.style.position = 'fixed';
            notification.style.top = '20px';
            notification.style.left = '50%';
            notification.style.transform = 'translateX(-50%)';
            notification.style.backgroundColor = isError ? '#ef4444' : '#10b981';
            notification.style.color = 'white';
            notification.style.padding = '10px 20px';
            notification.style.borderRadius = '4px';
            notification.style.zIndex = '9999';
            notification.style.boxShadow = '0 4px 6px rgba(0, 0, 0, 0.1)';

            document.body.appendChild(notification);

            setTimeout(() => {
                notification.style.opacity = '0';
                notification.style.transition = 'opacity 0.5s ease';
                setTimeout(() => {
                    if (notification.parentNode) {
                        notification.parentNode.removeChild(notification);
                    }
                }, 500);
            }, 3000);
        } catch (error) {
            console.error('Error showing notification:', error);
        }
    }

    /**
     * Get chemical name
     */
    function getChemicalName(chemical) {
        switch (chemical) {
            case 'water': return 'Water';
            case 'hcl': return 'Hydrochloric Acid';
            case 'naoh': return 'Sodium Hydroxide';
            case 'phenolphthalein': return 'Phenolphthalein';
            case 'mixture': return 'Chemical Mixture';
            default: return chemical;
        }
    }

    /**
     * Get chemical color
     */
    function getChemicalColor(chemical) {
        switch (chemical) {
            case 'water': return '#3b82f6'; // blue
            case 'hcl': return '#eab308'; // yellow
            case 'naoh': return '#a855f7'; // purple
            case 'phenolphthalein': return '#f9a8d4'; // pink
            case 'mixture': return '#6b7280'; // gray
            default: return '#6b7280'; // gray
        }
    }

    /**
     * Highlight all droppable equipment to make them more visible during drag
     */
    function highlightDroppableEquipment(highlight) {
        try {
            // Find all droppable equipment
            const droppableItems = document.querySelectorAll('[data-direct-droppable="true"]');

            droppableItems.forEach(item => {
                if (highlight) {
                    // Add a pulsing outline and increase size slightly
                    item.classList.add('equipment-highlight');

                    // Add a "Drop here" label
                    if (!item.querySelector('.drop-here-label')) {
                        const label = document.createElement('div');
                        label.className = 'drop-here-label';
                        label.textContent = 'Drop here';
                        label.style.position = 'absolute';
                        label.style.top = '-25px';
                        label.style.left = '50%';
                        label.style.transform = 'translateX(-50%)';
                        label.style.backgroundColor = 'rgba(16, 185, 129, 0.9)';
                        label.style.color = 'white';
                        label.style.padding = '3px 8px';
                        label.style.borderRadius = '4px';
                        label.style.fontSize = '12px';
                        label.style.fontWeight = 'bold';
                        label.style.zIndex = '200';
                        label.style.boxShadow = '0 2px 5px rgba(0, 0, 0, 0.2)';
                        label.style.pointerEvents = 'none'; // Don't interfere with mouse events
                        item.appendChild(label);
                    }
                } else {
                    // Remove highlighting
                    item.classList.remove('equipment-highlight');

                    // Remove the "Drop here" label
                    const label = item.querySelector('.drop-here-label');
                    if (label) {
                        label.parentNode.removeChild(label);
                    }
                }
            });

            console.log(`${highlight ? 'Added' : 'Removed'} highlighting from ${droppableItems.length} equipment items`);
        } catch (error) {
            console.error('Error highlighting droppable equipment:', error);
        }
    }
});
