<template>
  <div class="transactions-view">
    <div class="transactions-header">
      <h2>Transaction History</h2>
      <div class="filter-options">
        <select v-model="typeFilter" @change="applyFilters">
          <option value="">All Transactions</option>
          <option value="buy">Buy Orders</option>
          <option value="sell">Sell Orders</option>
        </select>
        <select v-model="symbolFilter" @change="applyFilters">
          <option value="">All Symbols</option>
          <option v-for="symbol in uniqueSymbols" :key="symbol" :value="symbol">
            {{ symbol }}
          </option>
        </select>
        <div class="date-range">
          <label>From:</label>
          <input type="date" v-model="startDate" @change="applyFilters">
          <label>To:</label>
          <input type="date" v-model="endDate" @change="applyFilters">
        </div>
      </div>
    </div>

    <div class="transactions-summary">
      <div class="summary-card">
        <h3>Total Transactions</h3>
        <p class="value">{{ filteredTransactions.length }}</p>
      </div>
      <div class="summary-card">
        <h3>Total Buy Orders</h3>
        <p class="value">{{ buyOrdersCount }}</p>
      </div>
      <div class="summary-card">
        <h3>Total Sell Orders</h3>
        <p class="value">{{ sellOrdersCount }}</p>
      </div>
      <div class="summary-card">
        <h3>Total Value</h3>
        <p class="value">₱{{ formatNumber(totalValue) }}</p>
      </div>
    </div>

    <div class="transactions-list">
      <div v-if="filteredTransactions.length === 0" class="empty-transactions">
        <p>No transactions found matching your filters.</p>
      </div>
      <table v-else class="transactions-table">
        <thead>
          <tr>
            <th @click="sortBy('date')">Date <span v-if="sortKey === 'date'" :class="sortOrder"></span></th>
            <th @click="sortBy('type')">Type <span v-if="sortKey === 'type'" :class="sortOrder"></span></th>
            <th @click="sortBy('symbol')">Symbol <span v-if="sortKey === 'symbol'" :class="sortOrder"></span></th>
            <th @click="sortBy('name')">Name <span v-if="sortKey === 'name'" :class="sortOrder"></span></th>
            <th @click="sortBy('quantity')">Quantity <span v-if="sortKey === 'quantity'" :class="sortOrder"></span></th>
            <th @click="sortBy('price')">Price <span v-if="sortKey === 'price'" :class="sortOrder"></span></th>
            <th @click="sortBy('total')">Total <span v-if="sortKey === 'total'" :class="sortOrder"></span></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(transaction, index) in sortedTransactions" :key="index" :class="transaction.type">
            <td>{{ formatDate(transaction.transaction_date) }}</td>
            <td>
              <span class="transaction-type" :class="transaction.type">
                {{ transaction.type === 'buy' ? 'Buy' : 'Sell' }}
              </span>
            </td>
            <td>{{ transaction.symbol }}</td>
            <td>{{ transaction.name }}</td>
            <td>{{ transaction.quantity }}</td>
            <td>₱{{ formatNumber(transaction.price) }}</td>
            <td>₱{{ formatNumber(transaction.total) }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
export default {
  name: 'TransactionsView',
  props: {
    transactions: {
      type: Array,
      required: true
    }
  },
  data() {
    return {
      typeFilter: '',
      symbolFilter: '',
      startDate: '',
      endDate: '',
      sortKey: 'date',
      sortOrder: 'desc'
    };
  },
  computed: {
    uniqueSymbols() {
      const symbols = [...new Set(this.transactions.map(t => t.symbol))];
      return symbols.sort();
    },
    filteredTransactions() {
      return this.transactions.filter(transaction => {
        // Type filter
        if (this.typeFilter && transaction.type !== this.typeFilter) {
          return false;
        }

        // Symbol filter
        if (this.symbolFilter && transaction.symbol !== this.symbolFilter) {
          return false;
        }

        // Date range filter
        if (this.startDate) {
          const transactionDate = new Date(transaction.transaction_date);
          const filterStartDate = new Date(this.startDate);
          if (transactionDate < filterStartDate) {
            return false;
          }
        }

        if (this.endDate) {
          const transactionDate = new Date(transaction.transaction_date);
          const filterEndDate = new Date(this.endDate);
          // Set end date to end of day
          filterEndDate.setHours(23, 59, 59, 999);
          if (transactionDate > filterEndDate) {
            return false;
          }
        }

        return true;
      });
    },
    sortedTransactions() {
      const direction = this.sortOrder === 'asc' ? 1 : -1;
      return [...this.filteredTransactions].sort((a, b) => {
        if (this.sortKey === 'date') {
          return direction * (new Date(a.transaction_date) - new Date(b.transaction_date));
        }

        if (a[this.sortKey] < b[this.sortKey]) return -1 * direction;
        if (a[this.sortKey] > b[this.sortKey]) return 1 * direction;
        return 0;
      });
    },
    buyOrdersCount() {
      return this.filteredTransactions.filter(t => t.type === 'buy').length;
    },
    sellOrdersCount() {
      return this.filteredTransactions.filter(t => t.type === 'sell').length;
    },
    totalValue() {
      try {
        // Calculate the sum of all transaction totals
        return this.filteredTransactions.reduce((sum, t) => {
          // Ensure we're adding numbers, not concatenating strings
          const transactionTotal = Number(t.total) || 0;
          return sum + transactionTotal;
        }, 0);
      } catch (error) {
        console.error('Error calculating total value:', error);
        return 0;
      }
    }
  },
  methods: {
    formatNumber(num) {
      try {
        // Ensure we're working with a number and not a string
        const numValue = Number(num);

        // Check if it's a valid number
        if (isNaN(numValue)) {
          console.error('Invalid number for formatting:', num);
          return '0.00';
        }

        // Format the number with 2 decimal places
        return numValue.toLocaleString('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
      } catch (error) {
        console.error('Error formatting number:', error);
        return '0.00';
      }
    },
    formatDate(date) {
      try {
        if (!date) return 'N/A';

        // Check if date is a valid date string or timestamp
        const dateObj = new Date(date);

        // Check if date is valid
        if (isNaN(dateObj.getTime())) {
          console.error('Invalid date:', date);
          return 'N/A';
        }

        return dateObj.toLocaleDateString('en-PH', {
          year: 'numeric',
          month: 'short',
          day: 'numeric',
          hour: '2-digit',
          minute: '2-digit'
        });
      } catch (error) {
        console.error('Error formatting date:', error, date);
        return 'N/A';
      }
    },
    applyFilters() {
      // This method is called when filters change
      // The filtering is handled by computed properties
    },
    sortBy(key) {
      if (this.sortKey === key) {
        this.sortOrder = this.sortOrder === 'asc' ? 'desc' : 'asc';
      } else {
        this.sortKey = key;
        this.sortOrder = 'desc';
      }
    }
  },
  mounted() {
    // Set default date range to last 30 days
    const today = new Date();
    const thirtyDaysAgo = new Date();
    thirtyDaysAgo.setDate(today.getDate() - 30);

    this.endDate = today.toISOString().split('T')[0];
    this.startDate = thirtyDaysAgo.toISOString().split('T')[0];
  }
};
</script>

<style scoped>
.transactions-view {
  max-width: 1200px;
  margin: 0 auto;
}

.transactions-header {
  margin-bottom: 1.5rem;
}

.filter-options {
  display: flex;
  flex-wrap: wrap;
  gap: 1rem;
  margin-top: 1rem;
}

.filter-options select {
  padding: 0.75rem;
  border: 1px solid #ddd;
  border-radius: 4px;
  min-width: 180px;
}

.date-range {
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.date-range input {
  padding: 0.75rem;
  border: 1px solid #ddd;
  border-radius: 4px;
}

.transactions-summary {
  display: flex;
  gap: 1rem;
  margin-bottom: 2rem;
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
  margin: 0.5rem 0 0 0;
}

.transactions-list {
  background-color: white;
  border-radius: 8px;
  padding: 1.5rem;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.empty-transactions {
  text-align: center;
  padding: 3rem 0;
  color: #666;
}

.transactions-table {
  width: 100%;
  border-collapse: collapse;
}

.transactions-table th, .transactions-table td {
  padding: 0.75rem;
  text-align: left;
  border-bottom: 1px solid #eee;
}

.transactions-table th {
  background-color: #f9f9f9;
  font-weight: bold;
  cursor: pointer;
  position: relative;
}

.transactions-table th:hover {
  background-color: #f0f0f0;
}

.transactions-table th span {
  display: inline-block;
  width: 0;
  height: 0;
  margin-left: 0.5rem;
  vertical-align: middle;
}

.transactions-table th span.asc {
  border-left: 4px solid transparent;
  border-right: 4px solid transparent;
  border-bottom: 4px solid #333;
}

.transactions-table th span.desc {
  border-left: 4px solid transparent;
  border-right: 4px solid transparent;
  border-top: 4px solid #333;
}

.transaction-type {
  display: inline-block;
  padding: 0.25rem 0.75rem;
  border-radius: 4px;
  font-weight: bold;
  text-align: center;
  min-width: 70px;
}

.transaction-type.buy {
  background-color: rgba(76, 175, 80, 0.1);
  color: #4caf50;
}

.transaction-type.sell {
  background-color: rgba(244, 67, 54, 0.1);
  color: #f44336;
}

tr.buy {
  background-color: rgba(76, 175, 80, 0.05);
}

tr.sell {
  background-color: rgba(244, 67, 54, 0.05);
}
</style>
