# Real-time WebSocket Integration Setup Guide

This guide will help you set up the real-time WebSocket features for your Laravel application.

## 🚀 Quick Setup

### 1. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

### 2. Configure Environment

Add these variables to your `.env` file:

```env
# Broadcasting Configuration
BROADCAST_DRIVER=pusher

# Pusher Configuration (you can use Pusher or a local alternative)
PUSHER_APP_ID=your_app_id
PUSHER_APP_KEY=your_app_key
PUSHER_APP_SECRET=your_app_secret
PUSHER_HOST=
PUSHER_PORT=443
PUSHER_SCHEME=https
PUSHER_APP_CLUSTER=mt1

# Vite Environment Variables
VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
VITE_PUSHER_HOST="${PUSHER_HOST}"
VITE_PUSHER_PORT="${PUSHER_PORT}"
VITE_PUSHER_SCHEME="${PUSHER_SCHEME}"
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
```

### 3. Set Up Pusher Account (Option 1 - Recommended for Production)

1. Go to [Pusher.com](https://pusher.com) and create a free account
2. Create a new app in your Pusher dashboard
3. Copy the app credentials to your `.env` file
4. Enable client events in your Pusher app settings

### 4. Use Local WebSocket Server (Option 2 - For Development)

For local development, you can use Laravel WebSockets:

```bash
# Install Laravel WebSockets
composer require beyondcode/laravel-websockets

# Publish the config
php artisan vendor:publish --provider="BeyondCode\LaravelWebSockets\WebSocketsServiceProvider" --tag="config"

# Update your .env for local WebSockets
PUSHER_HOST=127.0.0.1
PUSHER_PORT=6001
PUSHER_SCHEME=http
```

### 5. Build Assets

```bash
# Build the frontend assets
npm run build

# Or for development with hot reload
npm run dev
```

### 6. Start the Application

```bash
# Start Laravel
php artisan serve

# If using Laravel WebSockets, start the WebSocket server
php artisan websockets:serve

# Start the queue worker (important for real-time events)
php artisan queue:work
```

## 🎯 Features Included

### ✅ Real-time Leaderboard Updates
- Automatic rank updates when users gain points
- Live position changes with smooth animations
- Real-time point updates

### ✅ Live Notification System
- Instant notifications for achievements, level-ups, and challenges
- Browser push notifications (with user permission)
- Toast notifications with auto-dismiss
- Notification dropdown updates

### ✅ Real-time Activity Tracking
- Live activity feed updates
- User action broadcasting
- Activity graph updates

### ✅ Instant Challenge Completion Updates
- Real-time progress bar updates
- Challenge completion notifications
- Progress synchronization across devices

## 🔧 How It Works

### Broadcasting Events

The system uses Laravel's broadcasting feature with these events:

1. **LeaderboardUpdated** - Broadcasts when user rankings change
2. **RealTimeNotification** - Sends instant notifications
3. **ActivityTracked** - Tracks user activities in real-time
4. **ChallengeProgressUpdated** - Updates challenge progress

### Frontend Integration

The JavaScript real-time manager (`resources/js/realtime.js`) handles:

- WebSocket connection management
- Event listening and processing
- UI updates and animations
- Connection status monitoring

### Backend Services

The `RealTimeService` class provides methods to:

- Broadcast leaderboard updates
- Send notifications
- Track activities
- Update challenge progress

## 🎨 Customization

### Adding New Real-time Features

1. **Create a new event:**
```php
php artisan make:event YourCustomEvent
```

2. **Implement ShouldBroadcast interface:**
```php
class YourCustomEvent implements ShouldBroadcast
{
    // Implementation
}
```

3. **Add frontend handling:**
```javascript
window.realTimeManager.onCustomEvent((data) => {
    // Handle the event
});
```

### Styling Real-time Elements

The CSS includes animations for:
- Connection status indicators
- Rank update animations
- Progress bar updates
- Notification pulses

## 🐛 Troubleshooting

### Common Issues

1. **WebSocket connection fails:**
   - Check your Pusher credentials
   - Verify firewall settings
   - Ensure queue worker is running

2. **Events not broadcasting:**
   - Check `BROADCAST_DRIVER` is set to `pusher`
   - Verify queue worker is processing jobs
   - Check Laravel logs for errors

3. **Frontend not receiving events:**
   - Verify Vite environment variables
   - Check browser console for errors
   - Ensure user is authenticated for private channels

### Debug Mode

Enable debug mode by adding to your `.env`:
```env
PUSHER_APP_DEBUG=true
```

## 📱 Mobile Considerations

The real-time features are optimized for mobile:
- Reduced animation duration on mobile devices
- Touch-friendly notification interactions
- Responsive connection status indicators

## 🔒 Security

- Private channels require authentication
- User-specific notifications use private channels
- Public channels (leaderboard) are read-only for students
- CSRF protection for all API endpoints

## 📊 Performance

- Events are queued for better performance
- Leaderboard data is cached
- Connection pooling for WebSocket connections
- Automatic reconnection on connection loss

## 🚀 Production Deployment

For production deployment:

1. Use a proper WebSocket service (Pusher, Ably, or self-hosted)
2. Configure SSL/TLS for secure connections
3. Set up proper queue workers with supervisord
4. Monitor WebSocket connection health
5. Implement rate limiting for events

## 📝 Testing

Test the real-time features:

1. Open multiple browser windows/tabs
2. Perform actions in one window
3. Verify updates appear in other windows
4. Check notification delivery
5. Test connection recovery after network issues

---

🎉 **Congratulations!** Your real-time WebSocket integration is now ready!

For support or questions, check the Laravel Broadcasting documentation or create an issue in the project repository.
