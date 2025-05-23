<template>
  <div class="invest-smart-game">
    <header class="app-header">
      <div class="logo">
        <h1>InvestSmart</h1>
        <span class="tagline">Investment Strategy Game for ABM Students</span>
      </div>
      <nav class="main-nav">
        <button @click="activeView = 'portfolio'" :class="{ active: activeView === 'portfolio' }">Portfolio</button>
        <button @click="activeView = 'market'" :class="{ active: activeView === 'market' }">Market</button>
        <button @click="activeView = 'transactions'" :class="{ active: activeView === 'transactions' }">Transactions</button>
        <button @click="activeView = 'results'" :class="{ active: activeView === 'results' }">Results</button>
        <button @click="activeView = 'learn'" :class="{ active: activeView === 'learn' }">Learn</button>
        <button @click="activeView = 'challenges'" :class="{ active: activeView === 'challenges' }">Challenges</button>
      </nav>
      <div class="user-info">
        <span class="balance">Balance: ₱{{ formatNumber(balance) }}</span>
        <span class="username">{{ username }}</span>
      </div>
    </header>

    <main class="app-content">
      <component :is="currentView"
                 :portfolio="portfolio"
                 :balance="balance"
                 :transactions="transactions"
                 @buy-stock="handleBuyStock"
                 @sell-stock="sellStock"
                 @change-view="changeView">
      </component>
    </main>

    <footer class="app-footer">
      <p>InvestSmart © {{ new Date().getFullYear() }} | Educational Investment Simulation Game by GLP</p>
    </footer>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import axios from 'axios';
import PortfolioView from './views/PortfolioView.vue';
import MarketView from './views/MarketViewNew.vue';
import TransactionsView from './views/TransactionsView.vue';
import ResultsView from './views/ResultsView.vue';
import LearnView from './views/LearnView.vue';
import ChallengesView from './views/ChallengesView.vue';

// Data properties
const activeView = ref('portfolio');
const username = ref(document.querySelector('meta[name="user-name"]')?.getAttribute('content') || 'Student');
const balance = ref(100000); // Starting with ₱100,000 for testing
const portfolio = ref([]);
const transactions = ref([]);
const loading = ref(true);
const error = ref(null);

// Timer for price updates
let priceUpdateTimer = null;
const updateInterval = 3000; // Update prices every 5 seconds

// Computed properties
const currentView = computed(() => {
  switch(activeView.value) {
    case 'portfolio': return PortfolioView;
    case 'market': return MarketView;
    case 'transactions': return TransactionsView;
    case 'results': return ResultsView;
    case 'learn': return LearnView;
    case 'challenges': return ChallengesView;
    default: return PortfolioView;
  }
});

