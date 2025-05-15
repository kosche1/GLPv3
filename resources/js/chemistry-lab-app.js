import { createApp } from 'vue';
import SimpleMolecularViewer from './components/SimpleMolecularViewer.vue';

// Create a simple Vue app for the molecular viewer
const createMolecularViewerApp = (elementId, molecule = 'water') => {
    try {
        const app = createApp({
            template: `<simple-molecular-viewer :molecule="currentMolecule" :height="300" />`,
            components: {
                SimpleMolecularViewer
            },
            data() {
                return {
                    currentMolecule: molecule
                };
            },
            methods: {
                updateMolecule(newMolecule) {
                    try {
                        this.currentMolecule = newMolecule;
                    } catch (error) {
                        console.error('Error updating molecule:', error);
                    }
                }
            },
            errorCaptured(err, component, info) {
                // Handle errors in the component
                console.error('Vue error captured:', err, info);
                return false; // Prevent error from propagating
            }
        });

        // Add global error handler
        app.config.errorHandler = (err, instance, info) => {
            console.error('Vue global error:', err, info);
        };

        // Mount the app to the specified element
        const mountElement = document.getElementById(elementId);
        if (mountElement) {
            const vueApp = app.mount(mountElement);

            // Store the Vue instance on the window for external access
            if (!window.chemistryLabApps) {
                window.chemistryLabApps = {};
            }
            window.chemistryLabApps[elementId] = vueApp;

            return vueApp;
        } else {
            console.error(`Element with ID "${elementId}" not found`);
            return null;
        }
    } catch (error) {
        console.error('Error creating molecular viewer app:', error);
        return null;
    }
};

// Initialize the molecular viewer when the DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    // Check if we're on a chemistry lab page with a molecular viewer
    const viewerElement = document.getElementById('molecular-viewer');
    if (viewerElement) {
        // Create the molecular viewer app with default water molecule
        createMolecularViewerApp('molecular-viewer', 'water');

        // Wait a short time to ensure the chemistry-lab.js has initialized
        setTimeout(() => {
            // Set up a MutationObserver to watch for changes to the lab bench
            const labBench = document.querySelector('.lab-bench');
            if (labBench) {
                const observer = new MutationObserver((mutations) => {
                    try {
                        // When the lab bench changes, update the molecular viewer
                        if (window.chemistryLabApps && window.chemistryLabApps['molecular-viewer']) {
                            // Determine which molecule to show based on the lab bench
                            let molecule = 'water'; // Default molecule

                            try {
                                // Check for neutralization reaction
                                const neutralizationElement = document.querySelector('.lab-bench [data-reaction="neutralization"]');
                                if (neutralizationElement) {
                                    molecule = 'water'; // Product of neutralization
                                    window.chemistryLabApps['molecular-viewer'].updateMolecule(molecule);
                                    return;
                                }
                            } catch (e) {
                                console.error('Error checking for neutralization:', e);
                            }

                            try {
                                // With Matter.js, we need to check for chemicals differently
                                // Look for chemical labels or bodies
                                const hclElement = document.querySelector('.lab-bench [data-id="hcl"]');

                                // Also check for text content in labels
                                const labels = document.querySelectorAll('.chemical-label');
                                const hclLabel = Array.from(labels).find(label => label.textContent.includes('HCl'));

                                if (hclElement || hclLabel) {
                                    molecule = 'hcl';
                                    window.chemistryLabApps['molecular-viewer'].updateMolecule(molecule);
                                    return;
                                }
                            } catch (e) {
                                console.error('Error checking for HCl:', e);
                            }

                            try {
                                const naohElement = document.querySelector('.lab-bench [data-id="naoh"]');

                                // Also check for text content in labels
                                const naohLabels = document.querySelectorAll('.chemical-label');
                                const naohLabel = Array.from(naohLabels).find(label => label.textContent.includes('NaOH'));

                                if (naohElement || naohLabel) {
                                    molecule = 'naoh';
                                    window.chemistryLabApps['molecular-viewer'].updateMolecule(molecule);
                                    return;
                                }
                            } catch (e) {
                                console.error('Error checking for NaOH:', e);
                            }

                            try {
                                const waterElement = document.querySelector('.lab-bench [data-id="water"]');

                                // Also check for text content in labels
                                const waterLabels = document.querySelectorAll('.chemical-label');
                                const waterLabel = Array.from(waterLabels).find(label => label.textContent.includes('H₂O'));

                                if (waterElement || waterLabel) {
                                    molecule = 'water';
                                    window.chemistryLabApps['molecular-viewer'].updateMolecule(molecule);
                                    return;
                                }
                            } catch (e) {
                                console.error('Error checking for water:', e);
                            }

                            // Default to water if nothing else is found
                            window.chemistryLabApps['molecular-viewer'].updateMolecule('water');
                        }
                    } catch (error) {
                        console.error('Error in MutationObserver callback:', error);
                    }
                });

                // Start observing the lab bench for changes
                observer.observe(labBench, {
                    childList: true,
                    subtree: true,
                    attributes: true,
                    characterData: true
                });
            }
        }, 500);
    }
});

// Export the function for external use
export { createMolecularViewerApp };
