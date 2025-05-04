<template>
  <div class="challenges-view">
    <div class="challenges-header">
      <h2>Investment Challenges</h2>
      <p class="subtitle">Complete challenges to test your investment skills and earn points</p>
    </div>

    <div class="challenges-tabs">
      <button
        @click="activeTab = 'available'"
        :class="{ active: activeTab === 'available' }"
      >
        Available Challenges
      </button>
      <button
        @click="activeTab = 'inProgress'"
        :class="{ active: activeTab === 'inProgress' }"
      >
        In Progress
      </button>
      <button
        @click="activeTab = 'completed'"
        :class="{ active: activeTab === 'completed' }"
      >
        Completed
      </button>
    </div>

    <div class="challenges-list">
      <div v-if="loading" class="loading-indicator">
        <p>Loading challenges...</p>
      </div>

      <div v-else-if="error && !availableChallenges.length" class="error-message">
        <p>{{ error }}</p>
        <button @click="fetchChallenges" class="retry-button">Retry</button>
      </div>

      <div v-else-if="filteredChallenges.length === 0" class="empty-challenges">
        <p v-if="activeTab === 'available'">No available challenges at the moment. Check back later!</p>
        <p v-else-if="activeTab === 'inProgress'">You don't have any challenges in progress.</p>
        <p v-else>You haven't completed any challenges yet.</p>
      </div>

      <div v-else class="challenge-cards">
        <div
          v-for="challenge in filteredChallenges"
          :key="challenge.id"
          class="challenge-card"
        >
          <div class="challenge-header">
            <h3>{{ challenge.title }}</h3>
            <div class="challenge-badge" :class="challenge.difficulty">
              {{ challenge.difficulty }}
            </div>
          </div>

          <p class="challenge-description">{{ challenge.description }}</p>

          <div class="challenge-details">
            <div class="detail">
              <span class="label">Duration:</span>
              <span>{{ challenge.duration }} days</span>
            </div>
            <div class="detail">
              <span class="label">Points:</span>
              <span>{{ challenge.points }}</span>
            </div>
            <div class="detail">
              <span class="label">Deadline:</span>
              <span>{{ formatDate(challenge.deadline) }}</span>
            </div>
          </div>

          <div class="challenge-progress" v-if="challenge.status === 'in-progress'">
            <div class="progress-bar">
              <div
                class="progress-fill"
                :style="{ width: `${challenge.progress}%` }"
              ></div>
            </div>
            <span class="progress-text">{{ challenge.progress }}% Complete</span>
          </div>

          <div class="challenge-actions">
            <!-- For available challenges, check if already completed or in progress -->
            <button
              v-if="challenge.status === 'available' && !isChallengeCompleted(challenge) && !isChallengeInProgress(challenge)"
              class="start-button"
              @click="startChallenge(challenge)"
            >
              Start Challenge
            </button>

            <!-- Show completed status for available challenges that are already completed -->
            <div
              v-else-if="challenge.status === 'available' && isChallengeCompleted(challenge)"
              class="challenge-completed-status"
            >
              <span class="completed-badge">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                  <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
                Challenge Completed
              </span>
              <button class="view-completed-button" @click="viewCompletedChallenges">View in Completed</button>
            </div>

            <!-- Show in progress status for available challenges that are in progress -->
            <div
              v-else-if="challenge.status === 'available' && isChallengeInProgress(challenge)"
              class="challenge-inprogress-status"
            >
              <span class="inprogress-badge">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <circle cx="12" cy="12" r="10"></circle>
                  <polyline points="12 6 12 12 16 14"></polyline>
                </svg>
                In Progress
              </span>
              <button class="view-inprogress-button" @click="activeTab = 'inProgress'">View Progress</button>
            </div>

            <!-- For challenges that are actually in progress -->
            <button
              v-else-if="challenge.status === 'in-progress'"
              class="continue-button"
              @click="continueChallenge(challenge)"
            >
              Continue
            </button>

            <!-- For completed challenges that need submission -->
            <div v-else-if="challenge.status === 'completed' && !challenge.submitted" class="completed-actions">
              <button class="submit-button" @click="openSubmitModal(challenge)">
                Submit Results
              </button>
              <button v-if="activeTab === 'completed'" class="restart-button" @click="confirmRestartChallenge(challenge)">
                Restart Challenge
              </button>
            </div>

            <!-- For submitted challenges -->
            <div
              v-else-if="challenge.status === 'completed' && challenge.submitted"
              class="submission-status"
            >
              <span class="status-badge" :class="challenge.grade ? 'graded' : 'pending'">
                {{ challenge.grade ? 'Graded' : 'Pending Review' }}
              </span>
              <span v-if="challenge.grade" class="grade">
                Grade: {{ challenge.grade }}/100
              </span>

              <!-- Add restart button for completed challenges in the Completed tab -->
              <button
                v-if="activeTab === 'completed' && !challenge.grade"
                class="restart-button"
                @click="confirmRestartChallenge(challenge)"
              >
                Restart Challenge
              </button>
            </div>


          </div>
        </div>
      </div>
    </div>

    <!-- Confirmation Modal -->
    <div class="modal" v-if="showConfirmationModal">
      <div class="modal-content confirmation-modal">
        <span class="close" @click="showConfirmationModal = false">&times;</span>
        <div class="confirmation-content">
          <div class="confirmation-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#4caf50" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
              <polyline points="22 4 12 14.01 9 11.01"></polyline>
            </svg>
          </div>
          <h3>Challenge Started!</h3>
          <p class="confirmation-message">{{ confirmationMessage }}</p>
          <button class="continue-button" @click="showConfirmationModal = false">Continue</button>
        </div>
      </div>
    </div>

    <!-- Challenge Completion Modal -->
    <div class="modal" v-if="showCompletionModal">
      <div class="modal-content completion-modal">
        <span class="close" @click="showCompletionModal = false">&times;</span>
        <div class="confirmation-content">
          <div class="confirmation-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#4caf50" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
              <polyline points="22 4 12 14.01 9 11.01"></polyline>
            </svg>
          </div>
          <h3>Challenge Completed!</h3>
          <p class="completion-message">{{ completionMessage }}</p>
          <p class="completion-tip">You can view your completed challenges in the <strong>Completed</strong> tab.</p>
          <div class="completion-actions">
            <button class="view-completed-button" @click="viewCompletedChallenges">View Completed Challenges</button>
            <button class="continue-button" @click="showCompletionModal = false">Continue</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Restart Challenge Confirmation Modal -->
    <div class="modal" v-if="showRestartModal">
      <div class="modal-content confirmation-modal">
        <span class="close" @click="showRestartModal = false">&times;</span>
        <div class="confirmation-content">
          <div class="confirmation-icon warning">
            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#ff9800" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
              <line x1="12" y1="9" x2="12" y2="13"></line>
              <line x1="12" y1="17" x2="12.01" y2="17"></line>
            </svg>
          </div>
          <h3>Restart Challenge?</h3>
          <p class="confirmation-message">Are you sure you want to restart "{{ selectedChallenge.title }}"?</p>
          <p class="warning-message">This will delete your current progress and you'll need to start over.</p>
          <div class="modal-actions">
            <button class="cancel-button" @click="showRestartModal = false">Cancel</button>
            <button class="restart-button" @click="restartChallenge">Yes, Restart Challenge</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Submit Challenge Modal -->
    <div class="modal" v-if="showSubmitModal">
      <div class="modal-content">
        <span class="close" @click="showSubmitModal = false">&times;</span>
        <h3>Submit Challenge: {{ selectedChallenge.title }}</h3>

        <div class="portfolio-snapshot">
          <h4>Portfolio Snapshot</h4>
          <table class="snapshot-table">
            <thead>
              <tr>
                <th>Symbol</th>
                <th>Shares</th>
                <th>Current Value</th>
                <th>Gain/Loss</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="stock in portfolio" :key="stock.symbol">
                <td>{{ stock.symbol }}</td>
                <td>{{ stock.quantity }}</td>
                <td>₱{{ formatNumber(stock.quantity * stock.currentPrice) }}</td>
                <td :class="getGainLoss(stock) >= 0 ? 'positive' : 'negative'">
                  ₱{{ formatNumber(getGainLoss(stock)) }}
                  ({{ getGainLossPercentage(stock) }}%)
                </td>
              </tr>
            </tbody>
            <tfoot>
              <tr>
                <td colspan="2"><strong>Total Portfolio Value:</strong></td>
                <td colspan="2"><strong>₱{{ formatNumber(totalPortfolioValue) }}</strong></td>
              </tr>
            </tfoot>
          </table>
        </div>

        <div class="form-group">
          <label for="strategy">Describe your investment strategy:</label>
          <textarea
            id="strategy"
            v-model="submissionForm.strategy"
            rows="4"
            placeholder="Explain the strategy you used for this challenge..."
          ></textarea>
        </div>

        <div class="form-group">
          <label for="learnings">What did you learn from this challenge?</label>
          <textarea
            id="learnings"
            v-model="submissionForm.learnings"
            rows="4"
            placeholder="Share your key learnings and insights..."
          ></textarea>
        </div>

        <div class="modal-actions">
          <button class="cancel-button" @click="showSubmitModal = false">Cancel</button>
          <button
            class="submit-button"
            @click="submitChallenge"
            :disabled="!submissionForm.strategy || !submissionForm.learnings"
          >
            Submit Challenge
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'ChallengesView',
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
      activeTab: 'available',
      availableChallenges: [],
      userChallenges: [],
      loading: false,
      error: null,
      showSubmitModal: false,
      showConfirmationModal: false,
      showCompletionModal: false,
      showRestartModal: false,
      confirmationMessage: '',
      completionMessage: '',
      selectedChallenge: {},
      submissionForm: {
        strategy: '',
        learnings: ''
      },
      previousChallengeStates: {}
    };
  },
  created() {
    // Fetch challenges when component is created
    this.fetchChallenges();
  },
  computed: {
    filteredChallenges() {
      switch (this.activeTab) {
        case 'available':
          // Show all available challenges, including completed ones
          return this.availableChallenges;
        case 'inProgress':
          return this.userChallenges.filter(c => c.status === 'in-progress');
        case 'completed':
          return this.userChallenges.filter(c => ['completed', 'submitted', 'graded'].includes(c.status));
        default:
          return [];
      }
    },
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
          console.error('Invalid total value calculation in challenges view');
          return 0; // Return 0 instead of NaN
        }

        return totalValue;
      } catch (error) {
        console.error('Error calculating total portfolio value in challenges view:', error);
        return 0; // Return 0 in case of any error
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
          console.error('Invalid number for formatting in challenges view:', num);
          return '0.00';
        }

        // Format the number with 2 decimal places
        return numValue.toLocaleString('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
      } catch (error) {
        console.error('Error formatting number in challenges view:', error);
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
          console.error('Invalid date in ChallengesView:', date);
          return 'N/A';
        }

        return dateObj.toLocaleDateString('en-PH', {
          year: 'numeric',
          month: 'short',
          day: 'numeric'
        });
      } catch (error) {
        console.error('Error formatting date in ChallengesView:', error, date);
        return 'N/A';
      }
    },
    getGainLoss(stock) {
      try {
        // Ensure all values are properly converted to numbers
        const currentPrice = Number(stock.currentPrice) || 0;
        const quantity = Number(stock.quantity) || 0;
        const totalCost = Number(stock.totalCost) || 0;

        return (currentPrice * quantity) - totalCost;
      } catch (error) {
        console.error('Error calculating gain/loss for stock in challenges view:', stock, error);
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
        console.error('Error calculating gain/loss percentage for stock in challenges view:', stock, error);
        return '0.00';
      }
    },
    // Check for newly completed challenges and show completion modal if needed
    checkForCompletedChallenges(updatedChallenges) {
      // If we don't have previous states to compare, just store current states
      if (Object.keys(this.previousChallengeStates).length === 0) {
        updatedChallenges.forEach(challenge => {
          this.previousChallengeStates[challenge.id] = {
            status: challenge.status,
            progress: challenge.progress
          };
        });
        return;
      }

      // Check for challenges that just completed
      const newlyCompleted = updatedChallenges.find(challenge => {
        const previousState = this.previousChallengeStates[challenge.id];

        // If we have a previous state and the challenge just changed to completed
        return previousState &&
               previousState.status !== 'completed' &&
               challenge.status === 'completed';
      });

      // If we found a newly completed challenge, show the completion modal
      if (newlyCompleted) {
        this.selectedChallenge = newlyCompleted;
        this.completionMessage = `Congratulations! You have successfully completed the "${newlyCompleted.title}" challenge.\n\nYou've earned ${newlyCompleted.points} points!`;
        this.showCompletionModal = true;
      }

      // Update previous states for next comparison
      updatedChallenges.forEach(challenge => {
        this.previousChallengeStates[challenge.id] = {
          status: challenge.status,
          progress: challenge.progress
        };
      });
    },

    // Check if a challenge is already completed
    isChallengeCompleted(challenge) {
      return this.userChallenges.some(userChallenge =>
        (userChallenge.challenge_id === challenge.id || userChallenge.title === challenge.title) &&
        ['completed', 'submitted', 'graded'].includes(userChallenge.status)
      );
    },

    // Check if a challenge is in progress
    isChallengeInProgress(challenge) {
      return this.userChallenges.some(userChallenge =>
        (userChallenge.challenge_id === challenge.id || userChallenge.title === challenge.title) &&
        userChallenge.status === 'in-progress'
      );
    },

    // Navigate to the completed challenges tab
    viewCompletedChallenges() {
      this.activeTab = 'completed';
      this.showCompletionModal = false;
    },

    async fetchChallenges() {
      return new Promise(async (resolve, reject) => {
        try {
          this.loading = true;
          this.error = null;
          console.log('Fetching challenges...');
          console.log('User authentication status:', !!document.querySelector('meta[name="user-id"]')?.getAttribute('content'));

          // Fetch available challenges
          const availableResponse = await fetch('/api/investment-challenges', {
            headers: {
              'Accept': 'application/json',
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
            },
            credentials: 'same-origin'
          });

          console.log('Available challenges response status:', availableResponse.status);

          if (!availableResponse.ok) {
            const errorText = await availableResponse.text();
            console.error('Failed to fetch available challenges:', errorText);
            throw new Error(`Failed to fetch available challenges: ${availableResponse.status}`);
          }

          const availableChallengesData = await availableResponse.json();
          console.log('Available challenges data:', availableChallengesData);

          // Add status property to available challenges
          this.availableChallenges = availableChallengesData.map(challenge => ({
            ...challenge,
            status: 'available'
          }));

          // Fetch user's challenges
          try {
            const userResponse = await fetch('/api/user-investment-challenges', {
              headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
              },
              credentials: 'same-origin'
            });

            console.log('User challenges response status:', userResponse.status);

            if (!userResponse.ok) {
              const errorText = await userResponse.text();
              console.error('Failed to fetch user challenges:', errorText);
              console.warn(`User challenges fetch failed with status: ${userResponse.status}`);
              this.userChallenges = [];
            } else {
              const userChallengesData = await userResponse.json();
              console.log('User challenges data:', userChallengesData);
              this.userChallenges = userChallengesData;
            }
          } catch (userError) {
            console.error('Error fetching user challenges:', userError);
            this.userChallenges = [];
          }

          // Store current challenge states before updating
          const currentChallenges = [...this.userChallenges];

          // Check for newly completed challenges
          this.checkForCompletedChallenges([...this.userChallenges]);

          // Resolve the promise with the challenges
          resolve({
            available: this.availableChallenges,
            user: this.userChallenges
          });

        } catch (error) {
          console.error('Error fetching challenges:', error);
          this.error = error.message;
          this.availableChallenges = [];
          this.userChallenges = [];
          reject(error);
        } finally {
          this.loading = false;
          console.log('Fetch completed. Available challenges:', this.availableChallenges.length, 'User challenges:', this.userChallenges.length);
        }
      });
    },

    async startChallenge(challenge) {
      try {
        this.loading = true;

        const response = await fetch('/api/investment-challenges/start', {
          method: 'POST',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          },
          body: JSON.stringify({ challenge_id: challenge.id }),
          credentials: 'same-origin'
        });

        if (!response.ok) {
          const errorData = await response.json();
          throw new Error(errorData.message || 'Failed to start challenge');
        }

        const data = await response.json();
        console.log('Challenge started:', data);
        console.log('User ID from meta tag:', document.querySelector('meta[name="user-id"]')?.getAttribute('content'));

        // Show confirmation modal
        this.showConfirmationModal = true;
        this.confirmationMessage = `Challenge "${challenge.title}" started successfully!\n\nYou have ${challenge.duration} days to complete it.`;

        // Refresh challenges
        await this.fetchChallenges();

        // Switch to the In Progress tab
        this.activeTab = 'inProgress';

        // Emit event to notify parent component
        this.$emit('challenge-started', data.challenge);
      } catch (error) {
        console.error('Error starting challenge:', error);
        alert(`There was an error starting the challenge: ${error.message}`);
      } finally {
        this.loading = false;
      }
    },
    continueChallenge(challenge) {
      try {
        // Calculate days remaining
        const today = new Date();
        const endDate = new Date(challenge.end_date);
        const daysRemaining = Math.ceil((endDate - today) / (1000 * 60 * 60 * 24));

        // Prepare challenge details message
        let message = `Challenge: ${challenge.title}\n`;
        message += `Progress: ${challenge.progress}%\n`;
        message += `Days Remaining: ${daysRemaining > 0 ? daysRemaining : 'Last day!'}\n\n`;
        message += `Requirements:\n${challenge.description}\n\n`;
        message += `Tip: Continue building your portfolio according to the challenge requirements.`;

        // Show challenge details in modal
        this.selectedChallenge = challenge;
        this.confirmationMessage = message;
        this.showConfirmationModal = true;

        // Emit event to notify parent component
        this.$emit('challenge-continued', challenge);
      } catch (error) {
        console.error('Error continuing challenge:', error);
        alert('There was an error loading the challenge details. Please try again.');
      }
    },
    openSubmitModal(challenge) {
      this.selectedChallenge = challenge;
      this.submissionForm = {
        strategy: '',
        learnings: ''
      };
      this.showSubmitModal = true;
    },
    // Show confirmation modal for restarting a challenge
    confirmRestartChallenge(challenge) {
      this.selectedChallenge = challenge;
      this.showRestartModal = true;
    },

    // Restart a challenge by deleting it and then starting it again
    async restartChallenge() {
      try {
        this.loading = true;

        // Delete the user challenge from the database
        const response = await fetch(`/api/user-investment-challenges/${this.selectedChallenge.id}`, {
          method: 'DELETE',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          },
          credentials: 'same-origin'
        });

        if (!response.ok) {
          const errorData = await response.json();
          throw new Error(errorData.message || 'Failed to delete challenge');
        }

        // Close the modal
        this.showRestartModal = false;

        // Refresh challenges
        await this.fetchChallenges();

        // Find the challenge in available challenges
        const availableChallenge = this.availableChallenges.find(c =>
          c.id === this.selectedChallenge.challenge_id
        );

        if (availableChallenge) {
          // Start the challenge again
          this.startChallenge(availableChallenge);
        }
      } catch (error) {
        console.error('Error restarting challenge:', error);
        alert(`There was an error restarting the challenge: ${error.message}`);
      } finally {
        this.loading = false;
      }
    },

    async submitChallenge() {
      if (!this.submissionForm.strategy || !this.submissionForm.learnings) {
        alert('Please fill out all fields before submitting.');
        return;
      }

      try {
        this.loading = true;

        const response = await fetch(`/api/user-investment-challenges/${this.selectedChallenge.id}/submit`, {
          method: 'POST',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          },
          body: JSON.stringify({
            strategy: this.submissionForm.strategy,
            learnings: this.submissionForm.learnings
          }),
          credentials: 'same-origin'
        });

        if (!response.ok) {
          const errorData = await response.json();
          throw new Error(errorData.message || 'Failed to submit challenge');
        }

        const data = await response.json();

        // Show success message
        alert('Challenge submitted successfully! Your submission is now pending review.');
        this.showSubmitModal = false;

        // Refresh challenges
        await this.fetchChallenges();

        // Switch to the Completed tab
        this.activeTab = 'completed';
      } catch (error) {
        console.error('Error submitting challenge:', error);
        alert(`There was an error submitting the challenge: ${error.message}`);
      } finally {
        this.loading = false;
      }
    }
  }
};
</script>

