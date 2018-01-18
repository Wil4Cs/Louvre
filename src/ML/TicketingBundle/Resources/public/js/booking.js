$(function () {

    // Some selectors
    var tickets = $('#ml_ticketingbundle_bill_ticket_number');
    var container = $('div#ml_ticketingbundle_bill_tickets');
    var visitDaySelector = $('#ml_ticketingbundle_bill_visitDay');

    // Find how many ticket(s) are displayed
    var displayedTicket = container.find(':input').length;

    // Enable the number of tickets selector when a date of visit is selected
    // This remove the temporary message
    $(visitDaySelector).one('change', function () {
        tickets.prop('disabled', false);
        $('.temporary').remove();
    });

    // Launch Jquery Validator Form
    $(tickets).click(function () {
        $.validate();
    });

    // Add or delete ticket(s) depending the select value and adjust the basket's price
    $(tickets).change(function () {

        // Var nbTickets contains the number of tickets selected
        var selectedTickets = tickets.val();
        var totalPrice;
        var difference;

        // Add or delete ticket(s)
        if (selectedTickets > displayedTicket) {
            difference = selectedTickets - displayedTicket;
            for (var i = 0; i < difference; i++) {
                addTicket(container);
            }
        } else {
            difference = displayedTicket - selectedTickets;
            for (var i = 0; i < difference; i++) {
                deleteTicket(container);
            }
        }

        // The birthday date selector for each ticket.
        var birthdaySelector = $('[id$="birthday"]');
        //Add a readonly attribute on each
        birthdaySelector.attr('readonly', 'readonly');

        // Configuration of the date picker
        $('.birthDatePicker').datepicker({
            dateFormat: "dd/mm/yy",
            maxDate: 0,
            minDate: "-110y",
            duration: "fast",
            monthNames: ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"],
            monthNamesShort: ["JAN", "FÉV", "MAR", "AVR", "MAI", "JUN", "JUL", "AOU", "SEP", "OCT", "NOV", "DÉC"],
            dayNamesMin: ["Dim", "Lun", "Mar", "Mer", "Jeu", "Ven", "Sam"],
            showAnim: "clip",
            firstDay: 1,
            changeYear: true,
            changeMonth: true,
            yearRange: "c-110:c+30",
            prevText: "Précédent",
            nextText: "Suivant"
        });

        // Count the basket's price when a birth date is selected on a ticket
        $(birthdaySelector).change(function () {
            totalPrice = countTotalPrice();
            $('#basket').text(totalPrice);
        });

        // Count the basket's price depending the value of reduction's radio buttons
        $('[id$="reduction"]').change(function () {
            totalPrice = countTotalPrice();
            $('#basket').text(totalPrice);
        });

        totalPrice = countTotalPrice();

        $('#basket').text(totalPrice);
    });

    function addTicket(container) {
        // Name each ticket with a different number
        var template = container.attr('data-prototype')
            .replace(/__name__label__/g, 'Billet n°' + (displayedTicket + 1))
            .replace(/__name__/g, displayedTicket)
            .replace(/form-group/, 'col-sm-push-1 col-sm-5 ticket')
        ;

        var prototype = $(template);
        container.append(prototype);
        displayedTicket++;
    }

    function deleteTicket(container) {
        // Select the last element, remove it and adjust index
        var template = container.children('div').last();
        template.remove();
        displayedTicket--;
    }

    function countTotalPrice() {
        var basketPrice = 0;
        var visitDate = visitDaySelector.val();
        for (var i = 0; i < displayedTicket; i++) {
            var birthDate = $('#ml_ticketingbundle_bill_tickets_' + i + '_birthday').val();
            var age = countAge(visitDate,birthDate);
            if (birthDate !== "") {
                basketPrice += selectTicketPrice(i,age);
            }
        }
        return basketPrice;
    }

    function countAge(visitDate, birthDate) {
        var today = splitDate(visitDate);
        var birth = splitDate(birthDate);
        var age;
        if (today['month'] > birth['month'] || today['month'] === birth['month'] && today['day'] >= birth['day']) {
            age = today['year'] - birth['year'];
        } else {
            age = today['year'] - birth['year'] - 1;
        }
        return age;
    }

    function splitDate(date) {
        var arrayDate = {
            'day'   : date.slice(0, 2),
            'month' : date.slice(3, 5),
            'year'  : date.slice(6, 10)
        };
        return arrayDate;
    }

    function selectTicketPrice(index,age) {
        // Some selectors
        var reduction = $('#ml_ticketingbundle_bill_tickets_'+ index +'_reduction_0'),
            noReduction = $('#ml_ticketingbundle_bill_tickets_'+ index +'_reduction_1');

        var json = ajaxCall();

        // Find the price depending the age && disabled or enabled the reduced radio button
        if (age < json.ticket.normal.age) {
            if (reduction.is(':enabled')) {
                reduction.prop('disabled', true);
                noReduction.prop('checked', true);
            }
            if (age < json.ticket.teenager.age) {
                return json.ticket.baby.price;
            } else {
                return json.ticket.teenager.price;
            }
        } else {
            if (reduction.is(':disabled')) {
                reduction.prop('disabled', false);
            }
            if (reduction.is(':checked') === true) {
                return json.ticket.reduced.price;
            } else if (age < json.ticket.senior.age) {
                return json.ticket.normal.price;
            } else {
                return json.ticket.senior.price;
            }
        }
    }

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
});
