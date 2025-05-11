<x-layouts.app>
    <script src="https://cdn.jsdelivr.net/npm/plain-draggable@2.5.14/plain-draggable.min.js"></script>

    <div class="flex h-full w-full flex-1 flex-col gap-6 text-gray-100 p-6 border border-emerald-500 rounded-lg">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-emerald-500/10 rounded-lg">
                    <!-- Icon for Molecule Builder (e.g., atoms or molecule structure) -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" /> <!-- Simple atom/bond like structure -->
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-white">Molecule Builder</h1>
            </div>
            <a href="{{ route('subjects.specialized.stem') }}" class="flex items-center gap-2 px-5 py-2.5 rounded-lg border border-emerald-500/30 bg-emerald-500/10 transition-all duration-300 hover:bg-emerald-500/20 hover:border-emerald-500/50 hover:shadow-lg hover:shadow-emerald-900/20 group">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400 group-hover:text-emerald-300 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span class="text-base font-medium text-emerald-400 group-hover:text-emerald-300 transition-colors">Back to STEM Track</span>
            </a>
        </div>

        <!-- Main Content Area -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 flex-1">
            <!-- Left Column: Target Molecule & Atom Palette -->
            <div class="md:col-span-1 flex flex-col gap-6">
                <!-- Target Molecule Section -->
                <div class="bg-neutral-800 rounded-xl border border-neutral-700 p-4 shadow-lg">
                    <h2 class="text-lg font-semibold text-white mb-3">Target Molecule</h2>
                    <div id="target-molecule-display" class="min-h-[100px] bg-neutral-700/50 rounded-lg flex items-center justify-center p-4">
                        <p class="text-neutral-400 text-center">H₂O (Water)</p> <!-- Example -->
                        <!-- This could later display a 2D image or a simple CSS representation -->
                    </div>
                </div>

                <!-- Atom Palette Section -->
                <div class="bg-neutral-800 rounded-xl border border-neutral-700 p-4 shadow-lg flex-1">
                    <h2 class="text-lg font-semibold text-white mb-3">Atom Palette</h2>
                    <div id="atom-palette" class="grid grid-cols-3 gap-3">
                        <!-- Atoms will be added here by JavaScript -->
                        <div class="atom-item p-3 bg-red-500 rounded-md text-white text-center cursor-pointer hover:bg-red-400" data-atom="O">O</div>
                        <div class="atom-item p-3 bg-blue-500 rounded-md text-white text-center cursor-pointer hover:bg-blue-400" data-atom="H">H</div>
                        <div class="atom-item p-3 bg-gray-500 rounded-md text-white text-center cursor-pointer hover:bg-gray-400" data-atom="C">C</div>
                        <div class="atom-item p-3 bg-green-500 rounded-md text-white text-center cursor-pointer hover:bg-green-400" data-atom="Cl">Cl</div>
                        <div class="atom-item p-3 bg-purple-500 rounded-md text-white text-center cursor-pointer hover:bg-purple-400" data-atom="Na">Na</div>
                        <!-- Add more atoms as needed -->
                    </div>
                </div>
            </div>

            <!-- Right Column: Building Area & Controls -->
            <div class="md:col-span-2 flex flex-col gap-6">
                <!-- Building Area (Workbench) -->
                <div class="bg-neutral-800 rounded-xl border border-neutral-700 p-4 shadow-lg flex-1 relative">
                    <h2 class="text-lg font-semibold text-white mb-3">Workbench</h2>
                    <div id="workbench" class="min-h-[300px] md:min-h-[400px] bg-neutral-900/70 rounded-lg border-2 border-dashed border-neutral-700 relative overflow-hidden">
                        <!-- Atoms and bonds will be drawn here (e.g., using JS and canvas/SVG, or DOM elements) -->
                        <p class="absolute inset-0 flex items-center justify-center text-neutral-500 pointer-events-none">Drag atoms here to build</p>
                    </div>
                </div>

                <!-- Controls Section -->
                <div class="bg-neutral-800 rounded-xl border border-neutral-700 p-4 shadow-lg">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <button id="check-molecule-btn" class="w-full px-4 py-3 bg-emerald-600 hover:bg-emerald-500 text-white rounded-lg transition-colors flex items-center justify-center text-base font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            Check Molecule
                        </button>
                        <button id="reset-workbench-btn" class="w-full px-4 py-3 bg-red-600 hover:bg-red-500 text-white rounded-lg transition-colors flex items-center justify-center text-base font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Reset Workbench
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Feedback Area (optional, could be a modal or toast notifications) -->
        <div id="feedback-area" class="mt-4 text-center">
            <!-- Feedback messages will appear here -->
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const atomPalette = document.getElementById('atom-palette');
            const workbench = document.getElementById('workbench');
            workbench.style.position = 'relative'; // Ensure workbench has relative positioning

            const checkMoleculeBtn = document.getElementById('check-molecule-btn');
            const resetWorkbenchBtn = document.getElementById('reset-workbench-btn');
            const feedbackArea = document.getElementById('feedback-area');

            let workbenchAtoms = []; // Stores { id, type, x, y, element, draggableInstance }
            let atomIdCounter = 0;

            // --- Atom Palette Interaction ---
            atomPalette.addEventListener('click', function(event) {
                if (event.target.classList.contains('atom-item')) {
                    const atomType = event.target.getAttribute('data-atom');
                    const atomColor = event.target.style.backgroundColor;
                    spawnAtomOnWorkbench(atomType, atomColor);
                }
            });

            function spawnAtomOnWorkbench(type, color) {
                atomIdCounter++;
                const newAtomId = `atom-${atomIdCounter}`;

                const atomElement = document.createElement('div');
                atomElement.id = newAtomId;
                atomElement.className = 'workbench-atom absolute p-2 rounded-full text-white flex items-center justify-center cursor-grab select-none';
                atomElement.style.width = '40px';
                atomElement.style.height = '40px';
                atomElement.style.backgroundColor = color;
                atomElement.textContent = type;
                
                let initialX = (workbench.offsetWidth / 2) - 20 + (Math.random() * 40 - 20);
                let initialY = (workbench.offsetHeight / 2) - 20 + (Math.random() * 40 - 20);
                initialX = Math.max(0, Math.min(initialX, workbench.offsetWidth - 40));
                initialY = Math.max(0, Math.min(initialY, workbench.offsetHeight - 40));

                atomElement.style.left = initialX + 'px';
                atomElement.style.top = initialY + 'px';
                
                workbench.appendChild(atomElement);

                const atomData = { 
                    id: newAtomId, 
                    type: type, 
                    x: initialX, // Will be updated by PlainDraggable's onMove
                    y: initialY, // Will be updated by PlainDraggable's onMove
                    element: atomElement,
                    draggableInstance: null // Will hold the PlainDraggable instance
                };

                // Make the new atom draggable using PlainDraggable
                atomData.draggableInstance = new PlainDraggable(atomElement, {
                    containment: workbench,
                    onMove: function() { // PlainDraggable's onMove provides updated style.left/top
                        // Find the atom in our array by its element ID
                        const currentAtom = workbenchAtoms.find(a => a.id === atomElement.id);
                        if (currentAtom) {
                            // PlainDraggable updates the element's style directly.
                            // We read from the style to keep our data store in sync.
                            currentAtom.x = parseFloat(atomElement.style.left);
                            currentAtom.y = parseFloat(atomElement.style.top);
                            // console.log(`Atom ${currentAtom.id} moved to x: ${currentAtom.x}, y: ${currentAtom.y}`);
                        }
                    }
                });

                workbenchAtoms.push(atomData);
                console.log('Spawned atom:', atomData.id, 'PlainDraggable instance:', atomData.draggableInstance);
            }

            // --- Control Button Actions ---
            checkMoleculeBtn.addEventListener('click', function() {
                if (workbenchAtoms.length === 0) {
                    feedbackArea.textContent = 'Workbench is empty!';
                    return;
                }
                let message = 'Atoms on workbench: ';
                workbenchAtoms.forEach(atom => {
                    message += `${atom.type} (id: ${atom.id}, x: ${Math.round(atom.x)}, y: ${Math.round(atom.y)}); `;
                });
                feedbackArea.textContent = message;
                console.log('Current workbenchAtoms:', workbenchAtoms);
            });

            resetWorkbenchBtn.addEventListener('click', function() {
                workbenchAtoms.forEach(atom => {
                    if (atom.draggableInstance) {
                        atom.draggableInstance.remove(); // Clean up PlainDraggable instance
                    }
                    atom.element.remove(); // Remove atom from DOM
                });
                workbenchAtoms = [];
                atomIdCounter = 0;
                feedbackArea.textContent = 'Workbench reset!';
                
                const placeholderParagraph = workbench.querySelector('p.absolute.inset-0');
                if (!placeholderParagraph && workbench.children.length === 0) {
                     const p = document.createElement('p');
                     p.className = 'absolute inset-0 flex items-center justify-center text-neutral-500 pointer-events-none';
                     p.textContent = 'Drag atoms here to build';
                     workbench.appendChild(p);
                }
            });

            // Initial clear of workbench placeholder paragraph
            const initialPlaceholder = workbench.querySelector('p.absolute.inset-0');
            if (initialPlaceholder) initialPlaceholder.remove();

        });
    </script>
    @endpush
</x-layouts.app> 