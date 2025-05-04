<template>
  <div class="market-view">
    <div class="market-header">
      <h2>Stock Market</h2>
      <div class="search-filter">
        <div class="search-bar">
          <input
            type="text"
            v-model="searchQuery"
            placeholder="Search by symbol or company name"
            @input="filterStocks"
          >
        </div>
        <div class="filter-options">
          <select v-model="industryFilter" @change="filterStocks">
            <option value="">All Industries</option>
            <option v-for="industry in industries" :key="industry" :value="industry">
              {{ industry }}
            </option>
          </select>
        </div>
      </div>
    </div>

    <div class="market-indices">
      <div class="index-card">
        <h3>PSEi</h3>
        <p class="index-value">7,621.52</p>
        <p class="index-change positive">+45.23 (+0.60%)</p>
      </div>
      <div class="index-card">
        <h3>All Shares</h3>
        <p class="index-value">4,102.87</p>
        <p class="index-change positive">+18.65 (+0.46%)</p>
      </div>
      <div class="index-card">
        <h3>Financials</h3>
        <p class="index-value">1,892.34</p>
        <p class="index-change negative">-12.45 (-0.65%)</p>
      </div>
      <div class="index-card">
        <h3>Property</h3>
        <p class="index-value">3,245.78</p>
        <p class="index-change positive">+28.92 (+0.90%)</p>
      </div>
    </div>

    <div class="stock-list">
      <div v-if="loading" class="loading">
        <p>Loading market data...</p>
      </div>
      <div v-else-if="filteredStocks.length === 0" class="no-results">
        <p>No stocks found matching your search criteria.</p>
      </div>
      <table v-else class="stocks-table">
        <thead>
          <tr>
            <th @click="sortBy('symbol')">Symbol <span v-if="sortKey === 'symbol'" :class="sortOrder"></span></th>
            <th @click="sortBy('name')">Company Name <span v-if="sortKey === 'name'" :class="sortOrder"></span></th>
            <th @click="sortBy('price')">Price <span v-if="sortKey === 'price'" :class="sortOrder"></span></th>
            <th @click="sortBy('change')">Change <span v-if="sortKey === 'change'" :class="sortOrder"></span></th>
            <th @click="sortBy('changePercent')">% Change <span v-if="sortKey === 'changePercent'" :class="sortOrder"></span></th>
            <th @click="sortBy('volume')">Volume <span v-if="sortKey === 'volume'" :class="sortOrder"></span></th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="stock in sortedStocks" :key="stock.symbol">
            <td>{{ stock.symbol }}</td>
            <td>{{ stock.name }}</td>
            <td>₱{{ formatNumber(stock.price) }}</td>
            <td :class="stock.change >= 0 ? 'positive' : 'negative'">
              ₱{{ formatNumber(stock.change) }}
            </td>
            <td :class="stock.changePercent >= 0 ? 'positive' : 'negative'">
              {{ stock.changePercent >= 0 ? '+' : '' }}{{ stock.changePercent.toFixed(2) }}%
            </td>
            <td>{{ formatVolume(stock.volume) }}</td>
            <td>
              <button class="action-button view" @click="viewStockDetails(stock)">View</button>
              <button class="action-button buy" @click="openBuyModal(stock)">Buy</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Stock Detail Modal -->
    <div class="modal" v-if="showStockDetailModal">
      <div class="modal-content stock-detail-modal">
        <span class="close" @click="showStockDetailModal = false">&times;</span>
        <div class="stock-detail-header">
          <div>
            <h2>{{ selectedStock.name }} ({{ selectedStock.symbol }})</h2>
            <p class="stock-price">₱{{ formatNumber(selectedStock.price) }}
              <span :class="selectedStock.change >= 0 ? 'positive' : 'negative'">
                {{ selectedStock.change >= 0 ? '+' : '' }}{{ formatNumber(selectedStock.change) }}
                ({{ selectedStock.changePercent >= 0 ? '+' : '' }}{{ selectedStock.changePercent.toFixed(2) }}%)
              </span>
            </p>
          </div>
          <button class="buy-button" @click="openBuyModal(selectedStock)">Buy Stock</button>
        </div>

        <div class="stock-chart" ref="stockChart"></div>

        <div class="stock-info-grid">
          <div class="info-card">
            <h3>Market Cap</h3>
            <p>₱{{ formatLargeNumber(selectedStock.marketCap) }}</p>
          </div>
          <div class="info-card">
            <h3>P/E Ratio</h3>
            <p>{{ selectedStock.pe.toFixed(2) }}</p>
          </div>
          <div class="info-card">
            <h3>52-Week High</h3>
            <p>₱{{ formatNumber(selectedStock.high52Week) }}</p>
          </div>
          <div class="info-card">
            <h3>52-Week Low</h3>
            <p>₱{{ formatNumber(selectedStock.low52Week) }}</p>
          </div>
          <div class="info-card">
            <h3>Dividend Yield</h3>
            <p>{{ selectedStock.dividendYield.toFixed(2) }}%</p>
          </div>
          <div class="info-card">
            <h3>Volume</h3>
            <p>{{ formatVolume(selectedStock.volume) }}</p>
          </div>
        </div>

        <div class="company-info">
          <h3>About {{ selectedStock.name }}</h3>
          <p>{{ selectedStock.description }}</p>
        </div>
      </div>
    </div>

    <!-- Buy Modal -->
    <div class="modal" v-if="showBuyModal">
      <div class="modal-content">
        <span class="close" @click="showBuyModal = false">&times;</span>
        <h3>Buy {{ selectedStock.symbol }}</h3>
        <p>Current Price: ₱{{ formatNumber(selectedStock.price) }}</p>
        <p>Available Cash: ₱{{ formatNumber(balance) }}</p>

        <div class="form-group">
          <label for="buyQuantity">Quantity:</label>
          <input
            type="number"
            id="buyQuantity"
            v-model.number="buyQuantity"
            min="1"
            @input="updateTotalCost"
          >
        </div>

        <div class="form-group">
          <label>Total Cost:</label>
          <p class="total-cost">₱{{ formatNumber(totalCost) }}</p>
          <p v-if="totalCost > balance" class="error-message">
            Insufficient funds. You need ₱{{ formatNumber(totalCost - balance) }} more.
          </p>
        </div>

        <div class="modal-actions">
          <button class="cancel-button" @click="showBuyModal = false">Cancel</button>
          <button
            class="confirm-button"
            @click="confirmBuy"
            :disabled="totalCost > balance || buyQuantity <= 0"
          >
            Confirm Purchase
          </button>
        </div>
      </div>
    </div>

    <!-- Confirmation Modal -->
    <div class="modal" v-if="showConfirmationModal">
      <div class="modal-content confirmation-modal">
        <span class="close" @click="showConfirmationModal = false">&times;</span>
        <div class="confirmation-content">
          <div class="confirmation-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#4caf50" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
              <polyline points="22 4 12 14.01 9 11.01"></polyline>
            </svg>
          </div>
          <h3>Transaction Successful!</h3>
          <p class="confirmation-message">{{ confirmationMessage }}</p>
          <p class="confirmation-details">Your new balance: <span class="balance-highlight">₱{{ formatNumber(balance) }}</span></p>
          <button class="confirm-button" @click="showConfirmationModal = false">Continue</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
