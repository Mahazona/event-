jQuery(document).ready(function($) {
    // Handle RSVP form submission
    $('#sem-rsvp-form').on('submit', function(e) {
        e.preventDefault();
        
        var form = $(this);
        var submitBtn = form.find('button[type="submit"]');
        var messageContainer = $('#sem-rsvp-message');
        
        // Disable submit button
        submitBtn.prop('disabled', true).text('Processing...');
        
        // Clear previous messages
        messageContainer.empty();
        
        var formData = {
            action: 'sem_rsvp',
            event_id: form.find('input[name="event_id"]').val(),
            name: form.find('input[name="rsvp_name"]').val(),
            email: form.find('input[name="rsvp_email"]').val(),
            nonce: sem_ajax.nonce
        };
        
        $.ajax({
            url: sem_ajax.ajax_url,
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    messageContainer.html('<div class="sem-rsvp-message sem-rsvp-success">' + response.data + '</div>');
                    form[0].reset();
                } else {
                    messageContainer.html('<div class="sem-rsvp-message sem-rsvp-error">' + response.data + '</div>');
                }
            },
            error: function() {
                messageContainer.html('<div class="sem-rsvp-message sem-rsvp-error">An error occurred. Please try again.</div>');
            },
            complete: function() {
                submitBtn.prop('disabled', false).text('RSVP Now');
                
                // Scroll to message
                $('html, body').animate({
                    scrollTop: messageContainer.offset().top - 100
                }, 500);
            }
        });
    });
    
    // Add smooth scrolling to event links
    $('a[href*="#"]').on('click', function(e) {
        var target = $(this.hash);
        if (target.length) {
            e.preventDefault();
            $('html, body').animate({
                scrollTop: target.offset().top - 100
            }, 500);
        }
    });
});