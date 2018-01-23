$(function () {

    // Add an readonly attribute on date field to disable input by keyboard
    $('#ml_ticketingbundle_bill_visitDay').attr('readonly', 'readonly');

    function ajaxCall() {
        var dataObject = null;
        // Ask  parameters.json for the date picker and store it in dataObject
        $.ajax({
            'async': false,
            'dataType': 'json',
            'url': "../../data/parameters.json",
            'success': function (data) {
                dataObject = data;
            },
            error: function () {
                alert('La requête n\'a pas abouti');
            }
        });
        return dataObject;
    }

    // Configure the date picker
    $('.datepicker').datepicker({
        duration: "fast",
        dateFormat: "dd/mm/yy",
        firstDay: 1,
        monthNames: ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"],
        dayNamesMin: ["Dim", "Lun", "Mar", "Mer", "Jeu", "Ven", "Sam"],
        prevText: "Précédent",
        nextText: "Suivant",
        numberOfMonths: [1, 2],
        minDate: 0,
        maxDate: "+1y +1m",
        showAnim: "clip",
        stepMonths: 2,
        currentText: "Aujourd'hui",
        closeText: "Fermé",
        beforeShowDay: function (date) {
            // Return the name of the weekday (not just a number):
            var weekDay = new Array(7);
            weekDay[0] = "dimanche";
            weekDay[1] = "lundi";
            weekDay[2] = "mardi";
            weekDay[3] = "mercredi";
            weekDay[4] = "jeudi";
            weekDay[5] = "vendredi";
            weekDay[6] = "samedi";
            var currentWeekDay = weekDay[date.getDay()];

            // Return the date in 2 digit format dd-mm. E.g. 01/01 for the 1st january instead of 1/1
            var dayMonth = ('0' + date.getDate()).slice(-2) + '/' + ('0' + (date.getMonth() + 1)).slice(-2);

            var pickerParameters = ajaxCall();
            // Check if date(s) && week day(s) exist to disable it in the date picker
            // It returns -1 when it doesn't find a match, O when match.
            if ($.inArray(dayMonth, pickerParameters.datesOff) < 0 && $.inArray(currentWeekDay, pickerParameters.daysOff) < 0) {
                return [true, "", "Réserver!"];
            } else {
                return [false, "", ""];
            }
        }
    });
});
