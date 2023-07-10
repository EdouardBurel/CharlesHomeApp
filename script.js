$(document).ready(function() {
    $('#concern').change(function() {
        var selectedOption = $(this).val();
        
        if (selectedOption === 'other') {
            $('#other-description').show();
            $('#submit-btn').show();
        } else {
            $('#other-description').hide();
            $('#submit-btn').hide();
        }
        
        var text = '';
        
        switch (selectedOption) {
            case 'no-hot-water':
                text = 'Please contact our maintenance team for assistance with the hot water issue.';
                break;
            case 'cannot-access':
                text = 'If you are unable to access the apartment, please reach out to our support team.';
                break;
            case 'washing-machine-issue':
                text = 'To report an issue with the washing machine, kindly submit a maintenance request.';
                break;
            case 'apartment-leak':
                text = 'If there is a leak in the apartment, please inform our maintenance team immediately.';
                break;
            default:
                break;
        }
        
        $('#concern-text').text(text);
    });
    
    $('#submit-btn').click(function(event) {
        event.preventDefault();
        var description = $('#issue-description').val();
        if (description.trim() !== '') {
            // Send the message via email
            var email = 'bureledo@gmail.com';
            var subject = 'Issue Description - ' + apartmentName + ' - ' + reservationName + ' | Charles Home';
            var body = 'Issue description: ' + description;
            var mailtoLink = 'mailto:' + email + '?subject=' + encodeURIComponent(subject) + '&body=' + encodeURIComponent(body);
            window.location.href = mailtoLink;
        }
    });
});

/*
var text = $apartmentName;
var $imageName = text.toLowerCase().replace(/\s/g, '');
console.log(variable); */