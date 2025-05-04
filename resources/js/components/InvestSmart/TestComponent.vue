<template>
  <div class="test-component">
    <h2>Vue is Working!</h2>
    <p>This is a simple test component to verify Vue is rendering correctly.</p>
    <button @click="count++">Clicked {{ count }} times</button>
  </div>
</template>

<script setup>
import { ref } from 'vue';

const count = ref(0);
</script>

<style scoped>
.test-component {
  padding: 2rem;
  background-color: #f0f9ff;
  border-radius: 8px;
  text-align: center;
}

h2 {
  color: #0369a1;
  margin-bottom: 1rem;
}

button {
  background-color: #0ea5e9;
  color: white;
  border: none;
  padding: 0.5rem 1rem;
  border-radius: 4px;
  cursor: pointer;
  font-weight: bold;
  margin-top: 1rem;
}

button:hover {
  background-color: #0284c7;
}
</style>
