/**
 * InvestSmart - Investment Strategy Game for ABM Students
 *
 * This file registers the main InvestSmart Vue component and its dependencies.
 */

import { createApp } from 'vue';
import TestComponent from './TestComponent.vue';
import App from './App.vue';

// We're using CDN for Highcharts now, so we don't need to import it here

// Initialize the component when the DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    console.log('InvestSmart: DOM content loaded');

    // Check if the element exists in the DOM
    const el = document.getElementById('invest-smart-app');
    console.log('InvestSmart: App container found:', !!el);

    if (!el) {
        console.error('InvestSmart: Could not find #invest-smart-app element');
        return;
    }

    try {
        console.log('InvestSmart: Creating Vue app');

        // Now that we know Vue is working, let's use the main App component
        const app = createApp(App);

        // Add error handler
        app.config.errorHandler = (err, vm, info) => {
            console.error('InvestSmart Vue Error:', err);
            console.error('Component:', vm);
            console.error('Error Info:', info);
        };

        console.log('InvestSmart: Mounting main app to #invest-smart-app');
        app.mount('#invest-smart-app');
        console.log('InvestSmart: Main app mounted successfully');
    } catch (error) {
        console.error('InvestSmart: Error initializing Vue app:', error);
    }
});

