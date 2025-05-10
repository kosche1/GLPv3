/**
 * Chemistry Lab Simulator
 *
 * This file contains the core functionality for the Chemistry Lab Simulator.
 * It handles the interactive lab bench, chemical reactions, and molecular visualization.
 * Uses Matter.js for physics-based interactions and animations.
 */

class ChemistryLab {
    constructor() {
        this.labBench = document.querySelector('.lab-bench');
        this.chemicals = [];
        this.equipment = [];
        this.reactions = [];
        this.molecularViewer = null;
        this.isHeated = false;
        this.score = 0;
        this.completedReactions = [];

        // Matter.js properties
        this.engine = null;
        this.render = null;
        this.runner = null;
        this.world = null;
        this.bodies = {};
        this.liquids = {};
        this.isDragging = false;
        this.dragBody = null;
        this.mouseConstraint = null;
        this.pourAnimation = null;

        this.init();
    }

    /**
     * Initialize the Chemistry Lab
     */
    init() {
        this.setupMatterJS();
        this.setupDragAndDrop();
        this.setupButtons();
        this.setupTabs();
    }

    /**
     * Set up Matter.js physics engine
     */
    setupMatterJS() {
        // Import Matter.js modules
        const Engine = Matter.Engine;
        const Render = Matter.Render;
        const Runner = Matter.Runner;
        const Bodies = Matter.Bodies;
        const Composite = Matter.Composite;
        const Body = Matter.Body;
        const Events = Matter.Events;
        const Mouse = Matter.Mouse;
        const MouseConstraint = Matter.MouseConstraint;
        const Query = Matter.Query;
        const Vector = Matter.Vector;

        // Create engine
        this.engine = Engine.create({
            // Enable gravity
            gravity: {
                x: 0,
                y: 1,
                scale: 0.001
            }
        });
        this.world = this.engine.world;

        // Create renderer
        const labBenchRect = this.labBench.getBoundingClientRect();
        this.render = Render.create({
            element: this.labBench,
            engine: this.engine,
            options: {
                width: labBenchRect.width,
                height: labBenchRect.height,
                wireframes: false,
                background: 'transparent',
                showAngleIndicator: false,
                showCollisions: false,
                showVelocity: false
            }
        });

        // Clear any existing content
        while (this.labBench.firstChild) {
            this.labBench.removeChild(this.labBench.firstChild);
        }

        // Create walls to keep objects within the lab bench
        const wallThickness = 50;
        const wallOptions = {
            isStatic: true,
            render: {
                visible: false
            }
        };

        // Bottom wall
        Composite.add(this.world, [
            // Bottom wall
            Bodies.rectangle(
                labBenchRect.width / 2,
                labBenchRect.height + wallThickness / 2,
                labBenchRect.width,
                wallThickness,
                wallOptions
            ),
            // Left wall
            Bodies.rectangle(
                -wallThickness / 2,
                labBenchRect.height / 2,
                wallThickness,
                labBenchRect.height,
                wallOptions
            ),
            // Right wall
            Bodies.rectangle(
                labBenchRect.width + wallThickness / 2,
                labBenchRect.height / 2,
                wallThickness,
                labBenchRect.height,
                wallOptions
            ),
            // Top wall
            Bodies.rectangle(
                labBenchRect.width / 2,
                -wallThickness / 2,
                labBenchRect.width,
                wallThickness,
                wallOptions
            )
        ]);

        // Add mouse control with improved settings for better dragging
        const mouse = Mouse.create(this.render.canvas);
        this.mouseConstraint = MouseConstraint.create(this.engine, {
            mouse: mouse,
            constraint: {
                stiffness: 0.5,  // Increased stiffness for more responsive dragging
                damping: 0.1,    // Added damping for smoother movement
                render: {
                    visible: true,  // Make constraint visible for debugging
                    lineWidth: 1,
                    strokeStyle: 'rgba(255,255,255,0.2)'
                }
            },
            collisionFilter: {
                mask: 0x0001    // Only interact with category 0x0001 (which we'll set for all draggable objects)
            }
        });

        Composite.add(this.world, this.mouseConstraint);

        // Keep the mouse in sync with rendering
        this.render.mouse = mouse;

        // Add mouse events for better interaction feedback
        Events.on(this.mouseConstraint, 'mousemove', (event) => {
            // Highlight objects under mouse
            const bodies = Query.point(this.world.bodies, event.mouse.position);
            bodies.forEach(body => {
                if (body.render && !body.isStatic) {
                    // Store original color to restore later
                    if (!body.originalRender) {
                        body.originalRender = {
                            fillStyle: body.render.fillStyle,
                            strokeStyle: body.render.strokeStyle,
                            lineWidth: body.render.lineWidth
                        };
                    }

                    // Highlight effect
                    body.render.strokeStyle = '#ffffff';
                    body.render.lineWidth = 2;
                }
            });
        });

        // Handle mouse events for dragging
        Events.on(this.mouseConstraint, 'startdrag', (event) => {
            this.isDragging = true;
            this.dragBody = event.body;

            // If dragging a container with liquid, prepare for potential pouring
            if (this.dragBody && this.dragBody.label.startsWith('equipment_')) {
                const equipmentId = this.dragBody.label.split('_')[1];
                // Find if this equipment contains any chemicals
                this.prepareForPouring(equipmentId);
            }
        });

        Events.on(this.mouseConstraint, 'enddrag', (event) => {
            this.isDragging = false;
            this.dragBody = null;

            // Check for reactions after dragging ends
            this.checkForReactions();
        });

        // Run the engine
        Render.run(this.render);
        this.runner = Runner.create();
        Runner.run(this.runner, this.engine);

        // Add placeholder text
        const placeholder = document.createElement('div');
        placeholder.classList.add('absolute', 'inset-0', 'flex', 'items-center', 'justify-center', 'pointer-events-none', 'z-10');
        placeholder.innerHTML = '<p class="text-neutral-400">Drag chemicals and equipment here to start experimenting</p>';
        this.labBench.appendChild(placeholder);
        this.placeholder = placeholder;
    }

