/**
 * Chemistry Lab Visualization using p5.js
 * This file provides a more reliable visualization of chemical reactions
 * using the p5.js library for better rendering of colors and effects.
 */

// Global variables for the sketch (can be kept here or moved into createChemistryLabSketch if preferred)
let labSketch;
let beakers = [];
let testTubes = [];
let chemicals = {
    'water': { color: [59, 130, 246], symbol: 'H₂O', name: 'Water' },
    'hcl': { color: [234, 179, 8], symbol: 'HCl', name: 'Hydrochloric Acid' },
    'naoh': { color: [168, 85, 247], symbol: 'NaOH', name: 'Sodium Hydroxide' },
    'phenolphthalein': { color: [236, 72, 153], symbol: 'Ph', name: 'Phenolphthalein' },
    'nacl': { color: [243, 244, 246], symbol: 'NaCl', name: 'Sodium Chloride' },
    'hcl-solution': { color: [16, 185, 129], symbol: 'HCl+H₂O', name: 'HCl Solution' },
    'naoh-solution': { color: [192, 132, 252], symbol: 'NaOH+H₂O', name: 'NaOH Solution' },
    'mixture': { color: [96, 165, 250], symbol: 'Mix', name: 'Mixture' }
};

// Create a new p5 instance function
const createChemistryLabSketch = (p) => {
    // Setup function - runs once at the beginning
    p.setup = function() {
        const container = document.getElementById('p5-container'); // Assumes 'p5-container' is fixed for now
        
        if (!container) {
            console.error("#p5-container not found during p5.setup(). Canvas will not be created.");
            return; // Exit setup if container is not found
        }
        
        const canvas = p.createCanvas(container.offsetWidth, container.offsetHeight);
        canvas.parent(container); // Pass the element itself
        
        setupEquipment();
        
        const placeholder = document.getElementById('lab-bench-placeholder');
        if (placeholder) {
            placeholder.style.display = 'none';
        }
        
        p.textAlign(p.CENTER, p.CENTER);
        p.textSize(12);
        p.frameRate(30);
    };

    p.windowResized = function() {
        const container = document.getElementById('p5-container');
        if (container) {
            p.resizeCanvas(container.offsetWidth, container.offsetHeight);
        }
    };

    // Draw function - runs continuously
    p.draw = function() {
        // Clear the canvas
        p.clear();
        p.background(51, 51, 51, 200); // Semi-transparent dark background
        
        // Draw all beakers
        beakers.forEach(beaker => drawBeaker(beaker));
        
        // Draw all test tubes
        testTubes.forEach(testTube => drawTestTube(testTube));
        
        // Add any animations or effects
        addEffects();
    };
    
    // Function to set up initial equipment
    function setupEquipment() {
        // Clear existing equipment
        beakers = [];
        testTubes = [];
    }
    
    // Function to draw a beaker
    function drawBeaker(beaker) {
        console.log('[p5] drawBeaker - Received:', JSON.stringify(beaker)); // Log 1: What drawBeaker receives
        p.push(); // Save current drawing state
        
        // Draw beaker outline
        p.noFill();
        p.stroke(200);
        p.strokeWeight(2);
        p.rect(beaker.x, beaker.y, beaker.width, beaker.height, 2);
        
        // Draw chemical if beaker contains something
        if (beaker.contains) {
            const chemicalKey = beaker.contains ? beaker.contains.toLowerCase() : null;
            console.log('[p5] drawBeaker - chemicalKey:', chemicalKey); // Log 2: The key used for lookup
            const chemicalInfo = chemicalKey ? chemicals[chemicalKey] : null;
            console.log('[p5] drawBeaker - chemicalInfo:', JSON.stringify(chemicalInfo)); // Log 3: The result of lookup
            if (chemicalInfo && chemicalInfo.color) {
                console.log('[p5] drawBeaker - Drawing with chemical color:', chemicalInfo.color); // Log 4a: Path for color
                p.fill(chemicalInfo.color[0], chemicalInfo.color[1], chemicalInfo.color[2], 200);
                p.noStroke();
                
                // Calculate fill height based on volume
                const fillHeight = beaker.height * (beaker.fillLevel / 100);
                p.rect(beaker.x, beaker.y + beaker.height - fillHeight, beaker.width, fillHeight, 0, 0, 2, 2);
                
                // Add chemical symbol
                p.fill(255);
                p.textSize(14);
                p.text(chemicalInfo.symbol, beaker.x + beaker.width/2, beaker.y + beaker.height - fillHeight/2);
                
                // Add chemical name below beaker
                p.textSize(10);
                p.text(chemicalInfo.name, beaker.x + beaker.width/2, beaker.y + beaker.height + 15);
                
                // Add bubbles or other effects if needed
                if (beaker.reaction) {
                    addReactionEffects(beaker);
                }
            }
        } else {
            console.log('[p5] drawBeaker - beaker.contains is FALSY. Drawing empty.'); // Log 4b: Path for gray
            // Empty beaker label
            p.fill(150);
            p.textSize(12);
            p.text("Empty", beaker.x + beaker.width/2, beaker.y + beaker.height/2);
        }
        
        p.pop(); // Restore drawing state
    }
    
    // Function to draw a test tube
    function drawTestTube(testTube) {
        console.log('[p5] drawTestTube - Received:', JSON.stringify(testTube)); // Log 1
        p.push(); // Save current drawing state
        
        // Draw test tube outline
        p.noFill();
        p.stroke(200);
        p.strokeWeight(2);
        
        // Test tube is narrower than beaker
        const tubeWidth = testTube.width * 0.6;
        const centerX = testTube.x + testTube.width/2;
        
        // Draw the tube shape
        p.beginShape();
        p.vertex(centerX - tubeWidth/2, testTube.y); // Top left
        p.vertex(centerX + tubeWidth/2, testTube.y); // Top right
        p.vertex(centerX + tubeWidth/2, testTube.y + testTube.height - 5); // Bottom right before curve
        p.vertex(centerX, testTube.y + testTube.height); // Bottom center
        p.vertex(centerX - tubeWidth/2, testTube.y + testTube.height - 5); // Bottom left before curve
        p.vertex(centerX - tubeWidth/2, testTube.y); // Back to top left
        p.endShape(p.CLOSE);
        
        // Draw chemical if test tube contains something
        if (testTube.contains) {
            const chemicalKey = testTube.contains ? testTube.contains.toLowerCase() : null;
            console.log('[p5] drawTestTube - chemicalKey:', chemicalKey); // Log 2
            const chemicalInfo = chemicalKey ? chemicals[chemicalKey] : null;
            console.log('[p5] drawTestTube - chemicalInfo:', JSON.stringify(chemicalInfo)); // Log 3
            if (chemicalInfo && chemicalInfo.color) {
                console.log('[p5] drawTestTube - Drawing with chemical color:', chemicalInfo.color); // Log 4a
                p.fill(chemicalInfo.color[0], chemicalInfo.color[1], chemicalInfo.color[2], 200);
                p.noStroke();
                
                // Calculate fill height based on volume
                const fillHeight = testTube.height * (testTube.fillLevel / 100);
                
                // Draw the filled portion
                p.beginShape();
                p.vertex(centerX - tubeWidth/2, testTube.y + testTube.height - fillHeight); // Top left
                p.vertex(centerX + tubeWidth/2, testTube.y + testTube.height - fillHeight); // Top right
                
                if (fillHeight >= testTube.height - 5) {
                    // If fill reaches the curved bottom
                    p.vertex(centerX + tubeWidth/2, testTube.y + testTube.height - 5); // Bottom right before curve
                    p.vertex(centerX, testTube.y + testTube.height); // Bottom center
                    p.vertex(centerX - tubeWidth/2, testTube.y + testTube.height - 5); // Bottom left before curve
                } else {
                    // Straight bottom for the fill
                    p.vertex(centerX + tubeWidth/2, testTube.y + testTube.height - fillHeight); // Bottom right
                    p.vertex(centerX - tubeWidth/2, testTube.y + testTube.height - fillHeight); // Bottom left
                }
                
                p.endShape(p.CLOSE);
                
                // Add chemical symbol
                p.fill(255);
                p.textSize(12);
                p.text(chemicalInfo.symbol, centerX, testTube.y + testTube.height - fillHeight/2);
                
                // Add chemical name below test tube
                p.textSize(10);
                p.text(chemicalInfo.name, centerX, testTube.y + testTube.height + 15);
                
                // Add bubbles or other effects if needed
                if (testTube.reaction) {
                    addReactionEffects(testTube);
                }
            }
        } else {
            console.log('[p5] drawTestTube - testTube.contains is FALSY. Drawing empty.'); // Log 4b
            // Empty test tube label
            p.fill(150);
            p.textSize(10);
            p.text("Empty", centerX, testTube.y + testTube.height/2);
        }
        
        p.pop(); // Restore drawing state
    }
    
    // Function to add reaction effects
    function addReactionEffects(container) {
        if (container.reaction === 'neutralization') {
            // Add neutralization effects (e.g., bubbles)
            drawBubbles(container, 10, [255, 255, 255]);
        } else if (container.reaction === 'dilution') {
            // Add dilution effects (e.g., swirls)
            drawSwirls(container);
        } else if (container.reaction === 'mixing') {
            // Add mixing effects
            drawMixingEffect(container);
        }
    }
    
    // Function to draw bubbles
    function drawBubbles(container, count, color) {
        p.fill(color[0], color[1], color[2], 150);
        p.noStroke();
        
        // Calculate the area where bubbles can appear
        const fillHeight = container.height * (container.fillLevel / 100);
        const bubbleArea = {
            x: container.x,
            y: container.y + container.height - fillHeight,
            width: container.width,
            height: fillHeight
        };
        
        // Draw random bubbles
        for (let i = 0; i < count; i++) {
            const bubbleSize = p.random(3, 8);
            const bubbleX = p.random(bubbleArea.x + bubbleSize, bubbleArea.x + bubbleArea.width - bubbleSize);
            const bubbleY = p.random(bubbleArea.y + bubbleSize, bubbleArea.y + bubbleArea.height - bubbleSize);
            
            p.ellipse(bubbleX, bubbleY, bubbleSize, bubbleSize);
        }
    }
    
    // Function to draw swirls for dilution effect
    function drawSwirls(container) {
        p.noFill();
        p.stroke(255, 255, 255, 100);
        p.strokeWeight(1);
        
        // Calculate the area where swirls can appear
        const fillHeight = container.height * (container.fillLevel / 100);
        const swirlArea = {
            x: container.x,
            y: container.y + container.height - fillHeight,
            width: container.width,
            height: fillHeight
        };
        
        // Draw swirls
        const centerX = swirlArea.x + swirlArea.width / 2;
        const centerY = swirlArea.y + swirlArea.height / 2;
        const maxRadius = Math.min(swirlArea.width, swirlArea.height) / 2 * 0.8;
        
        // Use time to animate the swirls
        const time = p.millis() / 1000;
        
        for (let i = 0; i < 3; i++) {
            const startAngle = (i * p.TWO_PI / 3) + time;
            const endAngle = startAngle + p.TWO_PI / 2;
            
            p.beginShape();
            for (let angle = startAngle; angle <= endAngle; angle += 0.1) {
                const radius = maxRadius * (1 - (angle - startAngle) / (p.TWO_PI / 2));
                const x = centerX + radius * p.cos(angle);
                const y = centerY + radius * p.sin(angle);
                p.vertex(x, y);
            }
            p.endShape();
        }
    }
    
    // Function to draw mixing effect
    function drawMixingEffect(container) {
        // Similar to swirls but with different parameters
        p.noFill();
        p.stroke(255, 255, 255, 80);
        p.strokeWeight(1);
        
        // Calculate the area where mixing effects can appear
        const fillHeight = container.height * (container.fillLevel / 100);
        const mixArea = {
            x: container.x,
            y: container.y + container.height - fillHeight,
            width: container.width,
            height: fillHeight
        };
        
        // Draw crossing lines
        const time = p.millis() / 1000;
        
        for (let i = 0; i < 5; i++) {
            const y1 = mixArea.y + (i / 5) * mixArea.height;
            const amplitude = mixArea.height / 10;
            
            p.beginShape();
            for (let x = mixArea.x; x <= mixArea.x + mixArea.width; x += 2) {
                const xProgress = (x - mixArea.x) / mixArea.width;
                const y = y1 + amplitude * p.sin(xProgress * p.TWO_PI * 2 + time * 2);
                p.vertex(x, y);
            }
            p.endShape();
        }
    }
    
    // Function to add global effects
    function addEffects() {
        // Add any global effects here
    }
    
    // Mouse pressed event
    p.mousePressed = function() {
        // Handle mouse interactions
        checkEquipmentClick();
    };
    
    // Function to check if equipment was clicked
    function checkEquipmentClick() {
        // Check beakers
        for (let beaker of beakers) {
            if (p.mouseX >= beaker.x && p.mouseX <= beaker.x + beaker.width &&
                p.mouseY >= beaker.y && p.mouseY <= beaker.y + beaker.height) {
                // Beaker was clicked
                console.log('Beaker clicked:', beaker);
                return;
            }
        }
        
        // Check test tubes
        for (let testTube of testTubes) {
            const centerX = testTube.x + testTube.width/2;
            const tubeWidth = testTube.width * 0.6;
            
            if (p.mouseX >= centerX - tubeWidth/2 && p.mouseX <= centerX + tubeWidth/2 &&
                p.mouseY >= testTube.y && p.mouseY <= testTube.y + testTube.height) {
                // Test tube was clicked
                console.log('Test tube clicked:', testTube);
                return;
            }
        }
    }
};

