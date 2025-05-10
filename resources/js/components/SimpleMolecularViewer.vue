<template>
  <div class="simple-molecular-viewer" :style="{ height: `${height}px` }">
    <div v-if="loading" class="loading-overlay">
      <div class="loading-spinner"></div>
      <div class="loading-text">Loading molecule...</div>
    </div>
    <div v-else-if="error" class="error-message">
      {{ error }}
    </div>
    <div v-else class="molecule-container">
      <div class="molecule-name">{{ moleculeName }}</div>
      <div class="molecule-formula">{{ moleculeFormula }}</div>
      <div class="molecule-visualization" :class="molecule">
        <template v-if="molecule === 'water'">
          <div class="atom oxygen"></div>
          <div class="atom hydrogen hydrogen-1"></div>
          <div class="atom hydrogen hydrogen-2"></div>
          <div class="bond bond-1"></div>
          <div class="bond bond-2"></div>
        </template>
        <template v-else-if="molecule === 'hcl'">
          <div class="atom hydrogen"></div>
          <div class="atom chlorine"></div>
          <div class="bond bond-1"></div>
        </template>
        <template v-else-if="molecule === 'naoh'">
          <div class="atom sodium"></div>
          <div class="atom oxygen"></div>
          <div class="atom hydrogen"></div>
          <div class="bond bond-1"></div>
          <div class="bond bond-2"></div>
        </template>
        <template v-else>
          <div class="unknown-molecule">
            {{ molecule }}
          </div>
        </template>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'SimpleMolecularViewer',
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
      loading: true,
      error: null
    };
  },
  computed: {
    moleculeName() {
      switch (this.molecule.toLowerCase()) {
        case 'water':
          return 'Water';
        case 'hcl':
          return 'Hydrochloric Acid';
        case 'naoh':
          return 'Sodium Hydroxide';
        default:
          return this.molecule;
      }
    },
    moleculeFormula() {
      switch (this.molecule.toLowerCase()) {
        case 'water':
          return 'H₂O';
        case 'hcl':
          return 'HCl';
        case 'naoh':
          return 'NaOH';
        default:
          return '';
      }
    }
  },
  watch: {
    molecule() {
      this.loadMolecule();
    }
  },
  mounted() {
    this.loadMolecule();
  },
  methods: {
    loadMolecule() {
      this.loading = true;
      this.error = null;
      
      // Simulate loading time
      setTimeout(() => {
        try {
          // Check if molecule is supported
          const supportedMolecules = ['water', 'hcl', 'naoh'];
          if (!supportedMolecules.includes(this.molecule.toLowerCase())) {
            console.warn(`Molecule "${this.molecule}" is not fully supported. Displaying basic representation.`);
          }
          
          this.loading = false;
        } catch (error) {
          console.error('Error loading molecule:', error);
          this.error = `Failed to load ${this.molecule} molecule`;
          this.loading = false;
        }
      }, 500);
    }
  }
};
</script>

<style scoped>
.simple-molecular-viewer {
  position: relative;
  width: 100%;
  min-height: 200px;
  background-color: #111;
  border-radius: 8px;
  overflow: hidden;
  display: flex;
  align-items: center;
  justify-content: center;
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

.molecule-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  width: 100%;
  height: 100%;
  padding: 20px;
}

.molecule-name {
  font-size: 18px;
  font-weight: bold;
  color: white;
  margin-bottom: 5px;
}

.molecule-formula {
  font-size: 16px;
  color: #d1d5db;
  margin-bottom: 20px;
}

.molecule-visualization {
  position: relative;
  width: 200px;
  height: 150px;
}

/* Atom styles */
.atom {
  position: absolute;
  border-radius: 50%;
  box-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
}

.oxygen {
  width: 40px;
  height: 40px;
  background-color: #ef4444; /* Red */
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  z-index: 2;
}

.hydrogen {
  width: 25px;
  height: 25px;
  background-color: #f3f4f6; /* White */
  z-index: 2;
}

.hydrogen-1 {
  top: 30%;
  left: 25%;
}

.hydrogen-2 {
  top: 30%;
  left: 75%;
}

.chlorine {
  width: 40px;
  height: 40px;
  background-color: #10b981; /* Green */
  top: 50%;
  left: 65%;
  transform: translate(-50%, -50%);
  z-index: 2;
}

.sodium {
  width: 40px;
  height: 40px;
  background-color: #8b5cf6; /* Purple */
  top: 50%;
  left: 25%;
  transform: translate(-50%, -50%);
  z-index: 2;
}

/* Bond styles */
.bond {
  position: absolute;
  background-color: #9ca3af; /* Gray */
  z-index: 1;
}

/* Water bonds */
.water .bond-1 {
  width: 40px;
  height: 5px;
  top: 40%;
  left: 35%;
  transform: rotate(-30deg);
}

.water .bond-2 {
  width: 40px;
  height: 5px;
  top: 40%;
  left: 55%;
  transform: rotate(30deg);
}

/* HCl bond */
.hcl .bond-1 {
  width: 50px;
  height: 5px;
  top: 50%;
  left: 45%;
  transform: translateY(-50%);
}

/* NaOH bonds */
.naoh .bond-1 {
  width: 40px;
  height: 5px;
  top: 50%;
  left: 35%;
  transform: translateY(-50%);
}

.naoh .bond-2 {
  width: 40px;
  height: 5px;
  top: 40%;
  left: 55%;
  transform: rotate(30deg);
}

.unknown-molecule {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 100%;
  height: 100%;
  color: white;
  font-size: 16px;
  text-align: center;
  border: 2px dashed #6b7280;
  border-radius: 8px;
  padding: 10px;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}
</style>