    /**
     * Set up drag and drop functionality
     */
    setupDragAndDrop() {
        try {
            // Make chemicals draggable with click instead of HTML5 drag and drop
            const chemicalItems = document.querySelectorAll('.chemical-item');
            chemicalItems.forEach(item => {
                item.classList.add('cursor-pointer');

                item.addEventListener('click', () => {
                    try {
                        const chemicalId = item.getAttribute('data-chemical');
                        if (!chemicalId) {
                            console.error('No data-chemical attribute found on clicked item');
                            return;
                        }

                        const labBenchRect = this.labBench.getBoundingClientRect();

                        // Add to center of lab bench
                        const x = labBenchRect.width / 2;
                        const y = labBenchRect.height / 2;

                        this.addItemToLabBench('chemical', chemicalId, x, y);
                    } catch (error) {
                        console.error('Error in chemical item click handler:', error);
                    }
                });
            });

            // Make equipment draggable with click
            const equipmentItems = document.querySelectorAll('.equipment-item');
            equipmentItems.forEach(item => {
                item.classList.add('cursor-pointer');

                item.addEventListener('click', () => {
                    try {
                        const equipmentId = item.getAttribute('data-equipment');
                        if (!equipmentId) {
                            console.error('No data-equipment attribute found on clicked item');
                            return;
                        }

                        const labBenchRect = this.labBench.getBoundingClientRect();

                        // Add to center of lab bench
                        const x = labBenchRect.width / 2;
                        const y = labBenchRect.height / 2;

                        this.addItemToLabBench('equipment', equipmentId, x, y);
                    } catch (error) {
                        console.error('Error in equipment item click handler:', error);
                    }
                });
            });

            // Add direct drag and drop from sidebar to lab bench
            this.setupDirectDragAndDrop();
        } catch (error) {
            console.error('Error setting up drag and drop:', error);
        }
    }

    /**
     * Set up direct drag and drop from sidebar to lab bench
     */
    setupDirectDragAndDrop() {
        try {
            // Make chemicals draggable with HTML5 drag and drop
            const chemicalItems = document.querySelectorAll('.chemical-item');
            chemicalItems.forEach(item => {
                item.setAttribute('draggable', 'true');

                item.addEventListener('dragstart', (event) => {
                    try {
                        const chemicalId = item.getAttribute('data-chemical');
                        if (!chemicalId) return;

                        event.dataTransfer.setData('text/plain', JSON.stringify({
                            type: 'chemical',
                            id: chemicalId
                        }));

                        // Set a custom drag image
                        const dragImage = document.createElement('div');
                        dragImage.classList.add('w-8', 'h-8', 'rounded-full', 'bg-blue-500', 'flex', 'items-center', 'justify-center');
                        dragImage.innerHTML = '<span class="text-xs font-bold text-black">Drag</span>';
                        document.body.appendChild(dragImage);
                        event.dataTransfer.setDragImage(dragImage, 15, 15);

                        // Remove the drag image after it's been used
                        setTimeout(() => {
                            document.body.removeChild(dragImage);
                        }, 0);
                    } catch (error) {
                        console.error('Error in chemical dragstart handler:', error);
                    }
                });
            });

            // Make equipment draggable with HTML5 drag and drop
            const equipmentItems = document.querySelectorAll('.equipment-item');
            equipmentItems.forEach(item => {
                item.setAttribute('draggable', 'true');

                item.addEventListener('dragstart', (event) => {
                    try {
                        const equipmentId = item.getAttribute('data-equipment');
                        if (!equipmentId) return;

                        event.dataTransfer.setData('text/plain', JSON.stringify({
                            type: 'equipment',
                            id: equipmentId
                        }));

                        // Set a custom drag image
                        const dragImage = document.createElement('div');
                        dragImage.classList.add('w-8', 'h-8', 'rounded-full', 'bg-gray-500', 'flex', 'items-center', 'justify-center');
                        dragImage.innerHTML = '<span class="text-xs font-bold text-black">Drag</span>';
                        document.body.appendChild(dragImage);
                        event.dataTransfer.setDragImage(dragImage, 15, 15);

                        // Remove the drag image after it's been used
                        setTimeout(() => {
                            document.body.removeChild(dragImage);
                        }, 0);
                    } catch (error) {
                        console.error('Error in equipment dragstart handler:', error);
                    }
                });
            });

            // Make lab bench a drop target
            if (this.labBench) {
                this.labBench.addEventListener('dragover', (event) => {
                    event.preventDefault(); // Allow drop
                });

                this.labBench.addEventListener('drop', (event) => {
                    try {
                        event.preventDefault();

                        const data = JSON.parse(event.dataTransfer.getData('text/plain'));
                        if (!data || !data.type || !data.id) return;

                        // Get drop coordinates relative to lab bench
                        const labBenchRect = this.labBench.getBoundingClientRect();
                        const x = event.clientX - labBenchRect.left;
                        const y = event.clientY - labBenchRect.top;

                        // Add item at drop location
                        this.addItemToLabBench(data.type, data.id, x, y);
                    } catch (error) {
                        console.error('Error in lab bench drop handler:', error);
                    }
                });
            }
        } catch (error) {
            console.error('Error setting up direct drag and drop:', error);
        }
    }

    /**
     * Prepare for pouring animation when dragging a container
     */
    prepareForPouring(equipmentId) {
        // Find if this equipment contains any chemicals
        const containedChemicals = this.chemicals.filter(c => c.containerId === equipmentId);

        if (containedChemicals.length === 0) return;

        // Set up pouring detection
        Matter.Events.on(this.engine, 'afterUpdate', () => {
            if (!this.isDragging || !this.dragBody) return;

            // Only process if we're dragging equipment
            if (!this.dragBody.label.startsWith('equipment_')) return;

            const draggedEquipmentId = this.dragBody.label.split('_')[1];
            if (draggedEquipmentId !== equipmentId) return;

            // Check if the equipment is tilted enough for pouring
            const tiltAngle = this.dragBody.angle;
            const isTilted = Math.abs(tiltAngle) > 0.5; // About 30 degrees

            if (isTilted) {
                // Find a target container below
                const targetContainer = this.findPouringTarget(this.dragBody);

                if (targetContainer) {
                    this.pourChemical(draggedEquipmentId, targetContainer.id, tiltAngle);
                }
            }
        });
    }

    /**
     * Find a potential container to pour into
     */
    findPouringTarget(sourceBody) {
        // Get position of the pouring container
        const sourcePos = sourceBody.position;

        // Check all equipment to find one below the source
        for (const equipment of this.equipment) {
            if (equipment.body === sourceBody) continue;

            const targetPos = equipment.body.position;

            // Check if target is below source (y increases downward)
            if (targetPos.y > sourcePos.y &&
                Math.abs(targetPos.x - sourcePos.x) < 50) {
                return equipment;
            }
        }

        return null;
    }

    /**
     * Pour a chemical from one container to another
     */
    pourChemical(sourceId, targetId, tiltAngle) {
        // Find chemicals in the source container
        const chemicalsToPour = this.chemicals.filter(c => c.containerId === sourceId);

        if (chemicalsToPour.length === 0) return;

        // Create pouring animation
        if (!this.pourAnimation) {
            this.pourAnimation = this.createPouringAnimation(sourceId, targetId, chemicalsToPour[0].id, tiltAngle);

            // Transfer the chemical to the target container
            setTimeout(() => {
                chemicalsToPour.forEach(chemical => {
                    chemical.containerId = targetId;
                });

                // Remove the pouring animation
                if (this.pourAnimation) {
                    this.pourAnimation.remove();
                    this.pourAnimation = null;
                }

                // Check for reactions
                this.checkForReactions();
            }, 1500); // Animation duration
        }
    }

