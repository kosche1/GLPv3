/**
 * Chemistry Lab Pour Functionality
 *
 * This file adds pouring functionality to the Chemistry Lab simulator.
 * It allows chemicals to be poured from one container to another.
 */

document.addEventListener('DOMContentLoaded', function() {
    console.log('Chemistry Lab Pour functionality loaded');

    // Check if we're on a chemistry lab page
    const labBench = document.querySelector('.lab-bench');
    if (!labBench) {
        console.log('No lab bench found, skipping Chemistry Lab Pour functionality');
        return;
    }

    // Debug message removed as functionality is working properly

    // Global state to track selections
    window.chemistryLabState = {
        selectedChemical: null,
        selectedEquipment: null,

        // Set selected chemical
        setSelectedChemical: function(item) {
            this.selectedChemical = item;
            console.log('Set selected chemical:', item);
        },

        // Set selected equipment
        setSelectedEquipment: function(item) {
            this.selectedEquipment = item;
            console.log('Set selected equipment:', item);
        },

        // Clear selected chemical
        clearSelectedChemical: function() {
            this.selectedChemical = null;
            console.log('Cleared selected chemical');
        },

        // Clear selected equipment
        clearSelectedEquipment: function() {
            this.selectedEquipment = null;
            console.log('Cleared selected equipment');
        },

        // Check if a chemical is selected
        hasSelectedChemical: function() {
            return this.selectedChemical !== null;
        },

        // Check if equipment is selected
        hasSelectedEquipment: function() {
            return this.selectedEquipment !== null;
        }
    };

    // Initialize the pour functionality
    initPourFunctionality();

    // Initialize direct drag and drop functionality
    initDirectDragAndDrop();

    // Set up a periodic check to ensure all equipment items are droppable
    setInterval(() => {
        makeEquipmentItemsDroppable();
    }, 2000);

    /**
     * Initialize direct drag and drop functionality
     */
    function initDirectDragAndDrop() {
        try {
            console.log('Initializing direct drag and drop functionality');

            // Debug message removed as functionality is working properly

            // Make all chemical items draggable
            const chemicalItems = document.querySelectorAll('.chemical-item');
            chemicalItems.forEach(item => {
                item.setAttribute('draggable', 'true');

                // Add drag start handler
                item.addEventListener('dragstart', function(event) {
                    try {
                        console.log('Chemical item drag started');

                        // Get the chemical ID
                        const chemicalId = item.getAttribute('data-chemical');
                        if (!chemicalId) {
                            console.error('No data-chemical attribute found');
                            return;
                        }

                        // Set the drag data
                        event.dataTransfer.setData('text/plain', JSON.stringify({
                            type: 'chemical',
                            id: chemicalId
                        }));

                        // Visual feedback
                        item.classList.add('dragging');

                        console.log(`Started dragging chemical: ${chemicalId}`);
                    } catch (error) {
                        console.error('Error in chemical dragstart handler:', error);
                    }
                });

                // Add drag end handler
                item.addEventListener('dragend', function() {
                    item.classList.remove('dragging');
                });
            });

            // Make all equipment items on the bench droppable
            makeEquipmentItemsDroppable();

            console.log('Direct drag and drop initialization complete');
        } catch (error) {
            console.error('Error initializing direct drag and drop:', error);
        }
    }

    /**
     * Initialize pour functionality
     */
    function initPourFunctionality() {
        try {
            console.log('Initializing pour functionality');

            // Pour button removed as drag and drop functionality is working properly
            console.log('Pour button removed - using drag and drop instead');

            // Add event listener for lab item creation
            labBench.addEventListener('lab-item-created', handleLabItemCreated);

            // Add event listener for lab item selection
            labBench.addEventListener('click', handleLabItemClick);

            // Pour button event listener removed as drag and drop is used instead

            // Add custom CSS for pour functionality
            addPourStyles();

            // Add a direct click handler to all chemical and equipment items
            setupDirectClickHandlers();

            // Create the equipment table right away
            createEquipmentTable();

            // Add a mutation observer to handle dynamically added items
            setupMutationObserver();

            // Check if there are already items on the bench and hide placeholder if needed
            const existingItems = labBench.querySelectorAll('.lab-item');
            if (existingItems.length > 0) {
                hideBenchPlaceholder();
            }

            // Add direct click handlers to the tabs
            const chemicalsTab = document.querySelector('.nav-link[data-bs-target="#chemicals"]');
            const equipmentTab = document.querySelector('.nav-link[data-bs-target="#equipment"]');

            if (chemicalsTab) {
                chemicalsTab.addEventListener('click', function() {
                    console.log('Chemicals tab clicked');
                    setTimeout(() => {
                        setupDirectClickHandlers();
                        restoreSelectionState();
                    }, 100);
                });
            }

            if (equipmentTab) {
                equipmentTab.addEventListener('click', function() {
                    console.log('Equipment tab clicked');
                    setTimeout(() => {
                        setupDirectClickHandlers();
                        restoreSelectionState();
                    }, 100);
                });
            }

            /**
             * Restore selection state from global state
             */
            function restoreSelectionState() {
                try {
                    console.log('Restoring selection state from global state');

                    // Restore chemical selection
                    if (window.chemistryLabState.hasSelectedChemical()) {
                        const selectedChemical = window.chemistryLabState.selectedChemical;
                        if (selectedChemical.type === 'sidebar') {
                            const chemicalType = selectedChemical.chemicalType;
                            const chemicalItems = document.querySelectorAll(`.chemical-item[data-chemical="${chemicalType}"]`);

                            if (chemicalItems.length > 0) {
                                const chemicalItem = chemicalItems[0];
                                chemicalItem.classList.add('selected-item');

                                // Add checkmark
                                if (!chemicalItem.querySelector('.item-checkmark')) {
                                    const checkmark = document.createElement('div');
                                    checkmark.classList.add('item-checkmark');
                                    checkmark.innerHTML = '✓';
                                    checkmark.style.position = 'absolute';
                                    checkmark.style.top = '5px';
                                    checkmark.style.right = '5px';
                                    checkmark.style.backgroundColor = '#10b981';
                                    checkmark.style.color = 'white';
                                    checkmark.style.borderRadius = '50%';
                                    checkmark.style.width = '20px';
                                    checkmark.style.height = '20px';
                                    checkmark.style.display = 'flex';
                                    checkmark.style.alignItems = 'center';
                                    checkmark.style.justifyContent = 'center';
                                    checkmark.style.fontSize = '12px';
                                    checkmark.style.fontWeight = 'bold';

                                    chemicalItem.style.position = 'relative';
                                    chemicalItem.appendChild(checkmark);
                                }

                                // Update global state with new element reference
                                window.chemistryLabState.selectedChemical.element = chemicalItem;
                                console.log('Restored chemical selection:', chemicalType);
                            }
                        }
                    }

                    // Restore equipment selection
                    if (window.chemistryLabState.hasSelectedEquipment()) {
                        const selectedEquipment = window.chemistryLabState.selectedEquipment;
                        if (selectedEquipment.type === 'sidebar') {
                            const equipmentType = selectedEquipment.equipmentType;
                            const equipmentItems = document.querySelectorAll(`.equipment-item[data-equipment="${equipmentType}"]`);

                            if (equipmentItems.length > 0) {
                                const equipmentItem = equipmentItems[0];
                                equipmentItem.classList.add('selected-item');

                                // Add checkmark
                                if (!equipmentItem.querySelector('.item-checkmark')) {
                                    const checkmark = document.createElement('div');
                                    checkmark.classList.add('item-checkmark');
                                    checkmark.innerHTML = '✓';
                                    checkmark.style.position = 'absolute';
                                    checkmark.style.top = '5px';
                                    checkmark.style.right = '5px';
                                    checkmark.style.backgroundColor = '#10b981';
                                    checkmark.style.color = 'white';
                                    checkmark.style.borderRadius = '50%';
                                    checkmark.style.width = '20px';
                                    checkmark.style.height = '20px';
                                    checkmark.style.display = 'flex';
                                    checkmark.style.alignItems = 'center';
                                    checkmark.style.justifyContent = 'center';
                                    checkmark.style.fontSize = '12px';
                                    checkmark.style.fontWeight = 'bold';

                                    equipmentItem.style.position = 'relative';
                                    equipmentItem.appendChild(checkmark);
                                }

                                // Update global state with new element reference
                                window.chemistryLabState.selectedEquipment.element = equipmentItem;
                                console.log('Restored equipment selection:', equipmentType);
                            }
                        }
                    }

                    // Pour button state update removed as drag and drop is used instead
                } catch (error) {
                    console.error('Error restoring selection state:', error);
                }
            }

            // Debug buttons removed as functionality is working properly

            console.log('Pour functionality initialization complete');
        } catch (error) {
            console.error('Error initializing pour functionality:', error);
        }
    }

    /**
     * Set up direct click handlers for existing items
     */
    function setupDirectClickHandlers() {
        try {
            console.log('Setting up direct click handlers');

            // Get all chemical items
            const chemicalItems = document.querySelectorAll('.chemical-item');
            chemicalItems.forEach(item => {
                // Remove existing click handlers
                const newItem = item.cloneNode(true);
                item.parentNode.replaceChild(newItem, item);

                // Add new click handler
                newItem.addEventListener('click', function(event) {
                    console.log('Chemical item clicked directly');
                    handleSidebarItemClick(newItem, 'chemical', event);
                });

                // Make it look interactive
                newItem.style.cursor = 'pointer';
                newItem.style.transition = 'all 0.2s ease';

                // Add hover effect
                newItem.addEventListener('mouseenter', function() {
                    newItem.style.transform = 'scale(1.05)';
                    newItem.style.boxShadow = '0 4px 8px rgba(0, 0, 0, 0.2)';
                });

                newItem.addEventListener('mouseleave', function() {
                    newItem.style.transform = 'scale(1)';
                    newItem.style.boxShadow = 'none';
                });

                // Make it draggable
                newItem.setAttribute('draggable', 'true');

                // Add a visual indicator that this item is draggable
                const dragIndicator = document.createElement('div');
                dragIndicator.textContent = '↕ Drag me';
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

                newItem.style.position = 'relative';
                newItem.appendChild(dragIndicator);

                newItem.addEventListener('mouseenter', function() {
                    dragIndicator.style.opacity = '1';
                });

                newItem.addEventListener('mouseleave', function() {
                    dragIndicator.style.opacity = '0';
                });

                // Add drag start handler
                newItem.addEventListener('dragstart', function(event) {
                    try {
                        console.log('Chemical item drag started');

                        // Get the chemical ID
                        const chemicalId = newItem.getAttribute('data-chemical');
                        if (!chemicalId) {
                            console.error('No data-chemical attribute found');
                            return;
                        }

                        // Set the drag data
                        event.dataTransfer.setData('text/plain', JSON.stringify({
                            type: 'chemical',
                            id: chemicalId
                        }));

                        // Set effectAllowed to all to ensure it works across browsers and zoom levels
                        event.dataTransfer.effectAllowed = 'all';

                        // Create a larger drag image for better visibility at all zoom levels
                        const dragImage = document.createElement('div');
                        dragImage.textContent = chemicalId.toUpperCase();
                        dragImage.style.backgroundColor = getChemicalColor(chemicalId);
                        dragImage.style.color = 'black';
                        dragImage.style.padding = '15px'; // Increased padding
                        dragImage.style.borderRadius = '50%';
                        dragImage.style.width = '60px'; // Increased size
                        dragImage.style.height = '60px'; // Increased size
                        dragImage.style.display = 'flex';
                        dragImage.style.alignItems = 'center';
                        dragImage.style.justifyContent = 'center';
                        dragImage.style.fontWeight = 'bold';
                        dragImage.style.fontSize = '16px'; // Increased font size
                        dragImage.style.boxShadow = '0 4px 8px rgba(0, 0, 0, 0.3)'; // Added shadow for better visibility
                        dragImage.style.zIndex = '9999';
                        dragImage.classList.add('chemical-drag-image');

                        document.body.appendChild(dragImage);
                        event.dataTransfer.setDragImage(dragImage, 30, 30); // Adjusted offset for larger image

                        // Remove the drag image element after it's been used
                        setTimeout(() => {
                            document.body.removeChild(dragImage);
                        }, 0);

                        // Visual feedback
                        newItem.classList.add('dragging');

                        // Highlight all valid drop targets to make them more obvious
                        highlightAvailableEquipment();

                        console.log(`Started dragging chemical: ${chemicalId}`);
                    } catch (error) {
                        console.error('Error in chemical dragstart handler:', error);
                    }
                });

                // Add drag end handler
                newItem.addEventListener('dragend', function() {
                    newItem.classList.remove('dragging');
                });
            });

            // Get all equipment items
            const equipmentItems = document.querySelectorAll('.equipment-item');
            equipmentItems.forEach(item => {
                // Remove existing click handlers
                const newItem = item.cloneNode(true);
                item.parentNode.replaceChild(newItem, item);

                // Add new click handler
                newItem.addEventListener('click', function(event) {
                    console.log('Equipment item clicked directly');
                    handleSidebarItemClick(newItem, 'equipment', event);
                });

                // Make it look interactive
                newItem.style.cursor = 'pointer';
                newItem.style.transition = 'all 0.2s ease';

                // Add hover effect
                newItem.addEventListener('mouseenter', function() {
                    newItem.style.transform = 'scale(1.05)';
                    newItem.style.boxShadow = '0 4px 8px rgba(0, 0, 0, 0.2)';
                });

                newItem.addEventListener('mouseleave', function() {
                    newItem.style.transform = 'scale(1)';
                    newItem.style.boxShadow = 'none';
                });

                // Make it draggable
                newItem.setAttribute('draggable', 'true');

                // Add drag start handler
                newItem.addEventListener('dragstart', function(event) {
                    try {
                        console.log('Equipment item drag started');

                        // Get the equipment ID
                        const equipmentId = newItem.getAttribute('data-equipment');
                        if (!equipmentId) {
                            console.error('No data-equipment attribute found');
                            return;
                        }

                        // Set the drag data
                        event.dataTransfer.setData('text/plain', JSON.stringify({
                            type: 'equipment',
                            id: equipmentId
                        }));

                        // Visual feedback
                        newItem.classList.add('dragging');

                        console.log(`Started dragging equipment: ${equipmentId}`);
                    } catch (error) {
                        console.error('Error in equipment dragstart handler:', error);
                    }
                });

                // Add drag end handler
                newItem.addEventListener('dragend', function() {
                    newItem.classList.remove('dragging');
                });
            });

            // Set up the lab bench as a drop target
            const labBench = document.querySelector('.lab-bench');
            if (labBench) {
                // Remove existing event listeners by cloning
                const newLabBench = labBench.cloneNode(true);
                labBench.parentNode.replaceChild(newLabBench, labBench);

                // Add new event listeners
                newLabBench.addEventListener('dragover', function(event) {
                    event.preventDefault(); // Allow drop
                    newLabBench.classList.add('drag-over');
                });

                newLabBench.addEventListener('dragleave', function() {
                    newLabBench.classList.remove('drag-over');
                });

                newLabBench.addEventListener('drop', function(event) {
                    try {
                        event.preventDefault();
                        newLabBench.classList.remove('drag-over');

                        // Get the drop data
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

                        // Only allow equipment to be placed in the table, not chemicals
                        if (data.type === 'equipment') {
                            createLabItem(data.type, data.id);
                        } else {
                            // Check if we're dropping onto an equipment item
                            const equipmentItem = event.target.closest('.lab-item[data-type="equipment"]');
                            if (equipmentItem) {
                                // Let the equipment item's drop handler handle this
                                return;
                            } else {
                                // Show a message that chemicals should be dragged onto equipment
                                showMessage('Drag chemicals directly onto beakers or test tubes to pour them', true);

                                // Highlight available equipment to help the user
                                highlightAvailableEquipment();
                            }
                        }

                        console.log(`Item dropped: ${data.type} - ${data.id} in equipment table`);
                    } catch (error) {
                        console.error('Error in drop handler:', error);
                    }
                });

                // Re-add click handler for lab items
                newLabBench.addEventListener('click', handleLabItemClick);

                // Make equipment items droppable for chemicals
                makeEquipmentItemsDroppable();
            }

            console.log(`Set up handlers for ${chemicalItems.length} chemicals and ${equipmentItems.length} equipment items`);
        } catch (error) {
            console.error('Error setting up direct click handlers:', error);
        }
    }

    /**
     * Make equipment items droppable for chemicals
     */
    function makeEquipmentItemsDroppable() {
        try {
            console.log('Making equipment items droppable for chemicals');

            // Find all equipment items on the bench
            const equipmentItems = document.querySelectorAll('.lab-item[data-type="equipment"]');
            console.log('Found equipment items:', equipmentItems.length);

            // Also make the equipment table droppable
            const equipmentTable = document.querySelector('.equipment-table');
            if (equipmentTable) {
                console.log('Making equipment table droppable');

                // Make all equipment items in the table droppable
                const tableEquipmentItems = equipmentTable.querySelectorAll('.lab-item[data-type="equipment"]');
                console.log('Found equipment items in table:', tableEquipmentItems.length);

                tableEquipmentItems.forEach(item => {
                    makeItemDroppable(item);
                });
            }

            // Make all equipment items on the bench droppable
            equipmentItems.forEach(item => {
                makeItemDroppable(item);
            });

            // Add a direct query for beakers and test tubes to ensure they're made droppable
            const beakers = document.querySelectorAll('.lab-item[data-equipment="beaker"]');
            const testTubes = document.querySelectorAll('.lab-item[data-equipment="test-tube"]');

            console.log('Found beakers:', beakers.length);
            console.log('Found test tubes:', testTubes.length);

            beakers.forEach(item => makeItemDroppable(item));
            testTubes.forEach(item => makeItemDroppable(item));

            console.log('Finished making equipment items droppable');

            // Debug: Log all droppable items
            const droppableItems = document.querySelectorAll('[data-droppable="true"]');
            console.log('Total droppable items:', droppableItems.length);

        } catch (error) {
            console.error('Error making equipment items droppable:', error);
        }
    }

    /**
     * Make a single equipment item droppable for chemicals
     */
    function makeItemDroppable(item) {
        try {
            // Make sure it's a container (beaker or test tube)
            const equipmentType = item.getAttribute('data-equipment');
            if (equipmentType !== 'beaker' && equipmentType !== 'test-tube') {
                console.log('Item is not a beaker or test tube, skipping:', item);
                return;
            }

            console.log('Making item droppable:', item);

            // Skip if already made droppable
            if (item.hasAttribute('data-droppable')) {
                console.log('Item already droppable, skipping');
                return;
            }

            // Mark as droppable
            item.setAttribute('data-droppable', 'true');

            // Force the item to be positioned relatively to ensure proper event handling
            item.style.position = 'relative';

            // Add visual cue that this is droppable
            item.classList.add('chemical-droppable');

            // Add a subtle outline to indicate droppable area
            item.style.outline = '1px dashed rgba(16, 185, 129, 0.3)';

            // Add dragover event to show it's a valid drop target
            item.addEventListener('dragover', function(event) {
                event.preventDefault();
                event.stopPropagation(); // Prevent bubbling to lab bench

                // We can't read the data during dragover due to security restrictions
                // Instead, we'll just highlight the equipment item
                item.classList.add('drag-over-equipment');

                // Use the helper function to check if cursor is within the expanded hit area
                const isInExpandedArea = isPointInElement(event.clientX, event.clientY, item, 20);

                if (isInExpandedArea) {
                    // Ensure the item is highlighted
                    item.classList.add('drag-over-equipment');
                }

                console.log('Dragover event on equipment:', item);
            });

            // Remove highlight when dragging leaves
            item.addEventListener('dragleave', function() {
                item.classList.remove('drag-over-equipment');
            });

            // Handle drop of chemical onto equipment
            item.addEventListener('drop', function(event) {
                event.preventDefault();
                event.stopPropagation(); // Prevent bubbling to lab bench

                console.log('Drop event on equipment item:', item);
                console.log('Drop event target:', event.target);
                console.log('Current target:', event.currentTarget);

                // Remove highlight class
                item.classList.remove('drag-over-equipment');

                // Use the helper function to check if drop is within the expanded hit area
                const isInExpandedArea = isPointInElement(event.clientX, event.clientY, item, 25);

                // If not in expanded area, don't process the drop
                if (!isInExpandedArea) {
                    console.log('Drop outside expanded hit area, ignoring');
                    return;
                }

                // Add visual feedback to show where the drop occurred
                const dropIndicator = document.createElement('div');
                dropIndicator.style.position = 'absolute';
                dropIndicator.style.width = '30px';
                dropIndicator.style.height = '30px';
                dropIndicator.style.borderRadius = '50%';
                dropIndicator.style.backgroundColor = 'rgba(16, 185, 129, 0.5)';
                dropIndicator.style.left = (event.clientX - item.getBoundingClientRect().left) + 'px';
                dropIndicator.style.top = (event.clientY - item.getBoundingClientRect().top) + 'px';
                dropIndicator.style.transform = 'translate(-50%, -50%)';
                dropIndicator.style.pointerEvents = 'none';
                dropIndicator.style.zIndex = '1000';
                dropIndicator.style.animation = 'ripple 0.6s ease-out forwards';

                item.appendChild(dropIndicator);

                // Remove the indicator after animation completes
                setTimeout(() => {
                    if (dropIndicator.parentNode) {
                        dropIndicator.parentNode.removeChild(dropIndicator);
                    }
                }, 600);

                // Drop indicator removed as status display is used instead

                // Get the drop data
                const dataText = event.dataTransfer.getData('text/plain');
                console.log('Drop data text:', dataText);

                if (!dataText) {
                    console.error('No data found in drop event');
                    return;
                }

                try {
                    const data = JSON.parse(dataText);
                    console.log('Parsed drop data:', data);

                    if (!data || !data.type || !data.id) {
                        console.error('Invalid data format in drop event');
                        return;
                    }

                    // Only allow chemicals to be dropped
                    if (data.type === 'chemical') {
                        const chemicalType = data.id;
                        // Get the equipment type from the data attribute
                        let equipmentType = item.getAttribute('data-equipment');
                        if (!equipmentType) {
                            // Try to get it from the lab-item data attribute
                            equipmentType = item.getAttribute('data-equipment');
                            if (!equipmentType) {
                                // Fallback to checking the class
                                if (item.classList.contains('beaker-icon') || item.querySelector('.beaker-icon')) {
                                    equipmentType = 'beaker';
                                } else if (item.classList.contains('test-tube-icon') || item.querySelector('.test-tube-icon')) {
                                    equipmentType = 'test-tube';
                                } else {
                                    // Last resort - check the inner text
                                    const label = item.querySelector('.equipment-label');
                                    if (label) {
                                        const text = label.textContent.trim().toLowerCase();
                                        if (text === 'b') {
                                            equipmentType = 'beaker';
                                        } else if (text === 't') {
                                            equipmentType = 'test-tube';
                                        }
                                    }
                                }
                            }
                        }

                        console.log(`Chemical ${chemicalType} dropped onto ${equipmentType}`);
                        console.log('Equipment item:', item);

                        // Check if equipment already contains something
                        const equipmentContains = item.getAttribute('data-contains');
                        console.log('Equipment contains:', equipmentContains);

                        if (equipmentContains && equipmentContains !== '') {
                            console.log(`Equipment already contains ${equipmentContains}`);

                            // Mix the chemicals
                            mixChemicals(equipmentContains, chemicalType, item);

                            // Add visual feedback for the drop
                            addDropFeedback(item);
                        } else {
                            console.log('Equipment is empty, pouring chemical');

                            // Find the chemical item in the sidebar
                            const sidebarChemicalItem = document.querySelector(`.chemical-item[data-chemical="${chemicalType}"]`);
                            console.log('Found sidebar chemical item:', sidebarChemicalItem);

                            if (sidebarChemicalItem) {
                                // Pour the chemical into the equipment
                                console.log('Calling pourChemical with:', chemicalType, sidebarChemicalItem, item);
                                pourChemical(chemicalType, sidebarChemicalItem, item);

                                // Show a success message
                                showMessage(`Successfully poured ${getChemicalName(chemicalType)} into the ${equipmentType}`);

                                // Add visual feedback for the drop
                                addDropFeedback(item);

                                // Update the global state to reflect the change
                                if (window.chemistryLabState) {
                                    // Clear any selected chemical
                                    window.chemistryLabState.clearSelectedChemical();

                                    // Set the equipment as selected
                                    window.chemistryLabState.setSelectedEquipment({
                                        element: item,
                                        type: 'lab',
                                        equipmentType: equipmentType
                                    });
                                }
                            } else {
                                console.error('Could not find chemical in sidebar');
                                showMessage('Error finding chemical', true);
                            }
                        }
                    } else {
                        console.log('Only chemicals can be dropped onto equipment');
                        showMessage('Only chemicals can be dropped onto equipment', true);
                    }
                } catch (error) {
                    console.error('Error handling drop onto equipment:', error);
                    console.error(error);
                }
            });
        } catch (error) {
            console.error('Error making item droppable:', error);
        }
    }

    /**
     * Create the equipment table
     */
    function createEquipmentTable() {
        try {
            console.log('Creating equipment table');

            // Find the lab bench
            const labBench = document.querySelector('.lab-bench');
            if (!labBench) {
                console.log('Lab bench not found');
                return null;
            }

            // Create the equipment table if it doesn't exist
            let equipmentTable = labBench.querySelector('.equipment-table');
            if (!equipmentTable) {
                equipmentTable = document.createElement('div');
                equipmentTable.classList.add('equipment-table');
                equipmentTable.style.display = 'flex';
                equipmentTable.style.flexWrap = 'wrap';
                equipmentTable.style.justifyContent = 'center';
                equipmentTable.style.alignItems = 'center';
                equipmentTable.style.gap = '20px';
                equipmentTable.style.padding = '20px';
                equipmentTable.style.position = 'absolute';
                equipmentTable.style.bottom = '20px';
                equipmentTable.style.left = '50%';
                equipmentTable.style.transform = 'translateX(-50%)';
                equipmentTable.style.width = '90%';
                equipmentTable.style.minHeight = '100px';
                equipmentTable.style.backgroundColor = 'rgba(0, 0, 0, 0.2)';
                equipmentTable.style.borderRadius = '8px';
                equipmentTable.style.border = '1px dashed rgba(255, 255, 255, 0.3)';

                // Add a label to the equipment table
                const tableLabel = document.createElement('div');
                tableLabel.classList.add('table-label');
                tableLabel.textContent = 'Lab Equipment';
                tableLabel.style.position = 'absolute';
                tableLabel.style.top = '-25px';
                tableLabel.style.left = '50%';
                tableLabel.style.transform = 'translateX(-50%)';
                tableLabel.style.color = 'white';
                tableLabel.style.fontSize = '14px';
                tableLabel.style.fontWeight = 'bold';
                tableLabel.style.backgroundColor = 'rgba(0, 0, 0, 0.5)';
                tableLabel.style.padding = '3px 10px';
                tableLabel.style.borderRadius = '4px';
                equipmentTable.appendChild(tableLabel);

                labBench.appendChild(equipmentTable);

                // Hide the placeholder text
                hideBenchPlaceholder();
            }

            return equipmentTable;
        } catch (error) {
            console.error('Error creating equipment table:', error);
            return null;
        }
    }

    /**
     * Set up mutation observer to watch for new items
     */
    function setupMutationObserver() {
        try {
            console.log('Setting up mutation observer');

            // Create a mutation observer to watch for new items
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.type === 'childList') {
                        // Check for added nodes
                        if (mutation.addedNodes.length > 0) {
                            mutation.addedNodes.forEach(function(node) {
                                if (node.nodeType === 1) { // Element node
                                    // Check if it's a lab item
                                    if (node.classList.contains('lab-item')) {
                                        console.log('New lab item detected:', node);
                                        setupItemHandlers(node);

                                        // Hide the placeholder text when items are added
                                        hideBenchPlaceholder();

                                        // If it's an equipment item, make it droppable for chemicals
                                        if (node.getAttribute('data-type') === 'equipment') {
                                            // Make the new equipment item droppable
                                            console.log('New equipment item detected in mutation observer');

                                            // Check if it's a beaker or test tube
                                            const equipmentType = node.getAttribute('data-equipment');
                                            if (equipmentType === 'beaker' || equipmentType === 'test-tube') {
                                                console.log('Making new beaker/test tube droppable');
                                                makeItemDroppable(node);
                                            }

                                            // Also refresh all equipment items
                                            makeEquipmentItemsDroppable();
                                        }
                                    }

                                    // Check for chemical or equipment items inside
                                    const chemicalItems = node.querySelectorAll('.chemical-item');
                                    const equipmentItems = node.querySelectorAll('.equipment-item');

                                    chemicalItems.forEach(item => {
                                        console.log('New chemical item detected');
                                        item.addEventListener('click', function(event) {
                                            console.log('New chemical item clicked');
                                            const labItem = findLabItem(event.target);
                                            if (labItem) {
                                                selectItem(labItem);
                                            }
                                        });
                                    });

                                    equipmentItems.forEach(item => {
                                        console.log('New equipment item detected');
                                        item.addEventListener('click', function(event) {
                                            console.log('New equipment item clicked');
                                            const labItem = findLabItem(event.target);
                                            if (labItem) {
                                                selectItem(labItem);
                                            }
                                        });
                                    });
                                }
                            });
                        }

                        // Check for removed nodes
                        if (mutation.removedNodes.length > 0) {
                            // Check if any lab items remain
                            const labItems = labBench.querySelectorAll('.lab-item');
                            if (labItems.length === 0) {
                                // Show the placeholder text when all items are removed
                                showBenchPlaceholder();
                            }
                        }
                    }
                });

                // Update pour button state after mutations
                updatePourButtonState();
            });

            // Start observing the lab bench
            observer.observe(labBench, { childList: true, subtree: true });

            console.log('Mutation observer set up');
        } catch (error) {
            console.error('Error setting up mutation observer:', error);
        }
    }

    /**
     * Set up handlers for a lab item
     */
    function setupItemHandlers(item) {
        try {
            console.log('Setting up handlers for lab item');

            // Add click handler
            item.addEventListener('click', function(event) {
                console.log('Lab item clicked directly');
                selectItem(item);
            });

            // Add data attributes if not present
            if (!item.hasAttribute('data-selected')) {
                item.setAttribute('data-selected', 'false');
            }

            if (!item.hasAttribute('data-contains') && item.getAttribute('data-type') === 'equipment') {
                item.setAttribute('data-contains', '');
            }
        } catch (error) {
            console.error('Error setting up item handlers:', error);
        }
    }

    /**
     * Create a lab item on the bench
     */
    function createLabItem(type, id, x, y) {
        try {
            console.log(`Creating lab item: ${type} ${id} at (${x}, ${y})`);

            // Create the lab item element
            const item = document.createElement('div');
            item.classList.add('lab-item', `lab-${type}`);
            item.setAttribute('data-type', type);
            item.setAttribute(`data-${type}`, id);

            // For equipment items, make sure we set the equipment attribute correctly
            if (type === 'equipment') {
                item.setAttribute('data-equipment', id);
            }

            // Set position
            item.style.position = 'absolute';
            if (x && y) {
                item.style.left = `${x}px`;
                item.style.top = `${y}px`;
            } else {
                // Default position in center
                item.style.left = '50%';
                item.style.top = '50%';
                item.style.transform = 'translate(-50%, -50%)';
            }

            // Set appearance based on type and id
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

                item.innerHTML = `
                    <div class="chemical-visual">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center" style="background-color: ${color}">
                            <span class="text-sm font-bold text-black">${symbol}</span>
                        </div>
                        <div class="chemical-label">${name}</div>
                    </div>
                `;
            } else if (type === 'equipment') {
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

                // Create the equipment HTML
                item.innerHTML = `
                    <div class="equipment-visual">
                        ${equipmentHTML}
                        <div class="equipment-label">${name}</div>
                    </div>
                `;

                // Add container indicator and label for beakers and test tubes
                if (id === 'beaker' || id === 'test-tube') {
                    // Add container indicator
                    const containerIndicator = document.createElement('div');
                    containerIndicator.classList.add('container-indicator');
                    item.appendChild(containerIndicator);

                    // Add container label
                    const containerLabel = document.createElement('div');
                    containerLabel.classList.add('container-label');
                    containerLabel.textContent = 'Empty';
                    item.appendChild(containerLabel);
                }
            }

            // Make the item draggable within the lab bench
            makeLabItemDraggable(item);

            // If it's an equipment item, make it droppable for chemicals
            if (type === 'equipment' && (id === 'beaker' || id === 'test-tube')) {
                console.log('Making new equipment item droppable');
                makeItemDroppable(item);
            }

            // Add to equipment table instead of directly to the bench
            const labBench = document.querySelector('.lab-bench');
            const equipmentTable = createEquipmentTable();
            if (equipmentTable) {
                equipmentTable.appendChild(item);

                // Reset position to be relative to the table
                item.style.position = 'relative';
                item.style.left = 'auto';
                item.style.top = 'auto';
            } else {
                // Fallback to adding directly to the bench
                labBench.appendChild(item);
            }

            // Trigger a custom event
            const event = new CustomEvent('lab-item-created', {
                detail: { type, id, element: item }
            });
            labBench.dispatchEvent(event);

            return item;
        } catch (error) {
            console.error('Error creating lab item:', error);
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
                const labBench = document.querySelector('.lab-bench');
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
            });
        } catch (error) {
            console.error('Error making lab item draggable:', error);
        }
    }

    /**
     * Find the lab item from a clicked element
     */
    function findLabItem(element) {
        try {
            // Check if the element itself is a lab item
            if (element.classList.contains('lab-item')) {
                return element;
            }

            // Check if the element is inside a lab item
            const labItem = element.closest('.lab-item');
            if (labItem) {
                return labItem;
            }

            // Check if it's a chemical or equipment item
            if (element.classList.contains('chemical-item') || element.classList.contains('equipment-item')) {
                // These are in the sidebar, so we need to find the corresponding lab item
                const type = element.classList.contains('chemical-item') ? 'chemical' : 'equipment';
                const id = element.getAttribute(`data-${type}`);

                if (id) {
                    // Create a new lab item if it doesn't exist
                    console.log(`Creating new lab item for ${type} ${id}`);
                    return null; // Let the drag and drop system handle this
                }
            }

            return null;
        } catch (error) {
            console.error('Error finding lab item:', error);
            return null;
        }
    }

    /**
     * Select an item
     */
    function selectItem(item) {
        try {
            console.log('Selecting item:', item);

            // Toggle selection
            const isSelected = item.getAttribute('data-selected') === 'true';

            if (isSelected) {
                item.setAttribute('data-selected', 'false');
                item.classList.remove('selected-item');
                console.log('Item deselected');
            } else {
                item.setAttribute('data-selected', 'true');
                item.classList.add('selected-item');
                console.log('Item selected');
            }

            // Update pour button state
            updatePourButtonState();
        } catch (error) {
            console.error('Error selecting item:', error);
        }
    }

    /**
     * Handle lab item creation
     */
    function handleLabItemCreated(event) {
        try {
            const { type, id, element } = event.detail;

            // Add data attributes for pour functionality
            element.setAttribute('data-contains', '');
            element.setAttribute('data-selected', 'false');

            // Add a visual indicator for containers
            if (type === 'equipment' && (id === 'beaker' || id === 'test-tube')) {
                const containerIndicator = document.createElement('div');
                containerIndicator.classList.add('container-indicator');
                element.appendChild(containerIndicator);

                // Add a label to show what's in the container
                const containerLabel = document.createElement('div');
                containerLabel.classList.add('container-label');
                containerLabel.textContent = 'Empty';
                element.appendChild(containerLabel);
            }
        } catch (error) {
            console.error('Error handling lab item creation:', error);
        }
    }

    /**
     * Handle lab item click
     */
    function handleLabItemClick(event) {
        try {
            console.log('Lab item click event triggered');

            // Check if it's a chemical or equipment item in the sidebar
            const chemicalItem = event.target.closest('.chemical-item');
            const equipmentItem = event.target.closest('.equipment-item');

            if (chemicalItem) {
                console.log('Chemical item clicked in sidebar');
                handleSidebarItemClick(chemicalItem, 'chemical', event);
                return;
            }

            if (equipmentItem) {
                console.log('Equipment item clicked in sidebar');
                handleSidebarItemClick(equipmentItem, 'equipment', event);
                return;
            }

            // Find the closest lab item on the bench
            const labItem = event.target.closest('.lab-item');
            if (!labItem) {
                console.log('No lab item found in click event');
                return;
            }

            console.log('Lab item clicked on bench:', labItem);

            // Get the type of the clicked lab item
            const clickedType = labItem.getAttribute('data-type');

            // Visual: Only deselect items of the same type
            if (clickedType === 'chemical') {
                // Deselect all chemical items visually
                const chemicalItems = document.querySelectorAll('.lab-item[data-type="chemical"]');
                chemicalItems.forEach(item => {
                    if (item !== labItem) {
                        item.setAttribute('data-selected', 'false');
                        item.classList.remove('selected-item');
                    }
                });
            } else if (clickedType === 'equipment') {
                // Deselect all equipment items visually
                const equipmentItems = document.querySelectorAll('.lab-item[data-type="equipment"]');
                equipmentItems.forEach(item => {
                    if (item !== labItem) {
                        item.setAttribute('data-selected', 'false');
                        item.classList.remove('selected-item');
                    }
                });
            }

            // Toggle selection of the clicked item
            const isSelected = labItem.getAttribute('data-selected') === 'true';

            if (isSelected) {
                // If already selected, deselect it
                labItem.setAttribute('data-selected', 'false');
                labItem.classList.remove('selected-item');
                console.log('Lab item deselected');

                // Update global state
                if (clickedType === 'chemical') {
                    window.chemistryLabState.clearSelectedChemical();
                } else if (clickedType === 'equipment') {
                    window.chemistryLabState.clearSelectedEquipment();
                }
            } else {
                // If not selected, select it
                labItem.setAttribute('data-selected', 'true');
                labItem.classList.add('selected-item');
                console.log('Lab item selected');

                // Update global state
                if (clickedType === 'chemical') {
                    const chemicalType = labItem.getAttribute('data-chemical');
                    window.chemistryLabState.setSelectedChemical({
                        element: labItem,
                        type: 'lab',
                        chemicalType: chemicalType
                    });
                } else if (clickedType === 'equipment') {
                    const equipmentType = labItem.getAttribute('data-equipment');
                    window.chemistryLabState.setSelectedEquipment({
                        element: labItem,
                        type: 'lab',
                        equipmentType: equipmentType
                    });
                }
            }

            // Log selected items for debugging
            console.log('Global state:', window.chemistryLabState);

            // Update the pour button state
            updatePourButtonState();
        } catch (error) {
            console.error('Error handling lab item click:', error);
        }
    }

    /**
     * Handle sidebar item click
     */
    function handleSidebarItemClick(item, type, event) {
        try {
            console.log(`Handling sidebar ${type} item click`);

            // Check if Ctrl/Cmd key is pressed for multi-select (not used currently)
            const isMultiSelect = event.ctrlKey || event.metaKey;

            // Visual: Remove selection from all items of the same type
            const sameTypeItems = document.querySelectorAll(`.${type}-item`);
            sameTypeItems.forEach(sameTypeItem => {
                if (sameTypeItem !== item) {
                    sameTypeItem.classList.remove('selected-item');

                    // Remove checkmarks
                    const checkmark = sameTypeItem.querySelector('.item-checkmark');
                    if (checkmark) {
                        checkmark.style.opacity = '0';
                        setTimeout(() => {
                            if (checkmark.parentNode) {
                                checkmark.parentNode.removeChild(checkmark);
                            }
                        }, 300);
                    }
                }
            });

            // Visual: Deselect lab items of the same type
            const labItemsOfSameType = document.querySelectorAll(`.lab-item[data-type="${type}"]`);
            labItemsOfSameType.forEach(labItem => {
                labItem.setAttribute('data-selected', 'false');
                labItem.classList.remove('selected-item');
            });

            // Toggle selection of the clicked item
            const isSelected = item.classList.contains('selected-item');

            if (isSelected) {
                // If already selected, deselect it
                item.classList.remove('selected-item');
                console.log(`${type} item deselected`);

                // Update global state
                if (type === 'chemical') {
                    window.chemistryLabState.clearSelectedChemical();
                } else if (type === 'equipment') {
                    window.chemistryLabState.clearSelectedEquipment();
                }
            } else {
                // If not selected, select it
                item.classList.add('selected-item');
                console.log(`${type} item selected`);

                // Update global state
                if (type === 'chemical') {
                    window.chemistryLabState.setSelectedChemical({
                        element: item,
                        type: 'sidebar',
                        chemicalType: item.getAttribute('data-chemical')
                    });
                } else if (type === 'equipment') {
                    window.chemistryLabState.setSelectedEquipment({
                        element: item,
                        type: 'sidebar',
                        equipmentType: item.getAttribute('data-equipment')
                    });
                }

                // Add a checkmark to show it's selected
                if (!item.querySelector('.item-checkmark')) {
                    const checkmark = document.createElement('div');
                    checkmark.classList.add('item-checkmark');
                    checkmark.innerHTML = '✓';
                    checkmark.style.position = 'absolute';
                    checkmark.style.top = '5px';
                    checkmark.style.right = '5px';
                    checkmark.style.backgroundColor = '#10b981';
                    checkmark.style.color = 'white';
                    checkmark.style.borderRadius = '50%';
                    checkmark.style.width = '20px';
                    checkmark.style.height = '20px';
                    checkmark.style.display = 'flex';
                    checkmark.style.alignItems = 'center';
                    checkmark.style.justifyContent = 'center';
                    checkmark.style.fontSize = '12px';
                    checkmark.style.fontWeight = 'bold';
                    checkmark.style.opacity = '0';
                    checkmark.style.transition = 'opacity 0.3s ease';

                    item.style.position = 'relative';
                    item.appendChild(checkmark);

                    // Fade in the checkmark
                    setTimeout(() => {
                        checkmark.style.opacity = '1';
                    }, 10);
                }
            }

            // Update the pour button state
            updatePourButtonState();
        } catch (error) {
            console.error(`Error handling sidebar ${type} item click:`, error);
        }
    }

    /**
     * Handle pour button click
     */
    function handlePourButtonClick() {
        try {
            console.log('Pour button clicked');
            console.log('Global state:', window.chemistryLabState);

            // Get the selected chemical from global state
            let chemicalItem = null;
            let chemicalType = null;

            if (window.chemistryLabState.hasSelectedChemical()) {
                const selectedChemical = window.chemistryLabState.selectedChemical;
                chemicalItem = selectedChemical.element;

                if (selectedChemical.type === 'sidebar') {
                    chemicalType = selectedChemical.chemicalType;
                    console.log(`Using selected chemical from sidebar: ${chemicalType}`);
                } else if (selectedChemical.type === 'lab') {
                    chemicalType = selectedChemical.chemicalType;
                    console.log(`Using selected chemical from lab bench: ${chemicalType}`);
                }
            } else {
                // Fallback to DOM selection if global state fails
                const selectedChemicalItems = Array.from(document.querySelectorAll('.chemical-item.selected-item'));
                const selectedLabChemicals = Array.from(document.querySelectorAll('.lab-item[data-type="chemical"][data-selected="true"]'));

                // First check for selected chemicals in the sidebar
                if (selectedChemicalItems.length > 0) {
                    chemicalItem = selectedChemicalItems[0];
                    chemicalType = chemicalItem.getAttribute('data-chemical');
                    console.log(`Using selected chemical from sidebar (fallback): ${chemicalType}`);
                }
                // Then check for selected chemicals on the lab bench
                else if (selectedLabChemicals.length > 0) {
                    chemicalItem = selectedLabChemicals[0];
                    chemicalType = chemicalItem.getAttribute('data-chemical');
                    console.log(`Using selected chemical from lab bench (fallback): ${chemicalType}`);
                }
            }

            if (!chemicalItem || !chemicalType) {
                console.log('No chemical selected');
                showMessage('Please select a chemical first', true);
                return;
            }

            // Get the selected equipment from global state
            let equipmentItem = null;
            let equipmentType = null;

            if (window.chemistryLabState.hasSelectedEquipment()) {
                const selectedEquipment = window.chemistryLabState.selectedEquipment;
                equipmentItem = selectedEquipment.element;

                if (selectedEquipment.type === 'sidebar') {
                    equipmentType = selectedEquipment.equipmentType;
                    if (equipmentType === 'beaker' || equipmentType === 'test-tube') {
                        console.log(`Using selected equipment from sidebar: ${equipmentType}`);
                    } else {
                        equipmentItem = null;
                        equipmentType = null;
                    }
                } else if (selectedEquipment.type === 'lab') {
                    equipmentType = selectedEquipment.equipmentType;
                    if (equipmentType === 'beaker' || equipmentType === 'test-tube') {
                        console.log(`Using selected equipment from lab bench: ${equipmentType}`);
                    } else {
                        equipmentItem = null;
                        equipmentType = null;
                    }
                }
            } else {
                // Fallback to DOM selection if global state fails
                const selectedEquipmentItems = Array.from(document.querySelectorAll('.equipment-item.selected-item'));
                const selectedLabEquipment = Array.from(document.querySelectorAll('.lab-item[data-type="equipment"][data-selected="true"]'));

                // First check for selected equipment in the sidebar
                if (selectedEquipmentItems.length > 0) {
                    for (const item of selectedEquipmentItems) {
                        const type = item.getAttribute('data-equipment');
                        if (type === 'beaker' || type === 'test-tube') {
                            equipmentItem = item;
                            equipmentType = type;
                            console.log(`Using selected equipment from sidebar (fallback): ${equipmentType}`);
                            break;
                        }
                    }
                }
                // Then check for selected equipment on the lab bench
                else if (selectedLabEquipment.length > 0) {
                    for (const item of selectedLabEquipment) {
                        const type = item.getAttribute('data-equipment');
                        if (type === 'beaker' || type === 'test-tube') {
                            equipmentItem = item;
                            equipmentType = type;
                            console.log(`Using selected equipment from lab bench (fallback): ${equipmentType}`);
                            break;
                        }
                    }
                }
            }

            if (!equipmentItem || !equipmentType) {
                console.log('No valid equipment selected');
                showMessage('Please select a beaker or test tube', true);
                return;
            }

            // If we found equipment in the sidebar, create it on the bench
            if (window.chemistryLabState.hasSelectedEquipment() &&
                window.chemistryLabState.selectedEquipment.type === 'sidebar') {
                console.log('Creating equipment on bench from sidebar item');
                const equipmentType = window.chemistryLabState.selectedEquipment.equipmentType;
                const labEquipmentItem = createLabItem('equipment', equipmentType);

                if (labEquipmentItem) {
                    equipmentItem = labEquipmentItem;
                }
            } else if (equipmentItem && equipmentType &&
                       Array.from(document.querySelectorAll('.equipment-item.selected-item')).includes(equipmentItem)) {
                console.log('Creating equipment on bench from sidebar item (fallback)');
                const labEquipmentItem = createLabItem('equipment', equipmentType);

                if (labEquipmentItem) {
                    equipmentItem = labEquipmentItem;
                }
            }

            // For chemicals, we don't create a separate item on the bench
            // Instead, we'll pour directly from the sidebar into the equipment
            // This is enforced in the drag and drop handler as well

            console.log(`Ready to pour ${chemicalType} into ${equipmentType}`);

            // Check if equipment already contains something
            const equipmentContains = equipmentItem.getAttribute('data-contains');
            if (equipmentContains) {
                console.log(`Equipment already contains ${equipmentContains}`);
                // Mix the chemicals
                mixChemicals(equipmentContains, chemicalType, equipmentItem);
                return;
            }

            // Pour the chemical into the equipment
            console.log(`Pouring ${chemicalType} into equipment`);

            // If the chemical is from the sidebar, we don't need a source item on the bench
            if (window.chemistryLabState.hasSelectedChemical() &&
                window.chemistryLabState.selectedChemical.type === 'sidebar') {
                // Pour directly from the sidebar
                const sidebarChemicalItem = window.chemistryLabState.selectedChemical.element;
                pourChemical(chemicalType, sidebarChemicalItem, equipmentItem);
            } else {
                // Pour from an existing lab item
                pourChemical(chemicalType, chemicalItem, equipmentItem);
            }

            // Show a success message
            showMessage(`Successfully poured ${getChemicalName(chemicalType)} into the ${equipmentType}`);
        } catch (error) {
            console.error('Error handling pour button click:', error);
        }
    }

    /**
     * Create a lab item on the bench
     */
    function createLabItem(type, id) {
        try {
            console.log(`Creating lab item: ${type} ${id}`);

            // Only allow equipment to be created, not chemicals
            if (type === 'chemical') {
                console.log('Chemicals cannot be created directly on the bench');
                showMessage('Drag chemicals directly onto beakers or test tubes to pour them', true);

                // Highlight available equipment
                highlightAvailableEquipment();
                return null;
            }

            // Create the lab item
            const labItem = document.createElement('div');
            labItem.classList.add('lab-item');
            labItem.setAttribute('data-type', type);
            labItem.setAttribute(`data-${type}`, id);
            labItem.setAttribute('data-selected', 'true');
            labItem.classList.add('selected-item');

            if (type === 'equipment') {
                labItem.setAttribute('data-contains', '');

                // Make sure the equipment type is properly set
                if (id === 'beaker' || id === 'test-tube') {
                    labItem.classList.add(`${id}-container`);
                }
            }

            // Add the item to the lab bench
            const labBench = document.querySelector('.lab-bench');
            if (labBench) {
                // Get or create the equipment table
                const equipmentTable = createEquipmentTable();
                if (!equipmentTable) {
                    console.error('Failed to create equipment table');
                    return null;
                }

                // Add the item to the equipment table instead of directly to the bench
                equipmentTable.appendChild(labItem);

                // Reset position to be relative to the table
                labItem.style.position = 'relative';
                labItem.style.left = 'auto';
                labItem.style.top = 'auto';

                // Make the item droppable immediately if it's a beaker or test tube
                if (type === 'equipment' && (id === 'beaker' || id === 'test-tube')) {
                    console.log('Making newly created equipment item droppable');
                    makeItemDroppable(labItem);
                }

                // Hide the placeholder text when items are added
                hideBenchPlaceholder();

                // Add the item content
                if (type === 'equipment') {
                    let icon = '🧪';
                    let label = id.replace('-', ' ');
                    label = label.charAt(0).toUpperCase() + label.slice(1);

                    labItem.innerHTML = `
                        <div class="equipment-visual">
                            <div class="equipment-icon ${id}-icon">${icon}</div>
                            <div class="equipment-label">${id === 'beaker' ? 'B' : 'T'}</div>
                            <div class="container-indicator"></div>
                            <div class="container-label">Empty</div>
                        </div>
                    `;
                } else if (type === 'chemical') {
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

                    labItem.innerHTML = `
                        <div class="chemical-visual">
                            <div class="chemical-icon" style="background-color: ${color}">
                                <span class="chemical-symbol">${symbol}</span>
                            </div>
                            <div class="chemical-label">${symbol}</div>
                        </div>
                    `;
                }

                // Set up handlers for the new item
                setupItemHandlers(labItem);

                console.log('Lab item created successfully');
                return labItem;
            }

            console.log('Lab bench not found');
            return null;
        } catch (error) {
            console.error('Error creating lab item:', error);
            return null;
        }
    }

    /**
     * Show a message to the user
     * @param {string} message - The message to show
     * @param {boolean} isError - Whether this is an error message
     */
    function showMessage(message, isError = false) {
        try {
            console.log(`Showing message: ${message}, isError: ${isError}`);

            // Create the message element
            const messageElement = document.createElement('div');
            messageElement.classList.add('lab-message');

            // Add error styling if it's an error message
            if (isError) {
                messageElement.classList.add('lab-message-error');
                messageElement.style.backgroundColor = '#ef4444'; // Red-500
            }

            messageElement.textContent = message;

            // Add the message to the page
            document.body.appendChild(messageElement);

            // Remove the message after a delay
            setTimeout(() => {
                messageElement.classList.add('lab-message-hide');
                setTimeout(() => {
                    messageElement.remove();
                }, 500);
            }, 3000);
        } catch (error) {
            console.error('Error showing message:', error);
        }
    }

    /**
     * Get the selected source item (container with chemical or chemical itself)
     */
    function getSelectedSourceItem() {
        try {
            const selectedItems = Array.from(document.querySelectorAll('.lab-item[data-selected="true"]'));
            console.log('Selected items:', selectedItems.length);

            // First, check if we have a chemical selected
            const chemicalItem = selectedItems.find(item => {
                const type = item.getAttribute('data-type');
                return type === 'chemical';
            });

            if (chemicalItem) {
                console.log('Found chemical source:', chemicalItem);
                return chemicalItem;
            }

            // If no chemical, look for a container with a chemical
            const containerWithChemical = selectedItems.find(item => {
                const type = item.getAttribute('data-type');
                const id = item.getAttribute(`data-${type}`);
                const contains = item.getAttribute('data-contains');

                return type === 'equipment' && (id === 'beaker' || id === 'test-tube') && contains;
            });

            if (containerWithChemical) {
                console.log('Found container with chemical:', containerWithChemical);
                return containerWithChemical;
            }

            console.log('No valid source found');
            return null;
        } catch (error) {
            console.error('Error getting selected source item:', error);
            return null;
        }
    }

    /**
     * Get the selected target item (equipment container)
     */
    function getSelectedTargetItem() {
        try {
            const selectedItems = Array.from(document.querySelectorAll('.lab-item[data-selected="true"]'));

            // Find an equipment container
            const equipmentItem = selectedItems.find(item => {
                const type = item.getAttribute('data-type');
                const id = item.getAttribute(`data-${type}`);

                return type === 'equipment' && (id === 'beaker' || id === 'test-tube');
            });

            if (equipmentItem) {
                console.log('Found equipment target:', equipmentItem);
                return equipmentItem;
            }

            console.log('No valid target found');
            return null;
        } catch (error) {
            console.error('Error getting selected target item:', error);
            return null;
        }
    }

    /**
     * Pour a chemical from source to target
     */
    function pourChemical(chemical, sourceItem, targetItem) {
        try {
            console.log(`Pouring ${chemical} from source to target`);

            // Update the target container
            targetItem.setAttribute('data-contains', chemical);

            // Update the container label
            const containerLabel = targetItem.querySelector('.container-label');
            if (containerLabel) {
                containerLabel.textContent = getChemicalName(chemical);
            }

            // Update the container indicator
            const containerIndicator = targetItem.querySelector('.container-indicator');
            if (containerIndicator) {
                containerIndicator.style.backgroundColor = getChemicalColor(chemical);
                containerIndicator.style.height = '50%';
                containerIndicator.classList.add('has-chemical');
            }

            // Hide the equipment icon and label when it contains a chemical
            const equipmentIcon = targetItem.querySelector('.equipment-icon');
            const equipmentLabel = targetItem.querySelector('.equipment-label');

            if (equipmentIcon) {
                equipmentIcon.style.opacity = '0.2';
            }

            if (equipmentLabel) {
                equipmentLabel.style.opacity = '0.2';
            }

            // If the source is a chemical (not a container), don't empty it
            const sourceType = sourceItem.getAttribute('data-type');
            if (sourceType !== 'chemical') {
                // Empty the source container
                sourceItem.setAttribute('data-contains', '');

                // Update the source container label
                const sourceLabel = sourceItem.querySelector('.container-label');
                if (sourceLabel) {
                    sourceLabel.textContent = 'Empty';
                }

                // Update the source container indicator
                const sourceIndicator = sourceItem.querySelector('.container-indicator');
                if (sourceIndicator) {
                    sourceIndicator.style.height = '0%';
                    sourceIndicator.classList.remove('has-chemical');
                }

                // Show the equipment icon and label again
                const sourceEquipmentIcon = sourceItem.querySelector('.equipment-icon');
                const sourceEquipmentLabel = sourceItem.querySelector('.equipment-label');

                if (sourceEquipmentIcon) {
                    sourceEquipmentIcon.style.opacity = '1';
                }

                if (sourceEquipmentLabel) {
                    sourceEquipmentLabel.style.opacity = '1';
                }
            }

            // Show pouring animation
            showPouringAnimation(sourceItem, targetItem, chemical);

            // Update the pour button state
            updatePourButtonState();
        } catch (error) {
            console.error('Error pouring chemical:', error);
        }
    }

    /**
     * Mix chemicals in a container
     */
    function mixChemicals(chemical1, chemical2, container) {
        try {
            console.log(`Mixing ${chemical1} and ${chemical2}`);

            // Define some basic reactions
            let resultChemical = '';
            let reaction = '';

            if ((chemical1 === 'hcl' && chemical2 === 'naoh') ||
                (chemical1 === 'naoh' && chemical2 === 'hcl')) {
                resultChemical = 'nacl';
                reaction = 'neutralization';
            } else if ((chemical1 === 'water' && chemical2 === 'hcl') ||
                       (chemical1 === 'hcl' && chemical2 === 'water')) {
                resultChemical = 'hcl-solution';
                reaction = 'dilution';
            } else if ((chemical1 === 'water' && chemical2 === 'naoh') ||
                       (chemical1 === 'naoh' && chemical2 === 'water')) {
                resultChemical = 'naoh-solution';
                reaction = 'dilution';
            } else {
                resultChemical = 'mixture';
                reaction = 'mixing';
            }

            // Update the container
            container.setAttribute('data-contains', resultChemical);
            container.setAttribute('data-reaction', reaction);

            // Update the container label
            const containerLabel = container.querySelector('.container-label');
            if (containerLabel) {
                containerLabel.textContent = getChemicalName(resultChemical);
            }

            // Update the container indicator
            const containerIndicator = container.querySelector('.container-indicator');
            if (containerIndicator) {
                containerIndicator.style.backgroundColor = getChemicalColor(resultChemical);
                containerIndicator.style.height = '60%';
                containerIndicator.classList.add('has-chemical');

                // Add reaction class
                containerIndicator.classList.add(`reaction-${reaction}`);
            }

            // Hide the equipment icon and label when it contains a chemical
            const equipmentIcon = container.querySelector('.equipment-icon');
            const equipmentLabel = container.querySelector('.equipment-label');

            if (equipmentIcon) {
                equipmentIcon.style.opacity = '0.2';
            }

            if (equipmentLabel) {
                equipmentLabel.style.opacity = '0.2';
            }

            // Show reaction animation
            showReactionAnimation(container, reaction);

            // Update the pour button state
            updatePourButtonState();

            // Show success message
            showMessage(`Successfully mixed chemicals to create ${getChemicalName(resultChemical)}`);
        } catch (error) {
            console.error('Error mixing chemicals:', error);
        }
    }

    /**
     * Show pouring animation
     */
    function showPouringAnimation(sourceItem, targetItem, chemical) {
        try {
            // Create a pouring animation element
            const pouringElement = document.createElement('div');
            pouringElement.classList.add('pouring-animation');
            pouringElement.style.backgroundColor = getChemicalColor(chemical);

            // Position the pouring element
            const targetRect = targetItem.getBoundingClientRect();
            const labBenchRect = labBench.getBoundingClientRect();

            // Check if source is a sidebar item
            const isSidebarItem = sourceItem.classList.contains('chemical-item') ||
                                 sourceItem.classList.contains('equipment-item');

            let startX, startY;

            if (isSidebarItem) {
                // If pouring from sidebar, start from the top of the lab bench
                startX = targetRect.left + targetRect.width / 2 - labBenchRect.left;
                startY = 20; // Start from near the top
            } else {
                // If pouring from lab bench item, start from that item
                const sourceRect = sourceItem.getBoundingClientRect();
                startX = sourceRect.left + sourceRect.width / 2 - labBenchRect.left;
                startY = sourceRect.top + sourceRect.height / 2 - labBenchRect.top;
            }

            // Calculate the position relative to the lab bench
            const endX = targetRect.left + targetRect.width / 2 - labBenchRect.left;
            const endY = targetRect.top + targetRect.height / 4 - labBenchRect.top; // Aim for the top quarter of the target

            pouringElement.style.left = `${startX}px`;
            pouringElement.style.top = `${startY}px`;

            // Add the pouring element to the lab bench
            labBench.appendChild(pouringElement);

            // Animate the pouring
            setTimeout(() => {
                pouringElement.style.left = `${endX}px`;
                pouringElement.style.top = `${endY}px`;
                pouringElement.style.height = '0';
                pouringElement.style.width = '0';
                pouringElement.style.opacity = '0';
            }, 10);

            // Remove the pouring element after animation
            setTimeout(() => {
                if (pouringElement.parentNode) {
                    pouringElement.parentNode.removeChild(pouringElement);
                }
            }, 1000);
        } catch (error) {
            console.error('Error showing pouring animation:', error);
        }
    }

    /**
     * Show reaction animation
     */
    function showReactionAnimation(container, reaction) {
        try {
            // Add reaction class to container
            container.classList.add(`reaction-${reaction}`);

            // Create bubbles or other visual effects
            if (reaction === 'neutralization' || reaction === 'dilution') {
                for (let i = 0; i < 10; i++) {
                    const bubble = document.createElement('div');
                    bubble.classList.add('reaction-bubble');
                    bubble.style.left = `${Math.random() * 80 + 10}%`;
                    bubble.style.animationDelay = `${Math.random() * 2}s`;
                    container.appendChild(bubble);

                    // Remove bubble after animation
                    setTimeout(() => {
                        if (bubble.parentNode) {
                            bubble.parentNode.removeChild(bubble);
                        }
                    }, 3000);
                }
            }

            // Remove reaction class after animation
            setTimeout(() => {
                container.classList.remove(`reaction-${reaction}`);
            }, 3000);
        } catch (error) {
            console.error('Error showing reaction animation:', error);
        }
    }

    /**
     * Add visual feedback when a chemical is dropped onto equipment
     */
    function addDropFeedback(container) {
        try {
            // Add a pulse effect to the container
            container.classList.add('drop-pulse');

            // Create a ripple effect
            const ripple = document.createElement('div');
            ripple.classList.add('drop-ripple');
            container.appendChild(ripple);

            // Remove the pulse and ripple after animation completes
            setTimeout(() => {
                container.classList.remove('drop-pulse');
                if (ripple.parentNode) {
                    ripple.parentNode.removeChild(ripple);
                }
            }, 1000);

            // Add a highlight to the container indicator
            const containerIndicator = container.querySelector('.container-indicator');
            if (containerIndicator) {
                containerIndicator.classList.add('highlight-indicator');

                setTimeout(() => {
                    containerIndicator.classList.remove('highlight-indicator');
                }, 1000);
            }
        } catch (error) {
            console.error('Error adding drop feedback:', error);
        }
    }

    /**
     * Update the pour button state
     */
    function updatePourButtonState() {
        try {
            const pourButton = document.getElementById('pour-button');
            if (!pourButton) {
                console.log('Pour button not found');
                return;
            }

            console.log('Updating pour button state using global state');

            // Check if we have a chemical and an equipment selected using global state
            let hasChemical = window.chemistryLabState.hasSelectedChemical();
            let hasEquipment = window.chemistryLabState.hasSelectedEquipment();

            // If we have equipment, make sure it's a valid container
            if (hasEquipment) {
                const selectedEquipment = window.chemistryLabState.selectedEquipment;
                const equipmentType = selectedEquipment.type === 'sidebar'
                    ? selectedEquipment.equipmentType
                    : selectedEquipment.element.getAttribute('data-equipment');

                if (equipmentType !== 'beaker' && equipmentType !== 'test-tube') {
                    hasEquipment = false;
                    console.log('Selected equipment is not valid for pouring (not a beaker or test tube)');
                }
            }

            // Fallback to DOM selection if global state is not working
            if (!hasChemical) {
                // Check for chemicals in lab items
                const selectedLabChemicals = document.querySelectorAll('.lab-item[data-type="chemical"][data-selected="true"]');
                if (selectedLabChemicals.length > 0) {
                    hasChemical = true;
                    console.log('Found selected chemical in lab (fallback):', selectedLabChemicals[0]);
                }

                // Check for chemicals in sidebar
                const selectedChemicalItemsWithClass = document.querySelectorAll('.chemical-item.selected-item');
                if (selectedChemicalItemsWithClass.length > 0) {
                    hasChemical = true;
                    console.log('Found selected chemical item in sidebar (fallback):', selectedChemicalItemsWithClass[0]);
                }
            }

            if (!hasEquipment) {
                // Check for equipment in lab items
                const selectedLabEquipment = document.querySelectorAll('.lab-item[data-type="equipment"][data-selected="true"]');
                selectedLabEquipment.forEach(item => {
                    const id = item.getAttribute('data-equipment');
                    if (id === 'beaker' || id === 'test-tube') {
                        hasEquipment = true;
                        console.log('Found selected equipment in lab (fallback):', item);
                    }
                });

                // Check for equipment in sidebar
                const selectedEquipmentItemsWithClass = document.querySelectorAll('.equipment-item.selected-item');
                selectedEquipmentItemsWithClass.forEach(item => {
                    const id = item.getAttribute('data-equipment');
                    if (id === 'beaker' || id === 'test-tube') {
                        hasEquipment = true;
                        console.log('Found selected equipment item in sidebar (fallback):', item);
                    }
                });
            }

            console.log(`Has chemical: ${hasChemical}, Has equipment: ${hasEquipment}`);

            // Enable the pour button only if both chemical and equipment are selected
            if (hasChemical && hasEquipment) {
                pourButton.disabled = false;
                pourButton.classList.add('pour-button-enabled');
                console.log('Pour button enabled - both chemical and equipment selected');

                // Update the instructions
                const instructions = document.querySelector('.pour-instructions');
                if (instructions) {
                    instructions.textContent = 'Click Pour to mix the chemicals';
                    instructions.classList.add('ready-to-pour');
                }
            } else {
                pourButton.disabled = true;
                pourButton.classList.remove('pour-button-enabled');
                console.log('Pour button disabled - missing chemical or equipment');

                // Update the instructions
                const instructions = document.querySelector('.pour-instructions');
                if (instructions) {
                    if (!hasChemical && !hasEquipment) {
                        instructions.textContent = 'Select a chemical and equipment first';
                    } else if (!hasChemical) {
                        instructions.textContent = 'Select a chemical first';
                    } else {
                        instructions.textContent = 'Select equipment first';
                    }
                    instructions.classList.remove('ready-to-pour');
                }
            }
        } catch (error) {
            console.error('Error updating pour button state:', error);
        }
    }

    /**
     * Get chemical name
     */
    function getChemicalName(chemical) {
        switch (chemical) {
            case 'water':
                return 'Water';
            case 'hcl':
                return 'HCl';
            case 'naoh':
                return 'NaOH';
            case 'nacl':
                return 'NaCl';
            case 'hcl-solution':
                return 'HCl Solution';
            case 'naoh-solution':
                return 'NaOH Solution';
            case 'mixture':
                return 'Mixture';
            default:
                return chemical;
        }
    }

    /**
     * Get chemical color
     */
    function getChemicalColor(chemical) {
        switch (chemical) {
            case 'water':
                return '#3b82f6'; // blue-500
            case 'hcl':
                return '#eab308'; // yellow-500
            case 'naoh':
                return '#a855f7'; // purple-500
            case 'nacl':
                return '#f3f4f6'; // white
            case 'hcl-solution':
                return '#fcd34d'; // yellow-300
            case 'naoh-solution':
                return '#c084fc'; // purple-300
            case 'mixture':
                return '#6b7280'; // gray-500
            default:
                return '#6b7280'; // gray-500
        }
    }

    /**
     * Highlight available equipment to help the user understand where to drop chemicals
     */
    function highlightAvailableEquipment() {
        try {
            // Find all equipment items that can accept chemicals (beakers and test tubes)
            const equipmentItems = document.querySelectorAll('.lab-item[data-type="equipment"]');
            let hasEquipment = false;

            equipmentItems.forEach(item => {
                const equipmentType = item.getAttribute('data-equipment');
                if (equipmentType === 'beaker' || equipmentType === 'test-tube') {
                    // Add a stronger highlight effect for better visibility at all zoom levels
                    item.classList.add('equipment-highlight');
                    hasEquipment = true;

                    // Add a "Drop Here" label for better visibility
                    if (!item.querySelector('.drop-here-label')) {
                        const dropLabel = document.createElement('div');
                        dropLabel.classList.add('drop-here-label');
                        dropLabel.textContent = 'DROP HERE';
                        dropLabel.style.position = 'absolute';
                        dropLabel.style.top = '-25px';
                        dropLabel.style.left = '50%';
                        dropLabel.style.transform = 'translateX(-50%)';
                        dropLabel.style.backgroundColor = 'rgba(16, 185, 129, 0.9)';
                        dropLabel.style.color = 'white';
                        dropLabel.style.padding = '3px 8px';
                        dropLabel.style.borderRadius = '4px';
                        dropLabel.style.fontSize = '12px';
                        dropLabel.style.fontWeight = 'bold';
                        dropLabel.style.zIndex = '100';
                        dropLabel.style.whiteSpace = 'nowrap';
                        dropLabel.style.boxShadow = '0 2px 4px rgba(0, 0, 0, 0.3)';

                        // Make sure the item has relative positioning for absolute positioning of the label
                        if (item.style.position !== 'relative' && item.style.position !== 'absolute') {
                            item.style.position = 'relative';
                        }

                        item.appendChild(dropLabel);

                        // Remove the label after a delay
                        setTimeout(() => {
                            if (dropLabel.parentNode) {
                                dropLabel.parentNode.removeChild(dropLabel);
                            }
                        }, 3000);
                    }

                    // Remove the highlight after a delay
                    setTimeout(() => {
                        item.classList.remove('equipment-highlight');
                    }, 3000); // Increased time for better visibility
                }
            });

            // If no equipment is found, suggest adding some with a more prominent message
            if (!hasEquipment) {
                showMessage('Add a beaker or test tube from the Equipment tab first', true);

                // Highlight the equipment tab
                const equipmentTab = document.getElementById('equipment-tab');
                if (equipmentTab) {
                    equipmentTab.classList.add('highlight-tab');

                    // Make the tab pulse to draw attention
                    equipmentTab.style.animation = 'pulse 1s infinite alternate';

                    setTimeout(() => {
                        equipmentTab.classList.remove('highlight-tab');
                        equipmentTab.style.animation = '';
                    }, 3000);
                }

                // Show a more prominent message in the lab bench area
                const labBench = document.querySelector('.lab-bench');
                if (labBench) {
                    const noEquipmentMsg = document.createElement('div');
                    noEquipmentMsg.classList.add('no-equipment-message');
                    noEquipmentMsg.textContent = 'Add beakers or test tubes first!';
                    noEquipmentMsg.style.position = 'absolute';
                    noEquipmentMsg.style.top = '50%';
                    noEquipmentMsg.style.left = '50%';
                    noEquipmentMsg.style.transform = 'translate(-50%, -50%)';
                    noEquipmentMsg.style.backgroundColor = 'rgba(239, 68, 68, 0.9)'; // red
                    noEquipmentMsg.style.color = 'white';
                    noEquipmentMsg.style.padding = '10px 20px';
                    noEquipmentMsg.style.borderRadius = '8px';
                    noEquipmentMsg.style.fontSize = '16px';
                    noEquipmentMsg.style.fontWeight = 'bold';
                    noEquipmentMsg.style.zIndex = '100';
                    noEquipmentMsg.style.boxShadow = '0 4px 8px rgba(0, 0, 0, 0.3)';

                    labBench.appendChild(noEquipmentMsg);

                    // Remove the message after a delay
                    setTimeout(() => {
                        if (noEquipmentMsg.parentNode) {
                            noEquipmentMsg.parentNode.removeChild(noEquipmentMsg);
                        }
                    }, 3000);
                }
            }
        } catch (error) {
            console.error('Error highlighting available equipment:', error);
        }
    }

    /**
     * Hide the lab bench placeholder text
     */
    function hideBenchPlaceholder() {
        try {
            // Find the lab bench
            const labBench = document.querySelector('.lab-bench');
            if (!labBench) return;

            // Check if there's any placeholder text
            const placeholderText = labBench.querySelector(':not(.lab-item):not(.equipment-table)');
            if (placeholderText && placeholderText.textContent && placeholderText.textContent.includes('Drag chemicals')) {
                placeholderText.style.display = 'none';
            }

            // Alternative approach: set a style on the lab bench
            labBench.classList.add('has-items');

            // Add a style to hide the placeholder text
            if (!document.getElementById('bench-placeholder-style')) {
                const style = document.createElement('style');
                style.id = 'bench-placeholder-style';
                style.textContent = `
                    .lab-bench.has-items::before {
                        display: none !important;
                    }
                    .lab-bench.has-items > :not(.lab-item):not(.equipment-table) {
                        display: none !important;
                    }
                    .equipment-table {
                        z-index: 5;
                    }
                `;
                document.head.appendChild(style);
            }

            // Add a label to the equipment table if it doesn't have one
            const equipmentTable = labBench.querySelector('.equipment-table');
            if (equipmentTable && !equipmentTable.querySelector('.table-label')) {
                const tableLabel = document.createElement('div');
                tableLabel.classList.add('table-label');
                tableLabel.textContent = 'Lab Equipment';
                tableLabel.style.position = 'absolute';
                tableLabel.style.top = '-25px';
                tableLabel.style.left = '50%';
                tableLabel.style.transform = 'translateX(-50%)';
                tableLabel.style.color = 'white';
                tableLabel.style.fontSize = '14px';
                tableLabel.style.fontWeight = 'bold';
                tableLabel.style.backgroundColor = 'rgba(0, 0, 0, 0.5)';
                tableLabel.style.padding = '3px 10px';
                tableLabel.style.borderRadius = '4px';
                equipmentTable.appendChild(tableLabel);
            }
        } catch (error) {
            console.error('Error hiding bench placeholder:', error);
        }
    }

    /**
     * Show the lab bench placeholder text
     */
    function showBenchPlaceholder() {
        try {
            // Find the lab bench
            const labBench = document.querySelector('.lab-bench');
            if (!labBench) return;

            // Check if there are any items on the bench
            const items = labBench.querySelectorAll('.lab-item');
            if (items.length === 0) {
                // Check if there's any placeholder text
                const placeholderText = labBench.querySelector(':not(.lab-item)');
                if (placeholderText) {
                    placeholderText.style.display = '';
                }

                // Remove the has-items class
                labBench.classList.remove('has-items');
            }
        } catch (error) {
            console.error('Error showing bench placeholder:', error);
        }
    }

    /**
     * Helper function to check if a point is inside an element with expanded hit area
     * This helps with drag and drop at different zoom levels
     */
    function isPointInElement(x, y, element, expandBy = 20) {
        try {
            if (!element) return false;

            const rect = element.getBoundingClientRect();

            // Expand the hit area by the specified amount
            return (
                x >= rect.left - expandBy &&
                x <= rect.right + expandBy &&
                y >= rect.top - expandBy &&
                y <= rect.bottom + expandBy
            );
        } catch (error) {
            console.error('Error in isPointInElement:', error);
            return false;
        }
    }

    /**
     * Add custom CSS for pour functionality
     */
    function addPourStyles() {
        try {
            const style = document.createElement('style');
            style.textContent = `
                .lab-controls {
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    margin-top: 20px;
                }

                .lab-actions {
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    gap: 10px;
                }

                .lab-action-button {
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    padding: 15px 25px;
                    background-color: #f97316; /* Orange-500 */
                    border: none;
                    border-radius: 8px;
                    color: white;
                    font-weight: bold;
                    cursor: pointer;
                    transition: all 0.3s ease;
                    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                }

                .lab-action-button:hover:not(:disabled) {
                    background-color: #ea580c; /* Orange-600 */
                    transform: translateY(-2px);
                    box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
                }

                .lab-action-button:disabled {
                    background-color: #9ca3af; /* Gray-400 */
                    cursor: not-allowed;
                    transform: none;
                    box-shadow: none;
                }

                .lab-action-icon {
                    font-size: 28px;
                    margin-bottom: 8px;
                }

                .lab-action-text {
                    font-size: 16px;
                }

                .pour-instructions {
                    margin-top: 10px;
                    padding: 8px 12px;
                    background-color: rgba(0, 0, 0, 0.7);
                    color: white;
                    border-radius: 4px;
                    font-size: 14px;
                    text-align: center;
                    max-width: 250px;
                    transition: all 0.3s ease;
                }

                .ready-to-pour {
                    background-color: rgba(249, 115, 22, 0.9); /* Orange-500 with opacity */
                    font-weight: bold;
                    transform: scale(1.05);
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
                }

                .pour-button-enabled {
                    animation: pulse 1.5s infinite;
                }

                @keyframes pulse {
                    0% {
                        transform: scale(1);
                        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                    }
                    50% {
                        transform: scale(1.05);
                        box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
                    }
                    100% {
                        transform: scale(1);
                        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                    }
                }

                .lab-message {
                    position: fixed;
                    top: 20px;
                    left: 50%;
                    transform: translateX(-50%);
                    background-color: rgba(249, 115, 22, 0.9); /* Orange-500 with opacity */
                    color: white;
                    padding: 12px 20px;
                    border-radius: 8px;
                    font-size: 16px;
                    font-weight: bold;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
                    z-index: 9999;
                    animation: message-slide-in 0.3s ease-out;
                    transition: opacity 0.3s ease, transform 0.3s ease;
                }

                .lab-message-error {
                    background-color: rgba(239, 68, 68, 0.9) !important; /* Red-500 with opacity */
                    box-shadow: 0 4px 8px rgba(239, 68, 68, 0.3) !important;
                }

                .lab-message-hide {
                    opacity: 0;
                    transform: translateX(-50%) translateY(-20px);
                }

                @keyframes message-slide-in {
                    0% {
                        opacity: 0;
                        transform: translateX(-50%) translateY(-20px);
                    }
                    100% {
                        opacity: 1;
                        transform: translateX(-50%) translateY(0);
                    }
                }

                .container-indicator {
                    position: absolute;
                    bottom: 0;
                    left: 0;
                    width: 100%;
                    height: 0%;
                    background-color: transparent;
                    transition: all 0.5s ease;
                    border-radius: 0 0 8px 8px;
                    opacity: 0.8;
                    z-index: 1;
                    box-shadow: inset 0 -2px 4px rgba(0, 0, 0, 0.2);
                }

                .container-label {
                    position: absolute;
                    bottom: -25px;
                    left: 0;
                    width: 100%;
                    text-align: center;
                    font-size: 12px;
                    color: white;
                    background-color: rgba(0, 0, 0, 0.5);
                    padding: 2px;
                    border-radius: 4px;
                }

                .selected-item {
                    outline: 3px solid #f97316; /* Orange-500 */
                    box-shadow: 0 0 15px rgba(249, 115, 22, 0.7);
                    z-index: 20 !important;
                    transform: scale(1.05);
                }

                /* Styles for sidebar items */
                .chemical-item, .equipment-item {
                    cursor: pointer;
                    transition: all 0.2s ease;
                    position: relative;
                }

                .chemical-item:hover, .equipment-item:hover {
                    transform: translateY(-2px);
                    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                }

                .chemical-item.selected-item, .equipment-item.selected-item {
                    outline: 3px solid #f97316; /* Orange-500 */
                    box-shadow: 0 0 15px rgba(249, 115, 22, 0.7);
                    z-index: 20 !important;
                    transform: scale(1.05);
                }

                /* Add a checkmark to selected items */
                .chemical-item.selected-item::after, .equipment-item.selected-item::after {
                    content: '✓';
                    position: absolute;
                    top: -10px;
                    right: -10px;
                    background-color: #f97316;
                    color: white;
                    width: 24px;
                    height: 24px;
                    border-radius: 50%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 14px;
                    font-weight: bold;
                    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
                }

                .pouring-animation {
                    position: absolute;
                    width: 10px;
                    height: 50px;
                    background-color: #3b82f6;
                    border-radius: 5px;
                    transition: all 1s ease;
                    z-index: 100;
                }

                .reaction-bubble {
                    position: absolute;
                    bottom: 0;
                    width: 8px;
                    height: 8px;
                    background-color: rgba(255, 255, 255, 0.7);
                    border-radius: 50%;
                    animation: bubble 3s ease-in infinite;
                }

                @keyframes bubble {
                    0% {
                        transform: translateY(0) scale(0);
                        opacity: 0;
                    }
                    50% {
                        opacity: 1;
                    }
                    100% {
                        transform: translateY(-100px) scale(1.5);
                        opacity: 0;
                    }
                }

                .reaction-neutralization .container-indicator {
                    animation: fizz 2s ease-in-out;
                }

                @keyframes fizz {
                    0% {
                        transform: scale(1);
                    }
                    50% {
                        transform: scale(1.1);
                    }
                    100% {
                        transform: scale(1);
                    }
                }

                /* Drag and drop styles */
                .dragging {
                    opacity: 0.7;
                    transform: scale(0.95) !important;
                    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3) !important;
                }

                .drag-over {
                    border: 3px dashed #f97316 !important;
                    background-color: rgba(249, 115, 22, 0.1) !important;
                }

                .chemical-droppable {
                    transition: all 0.3s ease;
                }

                .drag-over-equipment {
                    transform: scale(1.1) !important;
                    box-shadow: 0 0 15px rgba(249, 115, 22, 0.8) !important;
                    border: 2px solid #f97316 !important;
                    z-index: 30 !important;
                }

                .lab-item {
                    user-select: none;
                    z-index: 10;
                    transition: transform 0.2s ease, box-shadow 0.2s ease;
                    width: 80px;
                    height: 100px;
                    padding: 10px;
                    margin: 5px;
                    background-color: rgba(0, 0, 0, 0.3);
                    border-radius: 12px;
                    position: relative;
                    border: 2px solid rgba(249, 115, 22, 0.5); /* Orange border */
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    justify-content: center;
                }

                .lab-item:hover {
                    z-index: 20;
                    transform: scale(1.05);
                    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.4);
                    border-color: rgba(249, 115, 22, 0.8);
                }

                .lab-item.selected-item {
                    border-color: #10b981; /* Green border for selected items */
                    box-shadow: 0 0 0 2px #10b981, 0 6px 12px rgba(0, 0, 0, 0.4);
                }

                .equipment-visual, .chemical-visual {
                    position: relative;
                    width: 100%;
                    height: 100%;
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    justify-content: center;
                }

                .equipment-icon, .chemical-icon {
                    width: 40px;
                    height: 40px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 24px;
                    margin-bottom: 5px;
                    transition: opacity 0.3s ease;
                    border-radius: 8px;
                    background-color: rgba(0, 0, 0, 0.3);
                    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
                }

                .chemical-icon {
                    border-radius: 50%;
                    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
                }

                .chemical-symbol {
                    font-weight: bold;
                    color: black;
                    font-size: 16px;
                    text-shadow: 0 1px 2px rgba(255, 255, 255, 0.5);
                }

                .equipment-label, .chemical-label {
                    font-size: 14px;
                    color: white;
                    text-align: center;
                    transition: opacity 0.3s ease;
                    background-color: rgba(0, 0, 0, 0.6);
                    padding: 2px 6px;
                    border-radius: 4px;
                    margin-top: 2px;
                    font-weight: bold;
                    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.8);
                }

                .container-label {
                    position: absolute;
                    bottom: -20px;
                    left: 50%;
                    transform: translateX(-50%);
                    background-color: rgba(0, 0, 0, 0.7);
                    color: white;
                    padding: 2px 6px;
                    border-radius: 4px;
                    font-size: 10px;
                    white-space: nowrap;
                    z-index: 5;
                }

                .cursor-grab {
                    cursor: grab;
                }

                .cursor-grabbing {
                    cursor: grabbing;
                }
            `;

            document.head.appendChild(style);
        } catch (error) {
            console.error('Error adding pour styles:', error);
        }
    }
});
