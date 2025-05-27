import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

// Configure Pusher
window.Pusher = Pusher;

// Initialize Laravel Echo
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1',
    wsHost: import.meta.env.VITE_PUSHER_HOST ? import.meta.env.VITE_PUSHER_HOST : `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusherapp.com`,
    wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
    wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
    forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
    enabledTransports: ['ws', 'wss'],
});

class RealTimeManager {
    constructor() {
        this.userId = null;
        this.isConnected = false;
        this.notificationCallbacks = [];
        this.leaderboardCallbacks = [];
        this.activityCallbacks = [];
        this.challengeCallbacks = [];
        
        this.init();
    }

    init() {
        // Get user ID from meta tag or global variable
        const userMeta = document.querySelector('meta[name="user-id"]');
        if (userMeta) {
            this.userId = userMeta.getAttribute('content');
        }

        if (this.userId) {
            this.setupPrivateChannels();
        }
        
        this.setupPublicChannels();
        this.setupConnectionHandlers();
    }

    setupPrivateChannels() {
        if (!this.userId) return;

        // Listen for personal notifications
        window.Echo.private(`user.${this.userId}`)
            .listen('.notification.new', (data) => {
                this.handleNotification(data);
            })
            .listen('.activity.tracked', (data) => {
                this.handleActivityUpdate(data);
            })
            .listen('.challenge.progress.updated', (data) => {
                this.handleChallengeProgress(data);
            });
    }

    setupPublicChannels() {
        // Listen for leaderboard updates
        window.Echo.channel('leaderboard')
            .listen('.leaderboard.updated', (data) => {
                this.handleLeaderboardUpdate(data);
            });

        // Listen for activity feed updates
        window.Echo.channel('activity-feed')
            .listen('.activity.tracked', (data) => {
                this.handlePublicActivity(data);
            });
    }

    setupConnectionHandlers() {
        window.Echo.connector.pusher.connection.bind('connected', () => {
            this.isConnected = true;
            console.log('Real-time connection established');
            this.showConnectionStatus('connected');
        });

        window.Echo.connector.pusher.connection.bind('disconnected', () => {
            this.isConnected = false;
            console.log('Real-time connection lost');
            this.showConnectionStatus('disconnected');
        });

        window.Echo.connector.pusher.connection.bind('error', (error) => {
            console.error('Real-time connection error:', error);
            this.showConnectionStatus('error');
        });
    }

    handleNotification(data) {
        console.log('New notification:', data);
        
        // Show browser notification if permission granted
        this.showBrowserNotification(data);
        
        // Update notification UI
        this.updateNotificationUI(data);
        
        // Call registered callbacks
        this.notificationCallbacks.forEach(callback => callback(data));
    }

    handleLeaderboardUpdate(data) {
        console.log('Leaderboard updated:', data);
        
        // Update leaderboard UI
        this.updateLeaderboardUI(data);
        
        // Call registered callbacks
        this.leaderboardCallbacks.forEach(callback => callback(data));
    }

    handleActivityUpdate(data) {
        console.log('Activity tracked:', data);
        
        // Update activity graph if visible
        this.updateActivityGraph(data);
        
        // Call registered callbacks
        this.activityCallbacks.forEach(callback => callback(data));
    }

    handleChallengeProgress(data) {
        console.log('Challenge progress updated:', data);
        
        // Update challenge progress UI
        this.updateChallengeProgressUI(data);
        
        // Call registered callbacks
        this.challengeCallbacks.forEach(callback => callback(data));
    }

    handlePublicActivity(data) {
        console.log('Public activity:', data);
        
        // Update public activity feed
        this.updatePublicActivityFeed(data);
    }

    showBrowserNotification(data) {
        if ('Notification' in window && Notification.permission === 'granted') {
            new Notification(data.title || 'New Notification', {
                body: data.message,
                icon: '/favicon.ico',
                tag: data.id,
            });
        }
    }

    updateNotificationUI(data) {
        // Update notification dropdown
        const notificationContainer = document.querySelector('[x-data*="notifications"]');
        if (notificationContainer && window.Alpine) {
            // Trigger Alpine.js update
            const alpineData = window.Alpine.$data(notificationContainer);
            if (alpineData && alpineData.notifications) {
                alpineData.notifications.unshift(data);
                
                // Update unread count
                const unreadCount = alpineData.notifications.filter(n => !n.read).length;
                this.updateNotificationBadge(unreadCount);
            }
        }
    }

