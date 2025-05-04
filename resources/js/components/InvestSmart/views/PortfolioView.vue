<template>
  <div class="portfolio-view">
    <div class="portfolio-header">
      <h2>Your Investment Portfolio</h2>
      <div class="portfolio-summary">
        <div class="summary-card">
          <h3>Total Value</h3>
          <p class="value">₱{{ formatNumber(totalPortfolioValue) }}</p>
        </div>
        <div class="summary-card">
          <h3>Total Gain/Loss</h3>
          <p class="value" :class="totalGainLoss >= 0 ? 'positive' : 'negative'">
            ₱{{ formatNumber(totalGainLoss) }}
            <span class="percentage">({{ totalGainLossPercentage }}%)</span>
          </p>
        </div>
        <div class="summary-card">
          <h3>Available Cash</h3>
          <p class="value">₱{{ formatNumber(balance) }}</p>
        </div>
      </div>
    </div>

    <div class="portfolio-allocation" v-if="portfolio.length > 0">
      <h3>Asset Allocation</h3>
      <div ref="allocationChart" class="allocation-chart"></div>
    </div>

    <div class="portfolio-holdings">
      <h3>Your Holdings</h3>
      <div v-if="portfolio.length === 0" class="empty-portfolio">
        <p>You don't have any investments yet. Visit the Market to start investing!</p>
        <button class="primary-button" @click="goToMarket">Explore Market</button>
      </div>
      <table v-else class="holdings-table">
        <thead>
          <tr>
            <th>Symbol</th>
            <th>Name</th>
            <th>Shares</th>
            <th>Avg. Price</th>
            <th>Current Price</th>
            <th>Market Value</th>
            <th>Gain/Loss</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="stock in portfolio" :key="stock.symbol">
            <td>{{ stock.symbol }}</td>
            <td>{{ stock.name }}</td>
            <td>{{ stock.quantity }}</td>
            <td>₱{{ formatNumber(stock.averagePrice) }}</td>
            <td>₱{{ formatNumber(stock.currentPrice) }}</td>
            <td>₱{{ formatNumber(stock.quantity * stock.currentPrice) }}</td>
            <td :class="getGainLoss(stock) >= 0 ? 'positive' : 'negative'">
              ₱{{ formatNumber(getGainLoss(stock)) }}
              <span class="percentage">({{ getGainLossPercentage(stock) }}%)</span>
            </td>
            <td>
              <button class="action-button sell" @click="openSellModal(stock)">Sell</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Sell Modal (hidden by default) -->
    <div class="modal" v-if="showSellModal">
      <div class="modal-content">
        <span class="close" @click="showSellModal = false">&times;</span>
        <h3>Sell {{ selectedStock.symbol }}</h3>
        <p>Current Price: ₱{{ formatNumber(selectedStock.currentPrice) }}</p>
        <p>Shares Owned: {{ selectedStock.quantity }}</p>

        <div class="form-group">
          <label for="sellQuantity">Quantity to Sell:</label>
          <input
            type="number"
            id="sellQuantity"
            v-model.number="sellQuantity"
            min="1"
            :max="selectedStock.quantity"
          >
        </div>

        <div class="form-group">
          <label>Total Sale Value:</label>
          <p class="sale-value">₱{{ formatNumber(sellQuantity * selectedStock.currentPrice) }}</p>
        </div>

        <div class="modal-actions">
          <button class="cancel-button" @click="showSellModal = false">Cancel</button>
          <button class="confirm-button" @click="confirmSell">Confirm Sale</button>
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

