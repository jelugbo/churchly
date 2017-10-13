/* Card.js plugin by Jesse Pollak. https://github.com/jessepollak/card */

$('form').card({
    container: '.card-wrapper',
    width: '90%',

    formSelectors: {
        nameInput: '.input[name="first-name"], input[name="last-name"]',
        numberInput: 'input.card-number', // optional — default input[name="number"]
        expiryInput: 'input.card-expiry', // optional — default input[name="expiry"]
        cvcInput: 'input.card-cvc' // optional — default input[name="cvc"]
        //nameInput: 'input#name' // optional - defaults input[name="name"]
    }
});