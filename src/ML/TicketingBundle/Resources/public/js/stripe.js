var handler = StripeCheckout.configure({
    key: 'pk_test_DNvpkGJnDd2qWkgbcehBjeKA',
    image: '../../img/louvre.png',
    locale: 'auto'
});

$('#ml_ticketingbundle_bill_save').click(function(e) {
    e.preventDefault();

    var amount = $('#basket').text(),
        amount = amount.replace(/\$/g, '').replace(/\,/g, ''),
        amount = parseFloat(amount),
        amount = amount * 100,
        email = $('#ml_ticketingbundle_bill_email_first').val();

    // Open Checkout with further options:
    handler.open({
        name: 'Musée du Louvre',
        description: 'Paiement des billets',
        zipCode: false,
        email: email,
        allowRememberMe: false,
        currency: 'eur',
        amount: Math.round(amount)
    });
});

// Close Checkout on page navigation:
window.addEventListener('popstate', function() {
    handler.close();
});