// Export a function to initialize the p5 lab
function initP5Lab(containerId) {
    console.log('[p5] initP5Lab CALLED with containerId:', containerId); // Log: initP5Lab entry
    const p5Container = document.getElementById(containerId);

    if (!p5Container) {
        console.error(`#${containerId} not found. P5 sketch cannot be initialized.`);
        return;
    }

    // Create the p5 sketch, ensuring it targets the correct container for canvas creation if not hardcoded
    // The createChemistryLabSketch function internally uses getElementById('p5-container'), 
    // so ensure containerId passed to initP5Lab matches this or modify createChemistryLabSketch.
    // For now, we assume createChemistryLabSketch will always look for 'p5-container'.
    if (containerId !== 'p5-container') {
        console.warn(`initP5Lab called with containerId '${containerId}', but sketch internally uses 'p5-container'. Ensure these match or update sketch.`);
    }

    labSketch = new p5(createChemistryLabSketch, p5Container); // Pass the DOM element to p5
    
    setupChemistryLabIntegration(); // This likely also needs access to labSketch or DOM elements

    // Observe the p5-container for size changes
    if (typeof ResizeObserver !== 'undefined') {
        const resizeObserver = new ResizeObserver(entries => {
            for (let entry of entries) {
                const newWidth = entry.contentRect ? entry.contentRect.width : entry.target.getBoundingClientRect().width;
                const newHeight = entry.contentRect ? entry.contentRect.height : entry.target.getBoundingClientRect().height;

                if (labSketch && newWidth > 0 && newHeight > 0) {
                    labSketch.resizeCanvas(newWidth, newHeight);
                }
            }
        });
        resizeObserver.observe(p5Container);
    } else {
        console.warn('ResizeObserver API not supported. Canvas might not resize correctly.');
    }
}