    /**
     * Create a visual pouring animation
     */
    createPouringAnimation(sourceId, targetId, chemicalId, tiltAngle) {
        // Get positions of source and target containers
        const sourceBody = this.bodies[`equipment_${sourceId}`];
        const targetBody = this.bodies[`equipment_${targetId}`];

        if (!sourceBody || !targetBody) return null;

        const sourcePos = sourceBody.position;
        const targetPos = targetBody.position;

        // Create a stream element
        const stream = document.createElement('div');
        stream.classList.add('pouring-stream', 'absolute');

        // Determine color based on chemical
        let color;
        switch (chemicalId) {
            case 'water':
                color = 'bg-blue-500';
                break;
            case 'hcl':
                color = 'bg-yellow-500';
                break;
            case 'naoh':
                color = 'bg-purple-500';
                break;
            case 'phenolphthalein':
                color = 'bg-pink-300';
                break;
            default:
                color = 'bg-gray-500';
        }

        // Calculate stream path
        const startX = sourcePos.x + (Math.sin(tiltAngle) * 30);
        const startY = sourcePos.y + (Math.cos(tiltAngle) * 30);
        const endX = targetPos.x;
        const endY = targetPos.y - 30; // Slightly above target

        // Create stream with bezier curve
        stream.innerHTML = `
            <svg class="absolute" width="100%" height="100%" style="pointer-events: none; z-index: 5;">
                <path d="M ${startX},${startY} C ${startX},${(startY + endY)/2} ${endX},${(startY + endY)/2} ${endX},${endY}"
                      stroke="${color.replace('bg-', '')}"
                      stroke-width="8"
                      fill="none"
                      stroke-dasharray="5,5">
                    <animate attributeName="stroke-dashoffset" from="0" to="100" dur="1s" repeatCount="indefinite" />
                </path>
                <circle cx="${startX}" cy="${startY}" r="5" fill="${color.replace('bg-', '')}" />
                <circle cx="${endX}" cy="${endY}" r="5" fill="${color.replace('bg-', '')}" />
            </svg>
        `;

        this.labBench.appendChild(stream);

        // Add droplet animation
        this.addDroplets(startX, startY, endX, endY, color);

        return stream;
    }

