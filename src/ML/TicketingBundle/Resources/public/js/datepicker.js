$(function() {

    // Add an readonly attribute on date field to disable input by keyboard
    $('#ml_ticketingbundle_bill_visitDay').attr('readonly', 'readonly');

    var pickerParameters = null;

    // Ask  parameters for the date picker and store it in pickerParameters
    $.ajax({
        'async': false,
        'dataType': 'json',
        'url': "../../data/datepicker_parameters.json",
        'success': function (data) {
            pickerParameters = data; },
        error: function() {
            alert('La requête n\'a pas abouti');
        }
    });

    // Check the hour and return a value for the minDate date picker option
    // If the today's time is > than the time we choose, it disables the today's date
    function getHour() {
        var today = new Date();
        var todayTime = today.toLocaleTimeString();
        if (todayTime > pickerParameters.closingTime) {
            return "1"; // Add +1 day to minDate option
        } else {
            return "0";
        }
    }

    // Configure the datepicker
    $('.datepicker').datepicker({
        duration: pickerParameters.duration,
        dateFormat: pickerParameters.dateFormat,
        firstDay: 1,
        monthNames: pickerParameters.monthNames,
        dayNamesMin: pickerParameters.dayNamesMin,
        prevText: pickerParameters.prevText,
        nextText: pickerParameters.nextText,
        numberOfMonths: pickerParameters.numberOfMonths,
        minDate: getHour(),
        maxDate: pickerParameters.maxDate,
        showAnim: pickerParameters.showAnim,
        stepMonths: pickerParameters.stepMonths,
        currentText: pickerParameters.currentText,
        closeText: pickerParameters.closeText,
        beforeShowDay: function(date) {
            // Return the name of the weekday (not just a number):
            var weekDay = new Array(7);
            weekDay[0] =  "dimanche";
            weekDay[1] = "lundi";
            weekDay[2] = "mardi";
            weekDay[3] = "mercredi";
            weekDay[4] = "jeudi";
            weekDay[5] = "vendredi";
            weekDay[6] = "samedi";
            var currentWeekDay = weekDay[date.getDay()];

            // Return the date in 2 digit format dd-mm. E.g. 01-01 for the 1st january instead of 1-1
            var dayMonth = ('0' + date.getDate()).slice(-2) + '-' + ('0' + (date.getMonth()+1)).slice(-2);

            // Check if date(s) && week day(s) exist to disable it in the date picker
            if ($.inArray(dayMonth, pickerParameters.datesOff) < 0 && $.inArray(currentWeekDay, pickerParameters.daysOff) < 0) {
                return [true,"","Réserver!"];
            } else {
                return [false,"",""];
            }
        }
    });
});