// Methods
const formatNumber = (num) => {
  // Ensure we're working with a number and not a string
  const numValue = Number(num);
  // Format the number with 2 decimal places
  return numValue.toLocaleString('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
};

// Old buyStock function removed - now using API version

// Old sellStock function removed - now using API version

// Function to change the active view
const changeView = (view) => {
  activeView.value = view;
};

// Function to load portfolio data from API
const loadPortfolio = async () => {
  try {
    loading.value = true;
    error.value = null;

    const response = await axios.get('/api/investsmart/portfolio');
    balance.value = response.data.balance;

    // Map the portfolio data to match what the component expects
    portfolio.value = response.data.portfolio.map(stock => ({
      symbol: stock.symbol,
      name: stock.name,
      quantity: stock.quantity,
      averagePrice: parseFloat(stock.average_price),
      totalCost: parseFloat(stock.total_cost),
      currentPrice: parseFloat(stock.current_price)
    }));

    console.log('Portfolio loaded:', portfolio.value);
  } catch (err) {
    console.error('Error loading portfolio:', err);
    error.value = 'Failed to load portfolio data. Please try again.';
  } finally {
    loading.value = false;
  }
};

// Function to load transaction history from API
const loadTransactions = async () => {
  try {
    const response = await axios.get('/api/investsmart/transactions');
    transactions.value = response.data;
    console.log('Transactions loaded:', response.data);
  } catch (err) {
    console.error('Error loading transactions:', err);
  }
};

// Function to update stock prices via API
const updateStockPrices = async () => {
  try {
    const response = await axios.post('/api/investsmart/update-prices');
    if (response.data.success) {
      console.log('Stock prices updated at', new Date().toLocaleTimeString());

      // Show a brief notification that prices have been updated
      //const notificationEl = document.createElement('div');
      //notificationEl.textContent = 'Market prices updated';
      //notificationEl.style.position = 'fixed';
      //notificationEl.style.bottom = '20px';
      //notificationEl.style.right = '20px';
      //notificationEl.style.backgroundColor = 'rgba(52, 152, 219, 0.9)';
      //notificationEl.style.color = 'white';
     // notificationEl.style.padding = '10px 15px';
      //notificationEl.style.borderRadius = '4px';
      //notificationEl.style.zIndex = '9999';
      //notificationEl.style.transition = 'opacity 0.5s';
      //document.body.appendChild(notificationEl);

      // Remove notification after 2 seconds
      //setTimeout(() => {
        //notificationEl.style.opacity = '0';
        //setTimeout(() => {
          //document.body.removeChild(notificationEl);
        //}, 500);
      //}, 2000);

      // Instead of reloading the entire portfolio, just update the current prices
      if (portfolio.value.length > 0) {
        // Get the latest market data
        const marketResponse = await axios.get('/api/investsmart/market');
        const marketData = marketResponse.data;

        // Update current prices in the portfolio
        portfolio.value = portfolio.value.map(stock => {
          // Find the matching market data
          const marketStock = marketData.find(ms => ms.symbol === stock.symbol);
          if (marketStock) {
            // Only update the current price
            return {
              ...stock,
              currentPrice: parseFloat(marketStock.price)
            };
          }
          return stock;
        });
      }
    }
  } catch (err) {
    console.error('Error updating stock prices:', err);
  }
};

// Buy stock function
const handleBuyStock = async (stock, quantity, price) => {
  try {
    const response = await axios.post('/api/investsmart/buy', {
      symbol: stock.symbol,
      quantity: quantity
    });

    if (response.data.success) {
      // Update balance
      balance.value = response.data.balance;

      // Reload portfolio
      await loadPortfolio();

      // Reload transactions
      await loadTransactions();

      return true;
    } else {
      console.error('Buy stock failed:', response.data.message);
      return false;
    }
  } catch (err) {
    console.error('Error buying stock:', err);
    return false;
  }
};

// Sell stock function
const sellStock = async (stock, quantity, price) => {
  try {
    const response = await axios.post('/api/investsmart/sell', {
      symbol: stock.symbol,
      quantity: quantity
    });

    if (response.data.success) {
      // Update balance
      balance.value = response.data.balance;

      // Reload portfolio
      await loadPortfolio();

      // Reload transactions
      await loadTransactions();

      return true;
    } else {
      console.error('Sell stock failed:', response.data.message);
      return false;
    }
  } catch (err) {
    console.error('Error selling stock:', err);
    return false;
  }
};

// Set up lifecycle hooks
onMounted(async () => {
  // Load initial data
  await loadPortfolio();
  await loadTransactions();

  // Start the price update timer
  priceUpdateTimer = setInterval(updateStockPrices, updateInterval);
  console.log('Price update timer started');
});

onUnmounted(() => {
  // Clean up the timer when component is unmounted
  if (priceUpdateTimer) {
    clearInterval(priceUpdateTimer);
    console.log('Price update timer cleared');
  }
});
</script>

<style scoped>
.invest-smart-game {
  display: flex;
  flex-direction: column;
  height: 100%;
  font-family: 'Roboto', sans-serif;
  color: #333;
}

.app-header {
  background-color: #2c3e50;
  color: white;
  padding: 1rem;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.logo h1 {
  margin: 0;
  font-size: 1.8rem;
}

.tagline {
  font-size: 0.8rem;
  opacity: 0.8;
}

.main-nav {
  display: flex;
  gap: 1rem;
}

.main-nav button {
  background: none;
  border: none;
  color: white;
  padding: 0.5rem 1rem;
  cursor: pointer;
  border-radius: 4px;
  transition: background-color 0.3s;
}

.main-nav button:hover {
  background-color: rgba(255, 255, 255, 0.1);
}

.main-nav button.active {
  background-color: rgba(255, 255, 255, 0.2);
  font-weight: bold;
}

.user-info {
  display: flex;
  flex-direction: column;
  align-items: flex-end;
}

.balance {
  font-weight: bold;
  font-size: 1.2rem;
}

.app-content {
  flex: 1;
  padding: 1.5rem;
  background-color: #f5f5f5;
  overflow-y: auto;
}

.app-footer {
  background-color: #2c3e50;
  color: white;
  text-align: center;
  padding: 1rem;
  font-size: 0.8rem;
}
</style>