// Functions for integration (handleChemicalPoured, etc.) should be defined or imported here
// These might need to be adjusted if they rely on global `labSketch` and it's now initialized differently.
function setupChemistryLabIntegration() {
    document.addEventListener('chemicalPoured', handleChemicalPoured);
    document.addEventListener('chemicalsMixed', handleChemicalsMixed);
    document.addEventListener('benchReset', handleBenchReset);
    observeLabBench();
}

function handleChemicalPoured(event) {
    const { chemical, targetId, sourceId } = event.detail;
    console.log('Chemical poured:', chemical, 'into', targetId, 'from', sourceId);
    
    // Update the p5.js visualization
    updateVisualization();
}

function handleChemicalsMixed(event) {
    const { chemical1, chemical2, resultChemical, containerId } = event.detail;
    console.log('Chemicals mixed:', chemical1, '+', chemical2, '=', resultChemical, 'in', containerId);
    
    // Update the p5.js visualization
    updateVisualization();
}

function handleBenchReset() {
    console.log('Bench reset');
    
    // Clear the p5.js visualization
    if (labSketch) {
        labSketch.beakers = [];
        labSketch.testTubes = [];
    }
}

function observeLabBench() {
    const labBench = document.querySelector('.lab-bench');
    if (!labBench) return;
    
    const observer = new MutationObserver(function(mutations) {
        updateVisualization();
    });
    
    observer.observe(labBench, { 
        childList: true, 
        subtree: true,
        attributes: true,
        attributeFilter: ['data-contains', 'data-reaction']
    });
}