    /**
     * Add droplet animation for pouring
     */
    addDroplets(startX, startY, endX, endY, color) {
        const dropletContainer = document.createElement('div');
        dropletContainer.classList.add('droplet-container', 'absolute', 'inset-0', 'pointer-events-none');

        // Create 10 droplets
        for (let i = 0; i < 10; i++) {
            const droplet = document.createElement('div');
            droplet.classList.add('droplet', 'absolute', color, 'rounded-full');

            // Random size between 3-8px
            const size = Math.floor(Math.random() * 6) + 3;
            droplet.style.width = `${size}px`;
            droplet.style.height = `${size}px`;

            // Position along the path with some randomness
            const progress = i / 10;
            const x = startX + (endX - startX) * progress + (Math.random() * 10 - 5);
            const y = startY + (endY - startY) * progress + (Math.random() * 10 - 5);

            droplet.style.left = `${x}px`;
            droplet.style.top = `${y}px`;

            // Add falling animation
            droplet.style.animation = `fall 1.5s ease-in ${i * 0.1}s infinite`;

            dropletContainer.appendChild(droplet);
        }

        // Add keyframes for falling animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes fall {
                0% {
                    transform: translateY(0) scale(1);
                    opacity: 0;
                }
                10% {
                    opacity: 1;
                }
                100% {
                    transform: translateY(${endY - startY}px) scale(0.5);
                    opacity: 0;
                }
            }
        `;

        dropletContainer.appendChild(style);
        this.labBench.appendChild(dropletContainer);

        // Remove after animation completes
        setTimeout(() => {
            dropletContainer.remove();
        }, 3000);
    }

    /**
     * Add an item to the lab bench
     */
    addItemToLabBench(type, id, x, y) {
        try {
            // Validate parameters
            if (!type || !id) {
                console.error('Invalid parameters for addItemToLabBench:', { type, id });
                return;
            }

            // Ensure x and y are valid numbers
            if (typeof x !== 'number' || isNaN(x) || typeof y !== 'number' || isNaN(y)) {
                console.error('Invalid coordinates for addItemToLabBench:', { x, y });

                // Use center of lab bench as fallback
                const labBenchRect = this.labBench.getBoundingClientRect();
                x = labBenchRect.width / 2;
                y = labBenchRect.height / 2;
            }

            // Clear the placeholder text if it exists
            if (this.placeholder && this.placeholder.parentNode) {
                this.placeholder.remove();
                this.placeholder = null;
            }

            // Add the item based on type
            if (type === 'chemical') {
                this.addChemical(id, x, y);
            } else if (type === 'equipment') {
                this.addEquipment(id, x, y);
            } else {
                console.error('Unknown item type:', type);
                return;
            }

            // Check for reactions
            this.checkForReactions();
        } catch (error) {
            console.error('Error adding item to lab bench:', error, { type, id, x, y });
        }
    }

    /**
     * Add a chemical to the lab bench
     */
    addChemical(id, x, y) {
        // Determine color and label based on chemical type
        let color, symbol;
        switch (id) {
            case 'water':
                color = '#3b82f6'; // blue-500
                symbol = 'H₂O';
                break;
            case 'hcl':
                color = '#eab308'; // yellow-500
                symbol = 'HCl';
                break;
            case 'naoh':
                color = '#a855f7'; // purple-500
                symbol = 'NaOH';
                break;
            case 'phenolphthalein':
                color = '#f9a8d4'; // pink-300
                symbol = 'Ph';
                break;
            default:
                color = '#6b7280'; // gray-500
                symbol = id;
        }

        // Create a Matter.js circle body for the chemical
        const radius = 25; // 50px diameter
        const chemicalBody = Matter.Bodies.circle(x, y, radius, {
            label: `chemical_${id}`,
            restitution: 0.6, // Bounciness
            friction: 0.1,
            frictionAir: 0.01,
            // Add collision filtering to make it draggable
            collisionFilter: {
                category: 0x0001,  // This object belongs to category 0x0001
                mask: 0xFFFFFFFF   // It can collide with all categories
            },
            render: {
                fillStyle: color,
                strokeStyle: '#ffffff',
                lineWidth: 2
            }
        });

        // Add the body to the world
        Matter.Composite.add(this.world, chemicalBody);

        // Store the body reference
        this.bodies[`chemical_${id}_${Date.now()}`] = chemicalBody;

        // Create a label for the chemical
        const label = document.createElement('div');
        label.classList.add('absolute', 'pointer-events-none', 'chemical-label');
        label.innerHTML = `<span class="text-sm font-bold text-black">${symbol}</span>`;
        label.style.zIndex = '10';
        this.labBench.appendChild(label);

        // Update label position on each render
        Matter.Events.on(this.engine, 'afterRender', () => {
            if (!chemicalBody.position) return;

            label.style.left = `${chemicalBody.position.x - 15}px`;
            label.style.top = `${chemicalBody.position.y - 10}px`;
        });

        // Add to chemicals array
        this.chemicals.push({
            id: id,
            body: chemicalBody,
            label: label,
            containerId: null // Not in a container initially
        });
    }

    /**
     * Add equipment to the lab bench
     */
    addEquipment(id, x, y) {
        let body, width, height, vertices;

        // Create appropriate Matter.js body based on equipment type
        switch (id) {
            case 'beaker':
                // Create a beaker shape using vertices
                width = 60;
                height = 80;

                // Create a beaker shape (glass with open top)
                vertices = [
                    // Bottom
                    { x: x - width/2, y: y + height/2 },
                    { x: x + width/2, y: y + height/2 },
                    // Right side
                    { x: x + width/2, y: y - height/2 },
                    // Top (open)
                    { x: x - width/2, y: y - height/2 }
                ];

                body = Matter.Bodies.fromVertices(x, y, [vertices], {
                    label: `equipment_${id}`,
                    restitution: 0.2,
                    friction: 0.1,
                    frictionAir: 0.02,
                    // Add collision filtering to make it draggable
                    collisionFilter: {
                        category: 0x0001,  // This object belongs to category 0x0001
                        mask: 0xFFFFFFFF   // It can collide with all categories
                    },
                    render: {
                        fillStyle: 'transparent',
                        strokeStyle: '#d1d5db', // gray-300
                        lineWidth: 2
                    }
                });

                // If that fails, use a rectangle as fallback
                if (!body) {
                    body = Matter.Bodies.rectangle(x, y, width, height, {
                        label: `equipment_${id}`,
                        restitution: 0.2,
                        friction: 0.1,
                        frictionAir: 0.02,
                        // Add collision filtering to make it draggable
                        collisionFilter: {
                            category: 0x0001,  // This object belongs to category 0x0001
                            mask: 0xFFFFFFFF   // It can collide with all categories
                        },
                        render: {
                            fillStyle: 'transparent',
                            strokeStyle: '#d1d5db', // gray-300
                            lineWidth: 2
                        }
                    });
                }
                break;

            case 'test-tube':
                // Create a test tube shape
                width = 30;
                height = 90;

                body = Matter.Bodies.rectangle(x, y, width, height, {
                    label: `equipment_${id}`,
                    restitution: 0.2,
                    friction: 0.1,
                    frictionAir: 0.02,
                    // Add collision filtering to make it draggable
                    collisionFilter: {
                        category: 0x0001,  // This object belongs to category 0x0001
                        mask: 0xFFFFFFFF   // It can collide with all categories
                    },
                    render: {
                        fillStyle: 'transparent',
                        strokeStyle: '#d1d5db', // gray-300
                        lineWidth: 2
                    }
                });
                break;

            case 'bunsen-burner':
                // Create a bunsen burner shape
                width = 50;
                height = 70;

                body = Matter.Bodies.rectangle(x, y, width, height, {
                    label: `equipment_${id}`,
                    isStatic: false, // Make it movable
                    restitution: 0.2,
                    friction: 0.1,
                    frictionAir: 0.02,
                    // Add collision filtering to make it draggable
                    collisionFilter: {
                        category: 0x0001,  // This object belongs to category 0x0001
                        mask: 0xFFFFFFFF   // It can collide with all categories
                    },
                    render: {
                        fillStyle: '#374151', // gray-700
                        strokeStyle: '#d1d5db', // gray-300
                        lineWidth: 2
                    }
                });
                break;

            case 'pipette':
                // Create a pipette shape
                width = 15;
                height = 80;

                body = Matter.Bodies.rectangle(x, y, width, height, {
                    label: `equipment_${id}`,
                    restitution: 0.2,
                    friction: 0.1,
                    frictionAir: 0.01,
                    // Add collision filtering to make it draggable
                    collisionFilter: {
                        category: 0x0001,  // This object belongs to category 0x0001
                        mask: 0xFFFFFFFF   // It can collide with all categories
                    },
                    render: {
                        fillStyle: 'transparent',
                        strokeStyle: '#d1d5db', // gray-300
                        lineWidth: 2
                    }
                });
                break;

            default:
                // Default equipment shape
                body = Matter.Bodies.rectangle(x, y, 60, 60, {
                    label: `equipment_${id}`,
                    restitution: 0.2,
                    friction: 0.1,
                    frictionAir: 0.02,
                    // Add collision filtering to make it draggable
                    collisionFilter: {
                        category: 0x0001,  // This object belongs to category 0x0001
                        mask: 0xFFFFFFFF   // It can collide with all categories
                    },
                    render: {
                        fillStyle: '#374151', // gray-700
                        strokeStyle: '#d1d5db', // gray-300
                        lineWidth: 2
                    }
                });
        }

        // Add the body to the world
        Matter.Composite.add(this.world, body);

        // Store the body reference
        this.bodies[`equipment_${id}`] = body;

        // Create a visual representation for the equipment
        const visual = document.createElement('div');
        visual.classList.add('absolute', 'pointer-events-none', 'equipment-visual');
        visual.style.zIndex = '5';

        // Add appropriate SVG based on equipment type
        switch (id) {
            case 'beaker':
                visual.innerHTML = `
                    <svg class="w-24 h-24 text-gray-300" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7 3H17V7C17 7 17 13 12 13C7 13 7 7 7 7V3Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M5 21H19V19C19 17 17 15 12 15C7 15 5 17 5 19V21Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                `;
                break;
            case 'test-tube':
                visual.innerHTML = `
                    <svg class="w-24 h-24 text-gray-300" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 3H15V8C15 8 15 16 12 16C9 16 9 8 9 8V3Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M7 21H17V19C17 18 15 17 12 17C9 17 7 18 7 19V21Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                `;
                break;
            case 'bunsen-burner':
                visual.innerHTML = `
                    <svg class="w-24 h-24 text-gray-300" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 3V7M12 21V17M12 17C10.3431 17 9 15.6569 9 14C9 12.3431 10.3431 11 12 11C13.6569 11 15 12.3431 15 14C15 15.6569 13.6569 17 12 17Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M7 21H17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                `;
                break;
            case 'pipette':
                visual.innerHTML = `
                    <svg class="w-24 h-24 text-gray-300" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 3V7M12 21V17M12 7V17M8 7H16M9 21H15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                `;
                break;
            default:
                visual.innerHTML = `
                    <div class="w-24 h-24 bg-gray-700 rounded-lg flex items-center justify-center">
                        <span class="text-sm font-bold text-white">${id}</span>
                    </div>
                `;
        }

        this.labBench.appendChild(visual);

        // Update visual position on each render
        Matter.Events.on(this.engine, 'afterRender', () => {
            if (!body.position) return;

            visual.style.left = `${body.position.x - 24}px`; // Half of width
            visual.style.top = `${body.position.y - 24}px`; // Half of height
            visual.style.transform = `rotate(${body.angle}rad)`;
        });

        // Add to equipment array
        this.equipment.push({
            id: id,
            body: body,
            visual: visual
        });
    }

    /**
     * We don't need this method anymore as Matter.js handles dragging
     * through the MouseConstraint
     */

    /**
     * Check for chemical reactions
     */
    checkForReactions() {
        // Check for chemicals in containers
        this.updateChemicalContainers();

        // Get all chemicals and equipment on the bench
        const chemicalsInBeaker = this.chemicals.filter(c => {
            const beaker = this.equipment.find(e => e.id === 'beaker');
            return beaker && c.containerId === 'beaker';
        });

        const chemicalsInTestTube = this.chemicals.filter(c => {
            const testTube = this.equipment.find(e => e.id === 'test-tube');
            return testTube && c.containerId === 'test-tube';
        });

        // Check for specific chemicals in containers
        const hasHClInBeaker = chemicalsInBeaker.some(c => c.id === 'hcl');
        const hasNaOHInBeaker = chemicalsInBeaker.some(c => c.id === 'naoh');
        const hasPhenolphthaleinInBeaker = chemicalsInBeaker.some(c => c.id === 'phenolphthalein');
        const hasWaterInBeaker = chemicalsInBeaker.some(c => c.id === 'water');

        const hasHClInTestTube = chemicalsInTestTube.some(c => c.id === 'hcl');
        const hasWaterInTestTube = chemicalsInTestTube.some(c => c.id === 'water');

        const hasBeaker = this.equipment.some(e => e.id === 'beaker');
        const hasTestTube = this.equipment.some(e => e.id === 'test-tube');
        const hasBunsenBurner = this.equipment.some(e => e.id === 'bunsen-burner');
        const isHeated = this.isHeated;

        // Check for proximity between equipment
        const bunsenBurner = this.equipment.find(e => e.id === 'bunsen-burner');
        const beaker = this.equipment.find(e => e.id === 'beaker');
        const testTube = this.equipment.find(e => e.id === 'test-tube');

        let beakerNearBurner = false;
        let testTubeNearBurner = false;

        if (bunsenBurner && beaker && beaker.body && bunsenBurner.body) {
            const distance = Matter.Vector.magnitude(
                Matter.Vector.sub(beaker.body.position, bunsenBurner.body.position)
            );
            beakerNearBurner = distance < 100; // Within 100px
        }

        if (bunsenBurner && testTube && testTube.body && bunsenBurner.body) {
            const distance = Matter.Vector.magnitude(
                Matter.Vector.sub(testTube.body.position, bunsenBurner.body.position)
            );
            testTubeNearBurner = distance < 100; // Within 100px
        }

        // Acid-base neutralization reaction
        if (hasHClInBeaker && hasNaOHInBeaker && hasPhenolphthaleinInBeaker) {
            this.showReaction('neutralization', beaker.body.position);
            this.addPoints(10, 'Neutralization reaction');
        }

        // Water heating reaction
        else if (hasWaterInBeaker && beakerNearBurner && isHeated) {
            this.showReaction('boiling', beaker.body.position);
            this.addPoints(5, 'Boiling water');
        }

        // HCl heating reaction
        else if (hasHClInTestTube && testTubeNearBurner && isHeated) {
            this.showReaction('hcl-decomposition', testTube.body.position);
            this.addPoints(15, 'HCl decomposition');
        }

        // NaOH in water reaction
        else if (hasNaOHInBeaker && hasWaterInBeaker) {
            this.showReaction('naoh-dissolution', beaker.body.position);
            this.addPoints(5, 'NaOH dissolution');
        }
    }

    /**
     * Update which chemicals are in which containers
     */
    updateChemicalContainers() {
        // For each chemical, check if it's inside a container
        for (const chemical of this.chemicals) {
            if (!chemical.body || !chemical.body.position) continue;

            const chemicalPos = chemical.body.position;
            let foundContainer = false;

            // Check each equipment to see if the chemical is inside it
            for (const equipment of this.equipment) {
                if (!equipment.body || !equipment.body.position) continue;

                // Skip non-container equipment
                if (equipment.id !== 'beaker' && equipment.id !== 'test-tube') continue;

                const equipmentPos = equipment.body.position;
                const equipmentBounds = equipment.body.bounds;

                // Check if chemical is inside the equipment bounds
                if (chemicalPos.x > equipmentBounds.min.x &&
                    chemicalPos.x < equipmentBounds.max.x &&
                    chemicalPos.y > equipmentBounds.min.y &&
                    chemicalPos.y < equipmentBounds.max.y) {

                    // Chemical is inside this container
                    chemical.containerId = equipment.id;
                    foundContainer = true;

                    // Update chemical position to stay inside container
                    Matter.Body.setPosition(chemical.body, {
                        x: equipmentPos.x,
                        y: equipmentPos.y - 10 // Slightly above center
                    });

                    // Make chemical static so it doesn't fall through
                    Matter.Body.setStatic(chemical.body, true);

                    break;
                }
            }

            // If not in any container, make sure it's not static
            if (!foundContainer && chemical.containerId) {
                chemical.containerId = null;
                Matter.Body.setStatic(chemical.body, false);
            }
        }
    }

    /**
     * Show a reaction in the lab bench
     */
    showReaction(reactionType, position) {
        // Check if reaction already exists
        if (this.reactions.includes(reactionType)) return;

        // Add to reactions array
        this.reactions.push(reactionType);

        // Create reaction visualization
        const reaction = document.createElement('div');
        reaction.classList.add('absolute', 'pointer-events-none', 'z-20');
        reaction.setAttribute('data-reaction', reactionType);

        // Position the reaction at the specified position
        if (position) {
            reaction.style.left = `${position.x - 75}px`; // Center horizontally
            reaction.style.top = `${position.y - 75}px`;  // Center vertically
            reaction.style.width = '150px';
            reaction.style.height = '150px';
        } else {
            // Fallback to full lab bench if no position specified
            reaction.classList.add('inset-0');
        }

        switch (reactionType) {
            case 'neutralization':
                // Pink color for phenolphthalein in basic solution
                reaction.innerHTML = `
                    <div class="w-full h-full bg-pink-500/30 animate-pulse rounded-lg flex items-center justify-center">
                        <div class="bg-white/80 px-4 py-2 rounded-lg">
                            <p class="text-black font-medium">Neutralization: HCl + NaOH → NaCl + H₂O</p>
                        </div>
                    </div>
                `;

                // Create particles for the reaction
                this.createParticles(position, 'pink', 20);
                break;

            case 'boiling':
                // Bubbling water effect
                reaction.innerHTML = `
                    <div class="w-full h-full rounded-lg flex items-center justify-center overflow-hidden">
                        <div class="absolute inset-0 bg-blue-500/30">
                            <!-- Bubbles -->
                            <div class="bubble bubble-1"></div>
                            <div class="bubble bubble-2"></div>
                            <div class="bubble bubble-3"></div>
                            <div class="bubble bubble-4"></div>
                            <div class="bubble bubble-5"></div>
                        </div>
                        <div class="bg-white/80 px-4 py-2 rounded-lg z-10">
                            <p class="text-black font-medium">Boiling: H₂O(l) → H₂O(g)</p>
                        </div>
                    </div>
                    <style>
                        .bubble {
                            position: absolute;
                            bottom: -20px;
                            background-color: rgba(255, 255, 255, 0.7);
                            border-radius: 50%;
                            animation: bubble 2s infinite ease-in;
                        }
                        .bubble-1 {
                            width: 20px;
                            height: 20px;
                            left: 20%;
                            animation-delay: 0s;
                        }
                        .bubble-2 {
                            width: 15px;
                            height: 15px;
                            left: 40%;
                            animation-delay: 0.5s;
                        }
                        .bubble-3 {
                            width: 25px;
                            height: 25px;
                            left: 60%;
                            animation-delay: 1s;
                        }
                        .bubble-4 {
                            width: 10px;
                            height: 10px;
                            left: 80%;
                            animation-delay: 1.5s;
                        }
                        .bubble-5 {
                            width: 18px;
                            height: 18px;
                            left: 30%;
                            animation-delay: 0.7s;
                        }
                        @keyframes bubble {
                            0% {
                                transform: translateY(0);
                                opacity: 0;
                            }
                            50% {
                                opacity: 1;
                            }
                            100% {
                                transform: translateY(-100px);
                                opacity: 0;
                            }
                        }
                    </style>
                `;

                // Create steam particles
                this.createParticles(position, 'blue', 15, true);
                break;

            case 'hcl-decomposition':
                // Gas release effect with yellow-green color
                reaction.innerHTML = `
                    <div class="w-full h-full rounded-lg flex items-center justify-center overflow-hidden">
                        <div class="absolute inset-0 bg-yellow-green-gradient animate-pulse">
                            <!-- Gas wisps -->
                            <div class="gas-wisp gas-wisp-1"></div>
                            <div class="gas-wisp gas-wisp-2"></div>
                            <div class="gas-wisp gas-wisp-3"></div>
                        </div>
                        <div class="bg-white/80 px-4 py-2 rounded-lg z-10">
                            <p class="text-black font-medium">HCl Decomposition: Heat + HCl → H₂ + Cl₂</p>
                        </div>
                    </div>
                    <style>
                        .bg-yellow-green-gradient {
                            background: linear-gradient(to top, rgba(234, 179, 8, 0.3), rgba(132, 204, 22, 0.3));
                        }
                        .gas-wisp {
                            position: absolute;
                            width: 40px;
                            height: 40px;
                            background-color: rgba(234, 179, 8, 0.4);
                            border-radius: 50%;
                            filter: blur(10px);
                            animation: rise 3s infinite ease-out;
                        }
                        .gas-wisp-1 {
                            left: 30%;
                            animation-delay: 0s;
                        }
                        .gas-wisp-2 {
                            left: 50%;
                            animation-delay: 1s;
                        }
                        .gas-wisp-3 {
                            left: 70%;
                            animation-delay: 2s;
                        }
                        @keyframes rise {
                            0% {
                                transform: translateY(100px);
                                opacity: 0;
                            }
                            50% {
                                opacity: 1;
                            }
                            100% {
                                transform: translateY(-50px);
                                opacity: 0;
                            }
                        }
                    </style>
                `;

                // Create gas particles
                this.createParticles(position, 'yellow', 25, true);
                break;

            case 'naoh-dissolution':
                // Dissolution effect with purple swirls
                reaction.innerHTML = `
                    <div class="w-full h-full rounded-lg flex items-center justify-center overflow-hidden">
                        <div class="absolute inset-0 bg-purple-500/20">
                            <!-- Swirls -->
                            <div class="swirl swirl-1"></div>
                            <div class="swirl swirl-2"></div>
                        </div>
                        <div class="bg-white/80 px-4 py-2 rounded-lg z-10">
                            <p class="text-black font-medium">NaOH Dissolution: NaOH + H₂O → Na⁺ + OH⁻</p>
                        </div>
                    </div>
                    <style>
                        .swirl {
                            position: absolute;
                            border-radius: 50%;
                            border: 3px solid rgba(168, 85, 247, 0.5);
                            animation: swirl 4s infinite linear;
                        }
                        .swirl-1 {
                            width: 100px;
                            height: 100px;
                            left: calc(50% - 50px);
                            top: calc(50% - 50px);
                        }
                        .swirl-2 {
                            width: 150px;
                            height: 150px;
                            left: calc(50% - 75px);
                            top: calc(50% - 75px);
                            animation-delay: 2s;
                            animation-direction: reverse;
                        }
                        @keyframes swirl {
                            0% {
                                transform: rotate(0deg) scale(0);
                                opacity: 1;
                            }
                            100% {
                                transform: rotate(360deg) scale(1.5);
                                opacity: 0;
                            }
                        }
                    </style>
                `;

                // Create dissolution particles
                this.createParticles(position, 'purple', 20);
                break;
        }

        this.labBench.appendChild(reaction);

        // Update the molecular viewer if it exists
        this.updateMolecularViewer();

        // Remove the reaction after 5 seconds
        setTimeout(() => {
            if (reaction.parentNode) {
                reaction.remove();
            }
        }, 5000);
    }

    /**
     * Create particle effects for reactions
     */
    createParticles(position, color, count, risingParticles = false) {
        if (!position) return;

        const particleContainer = document.createElement('div');
        particleContainer.classList.add('absolute', 'pointer-events-none', 'z-15');
        particleContainer.style.left = `${position.x - 50}px`;
        particleContainer.style.top = `${position.y - 50}px`;
        particleContainer.style.width = '100px';
        particleContainer.style.height = '100px';

        // Determine color values
        let colorValue;
        switch (color) {
            case 'pink':
                colorValue = 'rgba(236, 72, 153, 0.7)'; // pink-500
                break;
            case 'blue':
                colorValue = 'rgba(59, 130, 246, 0.7)'; // blue-500
                break;
            case 'yellow':
                colorValue = 'rgba(234, 179, 8, 0.7)'; // yellow-500
                break;
            case 'purple':
                colorValue = 'rgba(168, 85, 247, 0.7)'; // purple-500
                break;
            default:
                colorValue = 'rgba(255, 255, 255, 0.7)';
        }

        // Create particles
        for (let i = 0; i < count; i++) {
            const particle = document.createElement('div');
            particle.classList.add('particle', 'absolute', 'rounded-full');

            // Random size between 3-8px
            const size = Math.floor(Math.random() * 6) + 3;
            particle.style.width = `${size}px`;
            particle.style.height = `${size}px`;
            particle.style.backgroundColor = colorValue;

            // Random position within container
            const x = Math.random() * 100;
            const y = Math.random() * 100;
            particle.style.left = `${x}%`;
            particle.style.top = `${y}%`;

            // Add animation
            const delay = Math.random() * 2;
            const duration = 2 + Math.random() * 3;

            if (risingParticles) {
                // Rising particles (for gas/steam)
                particle.style.animation = `riseAndFade ${duration}s ease-out ${delay}s`;
            } else {
                // Expanding particles (for reactions)
                particle.style.animation = `expandAndFade ${duration}s ease-out ${delay}s`;
            }

            particleContainer.appendChild(particle);
        }

        // Add keyframes for animations
        const style = document.createElement('style');
        style.textContent = `
            @keyframes riseAndFade {
                0% {
                    transform: translateY(0) scale(1);
                    opacity: 0;
                }
                10% {
                    opacity: 1;
                }
                100% {
                    transform: translateY(-100px) scale(0.5);
                    opacity: 0;
                }
            }