// Using global Highcharts from CDN
const Highcharts = window.Highcharts;
import axios from 'axios';

export default {
  name: 'MarketView',
  props: {
    balance: {
      type: Number,
      required: true
    }
  },
  data() {
    return {
      loading: true,
      stocks: [],
      searchQuery: '',
      industryFilter: '',
      sortKey: 'symbol',
      sortOrder: 'asc',
      showStockDetailModal: false,
      showBuyModal: false,
      showConfirmationModal: false,
      confirmationMessage: '',
      selectedStock: {},
      buyQuantity: 1,
      totalCost: 0,
      stockChart: null,
      priceUpdateTimer: null
    };
  },
  computed: {
    industries() {
      // Get unique industries from stocks
      const industries = [...new Set(this.stocks.map(stock => stock.industry))];
      return industries.sort();
    },
    filteredStocks() {
      return this.stocks.filter(stock => {
        const matchesSearch =
          stock.symbol.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
          stock.name.toLowerCase().includes(this.searchQuery.toLowerCase());

        const matchesIndustry =
          this.industryFilter === '' || stock.industry === this.industryFilter;

        return matchesSearch && matchesIndustry;
      });
    },
    sortedStocks() {
      const direction = this.sortOrder === 'asc' ? 1 : -1;
      return [...this.filteredStocks].sort((a, b) => {
        if (a[this.sortKey] < b[this.sortKey]) return -1 * direction;
        if (a[this.sortKey] > b[this.sortKey]) return 1 * direction;
        return 0;
      });
    }
  },
  methods: {
    formatNumber(num) {
      return num.toLocaleString('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    },
    formatLargeNumber(num) {
      if (num >= 1e12) {
        return (num / 1e12).toFixed(2) + 'T';
      } else if (num >= 1e9) {
        return (num / 1e9).toFixed(2) + 'B';
      } else if (num >= 1e6) {
        return (num / 1e6).toFixed(2) + 'M';
      } else {
        return num.toLocaleString('en-PH');
      }
    },
    formatVolume(volume) {
      return volume.toLocaleString('en-PH');
    },
    filterStocks() {
      // This method is called when search or filter changes
      // The filtering is handled by computed properties
    },
    sortBy(key) {
      if (this.sortKey === key) {
        this.sortOrder = this.sortOrder === 'asc' ? 'desc' : 'asc';
      } else {
        this.sortKey = key;
        this.sortOrder = 'asc';
      }
    },
    viewStockDetails(stock) {
      this.selectedStock = stock;
      this.showStockDetailModal = true;

      // Initialize chart after modal is shown
      this.$nextTick(() => {
        this.initStockChart();
      });
    },
    initStockChart() {
      // Generate some sample historical data
      const today = new Date();
      const data = [];

      if (this.selectedStock.historicalData) {
        // Use historical data from API if available
        data = this.selectedStock.historicalData;
      } else {
        // Generate sample data if not available
        for (let i = 365; i >= 0; i--) {
          try {
            const date = new Date();
            date.setDate(today.getDate() - i);

            // Validate date
            if (isNaN(date.getTime())) {
              console.error('Invalid date generated in chart data');
              continue;
            }

            // Base price with some randomness
            let basePrice = this.selectedStock.price * 0.7;
            // Add trend over time (generally upward)
            basePrice += (this.selectedStock.price - basePrice) * (1 - i/365);
            // Add some randomness
            const randomFactor = 0.98 + Math.random() * 0.04;
            const price = basePrice * randomFactor;

            data.push([date.getTime(), price]);
          } catch (error) {
            console.error('Error generating chart data point:', error);
          }
        }
      }

      // Create the chart
      if (this.stockChart) {
        this.stockChart.destroy();
      }

      this.stockChart = Highcharts.stockChart(this.$refs.stockChart, {
        rangeSelector: {
          selected: 1
        },
        title: {
          text: `${this.selectedStock.symbol} Stock Price`
        },
        credits: {
          enabled: false // Remove the Highcharts.com text
        },
        series: [{
          name: this.selectedStock.symbol,
          data: data,
          tooltip: {
            valueDecimals: 2,
            valuePrefix: '₱'
          }
        }]
      });
    },
    openBuyModal(stock) {
      this.selectedStock = stock;
      this.buyQuantity = 1;
      this.updateTotalCost();
      this.showBuyModal = true;

      // Close detail modal if open
      if (this.showStockDetailModal) {
        this.showStockDetailModal = false;
      }
    },
    updateTotalCost() {
      this.totalCost = this.buyQuantity * this.selectedStock.price;
    },
    async confirmBuy() {
      if (this.buyQuantity <= 0) {
        alert('Please enter a valid quantity.');
        return;
      }

      if (this.totalCost > this.balance) {
        alert('Insufficient funds to complete this purchase.');
        return;
      }

      // Close the buy modal first
      this.showBuyModal = false;

      // Store the purchase details for the confirmation message
      const quantity = this.buyQuantity;
      const symbol = this.selectedStock.symbol;
      const totalCost = this.totalCost;

      try {
        // Emit the buy-stock event
        this.$emit('buy-stock', this.selectedStock, quantity, this.selectedStock.price);

        // Show confirmation modal with details
        this.confirmationMessage = `Successfully purchased ${quantity} shares of ${symbol} for ₱${this.formatNumber(totalCost)}.`;
        this.showConfirmationModal = true;
      } catch (error) {
        console.error('Error during purchase:', error);
        alert('There was an error processing your purchase. Please try again.');
      }
    },
    updateStockPrices() {
      // Update stock prices with random fluctuations
      this.stocks.forEach(stock => {
        // Generate random price change between -2% and +2%
        const changePercent = (Math.random() * 4 - 2) / 100;

        // Calculate new price
        const oldPrice = stock.price;
        const newPrice = parseFloat((oldPrice * (1 + changePercent)).toFixed(2));

        // Update price and change values
        stock.change = parseFloat((newPrice - oldPrice).toFixed(2));
        stock.changePercent = parseFloat(((newPrice / oldPrice - 1) * 100).toFixed(2));
        stock.price = newPrice;

        // If this is the selected stock, update it too
        if (this.selectedStock.symbol === stock.symbol) {
          this.selectedStock.price = newPrice;
          this.selectedStock.change = stock.change;
          this.selectedStock.changePercent = stock.changePercent;

          // Update chart if visible
          if (this.showStockDetailModal && this.stockChart) {
            // Add a new point to the chart
            const series = this.stockChart.series[0];
            const lastPoint = series.data[series.data.length - 1];
            series.addPoint([new Date().getTime(), newPrice], true, false);
          }
        }
      });

      // Also update market indices
      const indices = document.querySelectorAll('.index-card');
      indices.forEach(index => {
        const valueEl = index.querySelector('.index-value');
        const changeEl = index.querySelector('.index-change');

        if (valueEl && changeEl) {
          // Generate random change for index
          const changePercent = (Math.random() * 3 - 1.5) / 100;
          const oldValue = parseFloat(valueEl.textContent.replace(/[^\d.]/g, ''));
          const newValue = parseFloat((oldValue * (1 + changePercent)).toFixed(2));
          const change = parseFloat((newValue - oldValue).toFixed(2));
          const changePercentFormatted = parseFloat((changePercent * 100).toFixed(2));

          // Update display
          valueEl.textContent = newValue.toLocaleString('en-PH', { minimumFractionDigits: 2 });
          changeEl.textContent = `${change >= 0 ? '+' : ''}${change.toLocaleString('en-PH', { minimumFractionDigits: 2 })} (${changePercentFormatted >= 0 ? '+' : ''}${changePercentFormatted}%)`;
          changeEl.className = `index-change ${change >= 0 ? 'positive' : 'negative'}`;
        }
      });

      console.log('Market prices updated at', new Date().toLocaleTimeString());
    },

    async loadStockData() {
      this.loading = true;

      try {
        // Fetch market data from API
        const response = await axios.get('/api/investsmart/market');

        // Map API response to match our component's expected format
        this.stocks = response.data.map(stock => ({
          symbol: stock.symbol,
          name: stock.name,
          price: parseFloat(stock.price),
          change: parseFloat(stock.change),
          changePercent: parseFloat(stock.change_percent),
          volume: stock.volume,
          industry: stock.industry,
          marketCap: parseFloat(stock.market_cap),
          pe: parseFloat(stock.pe),
          high52Week: parseFloat(stock.high_52_week),
          low52Week: parseFloat(stock.low_52_week),
          dividendYield: parseFloat(stock.dividend_yield),
          description: stock.description,
          historicalData: stock.historical_data ? JSON.parse(stock.historical_data) : null
        }));

        this.loading = false;
      } catch (error) {
        console.error('Error loading market data:', error);
        this.loading = false;
      }
    }
  },
  mounted() {
    this.loadStockData();

    // Start price update timer
    this.priceUpdateTimer = setInterval(() => {
      this.updateStockPrices();
    }, 8000); // Update every 8 seconds
  },

  beforeUnmount() {
    // Clean up timer
    if (this.priceUpdateTimer) {
      clearInterval(this.priceUpdateTimer);
    }

    // Destroy chart if it exists
    if (this.stockChart) {
      this.stockChart.destroy();
    }
  }
};
</script>

<style scoped>
.market-view {
  max-width: 1200px;
  margin: 0 auto;
}

.market-header {
  margin-bottom: 1.5rem;
}

.search-filter {
  display: flex;
  gap: 1rem;
  margin-top: 1rem;
}

.search-bar {
  flex: 1;
}

.search-bar input {
  width: 100%;
  padding: 0.75rem;
  border: 1px solid #ddd;
  border-radius: 4px;
}

.filter-options select {
  padding: 0.75rem;
  border: 1px solid #ddd;
  border-radius: 4px;
  min-width: 200px;
}

.market-indices {
  display: flex;
  gap: 1rem;
  margin-bottom: 2rem;
  overflow-x: auto;
  padding-bottom: 0.5rem;
}

.index-card {
  background-color: white;
  border-radius: 8px;
  padding: 1rem;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  min-width: 180px;
}

.index-card h3 {
  margin-top: 0;
  margin-bottom: 0.5rem;
  font-size: 1rem;
  color: #666;
}

.index-value {
  font-size: 1.25rem;
  font-weight: bold;
  margin: 0;
}

.index-change {
  margin: 0.25rem 0 0 0;
  font-size: 0.9rem;
}

.positive {
  color: #4caf50;
}

.negative {
  color: #f44336;
}

.stock-list {
  background-color: white;
  border-radius: 8px;
  padding: 1.5rem;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.loading, .no-results {
  text-align: center;
  padding: 3rem 0;
  color: #666;
}

.stocks-table {
  width: 100%;
  border-collapse: collapse;
}

.stocks-table th, .stocks-table td {
  padding: 0.75rem;
  text-align: left;
  border-bottom: 1px solid #eee;
}

.stocks-table th {
  background-color: #f9f9f9;
  font-weight: bold;
  cursor: pointer;
  position: relative;
}

.stocks-table th:hover {
  background-color: #f0f0f0;
}

.stocks-table th span {
  display: inline-block;
  width: 0;
  height: 0;
  margin-left: 0.5rem;
  vertical-align: middle;
}

.stocks-table th span.asc {
  border-left: 4px solid transparent;
  border-right: 4px solid transparent;
  border-bottom: 4px solid #333;
}

.stocks-table th span.desc {
  border-left: 4px solid transparent;
  border-right: 4px solid transparent;
  border-top: 4px solid #333;
}

.action-button {
  border: none;
  padding: 0.5rem;
  border-radius: 4px;
  cursor: pointer;
  font-weight: bold;
  margin-right: 0.5rem;
}

.action-button.view {
  background-color: #3498db;
  color: white;
}

.action-button.buy {
  background-color: #4caf50;
  color: white;
}

/* Modal styles */
.modal {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1000;
}

.modal-content {
  background-color: white;
  border-radius: 8px;
  padding: 2rem;
  width: 100%;
  max-width: 500px;
  position: relative;
  max-height: 90vh;
  overflow-y: auto;
}

.stock-detail-modal {
  max-width: 800px;
}

.close {
  position: absolute;
  top: 1rem;
  right: 1rem;
  font-size: 1.5rem;
  cursor: pointer;
}

.stock-detail-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  margin-bottom: 1.5rem;
}

.stock-price {
  font-size: 1.5rem;
  font-weight: bold;
  margin: 0.5rem 0 0 0;
}

.buy-button {
  background-color: #4caf50;
  color: white;
  border: none;
  padding: 0.75rem 1.5rem;
  border-radius: 4px;
  cursor: pointer;
  font-weight: bold;
}

.stock-chart {
  height: 400px;
  margin-bottom: 2rem;
}

.stock-info-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 1rem;
  margin-bottom: 2rem;
}

.info-card {
  background-color: #f9f9f9;
  border-radius: 8px;
  padding: 1rem;
}

.info-card h3 {
  margin-top: 0;
  font-size: 0.9rem;
  color: #666;
}

.info-card p {
  font-size: 1.1rem;
  font-weight: bold;
  margin: 0.5rem 0 0 0;
}

.company-info {
  margin-top: 1.5rem;
}

.company-info h3 {
  margin-top: 0;
}

.form-group {
  margin-bottom: 1.5rem;
}

.form-group label {
  display: block;
  margin-bottom: 0.5rem;
  font-weight: bold;
}

.form-group input {
  width: 100%;
  padding: 0.75rem;
  border: 1px solid #ddd;
  border-radius: 4px;
}

.total-cost {
  font-size: 1.25rem;
  font-weight: bold;
}

.error-message {
  color: #f44336;
  margin-top: 0.5rem;
}

.modal-actions {
  display: flex;
  justify-content: flex-end;
  gap: 1rem;
  margin-top: 1.5rem;
}

.cancel-button {
  background-color: #ddd;
  border: none;
  padding: 0.75rem 1.5rem;
  border-radius: 4px;
  cursor: pointer;
}

.confirm-button {
  background-color: #4caf50;
  color: white;
  border: none;
  padding: 0.75rem 1.5rem;
  border-radius: 4px;
  cursor: pointer;
  font-weight: bold;
}

.confirm-button:disabled {
  background-color: #a5d6a7;
  cursor: not-allowed;
}

/* Confirmation modal styles */
.confirmation-modal {
  max-width: 400px;
  text-align: center;
}

.confirmation-content {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.confirmation-icon {
  margin-bottom: 1rem;
}

.confirmation-message {
  font-size: 1.1rem;
  margin: 1rem 0;
}

.confirmation-details {
  margin-bottom: 1.5rem;
  font-size: 1rem;
}

.balance-highlight {
  font-weight: bold;
  color: #4caf50;
}
</style>
