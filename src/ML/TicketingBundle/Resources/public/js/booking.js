$(function () {

    var tickets = $('#ml_ticketingbundle_bill_ticket_number');

    var container = $('div#ml_ticketingbundle_bill_tickets');

    // Find how many ticket(s) were selected
    var index = container.find(':input').length;

    // Add or delete ticket(s) depending the select value
    $(tickets).change(function () {
        var nbTickets = tickets.val();

        // No value means 0 ticket
        if (nbTickets === "") {
            nbTickets = 0;
        }

        // Add or delete ticket(s)
        if (nbTickets > index) {
            var difference = nbTickets - index;
            for (var i = 0 ; i < difference ; i++) {
                addTicket(container);
            }
        } else {
            var difference = index - nbTickets;
            for (var i = 0 ; i < difference ; i++) {
                deleteTicket(container);
            }
        }
    });

    function addTicket(container) {
        // Add a class depending of the ticket number for rendering. Pair or impair
        if (index % 2 === 0 ) {
            var template = container.attr('data-prototype')
                .replace(/__name__label__/g, 'Ticket n°' + (index+1))
                .replace(/__name__/g, index)
                .replace(/form-group/, 'col-sm-offset-1 col-sm-5 ticket-impair')
            ;
        } else {
            var template = container.attr('data-prototype')
                .replace(/__name__label__/g, 'Ticket n°' + (index + 1))
                .replace(/__name__/g, index)
                .replace(/form-group/, ' col-sm-5 ticket-pair')
            ;
        }

        var prototype = $(template);

        container.append(prototype);

        index++;
    }

    function deleteTicket(container) {
        var template = container.children('div').last();
        template.remove();
        index--;
    }

});