    updateLeaderboardUI(data) {
        // Update leaderboard section
        const leaderboardContainer = document.querySelector('.leaderboard-container');
        if (leaderboardContainer) {
            // Animate rank changes
            this.animateLeaderboardChanges(data);
        }
    }

    updateActivityGraph(data) {
        // Update activity graph if it exists
        const activityGraph = document.querySelector('.activity-graph');
        if (activityGraph) {
            // Add new activity point
            this.addActivityPoint(data);
        }
    }

    updateChallengeProgressUI(data) {
        // Update challenge progress bars
        const challengeElement = document.querySelector(`[data-challenge-id="${data.challenge_id}"]`);
        if (challengeElement) {
            this.animateProgressUpdate(challengeElement, data.progress);
        }
    }

    updatePublicActivityFeed(data) {
        // Update public activity feed
        const activityFeed = document.querySelector('.activity-feed');
        if (activityFeed) {
            this.addActivityFeedItem(data);
        }
    }

    // Utility methods
    showConnectionStatus(status) {
        const statusElement = document.querySelector('.connection-status');
        if (statusElement) {
            statusElement.className = `connection-status ${status}`;
            statusElement.textContent = status === 'connected' ? 'Connected' : 
                                      status === 'disconnected' ? 'Disconnected' : 'Error';
        }
    }

    updateNotificationBadge(count) {
        const badge = document.querySelector('.notification-badge');
        if (badge) {
            badge.textContent = count;
            badge.style.display = count > 0 ? 'flex' : 'none';
        }
    }

    animateLeaderboardChanges(data) {
        // Animate leaderboard position changes
        data.leaderboard.forEach((entry, index) => {
            const element = document.querySelector(`[data-user-id="${entry.user_id}"]`);
            if (element) {
                // Add animation class
                element.classList.add('rank-updated');
                setTimeout(() => element.classList.remove('rank-updated'), 1000);
            }
        });
    }

    animateProgressUpdate(element, newProgress) {
        const progressBar = element.querySelector('.progress-bar');
        if (progressBar) {
            progressBar.style.width = `${newProgress}%`;
            progressBar.classList.add('progress-updated');
            setTimeout(() => progressBar.classList.remove('progress-updated'), 1000);
        }
    }

    addActivityPoint(data) {
        // Add new point to activity graph
        console.log('Adding activity point:', data);
    }

    addActivityFeedItem(data) {
        // Add new item to activity feed
        const feedContainer = document.querySelector('.activity-feed-items');
        if (feedContainer) {
            const item = this.createActivityFeedItem(data);
            feedContainer.insertBefore(item, feedContainer.firstChild);
        }
    }

    createActivityFeedItem(data) {
        const item = document.createElement('div');
        item.className = 'activity-feed-item';
        item.innerHTML = `
            <div class="activity-icon">${this.getActivityIcon(data.activity_type)}</div>
            <div class="activity-content">
                <span class="activity-user">${data.user_name}</span>
                <span class="activity-action">${this.getActivityText(data.activity_type)}</span>
                <span class="activity-time">${new Date(data.timestamp).toLocaleTimeString()}</span>
            </div>
        `;
        return item;
    }

    getActivityIcon(type) {
        const icons = {
            'login': '🔐',
            'task_completed': '✅',
            'challenge_completed': '🏆',
            'level_up': '⬆️',
            'achievement': '🎖️',
        };
        return icons[type] || '📝';
    }

    getActivityText(type) {
        const texts = {
            'login': 'logged in',
            'task_completed': 'completed a task',
            'challenge_completed': 'completed a challenge',
            'level_up': 'leveled up',
            'achievement': 'earned an achievement',
        };
        return texts[type] || 'performed an action';
    }

    // Public API methods
    onNotification(callback) {
        this.notificationCallbacks.push(callback);
    }

    onLeaderboardUpdate(callback) {
        this.leaderboardCallbacks.push(callback);
    }

    onActivity(callback) {
        this.activityCallbacks.push(callback);
    }

    onChallengeProgress(callback) {
        this.challengeCallbacks.push(callback);
    }

    requestNotificationPermission() {
        if ('Notification' in window && Notification.permission === 'default') {
            Notification.requestPermission();
        }
    }
}

// Initialize real-time manager
window.realTimeManager = new RealTimeManager();

// Request notification permission on page load
document.addEventListener('DOMContentLoaded', () => {
    window.realTimeManager.requestNotificationPermission();
});

export default RealTimeManager;
