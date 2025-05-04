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
    confirmBuy() {
      if (this.buyQuantity <= 0) {
        alert('Please enter a valid quantity.');
        return;
      }

      if (this.totalCost > this.balance) {
        alert('Insufficient funds to complete this purchase.');
        return;
      }

      const success = this.$emit('buy-stock', this.selectedStock, this.buyQuantity, this.selectedStock.price);

      if (success) {
        this.showBuyModal = false;
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
        this.stocks = [
          {
            symbol: 'SM',
            name: 'SM Investments Corporation',
            price: 952.50,
            change: 15.50,
            changePercent: 1.65,
            volume: 1245678,
            industry: 'Conglomerate',
            marketCap: 1142500000000,
            pe: 18.75,
            high52Week: 1050.00,
            low52Week: 850.00,
            dividendYield: 1.2,
            description: 'SM Investments Corporation is one of the largest conglomerates in the Philippines, with interests in retail, banking, and property development.'
          },
          {
            symbol: 'ALI',
            name: 'Ayala Land, Inc.',
            price: 32.80,
            change: -0.45,
            changePercent: -1.35,
            volume: 3567890,
            industry: 'Property',
            marketCap: 482500000000,
            pe: 15.20,
            high52Week: 38.50,
            low52Week: 28.60,
            dividendYield: 1.8,
            description: 'Ayala Land, Inc. is the real estate arm of the Ayala Corporation, one of the Philippines\' oldest and largest conglomerates. It develops residential, commercial, and industrial properties.'
          },
          {
            symbol: 'BDO',
            name: 'BDO Unibank, Inc.',
            price: 128.70,
            change: 2.30,
            changePercent: 1.82,
            volume: 987654,
            industry: 'Banking',
            marketCap: 563200000000,
            pe: 12.45,
            high52Week: 135.00,
            low52Week: 110.50,
            dividendYield: 2.5,
            description: 'BDO Unibank, Inc. is the largest bank in the Philippines by assets, offering a wide range of banking services including retail, corporate, and investment banking.'
          },
          {
            symbol: 'JFC',
            name: 'Jollibee Foods Corporation',
            price: 215.40,
            change: 5.60,
            changePercent: 2.67,
            volume: 456789,
            industry: 'Food & Beverage',
            marketCap: 235600000000,
            pe: 22.80,
            high52Week: 240.00,
            low52Week: 180.00,
            dividendYield: 1.1,
            description: 'Jollibee Foods Corporation is the largest fast food chain in the Philippines, operating multiple brands including Jollibee, Chowking, Greenwich, Red Ribbon, and Mang Inasal.'
          },
          {
            symbol: 'TEL',
            name: 'PLDT Inc.',
            price: 1275.00,
            change: -18.50,
            changePercent: -1.43,
            volume: 123456,
            industry: 'Telecommunications',
            marketCap: 275800000000,
            pe: 14.30,
            high52Week: 1450.00,
            low52Week: 1150.00,
            dividendYield: 4.2,
            description: 'PLDT Inc. is the largest telecommunications and digital services company in the Philippines, offering mobile, fixed-line, and internet services.'
          },
          {
            symbol: 'AC',
            name: 'Ayala Corporation',
            price: 845.00,
            change: 12.50,
            changePercent: 1.50,
            volume: 234567,
            industry: 'Conglomerate',
            marketCap: 528100000000,
            pe: 16.80,
            high52Week: 900.00,
            low52Week: 750.00,
            dividendYield: 1.5,
            description: 'Ayala Corporation is one of the oldest and largest conglomerates in the Philippines, with businesses in real estate, banking, telecommunications, water, power, and more.'
          },
          {
            symbol: 'MER',
            name: 'Manila Electric Company',
            price: 325.60,
            change: 4.20,
            changePercent: 1.31,
            volume: 345678,
            industry: 'Utilities',
            marketCap: 366700000000,
            pe: 13.50,
            high52Week: 350.00,
            low52Week: 280.00,
            dividendYield: 3.8,
            description: 'Manila Electric Company (Meralco) is the largest electric distribution company in the Philippines, serving Metro Manila and nearby provinces.'
          },
          {
            symbol: 'SECB',
            name: 'Security Bank Corporation',
            price: 145.80,
            change: -2.70,
            changePercent: -1.82,
            volume: 567890,
            industry: 'Banking',
            marketCap: 110500000000,
            pe: 10.20,
            high52Week: 165.00,
            low52Week: 130.00,
            dividendYield: 3.2,
            description: 'Security Bank Corporation is one of the leading universal banks in the Philippines, offering retail, wholesale, and investment banking services.'
          },
          {
            symbol: 'URC',
            name: 'Universal Robina Corporation',
            price: 142.50,
            change: 3.80,
            changePercent: 2.74,
            volume: 678901,
            industry: 'Food & Beverage',
            marketCap: 310200000000,
            pe: 19.60,
            high52Week: 160.00,
            low52Week: 125.00,
            dividendYield: 1.7,
            description: 'Universal Robina Corporation is one of the largest food and beverage companies in the Philippines, with operations across the Asia-Pacific region.'
          },
          {
            symbol: 'GLO',
            name: 'Globe Telecom, Inc.',
            price: 1980.00,
            change: 25.00,
            changePercent: 1.28,
            volume: 89012,
            industry: 'Telecommunications',
            marketCap: 264300000000,
            pe: 15.70,
            high52Week: 2100.00,
            low52Week: 1800.00,
            dividendYield: 5.1,
            description: 'Globe Telecom, Inc. is a major telecommunications provider in the Philippines, offering mobile, broadband, and fixed-line services.'
          }
        ];

        this.loading = false;
      }, 1000);
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
</style>
