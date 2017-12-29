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

        // The birthday date selector for each ticket. Add a readonly attribute on each
        var birthdaySelector = $('[id$="birthday"]').attr('readonly', 'readonly');

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
            yearRange: "c-30:c+30",
            prevText: "Précédent",
            nextText: "Suivant"
        });

        // Count the basket's price when a date is selected
        $(birthdaySelector).change(function () {
            totalPrice = countPrice();
            $('#basket').text(totalPrice);
        });

        totalPrice = countPrice();

        $('#basket').text(totalPrice);
    });

    function addTicket(container) {
        // Add a class depending of the ticket number for rendering with CSS. Pair or impair
        // Name each ticket with a different number
        var template;
        if (displayedTicket % 2 === 0) {
            template = container.attr('data-prototype')
                .replace(/__name__label__/g, 'Billet n°' + (displayedTicket + 1))
                .replace(/__name__/g, displayedTicket)
                .replace(/form-group/, 'col-sm-offset-1 col-sm-5 ticket-impair')
            ;
        } else {
            template = container.attr('data-prototype')
                .replace(/__name__label__/g, 'Billet n°' + (displayedTicket + 1))
                .replace(/__name__/g, displayedTicket)
                .replace(/form-group/, ' col-sm-5 ticket-pair')
            ;
        }

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

    function countPrice() {
        var basketPrice = 0;
        var visitDate = visitDaySelector.val();
        for (var i = 0; i < displayedTicket; i++) {
            var birthDate = $('#ml_ticketingbundle_bill_tickets_' + i + '_birthday').val();
            var age = countAge(visitDate,birthDate);
            if (age === -1) {

            } else if (age < 4 || birthDate === "") {
                basketPrice += 0;
            } else if (age < 12) {
                basketPrice += 8;
            } else if (age < 62) {
                basketPrice += 16;
            } else {
                basketPrice += 12;
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
});