<style scoped>
.challenges-view {
  max-width: 1200px;
  margin: 0 auto;
}

.challenges-header {
  margin-bottom: 2rem;
  text-align: center;
}

.subtitle {
  color: #666;
  font-size: 1.1rem;
}

.challenges-tabs {
  display: flex;
  gap: 1rem;
  margin-bottom: 2rem;
}

.challenges-tabs button {
  background: none;
  border: none;
  padding: 0.75rem 1.5rem;
  border-radius: 4px;
  cursor: pointer;
  font-weight: bold;
  color: #666;
  transition: all 0.3s ease;
}

.challenges-tabs button:hover {
  background-color: #f0f0f0;
}

.challenges-tabs button.active {
  background-color: #3498db;
  color: white;
}

.empty-challenges {
  background-color: white;
  border-radius: 8px;
  padding: 3rem;
  text-align: center;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  color: #666;
}

.challenge-cards {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
  gap: 1.5rem;
}

.challenge-card {
  background-color: white;
  border-radius: 8px;
  padding: 1.5rem;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  display: flex;
  flex-direction: column;
}

.challenge-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  margin-bottom: 1rem;
}

.challenge-header h3 {
  margin: 0;
  font-size: 1.25rem;
}

.challenge-badge {
  padding: 0.25rem 0.75rem;
  border-radius: 4px;
  font-size: 0.8rem;
  font-weight: bold;
  text-transform: uppercase;
}

