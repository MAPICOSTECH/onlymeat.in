

jQuery(document).ready(function () {
    // This button will increment the value
    $('.qtyplus').click(function (e) {
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        fieldName = $(this).attr('field');
        // Get its current value
        var currentVal = parseInt($('input[name=' + fieldName + ']').val());
        // If is not undefined
        if (!$.isNumeric(currentVal)) {
            // Increment
            $('input[name=' + fieldName + ']').val(currentVal + 1);
        } else {
            // Otherwise put a 0 there
            $('input[name=' + fieldName + ']').val(0);
        }
    });
    // This button will decrement the value till 0
    $(".qtyminus").click(function (e) {
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        fieldName = $(this).attr('field');
        // Get its current value
        var currentVal = parseInt($('input[name=' + fieldName + ']').val());
        // If it isn't undefined or its greater than 0
        if (!$.isNumeric(currentVal) && currentVal > 0) {
            // Decrement one
            $('input[name=' + fieldName + ']').val(currentVal - 1);
        } else {
            // Otherwise put a 0 there
            $('input[name=' + fieldName + ']').val(0);
        }
    });
});

$(function () {
    $("#delivery_date").datepicker({minDate: 0});
});

$(document).ready(function () {
    $("#userexisting").click(function () {

        $(".newu1").show();
        $(".newu").hide();

    });

    $("#usernew").click(function () {

        $(".newu").show();
        $(".newu1").hide();

    });
    $('#f_submit').click(function () {
        var isExisting = $("#isExisting").val();
        var userType = $('input[name=usertype1]:checked').val();
		var paym = $('input[name=paym]:checked').val();
		var deliveryType = $('input[name=deliverytime]:checked').val();
						
        if (userType == "Existing User")
        {
            if ($('#mobile_number').val() == "")
            {
                $("#mes").html("Please enter mobile number");
                $("#mobile_number").focus();
                return false;
            }
            if ($('#add1').val() == "")
            {
                $("#mes").html("Please enter address");
                $("#add1").focus();
                return false;
            }
            if ($('#landmark').val() == "")
            {
                $("#mes").html("Please enter landmark");
                $("#landmark").focus();
                return false;
            }
            if ($('#city').val() == "")
            {
                $("#mes").html("Please enter city");
                $("#city").focus();
                return false;
            }
            if ($('#zipcode').val() == "")
            {
                $("#mes").html("Please enter zipcode");
                $("#zipcode").focus();
                return false;
            }
        }
        else if (userType == "New User")
        {
            if ($('#first_name').val() == "")
            {
                $("#mes").html("Please enter your name");
                $("#first_name").focus();
                return false;

            }
            if ($('#email').val() == "")
            {
                $("#mes").html("Please enter emailID");
                $("#email").focus();
                return false;

            }
            if ($('#mobile_number1').val() == "")
            {
                $("#mes").html("Please enter mobile number");
                $("#mobile_number1").focus();
                return false;

            }
            if ($('#add1').val() == "")
            {
                $("#mes").html("Please enter address");
                $("#add1").focus();
                return false;
            }
            if ($('#landmark').val() == "")
            {
                $("#mes").html("Please enter landmark");
                $("#landmark").focus();
                return false;
            }
            if ($('#city').val() == "")
            {
                $("#mes").html("Please enter city");
                $("#city").focus();
                return false;
            }
            if ($('#zipcode').val() == "")
            {
                $("#mes").html("Please enter zipcode");
                $("#zipcode").focus();
                return false;
            }
        }
		var add1 = $('#add1').val();
        var add2 = $('#add2').val();
		var area = $('#area').val();
        var landmark = $('#landmark').val();
        var zipcode = $('#zipcode').val();
        var city = $('#city').val();
        var delivery_date = $('#delivery_date').val();
        var orderTotal = $('#p-tot').html();
        var delivery_charge = $('#delivery_charge').val();
        var order_number = $('#order_number').val();

        var products = "";
        var qtys = "";
        var prices = "";
        var totalPrices = "";
        var tQuantity = "";
        var tPid = "";
        var tPrice = "";
        for (i = 1; i < 7; i++)
        {
            tQuantity = $("#con" + i).html();
            if (tQuantity != 0)
            {

                tPid = $("#pcode" + i).val();
                ttPrice = $("#cop" + i).html();
                tPrice = $("#prod-price-" + i).val();
                products = products + "," + tPid;
                qtys = qtys + "," + tQuantity;
                prices = prices + "," + tPrice;
                totalPrices = totalPrices + "," + ttPrice;
                var delivery_time = $('#ord_slot').val();
                

            }
            
        }
        if (userType == "New User")
        {
            var first_name = $('#first_name').val();
            var last_name = "abcd";
            var email = $('#email').val();
            var mobile_number1 = $('#mobile_number1').val();
            
            $.ajax({
                url: 'ajax_refresh1.php',
                type: 'POST',
                data: {userType: userType, first_name: first_name, last_name: last_name, email: email, mobile_number1: mobile_number1, add1: add1, add2: add2,area: area, landmark: landmark, zipcode: zipcode, city: city, orderTotal: orderTotal, delivery_charge: delivery_charge, products: products, qtys: qtys, prices: prices, totalPrices: totalPrices, delivery_date: delivery_date, delivery_time: delivery_time,paym: paym},
                dataType: 'json',
                success: function (data) {

                    for (i = 1; i < 7; i++) {
                        $("#p" + i).val(0);
                        $("#price-n" + i).html(0);
                        $("#cop" + i).html(0);
                        $("#con" + i).html(0);
                    }

                    $("#price-total").html(0);
                    $("#p-tot").html(0);
                    $("#order").hide();
                    $("#result").show();
                    $("#result").html(data.msg);

                    //$('#mobile_number').attr("disabled", "disabled");
                    $("#success").html(data.msg);
                    $('html,body').scrollTop(0);

                },
                error: function (data) {
                    //alert(data.length);

                }
            });
        }
        else if (userType == "Existing User")
        {
            if (isExisting == "Yes")
            {
                var mobile_number = $('#mobile_number3').val();
                var ccode = $('#ccode').val();
                var first_name = $('#first_name').val();
                var email = $('#email').val();
                $.ajax({
                    url: 'ajax_refresh1.php',
                    type: 'POST',
                    data: {userType: userType, first_name: first_name, email: email, mobile_number: mobile_number, ccode: ccode, add1: add1, add2: add2, landmark: landmark, zipcode: zipcode, city: city, orderTotal: orderTotal, products: products, qtys: qtys, prices: prices, totalPrices: totalPrices, delivery_date: delivery_date, paym: paym},
                    dataType: 'json',
                    success: function (data) {
                        for (i = 1; i < 7; i++) {
                            $("#p" + i).val(0);
                            $("#price-n" + i).html(0);
                            $("#cop" + i).html(0);
                            $("#con" + i).html(0);
                        }

                        $("#price-total").html(0);
                        $("#p-tot").html(0);
                        $("#order").hide();
                        $("#result").show();
                        $("#result").html(data.msg);

                        /*alert(data);*/
                        $("#success").html(data.msg);
                        $('html,body').scrollTop(0);
                        $('#mobile_number').attr("disabled", "disabled");

                    }
                });
            }
            else if (isExisting == "No")
            {
                alert("You are not an existing user.");
            }
        }


        return false;
    });

    $('#f_login').click(function () {
        var mobile_number = $('#mobile_number').val();
        $.ajax({
            url: 'ajax_refresh.php',
            type: 'POST',
            data: {mobile_number: mobile_number},
            dataType: 'json',
            success: function (data) {
                if (data == null)
                {
                    alert('Sorry, This number is not registered. ');
                }
                else
                {
                    $('#mobile_number3').val(data.mobile_number);
                    $('#mobile_number3').val(data.mobile_number1);
                    $('#ccode').val(data.cust_code);
                    $('#first_name').val(data.first_name);
                    $('#email').val(data.email);
                    $('#add1').val(data.address_1);
                    $('#add2').val(data.address_2);
                    $('#landmark').val(data.landmark);
                    $('#city').val(data.city);
                    $('#zipcode').val(data.post_code);
                    $("#isExisting").val("Yes");
                    $(".newu1").html(data.msg);
                    $(".newu").hide();
                    $(".utype").hide();
                    	
                }

            },
            error: function (xhr, textStatus, errorThrown)
            {

            }
        });
        return false;

    });
        
    $("#checkOut").click(function () {
        var tQty = 0;
        var quant = [];
        var price = [];
        for (i = 1; i < 7; i++) {
            quant[i] = $("#p" + i).val();
            
        }
        for (j = 1; j < 7; j++) {
            price[j] = $("#price-n" + j).html();
            
        }


        var totalp = $("#price-total").html();

        var delivery_charge = $('#delivery_charge').val();
        //Srinivas
        if (parseFloat(totalp) < 500)
        {
            var ptotal = parseFloat(totalp) + parseFloat(delivery_charge);
            $('.deliveryChargeSection').html('25');
        }
        else
        {

            $('.deliveryChargeSection').html('<strike>Waived</strike>');
            var ptotal = parseFloat(totalp);
        }

        $("#p-tot").html(ptotal);
        var ctr = 0;
        for (i = 1; i < 7; i++)
        {
            if (quant[i] != "0")
            {
                $("#con" + i).html(quant[i]);
                $("#cop" + i).html(price[i]);
                tQty = parseFloat(tQty) + parseFloat(quant[i]);

            }
            else
            {
                ctr++;
                $("#cart-product-" + i).hide();
            }
        }
        if (ctr != 6 && tQty > 0.5) {
            $("#order").show();
            $(window).scrollTop(850);
        }
        if (tQty < 1) {
            alert("Total order quantity should be minimum 1 Kg.");
        }


        return(false);

    });

});
(function ($) {
    $.fn.spinner = function () {
        this.each(function () {
            var el = $(this);

            // add elements
            el.wrap('<span class="spinner"></span>');
            el.before('<span class="sub">-</span>');
            el.after('<span class="add">+</span>');
            var items_qty = [];
            // substract
            el.parent().on('click', '.sub', function () {
                if (el.val() > parseInt(el.attr('min')))
                    el.val(function (i, oldval) {
                        oldval = parseFloat(oldval) - 0.5;
                        //alert(oldval);
                        return oldval;
                    });

                var oldval1 = $("#p1").val();
                var p1 = $("#prod-price-1").val()
                var sum1 = parseFloat(p1) * parseFloat(oldval1);

                $('#price-n1').html(sum1);
                $("#con1").html(oldval1);
                $("#cop1").html(sum1);
                items_qty[1] = oldval1;
                var oldval2 = $("#p2").val();
                var p2 = $("#prod-price-2").val()
                var sum2 = parseFloat(p2) * parseFloat(oldval2);
                
                $('#price-n2').html(sum2);
                $("#con2").html(oldval2);
                $("#cop2").html(sum2);
                items_qty[2] = oldval2;
                var oldval3 = $("#p3").val();
                var p3 = $("#prod-price-3").val()
                var sum3 = parseFloat(p3) * parseFloat(oldval3);
                
                $('#price-n3').html(sum3);
                $("#con3").html(oldval3);
                $("#cop3").html(sum3);
                items_qty[3] = oldval3;
                var oldval4 = $("#p4").val();
                var p4 = $("#prod-price-4").val()
                var sum4 = parseFloat(p4) * parseFloat(oldval4);
                
                $('#price-n4').html(sum4);
                $("#con4").html(oldval4);
                $("#cop4").html(sum4);
                items_qty[4] = oldval4;
                var oldval6 = $("#p6").val();
                var p6 = $("#prod-price-6").val()
                var sum6 = parseFloat(p6) * parseFloat(oldval6);
                
                $('#price-n6').html(sum6);
                $("#con6").html(oldval6);
                $("#cop6").html(sum6);
                items_qty[6] = oldval6;
                var oldval5 = $("#p5").val();
                var p5 = $("#prod-price-5").val();
                var sum5 = parseFloat(p5) * parseFloat(oldval5);
                
                $('#price-n5').html(sum5);
                $("#con5").html(oldval5);
                $("#cop5").html(sum5);
                items_qty[5] = oldval5;
                var delivery_charge = $('#delivery_charge').val();
                var total = parseFloat(sum1) + parseFloat(sum2) + parseFloat(sum3) + parseFloat(sum4) + parseFloat(sum5) + parseFloat(sum6);
                //var ptotal=parseFloat(sum1)+parseFloat(sum2)+parseFloat(sum3)+parseFloat(sum4)+parseFloat(sum5)+parseFloat(sum6)+parseFloat(delivery_charge);
                if (total < 500)
                {
                    var ptotal = total + parseFloat(delivery_charge);
                    $('.deliveryChargeSection').html('25');
                }
                else
                {
                    $('.deliveryChargeSection').html('<strike>Waived</strike>');
                    var ptotal = total;
                }

                //alert(ptotal);
                //alert(ptotal);
                //alert(total);
                $('#price-total').html(total);

                $("#tot").val(total);
                $("#p-tot").html(ptotal);
                console.log(oldval);
            });

            // increment
            el.parent().on('click', '.add', function () {

                if (el.val() < parseInt(el.attr('max')))
                    el.val(function (i, oldval) {
                        oldval = parseFloat(oldval) + 0.5;

                        //alert(oldval);
                        return oldval;
                    });



                var oldval1 = $("#p1").val();
                var p1 = $("#prod-price-1").val()
                var sum1 = parseFloat(p1) * parseFloat(oldval1);
                //alert(sum1);
                $('#price-n1').html(sum1);
                $("#con1").html(oldval1);
                $("#cop1").html(sum1);
                items_qty[1] = oldval1;
                var oldval2 = $("#p2").val();
                var p2 = $("#prod-price-2").val()
                var sum2 = parseFloat(p2) * parseFloat(oldval2);
                //alert(sum2);
                $('#price-n2').html(sum2);
                $("#con2").html(oldval2);
                $("#cop2").html(sum2);
                items_qty[2] = oldval2;
                var oldval3 = $("#p3").val();
                var p3 = $("#prod-price-3").val()
                var sum3 = parseFloat(p3) * parseFloat(oldval3);
                //alert(sum3);
                $('#price-n3').html(sum3);
                $("#con3").html(oldval3);
                $("#cop3").html(sum3);
                items_qty[3] = oldval3;
                var oldval4 = $("#p4").val();
                var p4 = $("#prod-price-4").val()
                var sum4 = parseFloat(p4) * parseFloat(oldval4);
                //alert(sum4);
                $('#price-n4').html(sum4);
                $("#con4").html(oldval4);
                $("#cop4").html(sum4);
                items_qty[4] = oldval4;
                var oldval6 = $("#p6").val();
                var p6 = $("#prod-price-6").val()
                var sum6 = parseFloat(p6) * parseFloat(oldval6);
                //alert(sum6);
                $('#price-n6').html(sum6);
                $("#con6").html(oldval6);
                $("#cop6").html(sum6);
                items_qty[6] = oldval6;
                var oldval5 = $("#p5").val();
                //alert('old'+oldval5);
                var p5 = $("#prod-price-5").val()
                //alert('old11'+p5);
                var sum5 = parseFloat(p5) * parseFloat(oldval5);
                //alert(sum5);
                $('#price-n5').html(sum5);
                $("#con5").html(oldval5);
                $("#cop5").html(sum5);
                items_qty[5] = oldval5;

                for (i = 1; i < 7; i++)
                {
                    if (items_qty[i] != "0")
                    {
                        $("#cart-product-" + i).show();
                    }
                }
                var delivery_charge = $('#delivery_charge').val();
                var total = parseFloat(sum1) + parseFloat(sum2) + parseFloat(sum3) + parseFloat(sum4) + parseFloat(sum5) + parseFloat(sum6);
                //var ptotal=parseFloat(sum1)+parseFloat(sum2)+parseFloat(sum3)+parseFloat(sum4)+parseFloat(sum5)+parseFloat(sum6)+parseFloat(delivery_charge);
                console.log($('.deliveryChargeSection'));
                if (total < 500)
                {
                    var ptotal = total + parseFloat(delivery_charge);
                    $('.deliveryChargeSection').html('25');
                }
                else
                {
                    $('.deliveryChargeSection').html('<strike>Waived</strike>');
                    var ptotal = total;
                }
                //alert(ptotal);
                $('#price-total').html(total);
                $("#tot").val(total);
                $("#p-tot").html(ptotal);
                //var multipleValues = $( "input[type=number]" ).val();

            });
        });
    };
})(jQuery);

$('input[type=number]').spinner();


function get_price(val)
{

    alert("The input value has changed. The new value is: " + val);
    var qty = $(el.val).spinner();
    var price = $("#prod-price-6").html();
    var tot_price = qty * price;
    $("#price-number").html(tot_price);
    document.write(qty);
    document.write(price);
    document.write(tot_price);
    return false;
}

//deliver now
$('#deliverytime1').click(function () {
    $('#area').children().remove();
    $('#area').prepend('<option>Kondapur</option>');
});

//scheduled
$('#deliverytime2').click(function () {
    $('#area').children().remove();
    $('#area').prepend('<option>Kondapur</option>');
    $('#area').prepend('<option>Gachibowli</option>');
    $('#area').prepend('<option>Hitec City</option>');
});