function updateVisualization() {
    if (!labSketch) return;
    console.log('[p5] updateVisualization CALLED'); // Log UV Call
    
    // Clear existing equipment
    labSketch.beakers = [];
    labSketch.testTubes = [];
    
    // Find all beakers in the lab bench
    const beakerElements = document.querySelectorAll('.beaker-container');
    beakerElements.forEach((element, index) => {
        const rect = element.getBoundingClientRect();
        const labBench = document.querySelector('.lab-bench');
        const labRect = labBench.getBoundingClientRect();
        
        const labItemElement = element.closest('.lab-item');
        // console.log('[p5] updateVisualization - Beaker - Found lab-item:', labItemElement); // Optional: log element
        const currentDataContains = labItemElement ? labItemElement.getAttribute('data-contains') : null;
        console.log(`[p5] updateVisualization - Beaker id: ${element.id || `beaker-${index}`}, data-contains from DOM: '${currentDataContains}'`); // Log UV data read
        const currentDataReaction = labItemElement ? labItemElement.getAttribute('data-reaction') : null;
        
        // Create a beaker object for p5.js
        const beaker = {
            id: element.id || `beaker-${index}`,
            x: rect.left - labRect.left,
            y: rect.top - labRect.top,
            width: rect.width,
            height: rect.height,
            contains: currentDataContains || '',
            reaction: currentDataReaction || '',
            fillLevel: (currentDataContains && currentDataContains !== '') ? 80 : 0,
        };
        
        labSketch.beakers.push(beaker);
    });
    
    // Find all test tubes in the lab bench
    const testTubeElements = document.querySelectorAll('.test-tube-container');
    testTubeElements.forEach((element, index) => {
        const rect = element.getBoundingClientRect();
        const labBench = document.querySelector('.lab-bench');
        const labRect = labBench.getBoundingClientRect();
        
        const labItemElement = element.closest('.lab-item');
        // console.log('[p5] updateVisualization - TestTube - Found lab-item:', labItemElement); // Optional: log element
        const currentDataContains = labItemElement ? labItemElement.getAttribute('data-contains') : null;
        console.log(`[p5] updateVisualization - TestTube id: ${element.id || `test-tube-${index}`}, data-contains from DOM: '${currentDataContains}'`); // Log UV data read
        const currentDataReaction = labItemElement ? labItemElement.getAttribute('data-reaction') : null;
        
        // Create a test tube object for p5.js
        const testTube = {
            id: element.id || `test-tube-${index}`,
            x: rect.left - labRect.left,
            y: rect.top - labRect.top,
            width: rect.width,
            height: rect.height,
            contains: currentDataContains || '',
            reaction: currentDataReaction || '',
            fillLevel: (currentDataContains && currentDataContains !== '') ? 80 : 0,
        };
        
        labSketch.testTubes.push(testTube);
    });
}
