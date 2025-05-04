<template>
  <div class="learn-view">
    <div class="learn-header">
      <h2>Investment Learning Center</h2>
      <p class="subtitle">Enhance your investment knowledge with these educational resources</p>
    </div>

    <div class="learn-categories">
      <div 
        v-for="category in categories" 
        :key="category.id"
        class="category-card"
        :class="{ active: activeCategory === category.id }"
        @click="activeCategory = category.id"
      >
        <div class="category-icon" v-html="category.icon"></div>
        <h3>{{ category.name }}</h3>
      </div>
    </div>

    <div class="learn-content">
      <div v-if="activeCategory === 'basics'" class="content-section">
        <h3>Investment Basics</h3>
        
        <div class="article-card">
          <h4>What is the Stock Market?</h4>
          <p>The stock market is a collection of markets where stocks (pieces of ownership in businesses) are traded. It's a way for companies to raise money and for investors to potentially make profits.</p>
          <button class="read-more-btn">Read More</button>
        </div>
        
        <div class="article-card">
          <h4>Understanding Risk and Return</h4>
          <p>All investments involve some degree of risk. Generally, the higher the potential return, the higher the risk. Understanding this relationship is crucial for making informed investment decisions.</p>
          <button class="read-more-btn">Read More</button>
        </div>
        
        <div class="article-card">
          <h4>Types of Investment Assets</h4>
          <p>There are many types of investment assets including stocks, bonds, mutual funds, ETFs, real estate, and more. Each has different characteristics, risks, and potential returns.</p>
          <button class="read-more-btn">Read More</button>
        </div>
      </div>

      <div v-if="activeCategory === 'strategies'" class="content-section">
        <h3>Investment Strategies</h3>
        
        <div class="article-card">
          <h4>Value Investing</h4>
          <p>Value investing involves buying stocks that appear to be undervalued based on fundamental analysis. Value investors look for companies trading below their intrinsic value.</p>
          <button class="read-more-btn">Read More</button>
        </div>
        
        <div class="article-card">
          <h4>Growth Investing</h4>
          <p>Growth investing focuses on companies expected to grow at an above-average rate compared to other companies. Growth investors often look at factors like revenue growth and market expansion.</p>
          <button class="read-more-btn">Read More</button>
        </div>
        
        <div class="article-card">
          <h4>Dividend Investing</h4>
          <p>Dividend investing involves buying stocks of companies that pay regular dividends. This strategy can provide a steady income stream while potentially benefiting from stock price appreciation.</p>
          <button class="read-more-btn">Read More</button>
        </div>
      </div>

      <div v-if="activeCategory === 'analysis'" class="content-section">
        <h3>Financial Analysis</h3>
        
        <div class="article-card">
          <h4>Fundamental Analysis</h4>
          <p>Fundamental analysis involves evaluating a company's financial health by examining financial statements, industry conditions, and economic factors to determine its intrinsic value.</p>
          <button class="read-more-btn">Read More</button>
        </div>
        
        <div class="article-card">
          <h4>Technical Analysis</h4>
          <p>Technical analysis involves studying price movements and trading volumes to identify patterns and trends that might indicate future price movements.</p>
          <button class="read-more-btn">Read More</button>
        </div>
        
        <div class="article-card">
          <h4>Key Financial Ratios</h4>
          <p>Financial ratios like P/E ratio, debt-to-equity, and return on equity help investors evaluate a company's performance, financial health, and valuation.</p>
          <button class="read-more-btn">Read More</button>
        </div>
      </div>

      <div v-if="activeCategory === 'portfolio'" class="content-section">
        <h3>Portfolio Management</h3>
        
        <div class="article-card">
          <h4>Diversification</h4>
          <p>Diversification involves spreading investments across various asset classes to reduce risk. It's based on the principle that different assets perform differently under various market conditions.</p>
          <button class="read-more-btn">Read More</button>
        </div>
        
        <div class="article-card">
          <h4>Asset Allocation</h4>
          <p>Asset allocation is the process of dividing investments among different asset categories like stocks, bonds, and cash. The right allocation depends on your goals, risk tolerance, and time horizon.</p>
          <button class="read-more-btn">Read More</button>
        </div>
        
        <div class="article-card">
          <h4>Rebalancing Your Portfolio</h4>
          <p>Rebalancing involves periodically buying or selling assets to maintain your desired asset allocation. It helps manage risk and can potentially improve returns over time.</p>
          <button class="read-more-btn">Read More</button>
        </div>
      </div>

      <div v-if="activeCategory === 'glossary'" class="content-section">
        <h3>Financial Glossary</h3>
        
        <div class="glossary-search">
          <input 
            type="text" 
            v-model="glossarySearch" 
            placeholder="Search financial terms..."
            @input="filterGlossaryTerms"
          >
        </div>
        
        <div class="glossary-list">
          <div v-for="term in filteredGlossaryTerms" :key="term.term" class="glossary-term">
            <h4>{{ term.term }}</h4>
            <p>{{ term.definition }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'LearnView',
  data() {
    return {
      activeCategory: 'basics',
      glossarySearch: '',
      categories: [
        {
          id: 'basics',
          name: 'Investment Basics',
          icon: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>'
        },
        {
          id: 'strategies',
          name: 'Investment Strategies',
          icon: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>'
        },
        {
          id: 'analysis',
          name: 'Financial Analysis',
          icon: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>'
        },
        {
          id: 'portfolio',
          name: 'Portfolio Management',
          icon: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>'
        },
        {
          id: 'glossary',
          name: 'Financial Glossary',
          icon: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>'
        }
      ],
      glossaryTerms: [
        { term: 'Asset', definition: 'Anything of value owned by a person or organization that can be converted to cash.' },
        { term: 'Bear Market', definition: 'A market condition in which stock prices are falling and widespread pessimism causes the negative sentiment to be self-sustaining.' },
        { term: 'Bull Market', definition: 'A market condition in which stock prices are rising or expected to rise.' },
        { term: 'Dividend', definition: 'A portion of a company\'s earnings paid to shareholders, usually on a quarterly basis.' },
        { term: 'ETF (Exchange-Traded Fund)', definition: 'A type of investment fund that is traded on stock exchanges, similar to stocks.' },
        { term: 'Fundamental Analysis', definition: 'A method of evaluating a security by measuring its intrinsic value by examining related economic, financial, and other qualitative and quantitative factors.' },
        { term: 'Market Capitalization', definition: 'The total market value of a company\'s outstanding shares, calculated by multiplying the stock price by the total number of shares outstanding.' },
        { term: 'P/E Ratio (Price-to-Earnings Ratio)', definition: 'A valuation ratio of a company\'s current share price compared to its per-share earnings.' },
        { term: 'Portfolio', definition: 'A collection of financial investments like stocks, bonds, commodities, cash, and cash equivalents.' },
        { term: 'Volatility', definition: 'A statistical measure of the dispersion of returns for a given security or market index.' }
      ],
      filteredGlossaryTerms: []
    };
  },
  methods: {
    filterGlossaryTerms() {
      if (!this.glossarySearch) {
        this.filteredGlossaryTerms = this.glossaryTerms;
        return;
      }
      
      const search = this.glossarySearch.toLowerCase();
      this.filteredGlossaryTerms = this.glossaryTerms.filter(term => 
        term.term.toLowerCase().includes(search) || 
        term.definition.toLowerCase().includes(search)
      );
    }
  },
  mounted() {
    this.filteredGlossaryTerms = this.glossaryTerms;
  }
};
</script>