export default {
  name: 'PortfolioView',
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
      showSellModal: false,
      showConfirmationModal: false,
      confirmationMessage: '',
      selectedStock: {},
      sellQuantity: 1,
      allocationChart: null
    };
  },
  computed: {
    totalPortfolioValue() {
      try {
        // Calculate the value of all stocks in the portfolio
        const holdingsValue = this.portfolio.reduce((total, stock) => {
          // Ensure all values are properly converted to numbers
          const quantity = Number(stock.quantity) || 0;
          const price = Number(stock.currentPrice) || 0;
          return total + (quantity * price);
        }, 0);

        // Add the cash balance (ensure it's a number)
        const totalValue = holdingsValue + Number(this.balance);

        // Check if the result is a valid number
        if (isNaN(totalValue)) {
          console.error('Invalid total value calculation:', {
            holdingsValue,
            balance: this.balance,
            portfolio: this.portfolio
          });
          return 0; // Return 0 instead of NaN
        }

        return totalValue;
      } catch (error) {
        console.error('Error calculating total portfolio value:', error);
        return 0; // Return 0 in case of any error
      }
    },
    totalGainLoss() {
      try {
        return this.portfolio.reduce((total, stock) => {
          const gainLoss = this.getGainLoss(stock);
          return total + (isNaN(gainLoss) ? 0 : gainLoss);
        }, 0);
      } catch (error) {
        console.error('Error calculating total gain/loss:', error);
        return 0;
      }
    },
    totalGainLossPercentage() {
      try {
        const totalCost = this.portfolio.reduce((total, stock) => {
          return total + (Number(stock.totalCost) || 0);
        }, 0);

        if (totalCost === 0) return '0.00';

        const percentage = (this.totalGainLoss / totalCost) * 100;
        return isNaN(percentage) ? '0.00' : percentage.toFixed(2);
      } catch (error) {
        console.error('Error calculating total gain/loss percentage:', error);
        return '0.00';
      }
    }
  },
  methods: {
    formatNumber(num) {
      // Ensure we're working with a number and not a string
      const numValue = Number(num);
      // Format the number without the currency symbol
      return numValue.toLocaleString('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    },
    getGainLoss(stock) {
      try {
        // Ensure all values are properly converted to numbers
        const currentPrice = Number(stock.currentPrice) || 0;
        const quantity = Number(stock.quantity) || 0;
        const totalCost = Number(stock.totalCost) || 0;

        return (currentPrice * quantity) - totalCost;
      } catch (error) {
        console.error('Error calculating gain/loss for stock:', stock, error);
        return 0;
      }
    },
    getGainLossPercentage(stock) {
      try {
        const totalCost = Number(stock.totalCost) || 0;
        if (totalCost === 0) return '0.00';

        const gainLoss = this.getGainLoss(stock);
        const percentage = (gainLoss / totalCost) * 100;

        return isNaN(percentage) ? '0.00' : percentage.toFixed(2);
      } catch (error) {
        console.error('Error calculating gain/loss percentage for stock:', stock, error);
        return '0.00';
      }
    },
    goToMarket() {
      this.$emit('change-view', 'market');
    },
    openSellModal(stock) {
      this.selectedStock = stock;
      this.sellQuantity = 1;
      this.showSellModal = true;
    },
    async confirmSell() {
      if (this.sellQuantity <= 0 || this.sellQuantity > this.selectedStock.quantity) {
        alert('Please enter a valid quantity.');
        return;
      }

      // Close the sell modal first
      this.showSellModal = false;

      // Store the sale details for the confirmation message
      const quantity = this.sellQuantity;
      const symbol = this.selectedStock.symbol;
      const saleValue = quantity * this.selectedStock.currentPrice;

      try {
        // Emit the sell-stock event
        this.$emit('sell-stock', this.selectedStock, quantity, this.selectedStock.currentPrice);

        // Show confirmation modal with details
        this.confirmationMessage = `Successfully sold ${quantity} shares of ${symbol} for ₱${this.formatNumber(saleValue)}.`;
        this.showConfirmationModal = true;
        this.updateAllocationChart();
      } catch (error) {
        console.error('Error during sale:', error);
        alert('There was an error processing your sale. Please try again.');
      }
    },
    updateAllocationChart() {
      if (this.portfolio.length === 0) {
        if (this.allocationChart) {
          this.allocationChart.destroy();
          this.allocationChart = null;
        }
        return;
      }

      // Prepare data for the chart
      const chartData = this.portfolio.map(stock => ({
        name: stock.symbol,
        y: stock.quantity * stock.currentPrice
      }));

      // Add cash as part of allocation
      chartData.push({
        name: 'Cash',
        y: this.balance
      });

      // Create or update chart
      if (this.allocationChart) {
        this.allocationChart.series[0].setData(chartData);
      } else {
        this.$nextTick(() => {
          this.allocationChart = Highcharts.chart(this.$refs.allocationChart, {
            chart: {
              type: 'pie'
            },
            title: {
              text: 'Portfolio Allocation'
            },
            tooltip: {
              pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            credits: {
              enabled: false // Remove the Highcharts.com text
            },
            plotOptions: {
              pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                  enabled: true,
                  format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                }
              }
            },
            series: [{
              name: 'Allocation',
              colorByPoint: true,
              data: chartData
            }]
          });
        });
      }
    }
  },
  mounted() {
    this.updateAllocationChart();
  },
  updated() {
    this.updateAllocationChart();
  }
};
</script>

<style scoped>
.portfolio-view {
  max-width: 1200px;
  margin: 0 auto;
}

.portfolio-header {
  margin-bottom: 2rem;
}

.portfolio-summary {
  display: flex;
  gap: 1.5rem;
  margin-top: 1rem;
}

.summary-card {
  background-color: white;
  border-radius: 8px;
  padding: 1.5rem;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  flex: 1;
}

.summary-card h3 {
  margin-top: 0;
  font-size: 1rem;
  color: #666;
}

.value {
  font-size: 1.5rem;
  font-weight: bold;
  margin: 0;
}

.positive {
  color: #4caf50;
}

.negative {
  color: #f44336;
}

.percentage {
  font-size: 0.9rem;
  opacity: 0.8;
}

.portfolio-allocation {
  background-color: white;
  border-radius: 8px;
  padding: 1.5rem;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  margin-bottom: 2rem;
}

.allocation-chart {
  height: 300px;
}

.portfolio-holdings {
  background-color: white;
  border-radius: 8px;
  padding: 1.5rem;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.empty-portfolio {
  text-align: center;
  padding: 3rem 0;
}

.primary-button {
  background-color: #3498db;
  color: white;
  border: none;
  padding: 0.75rem 1.5rem;
  border-radius: 4px;
  cursor: pointer;
  font-weight: bold;
  margin-top: 1rem;
}

.holdings-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 1rem;
}

.holdings-table th, .holdings-table td {
  padding: 0.75rem;
  text-align: left;
  border-bottom: 1px solid #eee;
}

.holdings-table th {
  background-color: #f9f9f9;
  font-weight: bold;
}

.action-button {
  border: none;
  padding: 0.5rem 1rem;
  border-radius: 4px;
  cursor: pointer;
  font-weight: bold;
}

.action-button.sell {
  background-color: #f44336;
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
}

.close {
  position: absolute;
  top: 1rem;
  right: 1rem;
  font-size: 1.5rem;
  cursor: pointer;
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

.sale-value {
  font-size: 1.25rem;
  font-weight: bold;
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