.challenge-badge.beginner {
  background-color: #4caf50;
  color: white;
}

.challenge-badge.intermediate {
  background-color: #ff9800;
  color: white;
}

.challenge-badge.advanced {
  background-color: #f44336;
  color: white;
}

.challenge-description {
  color: #666;
  margin-bottom: 1.5rem;
  flex-grow: 1;
}

.challenge-details {
  margin-bottom: 1.5rem;
}

.detail {
  display: flex;
  justify-content: space-between;
  margin-bottom: 0.5rem;
}

.label {
  font-weight: bold;
  color: #666;
}

.challenge-progress {
  margin-bottom: 1.5rem;
}

.progress-bar {
  height: 8px;
  background-color: #eee;
  border-radius: 4px;
  overflow: hidden;
  margin-bottom: 0.5rem;
}

.progress-fill {
  height: 100%;
  background-color: #3498db;
}

.progress-text {
  font-size: 0.9rem;
  color: #666;
}

.challenge-actions {
  margin-top: auto;
}

.start-button, .continue-button, .submit-button {
  width: 100%;
  padding: 0.75rem;
  border: none;
  border-radius: 4px;
  font-weight: bold;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.start-button {
  background-color: #3498db;
  color: white;
}

.start-button:hover {
  background-color: #2980b9;
}

.continue-button {
  background-color: #ff9800;
  color: white;
}

.continue-button:hover {
  background-color: #f57c00;
}

.submit-button {
  background-color: #4caf50;
  color: white;
}

.submit-button:hover {
  background-color: #388e3c;
}

.submission-status {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.status-badge {
  padding: 0.5rem 1rem;
  border-radius: 4px;
  font-weight: bold;
  margin-bottom: 0.5rem;
}

.status-badge.pending {
  background-color: #ff9800;
  color: white;
}

.status-badge.graded {
  background-color: #4caf50;
  color: white;
}

.grade {
  font-weight: bold;
  font-size: 1.1rem;
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
  max-width: 800px;
  position: relative;
  max-height: 90vh;
  overflow-y: auto;
}

.confirmation-modal {
  max-width: 400px;
  text-align: center;
  padding: 1.5rem;
}

.close {
  position: absolute;
  top: 0.75rem;
  right: 0.75rem;
  font-size: 1.25rem;
  cursor: pointer;
  color: #666;
}

.confirmation-content {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.confirmation-icon {
  margin-bottom: 0.75rem;
}

.confirmation-message {
  font-size: 1rem;
  margin: 0.75rem 0;
  color: #333;
  white-space: pre-line;
  line-height: 1.4;
}

.confirmation-modal h3, .completion-modal h3 {
  margin: 0.5rem 0;
  font-size: 1.5rem;
  color: #333;
}

.completion-message {
  font-size: 1.1rem;
  margin: 1rem 0;
  color: #333;
  white-space: pre-line;
  line-height: 1.5;
}

.completion-tip {
  font-size: 1rem;
  margin: 1rem 0;
  color: #666;
}

.completion-actions {
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
  width: 100%;
  max-width: 250px;
  margin-top: 1rem;
}

.view-completed-button {
  background-color: #3498db;
  color: white;
  border: none;
  padding: 0.75rem 1.5rem;
  border-radius: 4px;
  cursor: pointer;
  font-weight: bold;
  width: 100%;
}

.view-completed-button:hover {
  background-color: #2980b9;
}

.continue-button {
  background-color: #4caf50;
  color: white;
  border: none;
  padding: 0.75rem 1.5rem;
  border-radius: 4px;
  cursor: pointer;
  font-weight: bold;
  margin-top: 1rem;
  width: 100%;
  max-width: 200px;
}

.continue-button:hover {
  background-color: #388e3c;
}

.portfolio-snapshot {
  margin-bottom: 2rem;
}

.snapshot-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 1rem;
}

.snapshot-table th, .snapshot-table td {
  padding: 0.75rem;
  text-align: left;
  border-bottom: 1px solid #eee;
}

.snapshot-table th {
  background-color: #f9f9f9;
  font-weight: bold;
}

.snapshot-table tfoot td {
  font-weight: bold;
  border-top: 2px solid #ddd;
}

.positive {
  color: #4caf50;
}

.negative {
  color: #f44336;
}

.form-group {
  margin-bottom: 1.5rem;
}

.form-group label {
  display: block;
  margin-bottom: 0.5rem;
  font-weight: bold;
}

.form-group textarea {
  width: 100%;
  padding: 0.75rem;
  border: 1px solid #ddd;
  border-radius: 4px;
  resize: vertical;
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

.submit-button:disabled {
  background-color: #a5d6a7;
  cursor: not-allowed;
}

.loading-indicator {
  text-align: center;
  padding: 2rem;
  color: #666;
}

.error-message {
  text-align: center;
  padding: 2rem;
  color: #f44336;
}

.retry-button {
  background-color: #f44336;
  color: white;
  border: none;
  padding: 0.5rem 1rem;
  border-radius: 4px;
  margin-top: 1rem;
  cursor: pointer;
}

.retry-button:hover {
  background-color: #d32f2f;
}

/* Challenge status styles */
.challenge-completed-status,
.challenge-inprogress-status {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 0.75rem;
}

.completed-badge,
.inprogress-badge {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.5rem 1rem;
  border-radius: 4px;
  font-weight: bold;
}

.completed-badge {
  background-color: #4caf50;
  color: white;
}

.inprogress-badge {
  background-color: #ff9800;
  color: white;
}

.view-inprogress-button {
  background-color: #ff9800;
  color: white;
  border: none;
  padding: 0.5rem 1rem;
  border-radius: 4px;
  cursor: pointer;
  font-weight: bold;
  width: 100%;
}

.view-inprogress-button:hover {
  background-color: #f57c00;
}

.restart-button {
  background-color: #f44336;
  color: white;
  border: none;
  padding: 0.75rem 1.5rem;
  border-radius: 4px;
  cursor: pointer;
  font-weight: bold;
  margin-top: 0.75rem;
  width: 100%;
}

.restart-button:hover {
  background-color: #d32f2f;
}

.warning-message {
  color: #f44336;
  font-size: 0.9rem;
  margin: 0.5rem 0 1rem;
}

.confirmation-icon.warning svg {
  stroke: #ff9800;
}

.completed-actions {
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
  width: 100%;
}
</style>
