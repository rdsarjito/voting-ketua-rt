import './bootstrap';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

// Configure Pusher
window.Pusher = Pusher;

// Configure Echo
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1',
    wsHost: import.meta.env.VITE_PUSHER_HOST ? import.meta.env.VITE_PUSHER_HOST : `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`,
    wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
    wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
    forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
    enabledTransports: ['ws', 'wss'],
});

// Listen for vote cast events
window.Echo.channel('voting-updates')
    .listen('.vote.cast', (e) => {
        console.log('Vote cast:', e);
        
        // Show notification
        if (e.user_name && e.candidate_name && e.category_name) {
            showNotification(
                'Vote Baru!',
                `${e.user_name} memilih ${e.candidate_name} untuk ${e.category_name}`,
                'success'
            );
        }
    })
    .listen('.voting.period.changed', (e) => {
        console.log('Voting period changed:', e);
        
        // Show notification
        if (e.category_name && e.action) {
            showNotification(
                'Periode Voting Diubah',
                `Periode voting ${e.category_name} telah ${e.action}`,
                'info'
            );
        }
    });

// Listen for admin notifications
window.Echo.private('admin-notifications')
    .listen('.vote.cast', (e) => {
        console.log('Admin notification - Vote cast:', e);
        
        // Show admin-specific notification
        if (e.user_name && e.candidate_name && e.category_name) {
            showNotification(
                'Admin: Vote Baru',
                `${e.user_name} memilih ${e.candidate_name} untuk ${e.category_name}`,
                'warning'
            );
        }
    });

// Notification function
function showNotification(title, message, type = 'info') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 max-w-sm w-full bg-white dark:bg-gray-800 border-l-4 ${
        type === 'success' ? 'border-green-500' : 
        type === 'warning' ? 'border-yellow-500' : 
        type === 'error' ? 'border-red-500' : 'border-blue-500'
    } shadow-lg rounded-lg p-4 transform translate-x-full transition-transform duration-300`;
    
    notification.innerHTML = `
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 ${
                    type === 'success' ? 'text-green-400' : 
                    type === 'warning' ? 'text-yellow-400' : 
                    type === 'error' ? 'text-red-400' : 'text-blue-400'
                }" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-900 dark:text-white">${title}</p>
                <p class="text-sm text-gray-500 dark:text-gray-300">${message}</p>
            </div>
            <div class="ml-auto pl-3">
                <button onclick="this.parentElement.parentElement.parentElement.remove()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </div>
    `;
    
    // Add to page
    document.body.appendChild(notification);
    
    // Animate in
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 100);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => {
            if (notification.parentElement) {
                notification.remove();
            }
        }, 300);
    }, 5000);
}

// Make notification function globally available
window.showNotification = showNotification;