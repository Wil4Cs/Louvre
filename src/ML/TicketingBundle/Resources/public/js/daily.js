$(function () {
    var today = new Date();
    var todayDate = today.toLocaleDateString();
    var todayTime = today.toLocaleTimeString();
    var selectedDate = $('#ml_ticketingbundle_bill_visitDay');
    var timeParameter = null;

    // Ask  parameters.json to know closing time and store it in timeParameter
    $.ajax({
        'async': false,
        'dataType': 'json',
        'url': "../../data/parameters.json",
        'success': function (data) {
            timeParameter = data;
        },
        error: function () {
            alert('La requête n\'a pas abouti');
        }
    });

    // Check the today date & time and disable or not the daily ticket
    $(selectedDate).change(function () {
        if (selectedDate.val() === todayDate && todayTime >= timeParameter.closingTime) {
            $('#ml_ticketingbundle_bill_daily_0').prop('disabled', true);
            $('#ml_ticketingbundle_bill_daily_1').prop('checked', true);
        } else {
            $('#ml_ticketingbundle_bill_daily_0').prop('disabled', false);
            $('#ml_ticketingbundle_bill_daily_1').prop('checked', false);
        }
    });
});

