jQuery(document).ready(function($) {
    // Initialize date picker if available
    if ($.fn.datepicker) {
        $('#event_date').datepicker({
            dateFormat: 'yy-mm-dd',
            minDate: 0
        });
    }
    
    // Auto-refresh RSVP count
    if ($('.sem-rsvp-list').length) {
        setInterval(function() {
            location.reload();
        }, 30000); // Refresh every 30 seconds
    }
});