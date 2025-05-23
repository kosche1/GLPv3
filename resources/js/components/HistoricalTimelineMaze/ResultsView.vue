<template>
  <div class="results-container">
    <h2 class="text-2xl font-bold mb-4">Historical Timeline Maze Results</h2>
    <p class="text-gray-600 mb-6">View your performance history in the Historical Timeline Maze game.</p>

    <div v-if="loading" class="flex justify-center items-center py-12">
      <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-orange-500"></div>
    </div>

    <div v-else-if="error" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
      <p>{{ error }}</p>
      <button @click="fetchResults" class="underline mt-2">Try again</button>
    </div>

    <div v-else-if="results.length === 0" class="bg-gray-100 p-6 rounded-lg text-center">
      <p class="text-lg mb-4">You haven't played any Historical Timeline Maze games yet.</p>
      <p>Complete a game to see your results here.</p>
    </div>

    <div v-else>
      <!-- Results Summary -->
      <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h3 class="text-xl font-semibold mb-4">Performance Summary</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <div class="bg-gray-50 p-4 rounded-lg">
            <p class="text-sm text-gray-500">Total Games</p>
            <p class="text-2xl font-bold">{{ results.length }}</p>
          </div>
          <div class="bg-gray-50 p-4 rounded-lg">
            <p class="text-sm text-gray-500">Average Score</p>
            <p class="text-2xl font-bold">{{ averageScore }}</p>
          </div>
          <div class="bg-gray-50 p-4 rounded-lg">
            <p class="text-sm text-gray-500">Average Accuracy</p>
            <p class="text-2xl font-bold">{{ averageAccuracy }}%</p>
          </div>
        </div>
      </div>

      <!-- Era Distribution -->
      <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h3 class="text-xl font-semibold mb-4">Era Distribution</h3>
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
          <div v-for="(count, era) in eraCounts" :key="era" class="bg-gray-50 p-4 rounded-lg text-center">
            <p class="text-sm text-gray-500">{{ formatEraName(era) }}</p>
            <p class="text-2xl font-bold">{{ count }}</p>
            <p class="text-xs text-gray-400">games played</p>
          </div>
        </div>
      </div>

      <!-- Results List -->
      <h3 class="text-xl font-semibold mb-4">Game History</h3>
      <div class="space-y-4">
        <div v-for="(result, index) in results" :key="result.id" 
          class="bg-white rounded-lg shadow-md overflow-hidden">
          <div class="p-4 border-b border-gray-200 flex justify-between items-center">
            <div>
              <span class="font-semibold text-lg">Game #{{ results.length - index }}</span>
              <span class="ml-2 text-sm text-gray-500">{{ formatDate(result.created_at) }}</span>
            </div>
            <div class="flex items-center gap-2">
              <span 
                class="px-3 py-1 rounded-full text-sm font-medium"
                :class="{
                  'bg-green-100 text-green-800': result.difficulty === 'easy',
                  'bg-yellow-100 text-yellow-800': result.difficulty === 'medium',
                  'bg-red-100 text-red-800': result.difficulty === 'hard'
                }"
              >
                {{ capitalize(result.difficulty) }}
              </span>
              <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-800 text-sm font-medium">
                {{ result.era ? formatEraName(result.era.era) : 'Unknown Era' }}
              </span>
            </div>
          </div>
          
          <div class="p-4">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
              <div>
                <p class="text-sm text-gray-500">Score</p>
                <p class="font-bold text-xl">{{ result.score }}</p>
              </div>
              <div>
                <p class="text-sm text-gray-500">Accuracy</p>
                <p class="font-bold text-xl">{{ result.accuracy_percentage.toFixed(1) }}%</p>
              </div>
              <div>
                <p class="text-sm text-gray-500">Questions</p>
                <p class="font-bold text-xl">{{ result.questions_correct }} / {{ result.questions_attempted }}</p>
              </div>
              <div>
                <p class="text-sm text-gray-500">Time Spent</p>
                <p class="font-bold text-xl">{{ formatTime(result.time_spent_seconds) }}</p>
              </div>
            </div>
            
            <div v-if="result.notes" class="mt-2 p-3 bg-gray-50 rounded">
              <p class="text-sm text-gray-600 mb-1">Notes:</p>
              <p class="text-sm">{{ result.notes }}</p>
            </div>
            
            <div class="mt-3 flex justify-between items-center">
              <span 
                class="text-sm"
                :class="result.completed ? 'text-green-600' : 'text-orange-600'"
              >
                {{ result.completed ? 'Completed' : 'Not Completed' }}
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'HistoricalTimelineMazeResults',
  data() {
    return {
      results: [],
      loading: true,
      error: null
    };
  },
  computed: {
    averageScore() {
      if (this.results.length === 0) return 0;
      const total = this.results.reduce((sum, result) => sum + result.score, 0);
      return Math.round(total / this.results.length);
    },
    averageAccuracy() {
      if (this.results.length === 0) return 0;
      const total = this.results.reduce((sum, result) => sum + parseFloat(result.accuracy_percentage), 0);
      return (total / this.results.length).toFixed(1);
    },
    eraCounts() {
      const counts = {
        ancient: 0,
        medieval: 0,
        renaissance: 0,
        modern: 0,
        contemporary: 0
      };
      
      this.results.forEach(result => {
        if (result.era && result.era.era) {
          counts[result.era.era] = (counts[result.era.era] || 0) + 1;
        }
      });
      
      return counts;
    }
  },
  mounted() {
    this.fetchResults();
  },
  methods: {
    async fetchResults() {
      try {
        this.loading = true;
        this.error = null;
        
        const response = await fetch('/subjects/specialized/humms/historical-timeline-maze/results', {
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
          },
          credentials: 'same-origin'
        });
        
        if (!response.ok) {
          throw new Error('Failed to fetch results');
        }
        
        const data = await response.json();
        this.results = data;
      } catch (error) {
        console.error('Error fetching results:', error);
        this.error = 'There was an error loading your results. Please try again.';
      } finally {
        this.loading = false;
      }
    },
    formatDate(dateString) {
      const options = { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' };
      return new Date(dateString).toLocaleDateString(undefined, options);
    },
    formatTime(seconds) {
      const minutes = Math.floor(seconds / 60);
      const remainingSeconds = seconds % 60;
      return `${minutes}m ${remainingSeconds}s`;
    },
    capitalize(string) {
      return string.charAt(0).toUpperCase() + string.slice(1);
    },
    formatEraName(era) {
      const eraNames = {
        'ancient': 'Ancient',
        'medieval': 'Medieval',
        'renaissance': 'Renaissance',
        'modern': 'Modern',
        'contemporary': 'Contemporary'
      };
      
      return eraNames[era] || era;
    }
  }
};
</script>

<style scoped>
.results-container {
  max-width: 1000px;
  margin: 0 auto;
  padding: 1rem;
}
</style>
