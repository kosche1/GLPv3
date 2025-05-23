<template>
  <div class="results-view">
    <div class="results-header">
      <h2 class="text-2xl font-bold mb-2">Investment Results</h2>
      <p class="subtitle mb-4">Track your investment performance over time</p>
      
      <div class="flex justify-between items-center mb-6">
        <button 
          @click="saveCurrentResult" 
          class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-2 px-4 rounded flex items-center"
          :disabled="saving"
        >
          <span v-if="saving">Saving...</span>
          <span v-else>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
            Save Current Result
          </span>
        </button>
      </div>
    </div>

    <div v-if="showSaveModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full">
        <h3 class="text-xl font-bold mb-4">Save Investment Result</h3>
        
        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2" for="notes">
            Notes (optional)
          </label>
          <textarea 
            id="notes" 
            v-model="notes" 
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            rows="4"
            placeholder="Add notes about your investment strategy or learnings..."
          ></textarea>
        </div>
        
        <div class="flex justify-end space-x-2">
          <button 
            @click="showSaveModal = false" 
            class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded"
          >
            Cancel
          </button>
          <button 
            @click="confirmSaveResult" 
            class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-2 px-4 rounded"
            :disabled="saving"
          >
            {{ saving ? 'Saving...' : 'Save Result' }}
          </button>
        </div>
      </div>
    </div>

    <div v-if="loading" class="flex justify-center items-center py-12">
      <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-orange-500"></div>
    </div>

    <div v-else-if="error" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
      <p>{{ error }}</p>
      <button @click="fetchResults" class="underline mt-2">Try again</button>
    </div>

    <div v-else-if="results.length === 0" class="bg-gray-100 p-6 rounded-lg text-center">
      <p class="text-lg mb-4">You haven't saved any investment results yet.</p>
      <p>Save your current portfolio performance to track your progress over time.</p>
    </div>

    <div v-else class="results-list space-y-4">
      <div v-for="(result, index) in results" :key="result.id" 
        class="result-card bg-white p-4 rounded-lg shadow hover:shadow-md transition-shadow">
        <div class="flex justify-between items-start">
          <div>
            <h3 class="font-bold text-lg">Result #{{ results.length - index }}</h3>
            <p class="text-sm text-gray-500">{{ formatDate(result.created_at) }}</p>
          </div>
          <div class="text-right">
            <p class="font-bold text-xl">₱{{ formatNumber(result.total_value) }}</p>
            <p :class="result.total_return_percent >= 0 ? 'text-green-600' : 'text-red-600'">
              {{ result.total_return_percent >= 0 ? '+' : '' }}{{ result.total_return_percent.toFixed(2) }}%
            </p>
          </div>
        </div>
        
        <div class="mt-4 grid grid-cols-2 gap-4">
          <div>
            <p class="text-sm text-gray-600">Cash Balance</p>
            <p class="font-medium">₱{{ formatNumber(result.cash_balance) }}</p>
          </div>
          <div>
            <p class="text-sm text-gray-600">Portfolio Value</p>
            <p class="font-medium">₱{{ formatNumber(result.portfolio_value) }}</p>
          </div>
          <div>
            <p class="text-sm text-gray-600">Stocks</p>
            <p class="font-medium">{{ result.stock_count }}</p>
          </div>
          <div>
            <p class="text-sm text-gray-600">Transactions</p>
            <p class="font-medium">{{ result.transaction_count }}</p>
          </div>
        </div>
        
        <div v-if="result.notes" class="mt-4 p-3 bg-gray-50 rounded">
          <p class="text-sm text-gray-600 mb-1">Notes:</p>
          <p class="text-sm">{{ result.notes }}</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'ResultsView',
  props: {
    portfolio: {
      type: Array,
      required: true
    },
    balance: {
      type: Number,
      required: true
    }
  },
  data() {
    return {
      results: [],
      loading: true,
      error: null,
      saving: false,
      showSaveModal: false,
      notes: ''
    };
  },
  created() {
    this.fetchResults();
  },
  methods: {
    async fetchResults() {
      try {
        this.loading = true;
        this.error = null;
        
        const response = await fetch('/api/investsmart/results', {
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
        this.error = 'There was an error loading your investment results. Please try again.';
      } finally {
        this.loading = false;
      }
    },
    
    saveCurrentResult() {
      this.showSaveModal = true;
      this.notes = '';
    },
    
    async confirmSaveResult() {
      try {
        this.saving = true;
        
        const response = await fetch('/api/investsmart/save-result', {
          method: 'POST',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
          },
          body: JSON.stringify({
            notes: this.notes
          }),
          credentials: 'same-origin'
        });
        
        if (!response.ok) {
          throw new Error('Failed to save result');
        }
        
        const data = await response.json();
        
        // Close modal and refresh results
        this.showSaveModal = false;
        await this.fetchResults();
        
        // Show success message
        alert('Investment result saved successfully!');
      } catch (error) {
        console.error('Error saving result:', error);
        alert('There was an error saving your investment result. Please try again.');
      } finally {
        this.saving = false;
      }
    },
    
    formatDate(dateString) {
      const options = { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' };
      return new Date(dateString).toLocaleDateString(undefined, options);
    },
    
    formatNumber(number) {
      return number.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }
  }
};
</script>

<style scoped>
.results-view {
  max-width: 1200px;
  margin: 0 auto;
}

.results-header {
  margin-bottom: 2rem;
}

.subtitle {
  color: #666;
  font-size: 1.1rem;
}
</style>