            @keyframes expandAndFade {
                0% {
                    transform: scale(1) rotate(0deg);
                    opacity: 0;
                }
                10% {
                    opacity: 1;
                }
                100% {
                    transform: scale(3) rotate(${Math.random() * 360}deg);
                    opacity: 0;
                }
            }
        `;

        particleContainer.appendChild(style);
        this.labBench.appendChild(particleContainer);

        // Remove after animation completes
        setTimeout(() => {
            if (particleContainer.parentNode) {
                particleContainer.remove();
            }
        }, 5000);
    }

    /**
     * Set up button functionality
     */
    setupButtons() {
        // Reset bench button
        const resetButton = document.getElementById('reset-bench');
        if (resetButton) {
            resetButton.addEventListener('click', () => this.resetLabBench());
        }

        // View molecular button
        const viewMolecularButton = document.getElementById('view-molecular');
        if (viewMolecularButton) {
            viewMolecularButton.addEventListener('click', () => this.toggleMolecularView());
        }

        // Heat button
        const heatButton = document.getElementById('heat-bench');
        if (heatButton) {
            heatButton.addEventListener('click', () => this.toggleHeat());
        }

        // Show results button
        const resultsButton = document.getElementById('show-results');
        if (resultsButton) {
            resultsButton.addEventListener('click', () => this.showResults());
        }
    }

    /**
     * Toggle heating of the lab bench
     */
    toggleHeat() {
        this.isHeated = !this.isHeated;

        // Update the heat button appearance
        const heatButton = document.getElementById('heat-bench');
        if (heatButton) {
            if (this.isHeated) {
                heatButton.classList.remove('bg-orange-600', 'hover:bg-orange-500');
                heatButton.classList.add('bg-red-600', 'hover:bg-red-500');
                heatButton.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z" />
                    </svg>
                    Stop Heating
                `;

