// Configuration of the JQuery Validator Form
$(function () {
    $.validate({
        form : '#bookingForm',
        modules : 'html5, security, date, toggleDisabled',
        lang : 'fr'
    });
});