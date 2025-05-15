<template>
  <div class="molecular-viewer">
    <div ref="container" class="viewer-container" :style="{ height: height + 'px' }"></div>
  </div>
</template>

<script>
import * as THREE from 'three';
import { OrbitControls } from 'three/examples/jsm/controls/OrbitControls.js';

export default {
  name: 'MolecularViewer',
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
      animationFrameId: null
    };
  },
  mounted() {
    this.initThree();
    this.createMolecule(this.molecule);
    this.animate();

    // Handle window resize
    window.addEventListener('resize', this.onWindowResize);
  },
  beforeUnmount() {
    window.removeEventListener('resize', this.onWindowResize);
    cancelAnimationFrame(this.animationFrameId);

    // Clean up Three.js resources
    this.scene = null;
    this.camera = null;
    if (this.renderer) {
      this.renderer.dispose();
      this.renderer = null;
    }
    if (this.controls) {
      this.controls.dispose();
      this.controls = null;
    }
  },
  watch: {
    molecule(newMolecule) {
      // Clear existing molecule
      this.clearMolecule();
      // Create new molecule
      this.createMolecule(newMolecule);
    }
  },
  methods: {
    initThree() {
      // Create scene
      this.scene = new THREE.Scene();
      this.scene.background = new THREE.Color(0x000000);

      // Create camera
      this.camera = new THREE.PerspectiveCamera(
        75,
        this.$refs.container.clientWidth / this.$refs.container.clientHeight,
        0.1,
        1000
      );
      this.camera.position.z = 5;

      // Create renderer
      this.renderer = new THREE.WebGLRenderer({ antialias: true });
      this.renderer.setSize(
        this.$refs.container.clientWidth,
        this.$refs.container.clientHeight
      );
      this.$refs.container.appendChild(this.renderer.domElement);

      // Add orbit controls
      this.controls = new OrbitControls(this.camera, this.renderer.domElement);
      this.controls.enableDamping = true;
      this.controls.dampingFactor = 0.25;

      // Add ambient light
      const ambientLight = new THREE.AmbientLight(0xffffff, 0.5);
      this.scene.add(ambientLight);

      // Add directional light
      const directionalLight = new THREE.DirectionalLight(0xffffff, 0.8);
      directionalLight.position.set(1, 1, 1);
      this.scene.add(directionalLight);
    },
    createMolecule(moleculeType) {
      switch (moleculeType) {
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
          this.createWaterMolecule();
      }
    },
    createWaterMolecule() {
      // Create oxygen atom (red)
      const oGeometry = new THREE.SphereGeometry(0.5, 32, 32);
      const oMaterial = new THREE.MeshPhongMaterial({ color: 0xff0000 });
      const oxygen = new THREE.Mesh(oGeometry, oMaterial);
      this.scene.add(oxygen);

      // Create hydrogen atoms (white)
      const hGeometry = new THREE.SphereGeometry(0.3, 32, 32);
      const hMaterial = new THREE.MeshPhongMaterial({ color: 0xffffff });

      const hydrogen1 = new THREE.Mesh(hGeometry, hMaterial);
      hydrogen1.position.set(0.5, 0.5, 0);
      this.scene.add(hydrogen1);

      const hydrogen2 = new THREE.Mesh(hGeometry, hMaterial);
      hydrogen2.position.set(-0.5, 0.5, 0);
      this.scene.add(hydrogen2);

      // Create bonds (cylinders)
      this.createBond(oxygen.position, hydrogen1.position, 0x888888);
      this.createBond(oxygen.position, hydrogen2.position, 0x888888);
    },
    createHClMolecule() {
      // Create chlorine atom (green)
      const clGeometry = new THREE.SphereGeometry(0.6, 32, 32);
      const clMaterial = new THREE.MeshPhongMaterial({ color: 0x00ff00 });
      const chlorine = new THREE.Mesh(clGeometry, clMaterial);
      chlorine.position.set(-0.6, 0, 0);
      this.scene.add(chlorine);

      // Create hydrogen atom (white)
      const hGeometry = new THREE.SphereGeometry(0.3, 32, 32);
      const hMaterial = new THREE.MeshPhongMaterial({ color: 0xffffff });
      const hydrogen = new THREE.Mesh(hGeometry, hMaterial);
      hydrogen.position.set(0.6, 0, 0);
      this.scene.add(hydrogen);

      // Create bond
      this.createBond(chlorine.position, hydrogen.position, 0x888888);
    },
    createNaOHMolecule() {
      // Create sodium atom (purple)
      const naGeometry = new THREE.SphereGeometry(0.6, 32, 32);
      const naMaterial = new THREE.MeshPhongMaterial({ color: 0x8a2be2 });
      const sodium = new THREE.Mesh(naGeometry, naMaterial);
      sodium.position.set(-0.8, 0, 0);
      this.scene.add(sodium);

      // Create oxygen atom (red)
      const oGeometry = new THREE.SphereGeometry(0.5, 32, 32);
      const oMaterial = new THREE.MeshPhongMaterial({ color: 0xff0000 });
      const oxygen = new THREE.Mesh(oGeometry, oMaterial);
      oxygen.position.set(0.2, 0, 0);
      this.scene.add(oxygen);

      // Create hydrogen atom (white)
      const hGeometry = new THREE.SphereGeometry(0.3, 32, 32);
      const hMaterial = new THREE.MeshPhongMaterial({ color: 0xffffff });
      const hydrogen = new THREE.Mesh(hGeometry, hMaterial);
      hydrogen.position.set(0.8, 0.5, 0);
      this.scene.add(hydrogen);

      // Create bonds
      this.createBond(sodium.position, oxygen.position, 0x888888);
      this.createBond(oxygen.position, hydrogen.position, 0x888888);
    },
    createBond(start, end, color) {
      try {
        // Calculate the midpoint and direction
        const direction = new THREE.Vector3().subVectors(end, start);
        const midpoint = new THREE.Vector3().addVectors(start, end).multiplyScalar(0.5);

        // Create cylinder geometry
        const length = direction.length();
        const cylinderGeometry = new THREE.CylinderGeometry(0.1, 0.1, length, 8);
        const cylinderMaterial = new THREE.MeshPhongMaterial({ color });
        const cylinder = new THREE.Mesh(cylinderGeometry, cylinderMaterial);

        // Position and orient the cylinder
        cylinder.position.copy(midpoint);

        // Use a different approach to orient the cylinder to avoid modelViewMatrix issues
        // Calculate rotation from direction vector
        if (direction.y > 0.99999) {
          cylinder.rotation.set(0, 0, 0);
        } else if (direction.y < -0.99999) {
          cylinder.rotation.set(Math.PI, 0, 0);
        } else {
          const axis = new THREE.Vector3(direction.z, 0, -direction.x).normalize();
          const radians = Math.acos(direction.y);
          cylinder.quaternion.setFromAxisAngle(axis, radians);
        }

        this.scene.add(cylinder);
      } catch (error) {
        console.error('Error creating bond:', error);
      }
    },
    clearMolecule() {
      // Remove all objects except lights
      while (this.scene.children.length > 2) {
        const object = this.scene.children[2];
        this.scene.remove(object);
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
      if (this.camera && this.renderer && this.$refs.container) {
        this.camera.aspect = this.$refs.container.clientWidth / this.$refs.container.clientHeight;
        this.camera.updateProjectionMatrix();
        this.renderer.setSize(
          this.$refs.container.clientWidth,
          this.$refs.container.clientHeight
        );
      }
    }
  }
};
</script>

<style scoped>
.molecular-viewer {
  width: 100%;
  background-color: #000;
  border-radius: 0.5rem;
  overflow: hidden;
}

.viewer-container {
  width: 100%;
  min-height: 300px;
}
</style>