<style scoped>
.learn-view {
  max-width: 1200px;
  margin: 0 auto;
}

.learn-header {
  margin-bottom: 2rem;
  text-align: center;
}

.subtitle {
  color: #666;
  font-size: 1.1rem;
}

.learn-categories {
  display: flex;
  gap: 1rem;
  margin-bottom: 2rem;
  overflow-x: auto;
  padding-bottom: 0.5rem;
}

.category-card {
  background-color: white;
  border-radius: 8px;
  padding: 1.5rem;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  min-width: 150px;
  text-align: center;
  cursor: pointer;
  transition: all 0.3s ease;
}

.category-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.category-card.active {
  background-color: #3498db;
  color: white;
}

.category-icon {
  margin-bottom: 1rem;
}

.category-card.active .category-icon {
  color: white;
}

.category-card h3 {
  margin: 0;
  font-size: 1rem;
}

.learn-content {
  background-color: white;
  border-radius: 8px;
  padding: 2rem;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.content-section h3 {
  margin-top: 0;
  margin-bottom: 1.5rem;
  font-size: 1.5rem;
}

.article-card {
  border: 1px solid #eee;
  border-radius: 8px;
  padding: 1.5rem;
  margin-bottom: 1.5rem;
}

.article-card h4 {
  margin-top: 0;
  margin-bottom: 0.5rem;
  font-size: 1.2rem;
}

.article-card p {
  color: #666;
  margin-bottom: 1rem;
}

.read-more-btn {
  background-color: #3498db;
  color: white;
  border: none;
  padding: 0.5rem 1rem;
  border-radius: 4px;
  cursor: pointer;
  font-weight: bold;
}

.glossary-search {
  margin-bottom: 1.5rem;
}

.glossary-search input {
  width: 100%;
  padding: 0.75rem;
  border: 1px solid #ddd;
  border-radius: 4px;
}

.glossary-term {
  border-bottom: 1px solid #eee;
  padding: 1rem 0;
}

.glossary-term h4 {
  margin-top: 0;
  margin-bottom: 0.5rem;
  font-size: 1.1rem;
}

.glossary-term p {
  color: #666;
  margin: 0;
}
</style>
