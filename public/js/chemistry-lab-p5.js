/**
 * Chemistry Lab Visualization using p5.js
 * This file provides a more reliable visualization of chemical reactions
 * using the p5.js library for better rendering of colors and effects.
 */

// Global variables
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

// Create a new p5 instance
const createChemistryLabSketch = (p) => {
    // Setup function - runs once at the beginning
    p.setup = function() {
        // Create canvas that fills the container
        const container = document.getElementById('p5-container');
        const canvas = p.createCanvas(container.offsetWidth, container.offsetHeight);
        canvas.parent('p5-container');
        
        // Set up initial beakers and test tubes
        setupEquipment();
        
        // Hide the placeholder text
        const placeholder = document.getElementById('lab-bench-placeholder');
        if (placeholder) {
            placeholder.style.display = 'none';
        }
        
        // Set text properties
        p.textAlign(p.CENTER, p.CENTER);
        p.textSize(12);
        
        // Set frame rate
        p.frameRate(30);
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
        p.push(); // Save current drawing state
        
        // Draw beaker outline
        p.noFill();
        p.stroke(200);
        p.strokeWeight(2);
        p.rect(beaker.x, beaker.y, beaker.width, beaker.height, 2);
        
        // Draw chemical if beaker contains something
        if (beaker.contains) {
            const chemicalInfo = chemicals[beaker.contains];
            
            // Fill with chemical color
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
        } else {
            // Empty beaker label
            p.fill(150);
            p.textSize(12);
            p.text("Empty", beaker.x + beaker.width/2, beaker.y + beaker.height/2);
        }
        
        p.pop(); // Restore drawing state
    }
    
    // Function to draw a test tube
    function drawTestTube(testTube) {
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
            const chemicalInfo = chemicals[testTube.contains];
            
            // Fill with chemical color
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
        } else {
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

// Initialize the p5.js sketch when the page is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Create the p5 sketch
    labSketch = new p5(createChemistryLabSketch, 'p5-container');
    
    // Set up communication with the existing chemistry lab code
    setupChemistryLabIntegration();
});

// Function to set up integration with existing chemistry lab code
function setupChemistryLabIntegration() {
    // Listen for events from the existing chemistry lab code
    document.addEventListener('chemicalPoured', handleChemicalPoured);
    document.addEventListener('chemicalsMixed', handleChemicalsMixed);
    document.addEventListener('benchReset', handleBenchReset);
    
    // Create a MutationObserver to watch for changes to the lab bench
    observeLabBench();
}

// Function to handle chemical poured event
function handleChemicalPoured(event) {
    const { chemical, targetId, sourceId } = event.detail;
    console.log('Chemical poured:', chemical, 'into', targetId, 'from', sourceId);
    
    // Update the p5.js visualization
    updateVisualization();
}

// Function to handle chemicals mixed event
function handleChemicalsMixed(event) {
    const { chemical1, chemical2, resultChemical, containerId } = event.detail;
    console.log('Chemicals mixed:', chemical1, '+', chemical2, '=', resultChemical, 'in', containerId);
    
    // Update the p5.js visualization
    updateVisualization();
}

// Function to handle bench reset event
function handleBenchReset() {
    console.log('Bench reset');
    
    // Clear the p5.js visualization
    if (labSketch) {
        labSketch.beakers = [];
        labSketch.testTubes = [];
    }
}

// Function to observe changes to the lab bench
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

// Function to update the p5.js visualization based on the current state
function updateVisualization() {
    if (!labSketch) return;
    
    // Clear existing equipment
    labSketch.beakers = [];
    labSketch.testTubes = [];
    
    // Find all beakers in the lab bench
    const beakerElements = document.querySelectorAll('.beaker-container');
    beakerElements.forEach((element, index) => {
        const rect = element.getBoundingClientRect();
        const labBench = document.querySelector('.lab-bench');
        const labRect = labBench.getBoundingClientRect();
        
        // Create a beaker object for p5.js
        const beaker = {
            id: element.id || `beaker-${index}`,
            x: rect.left - labRect.left,
            y: rect.top - labRect.top,
            width: rect.width,
            height: rect.height,
            contains: element.getAttribute('data-contains') || '',
            reaction: element.getAttribute('data-reaction') || '',
            fillLevel: element.contains ? 80 : 0
        };
        
        labSketch.beakers.push(beaker);
    });
    
    // Find all test tubes in the lab bench
    const testTubeElements = document.querySelectorAll('.test-tube-container');
    testTubeElements.forEach((element, index) => {
        const rect = element.getBoundingClientRect();
        const labBench = document.querySelector('.lab-bench');
        const labRect = labBench.getBoundingClientRect();
        
        // Create a test tube object for p5.js
        const testTube = {
            id: element.id || `test-tube-${index}`,
            x: rect.left - labRect.left,
            y: rect.top - labRect.top,
            width: rect.width,
            height: rect.height,
            contains: element.getAttribute('data-contains') || '',
            reaction: element.getAttribute('data-reaction') || '',
            fillLevel: element.contains ? 80 : 0
        };
        
        labSketch.testTubes.push(testTube);
    });
}
