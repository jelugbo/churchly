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

