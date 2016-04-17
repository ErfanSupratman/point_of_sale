$(document).ready(function() {

	 $.get('Invoice/countAllStates', {}, function(data) {
            /*$('#pendingBadge').text(data);*/
            $('#bookingBadge').text(0);
            $('#pendingBadge').text(0);
            $('#finishedBadge').text(0);
            for (var key in data) {
                if (data[key].state == 0) {
                    $('#bookingBadge').text(data[key].total);
                } else if (data[key].state == 1) {
                    $('#pendingBadge').text(data[key].total);
                } else if (data[key].state == 2) {
                    $('#finishedBadge').text(data[key].total);
                }

            }
        }, 'json');
});