                // Add heating effect to the lab bench
                const heatingEffect = document.createElement('div');
                heatingEffect.id = 'heating-effect';
                heatingEffect.classList.add('absolute', 'inset-0', 'pointer-events-none', 'z-0');
                heatingEffect.innerHTML = `
                    <div class="absolute inset-0 bg-orange-500/10 animate-pulse rounded-lg">
                        <div class="flame flame-1"></div>
                        <div class="flame flame-2"></div>
                        <div class="flame flame-3"></div>
                    </div>
                    <style>
                        .flame {
                            position: absolute;
                            bottom: -10px;
                            width: 20px;
                            height: 20px;
                            background: linear-gradient(to top, rgba(255, 165, 0, 0.7), rgba(255, 0, 0, 0.5));
                            border-radius: 50% 50% 50% 0;
                            transform: rotate(-45deg);
                            animation: flicker 0.5s infinite alternate;
                        }
                        .flame-1 {
                            left: 20%;
                            animation-delay: 0s;
                        }
                        .flame-2 {
                            left: 50%;
                            animation-delay: 0.2s;
                        }
                        .flame-3 {
                            left: 80%;
                            animation-delay: 0.4s;
                        }
                        @keyframes flicker {
                            0% {
                                transform: rotate(-45deg) scale(1);
                                opacity: 0.8;
                            }
                            100% {
                                transform: rotate(-45deg) scale(1.1);
                                opacity: 1;
                            }
                        }
                    </style>
                `;
                this.labBench.appendChild(heatingEffect);
            } else {
                heatButton.classList.remove('bg-red-600', 'hover:bg-red-500');
                heatButton.classList.add('bg-orange-600', 'hover:bg-orange-500');
                heatButton.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z" />
                    </svg>
                    Heat Bench
                `;

                // Remove heating effect
                const heatingEffect = document.getElementById('heating-effect');
                if (heatingEffect) {
                    heatingEffect.remove();
                }
            }
        }

        // Check for reactions that might occur with heat
        this.checkForReactions();
    }

    /**
     * Add points to the score
     */
    addPoints(points, reactionName) {
        // Check if this reaction has already been completed
        if (this.completedReactions.includes(reactionName)) {
            return;
        }

        // Add to completed reactions
        this.completedReactions.push(reactionName);

        // Add points
        this.score += points;

        // Update score display
        this.updateScoreDisplay();

        // Show notification
        this.showNotification(`+${points} points: ${reactionName}`);
    }

    /**
     * Update the score display
     */
    updateScoreDisplay() {
        const scoreDisplay = document.getElementById('score-display');
        if (scoreDisplay) {
            scoreDisplay.textContent = this.score;
        }
    }

    /**
     * Show a notification
     */
    showNotification(message) {
        const notification = document.createElement('div');
        notification.classList.add('fixed', 'top-4', 'right-4', 'bg-emerald-500', 'text-white', 'px-4', 'py-2', 'rounded-lg', 'shadow-lg', 'z-50', 'animate-fade-in-out');
        notification.innerHTML = message;

        document.body.appendChild(notification);

        // Remove after 3 seconds
        setTimeout(() => {
            notification.classList.add('animate-fade-out');
            setTimeout(() => {
                notification.remove();
            }, 500);
        }, 3000);
    }

    /**
     * Show results modal
     */
    showResults() {
        // Create modal backdrop
        const backdrop = document.createElement('div');
        backdrop.classList.add('fixed', 'inset-0', 'bg-black/50', 'flex', 'items-center', 'justify-center', 'z-50');
        backdrop.id = 'results-modal';

        // Create modal content
        let completedReactionsHTML = '';
        if (this.completedReactions.length > 0) {
            completedReactionsHTML = `
                <h3 class="text-lg font-semibold mb-2">Completed Reactions:</h3>
                <ul class="list-disc pl-5 mb-4">
                    ${this.completedReactions.map(reaction => `<li>${reaction}</li>`).join('')}
                </ul>
            `;
        } else {
            completedReactionsHTML = `
                <p class="mb-4">No reactions completed yet. Try combining different chemicals!</p>
            `;
        }

        backdrop.innerHTML = `
            <div class="bg-neutral-800 rounded-xl border border-neutral-700 p-6 max-w-md mx-auto shadow-2xl">
                <h2 class="text-2xl font-bold text-white mb-4">Experiment Results</h2>

                ${completedReactionsHTML}

                <div class="bg-emerald-500/20 border border-emerald-500/30 rounded-lg p-4 mb-6">
                    <div class="flex items-center justify-between">
                        <span class="text-lg font-semibold">Total Score:</span>
                        <span class="text-2xl font-bold text-emerald-400">${this.score} points</span>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button id="close-results" class="px-4 py-2 bg-neutral-700 hover:bg-neutral-600 text-white rounded-lg transition-colors">
                        Close
                    </button>
                </div>
            </div>
        `;

        document.body.appendChild(backdrop);

        // Add close button functionality
        document.getElementById('close-results').addEventListener('click', () => {
            backdrop.remove();
        });
    }

    /**
     * Reset the lab bench
     */
    resetLabBench() {
        // Clear all bodies from the Matter.js world
        Matter.Composite.clear(this.world);

        // Re-add walls
        const labBenchRect = this.labBench.getBoundingClientRect();
        const wallThickness = 50;
        const wallOptions = {
            isStatic: true,
            render: {
                visible: false
            }
        };

        Matter.Composite.add(this.world, [
            // Bottom wall
            Matter.Bodies.rectangle(
                labBenchRect.width / 2,
                labBenchRect.height + wallThickness / 2,
                labBenchRect.width,
                wallThickness,
                wallOptions
            ),
            // Left wall
            Matter.Bodies.rectangle(
                -wallThickness / 2,
                labBenchRect.height / 2,
                wallThickness,
                labBenchRect.height,
                wallOptions
            ),
            // Right wall
            Matter.Bodies.rectangle(
                labBenchRect.width + wallThickness / 2,
                labBenchRect.height / 2,
                wallThickness,
                labBenchRect.height,
                wallOptions
            ),
            // Top wall
            Matter.Bodies.rectangle(
                labBenchRect.width / 2,
                -wallThickness / 2,
                labBenchRect.width,
                wallThickness,
                wallOptions
            )
        ]);

        // Re-add mouse constraint
        const mouse = Matter.Mouse.create(this.render.canvas);
        this.mouseConstraint = Matter.MouseConstraint.create(this.engine, {
            mouse: mouse,
            constraint: {
                stiffness: 0.2,
                render: {
                    visible: false
                }
            }
        });

        Matter.Composite.add(this.world, this.mouseConstraint);
        this.render.mouse = mouse;

        // Clear all visual elements
        const visuals = this.labBench.querySelectorAll('.equipment-visual, .chemical-label, .pouring-stream, .droplet-container, [data-reaction]');
        visuals.forEach(el => el.remove());

        // Add placeholder text
        if (!this.placeholder) {
            this.placeholder = document.createElement('div');
            this.placeholder.classList.add('absolute', 'inset-0', 'flex', 'items-center', 'justify-center', 'pointer-events-none', 'z-10');
            this.placeholder.innerHTML = '<p class="text-neutral-400">Drag chemicals and equipment here to start experimenting</p>';
            this.labBench.appendChild(this.placeholder);
        }

        // Reset arrays and objects
        this.chemicals = [];
        this.equipment = [];
        this.reactions = [];
        this.bodies = {};
        this.liquids = {};
        this.pourAnimation = null;

        // Reset heating
        if (this.isHeated) {
            this.isHeated = false;

            // Update heat button
            const heatButton = document.getElementById('heat-bench');
            if (heatButton) {
                heatButton.classList.remove('bg-red-600', 'hover:bg-red-500');
                heatButton.classList.add('bg-orange-600', 'hover:bg-orange-500');
                heatButton.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z" />
                    </svg>
                    Heat Bench
                `;
            }
        }

        // Don't reset score or completed reactions - those persist across experiments
    }

    /**
     * Toggle the molecular view
     */
    toggleMolecularView() {
        const viewerSection = document.getElementById('molecular-viewer-section');
        viewerSection.classList.toggle('hidden');

        if (!viewerSection.classList.contains('hidden')) {
            this.updateMolecularViewer();
        }
    }

    /**
     * Update the Vue.js molecular viewer
     */
    updateMolecularViewer() {
        // Determine which molecule to show based on the chemicals in the lab bench
        let moleculeType = 'water'; // Default

        if (this.reactions.includes('neutralization')) {
            moleculeType = 'water'; // Product of neutralization
        } else if (this.chemicals.some(c => c.id === 'hcl')) {
            moleculeType = 'hcl';
        } else if (this.chemicals.some(c => c.id === 'naoh')) {
            moleculeType = 'naoh';
        } else if (this.chemicals.some(c => c.id === 'water')) {
            moleculeType = 'water';
        }

        // Update the Vue.js component if it exists
        if (window.chemistryLabApps && window.chemistryLabApps['molecular-viewer']) {
            window.chemistryLabApps['molecular-viewer'].updateMolecule(moleculeType);
        }
    }

    /**
     * Set up tab switching
     */
    setupTabs() {
        const tabs = document.querySelectorAll('[data-tab]');
        tabs.forEach(tab => {
            tab.addEventListener('click', function() {
                // Remove active class from all tabs
                tabs.forEach(t => {
                    t.classList.remove('border-emerald-500', 'text-emerald-400');
                    t.classList.add('border-transparent', 'hover:text-gray-300', 'hover:border-gray-300');
                    t.setAttribute('aria-selected', 'false');
                });

                // Add active class to clicked tab
                this.classList.add('border-emerald-500', 'text-emerald-400');
                this.classList.remove('border-transparent', 'hover:text-gray-300', 'hover:border-gray-300');
                this.setAttribute('aria-selected', 'true');

                // Hide all tab content
                document.querySelectorAll('.tab-content').forEach(content => {
                    content.classList.add('hidden');
                    content.classList.remove('active');
                });

                // Show selected tab content
                const tabName = this.getAttribute('data-tab');
                const tabContent = document.getElementById(`${tabName}-content`);
                tabContent.classList.remove('hidden');
                tabContent.classList.add('active');
            });
        });
    }
}

// Initialize the Chemistry Lab when the DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    try {
        // Check if we're on a chemistry lab page
        const labBench = document.querySelector('.lab-bench');
        if (labBench) {
            console.log('Initializing Chemistry Lab...');
            window.chemistryLab = new ChemistryLab();
            console.log('Chemistry Lab initialized successfully');
        } else {
            console.log('No lab bench found, skipping Chemistry Lab initialization');
        }
    } catch (error) {
        console.error('Error initializing Chemistry Lab:', error);
    }
});
