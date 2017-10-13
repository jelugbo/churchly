/**
 * Created by jelug on 6/27/2017.
 */


$(document).ready(function(){
    $(".card-number").change(function() {
        $(".card-type").val(CardJs.cardTypeFromNumber($(this).val()));
    });

    $('form').card({
        container: '.card-wrapper',
        width: '90%',

        formSelectors: {
            nameInput: 'input[name="first-name"], input[name="last-name"]',
            numberInput: 'input.card-number', // optional — default input[name="number"]
            expiryInput: 'input.card-expiry', // optional — default input[name="expiry"]
            cvcInput: 'input.card-cvc' // optional — default input[name="cvc"]
            //nameInput: 'input#name' // optional - defaults input[name="name"]
        }
    });
    var params = get_params();
    console.log(params);
    Stripe.setPublishableKey(params.publishablekey);
    function stripeResponseHandler(status, response) {
        console.log(response);
        console.log(status);
        if (response.error) {
            reportError(response.error.message);
        } else {
            var f = $("#payment-form");
            var token = response.id;
            f.append('<input type="hidden" name="stripeToken" value="' + token + '" />');
            f.get(0).submit();
        }
    }

    function reportError(msg) {
        $('#payment-errors').text(msg).addClass('error');
        $('#post_data').prop('disabled', false);
        return false;
    }
    
// Watch for a form submission:
    $("#payment-form").submit(function(event) {
        console.log("Inside");
        $('#post_data').attr('disabled', 'disabled');
        var error = false;
        var ccNum = $('.card-number').val(),
            cvcNum = $('.card-cvc').val(),
            expMonth = ($('.card-expiry').val()).substring(0,2),
            expYear = ($('.card-expiry').val()).slice(-2);

        if (!Stripe.card.validateCardNumber(ccNum)) {
            error = true;
            reportError('The credit card number appears to be invalid.');
        }

        if (!Stripe.card.validateCVC(cvcNum)) {
            error = true;
            reportError('The CVC number appears to be invalid.');
        }

        if (!Stripe.card.validateExpiry(expMonth, expYear)) {
            error = true;
            reportError('The expiration date appears to be invalid.');
        }
        if (!error) {
            // Get the Stripe token:
            Stripe.card.createToken({
                number: ccNum,
                cvc: cvcNum,
                exp_month: expMonth,
                exp_year: expYear
            }, stripeResponseHandler);
        }

        return false;
    }); // form submission

    function get_params(){
        var params =[];
        var a = ($("#settings").val()).split(",");
        a.forEach(function(b){
            q = b.split(":");
            params[q[0]] = q[1];
        });
        return params;
    }

    $("#proceed").click(function(e){
        if( $(".items").val() == "" || $(".amount").val() == ""){
            e.preventDefault();
            //$(".items").focus
        }else {
            $("#itemDiv").hide();
            $("#payDiv").show();
        }

    });
    $("#goback").click(function(){
        $("#payDiv").hide();
        $("#itemDiv").show();
    });
    $('.amount').each(function() {
        $(this).on('keypress',function () {
//                console.log($(this).val());
        });
    });

    $(document).on('change', '.amount', function(){
        console.log($(this).val());
        var total = 0;
        $('.amount').each(function (index, element) {
            total = ($(element).val() > 0) ? total + parseFloat($(element).val()): total;
        });
        $('.total').text(total);
        $('#total').val(total);
        console.log(total);
    });

    $(document).on('click', '.btn-add', function(e)
    {
        e.preventDefault();
        var controlForm = $(this).parents('.bigger:first'),
            currentEntry = $(this).parents('.entry:first'),
            newEntry = $(currentEntry.clone()).appendTo(controlForm);

        newEntry.find('input').val('');
        controlForm.find('.entry:not(:last) .btn-add')
            .removeClass('btn-add').addClass('btn-remove')
            .removeClass('btn-success').addClass('btn-danger')
            .html('<span class="glyphicon glyphicon-minus"></span>');
    }).on('click', '.btn-remove', function(e)
    {
        $(this).parents('.entry:first').remove();

        e.preventDefault();
        return false;
    });
});

