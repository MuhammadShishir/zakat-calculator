jQuery(document).ready(function($) {
    // JavaScript code for Zakat Calculator widget

    // Handle form submission
    $('.zakat-calculator-form').submit(function(event) {
        // Prevent default form submission
        event.preventDefault();

        // Get input value
        var amount = parseFloat($('.zakat-calculator-input').val());

        // Validate input
        if (isNaN(amount) || amount <= 0) {
            alert('Please enter a valid amount.');
            return;
        }

        // Perform Zakat calculation
        var zakatAmount = calculateZakat(amount);

        // Display result
        $('.zakat-calculator-result-amount').text(zakatAmount.toFixed(2));
        $('.zakat-calculator-result').show();
    });

    // Function to calculate Zakat
    function calculateZakat(amount) {
        var nisab = 87.48; // Nisab amount in grams
        var zakatRate = 0.025; // Zakat rate (2.5%)

        // Check if the amount is above the Nisab
        if (amount < nisab) {
            return 0;
        } else {
            // Calculate Zakat amount
            return amount * zakatRate;
        }
    }
});
