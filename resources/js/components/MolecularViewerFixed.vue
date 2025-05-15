<template>
  <div ref="container" class="molecular-viewer" :style="{ height: `${height}px` }">
    <div v-if="loading" class="loading-overlay">
      <div class="loading-spinner"></div>
      <div class="loading-text">Loading molecule...</div>
    </div>
    <div v-if="error" class="error-message">
      {{ error }}
    </div>
  </div>
</template>

<script>
import * as THREE from 'three';
import { OrbitControls } from 'three/examples/jsm/controls/OrbitControls.js';

export default {
  name: 'MolecularViewerFixed',
  props: {
    molecule: {
      type: String,
      default: 'water'
    },
    height: {
      type: Number,
      default: 300
    }
  },
  data() {
    return {
      scene: null,
      camera: null,
      renderer: null,
      controls: null,
      animationFrameId: null,
      loading: true,
      error: null,
      atoms: [],
      bonds: []
    };
  },
  watch: {
    molecule(newValue) {
      this.clearMolecule();
      this.createMolecule(newValue);
    }
  },
  mounted() {
    try {
      this.initScene();
      this.createMolecule(this.molecule);
      this.animate();
      
      // Handle window resize
      window.addEventListener('resize', this.onWindowResize);
    } catch (error) {
      console.error('Error initializing molecular viewer:', error);
      this.error = 'Failed to initialize molecular viewer';
    }
  },
  beforeUnmount() {
    try {
      // Clean up resources
      window.removeEventListener('resize', this.onWindowResize);
      
      if (this.animationFrameId) {
        cancelAnimationFrame(this.animationFrameId);
      }
      
      if (this.renderer) {
        this.renderer.dispose();
      }
      
      // Clean up scene
      if (this.scene) {
        this.disposeScene(this.scene);
      }
    } catch (error) {
      console.error('Error cleaning up molecular viewer:', error);
    }
  },
  methods: {
    initScene() {
      try {
        // Create scene
        this.scene = new THREE.Scene();
        this.scene.background = new THREE.Color(0x000000);
        
        // Create camera
        const container = this.$refs.container;
        const width = container.clientWidth;
        const height = container.clientHeight;
        const aspect = width / height;
        
        this.camera = new THREE.PerspectiveCamera(75, aspect, 0.1, 1000);
        this.camera.position.z = 5;
        
        // Create renderer
        this.renderer = new THREE.WebGLRenderer({ antialias: true });
        this.renderer.setSize(width, height);
        container.appendChild(this.renderer.domElement);
        
        // Add orbit controls
        this.controls = new OrbitControls(this.camera, this.renderer.domElement);
        this.controls.enableDamping = true;
        this.controls.dampingFactor = 0.25;
        
        // Add ambient light
        const ambientLight = new THREE.AmbientLight(0x404040);
        this.scene.add(ambientLight);
        
        // Add directional light
        const directionalLight = new THREE.DirectionalLight(0xffffff, 0.5);
        directionalLight.position.set(1, 1, 1);
        this.scene.add(directionalLight);
      } catch (error) {
        console.error('Error in initScene:', error);
        throw error;
      }
    },
    createMolecule(moleculeType) {
      try {
        this.loading = true;
        this.error = null;
        
        // Clear any existing molecule
        this.clearMolecule();
        
        // Create molecule based on type
        switch (moleculeType.toLowerCase()) {
          case 'water':
            this.createWaterMolecule();
            break;
          case 'hcl':
            this.createHClMolecule();
            break;
          case 'naoh':
            this.createNaOHMolecule();
            break;
          default:
            this.createWaterMolecule(); // Default to water
        }
        
        this.loading = false;
      } catch (error) {
        console.error('Error creating molecule:', error);
        this.error = `Failed to create ${moleculeType} molecule`;
        this.loading = false;
      }
    },
    createWaterMolecule() {
      try {
        // Create oxygen atom (red)
        const oxygen = this.createAtom(0, 0, 0, 0xff0000);
        
        // Create hydrogen atoms (white)
        const hydrogen1 = this.createAtom(-0.8, 0.6, 0, 0xffffff);
        const hydrogen2 = this.createAtom(0.8, 0.6, 0, 0xffffff);
        
        // Create bonds
        this.createSimpleBond(oxygen.position, hydrogen1.position, 0x888888);
        this.createSimpleBond(oxygen.position, hydrogen2.position, 0x888888);
      } catch (error) {
        console.error('Error creating water molecule:', error);
        throw error;
      }
    },
    createHClMolecule() {
      try {
        // Create hydrogen atom (white)
        const hydrogen = this.createAtom(-0.5, 0, 0, 0xffffff);
        
        // Create chlorine atom (green)
        const chlorine = this.createAtom(0.5, 0, 0, 0x00ff00);
        
        // Create bond
        this.createSimpleBond(hydrogen.position, chlorine.position, 0x888888);
      } catch (error) {
        console.error('Error creating HCl molecule:', error);
        throw error;
      }
    },
    createNaOHMolecule() {
      try {
        // Create sodium atom (purple)
        const sodium = this.createAtom(-1, 0, 0, 0x8a2be2);
        
        // Create oxygen atom (red)
        const oxygen = this.createAtom(0, 0, 0, 0xff0000);
        
        // Create hydrogen atom (white)
        const hydrogen = this.createAtom(0.8, 0.6, 0, 0xffffff);
        
        // Create bonds
        this.createSimpleBond(sodium.position, oxygen.position, 0x888888);
        this.createSimpleBond(oxygen.position, hydrogen.position, 0x888888);
      } catch (error) {
        console.error('Error creating NaOH molecule:', error);
        throw error;
      }
    },
    createAtom(x, y, z, color) {
      try {
        const geometry = new THREE.SphereGeometry(0.3, 32, 32);
        const material = new THREE.MeshPhongMaterial({ color });
        const atom = new THREE.Mesh(geometry, material);
        
        atom.position.set(x, y, z);
        this.scene.add(atom);
        this.atoms.push(atom);
        
        return atom;
      } catch (error) {
        console.error('Error creating atom:', error);
        throw error;
      }
    },
    createSimpleBond(start, end, color) {
      try {
        // Calculate the midpoint
        const midpoint = new THREE.Vector3().addVectors(start, end).multiplyScalar(0.5);
        
        // Calculate the distance between atoms
        const distance = start.distanceTo(end);
        
        // Create a cylinder geometry for the bond
        const geometry = new THREE.CylinderGeometry(0.05, 0.05, distance, 8);
        const material = new THREE.MeshPhongMaterial({ color });
        const bond = new THREE.Mesh(geometry, material);
        
        // Position the bond at the midpoint
        bond.position.copy(midpoint);
        
        // Orient the bond to connect the atoms
        // This approach avoids using modelViewMatrix
        bond.lookAt(end);
        bond.rotateX(Math.PI / 2);
        
        this.scene.add(bond);
        this.bonds.push(bond);
        
        return bond;
      } catch (error) {
        console.error('Error creating bond:', error);
        throw error;
      }
    },
    clearMolecule() {
      try {
        // Remove all atoms
        for (const atom of this.atoms) {
          this.scene.remove(atom);
          atom.geometry.dispose();
          atom.material.dispose();
        }
        this.atoms = [];
        
        // Remove all bonds
        for (const bond of this.bonds) {
          this.scene.remove(bond);
          bond.geometry.dispose();
          bond.material.dispose();
        }
        this.bonds = [];
      } catch (error) {
        console.error('Error clearing molecule:', error);
      }
    },
    animate() {
      try {
        this.animationFrameId = requestAnimationFrame(this.animate);
        
        // Update controls
        if (this.controls) {
          this.controls.update();
        }
        
        // Render scene
        if (this.renderer && this.scene && this.camera) {
          this.renderer.render(this.scene, this.camera);
        }
      } catch (error) {
        console.error('Error in animation loop:', error);
        // Cancel animation frame to prevent error loops
        if (this.animationFrameId) {
          cancelAnimationFrame(this.animationFrameId);
          this.animationFrameId = null;
        }
      }
    },
    onWindowResize() {
      try {
        if (this.camera && this.renderer && this.$refs.container) {
          this.camera.aspect = this.$refs.container.clientWidth / this.$refs.container.clientHeight;
          this.camera.updateProjectionMatrix();
          this.renderer.setSize(this.$refs.container.clientWidth, this.$refs.container.clientHeight);
        }
      } catch (error) {
        console.error('Error resizing window:', error);
      }
    },
    disposeScene(scene) {
      try {
        scene.traverse((object) => {
          if (object.geometry) {
            object.geometry.dispose();
          }
          
          if (object.material) {
            if (Array.isArray(object.material)) {
              for (const material of object.material) {
                this.disposeMaterial(material);
              }
            } else {
              this.disposeMaterial(object.material);
            }
          }
        });
      } catch (error) {
        console.error('Error disposing scene:', error);
      }
    },
    disposeMaterial(material) {
      try {
        if (material.map) material.map.dispose();
        if (material.lightMap) material.lightMap.dispose();
        if (material.bumpMap) material.bumpMap.dispose();
        if (material.normalMap) material.normalMap.dispose();
        if (material.specularMap) material.specularMap.dispose();
        if (material.envMap) material.envMap.dispose();
        
        material.dispose();
      } catch (error) {
        console.error('Error disposing material:', error);
      }
    }
  }
};
</script>

<style scoped>
.molecular-viewer {
  position: relative;
  width: 100%;
  min-height: 300px;
  background-color: #000;
  border-radius: 8px;
  overflow: hidden;
}

.loading-overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  background-color: rgba(0, 0, 0, 0.7);
  color: white;
  z-index: 10;
}

.loading-spinner {
  width: 40px;
  height: 40px;
  border: 4px solid rgba(255, 255, 255, 0.3);
  border-radius: 50%;
  border-top-color: #10b981;
  animation: spin 1s ease-in-out infinite;
  margin-bottom: 10px;
}

.loading-text {
  font-size: 14px;
}

.error-message {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: rgba(0, 0, 0, 0.7);
  color: #ef4444;
  padding: 20px;
  text-align: center;
  z-index: 10;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}
</style>
