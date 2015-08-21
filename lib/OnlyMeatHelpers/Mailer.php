<?php

namespace OnlyMeatHelpers;

class Mailer {

    public static function getOrderMailTemplateForCustomer() {
        return ' <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>Order Confirmation - Your Order with Onlymeat.in [#404-0232994-4273140] has been successfully placed!</title>
                <link href="http://www.ayushmantechnology.com/onlymeat/css/order.css" rel="stylesheet" type="text/css" />

            </head>
            <body style="margin-top: 0px;margin-bottom: 0px; font-family: "zonaprouploaded_file">
                  <div id="main" style="height: 1400px; width: 720px; margin-right: auto; margin-left: auto; border: 1px solid #E3000F; padding-bottom: 0px; color: #333; ">
                    <div id="top-header"> 
                    </div>
                    <div id="header-main" style="height: 100px;width: 720px;border-bottom-width: 5px;border-bottom-style: solid;border-bottom-color: #ffed00;background-color: #e3000f;">

                        <div id="logo" style="height: 100px;width: 125px;background-image: url(http://www.ayushmantechnology.com/onlymeat/images/logo.png);background-repeat: no-repeat;background-position: center center;margin-left: 34px;float: left;">
                        </div>
                        <div id="top-header-right" style="background-image: url(http://www.ayushmantechnology.com/onlymeat/images/header-icons.png);background-repeat: no-repeat;background-position: center center;float: right;height: 100px;width: 270px;margin-right: 64px;">

                        </div>
                    </div>
                    <div id="order-number" style="height: 70px; width: 720px;">
                        <div id="order-num" style="float: right; height: 50px; width: 350px; margin-top: 10px; margin-right: 30px; margin-bottom: 10px; line-height: 0px; text-align: right;">
                            <h2 style="font-weight: bold; color: #333; font-size: 20px; margin-top: 10px; margin-bottom: 10px;">Order Confirmation</h2>
                            <h3 style="font-size: 18px; color: #666666; font-weight: 400; margin-bottom: 10px; margin-top: 25px;">Order <font color="#e3000f">[[ORDER_ID]]</font></h3>
                        </div></div>
                    <div id="welcome-text" style=" height: auto; width: 660px; float: left; padding-right: 30px; padding-left: 30px; padding-top: 20px; padding-bottom: 20px;">
                        <h5 style="font-size: 16px; font-weight: bold; color: #E3000F; text-transform: capitalize; margin-bottom: 5px; margin-top: 0px;">Hello [[CUSTOMER_NAME]],</h5>
                        <p style="font-size: 14px; color: #666; margin-top: 0px; margin-bottom: 15px; text-align: justify; line-height: 20px;">Thank you for your order. This e-mail confirms that we have received your order.<br/><br/>
                            If you would like to know the status of your order or make any changes to it, <br/>
                            please Call us on <font color="#e3000f"><strong>+91-94 93 92 25 25</strong></font>.
                        </p>
                    </div> 
                    <div id="order-detailes" style="height: auto; width: 660px; float: left; background-color: #E6E7E8; border-top-width: 1px; border-bottom-width: 1px; border-top-style: solid; border-bottom-style: solid; border-top-color: #e3000f; border-bottom-color: #e3000f; padding-top: 19px; padding-right: 30px; padding-bottom: 19px; padding-left: 30px;">
                        <h5 style="font-size: 16px; font-weight: bold; color: #E3000F; text-transform: capitalize; margin-bottom: 5px; margin-top: 0px;">Order Details</h5>

                        <h6 style="color: #221e1e;font-size: 14px;margin-bottom: 15px;line-height: 20px;margin-top: 10px;font-weight: normal;">Order ID <font color="#e3000f">#[[ORDER_ID]]</font> | Placed on: [[ORDER_PLACED_DATE]] </h6>
                        <table width="660" border="1" class="hovertable" style="font-size: 14px; color: #333333; border-width: 0px; border-color: #E3000F; border-collapse: collapse;">
                            <tr>

                                <td width="114"><strong>Item Name</strong></td>
                                <td width="94"><strong>Quantity</strong></td>
                                <td width="96"><strong>Price</strong></td>
                            </tr>
                            [[ORDERED_PRODUCTS_LIST]]
                        </table>
                    </div>

                    <div id="order-total" style="height: auto;width: 660px;float: left;padding-top: 19px;padding-right: 30px;padding-bottom: 19px;padding-left: 30px;border-bottom-width: 1px;border-bottom-style: solid;border-bottom-color: #E3000F;"></div><div id="download-app" style="float: left;height: 120px;width: 400px;background-image: url(http://www.ayushmantechnology.com/onlymeat/images/app.png);background-repeat: no-repeat;background-position: center center;"></div><div id="total-price" style="float: left;height: 120px; width: 260px;">
                        <table width="100%" class="hovertable1" style="font-size: 14px; color: #333333; border-width: 0px;">
                            <tr>
                                <td width="66%">Item Subtotal</td>
                                <td width="9%">:</td>
                                <td width="25%"><strong>&#8377; [[ORDER_SUB_TOTAL]]</strong></td>
                            </tr>
                            <tr>
                                <td>Delivery Charges</td>
                                <td>:</td>
                                <td><strong>&#8377; [[ORDER_DELIVERY_CHARGE]]</strong></td>
                            </tr>
                            <tr>
                                <td><strong>Order Total</strong></td>
                                <td>:</td>
                                <td><strong>&#8377; [[ORDER_TOTAL]]</strong></td>
                            </tr> 	 
                        </table>
                    </div>
                    <div id="order-delivery" style="height: auto; width: 660px; float: left; padding-top: 19px; padding-right: 30px; padding-bottom: 19px; padding-left: 30px; border-bottom-width: 1px; border-bottom-style: solid; border-bottom-color: #E3000F;">
                        <div id="delivery-heading" style="width: 660px;float: left;line-height: 40px;text-align: left;height: 40px;border-bottom-width: 1px;border-bottom-style: dashed;border-bottom-color: #ED3237;">
                            <h5 style="font-size: 16px; font-weight: bold; color: #E3000F; text-transform: capitalize; margin-bottom: 5px; margin-top: 0px;">Delivery Address</h5>
                        </div>
                        <div id="delivery-adress" style="float: left;height: auto;width: 419px;border-right-width: 1px;border-right-style: dashed;border-right-color: #ED3237;"> 	 	 
                            <table width="100%" class="hovertable1" style="font-size: 14px; color: #333333; border-width: 0px;">
                                <tr>
                                    <td width="31%"><strong>[[CUSTOMER_NAME]]</strong></td>
                                    <td width="6%"><strong>:</strong></td>
                                    <td width="63%"><strong>[[MOBILE_ADDRESS]]</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="3">[[ORDER_DELIVERY_ADDRESS]]</td>
                                </tr>
                                <tr>
                                    <td colspan="3"><strong>Scheduled Delivery : [[ORDER_DELIVERY_DATE_TIME]]</strong></td>
                                </tr>
                            </table>
                        </div>
                        <div id="logo-red" style="float: left;height: 120px;width: 240px;background-image: url(http://www.ayushmantechnology.com/onlymeat/images/logo-red.png);background-repeat: no-repeat;background-position: center center;"></div>
                    </div>
                    <div id="process" style=" height: auto; width: 660px; float: left; padding-top: 19px; padding-right: 30px; padding-bottom: 19px; padding-left: 30px; border-bottom-width: 1px; border-bottom-style: solid; border-bottom-color: #E3000F; background-color: #E6E7E8;">
                        <div id="process-img" style="float: left;height: 120px;width: 660px;background-image: url(http://www.ayushmantechnology.com/onlymeat/images/process.png);background-repeat: no-repeat;background-position: center center;"></div>
                    </div><div id="main" style="height: 1400px; width: 720px; margin-right: auto; margin-left: auto; border: 1px solid #E3000F; padding-bottom: 0px; color: #333; "><div id="top-header"></div>
                        <div id="notify-text" style="height: auto; width: 660px; float: left; padding-right: 30px; padding-left: 30px; padding-top: 20px; padding-bottom: 20px; font-size: 12px; color: #666;">
                            Need to make changes to your order? please Call us on <font color="#e3000f"><strong>+91-94 93 92 25 25</strong></font><br/><br/>
                            We hope to see you again soon.
                        </div><div id="fresh-by-order" style="height: auto; width: 660px; float: left; padding-right: 30px; padding-left: 30px; padding-top: 20px; padding-bottom: 20px; font-size: 12px; background-image: url(http://www.ayushmantechnology.com/onlymeat/images/fesh-by-order.png); background-repeat: no-repeat; background-position: center center;"></div>
                        <div id="bottom-menu" style="height: 40px;width: 530px;margin-right: 95px;margin-left: 95px;float: left;margin-top: 15px;margin-bottom: 10px;border-top-width: 1px;border-top-style: dotted;border-top-color: #ED3237;line-height: 40px;text-align: center;font-size: 13px;">
                            <a href="#" style="color: #666666; text-decoration: none;">24x7 Customer Support</a>&nbsp; |&nbsp; 
                            <a href="#" style="color: #666666; text-decoration: none;">Buyer Protection</a>&nbsp; |&nbsp; 
                            <a href="#" style="color: #666666; text-decoration: none;">Flexible Payment Options</a> <br/>
                        </div><div id="footer" style="width: 660px; margin-right: 30px; margin-left: 30px; float: left; margin-top: 10px; margin-bottom: 10px; line-height: 25px; text-align: center; font-size: 10px; height: 25px;"> 
                            This email was sent from a notification-only address that cannot accept incoming email. Please do not reply to this message.
                        </div>
                    </div></body></html>';
    }

    public static function sendMail($fromEmailID, $toEmailID, $subject, $mailMessage) {
        // More headers
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
        $headers .= 'From: Only Meat<'.$fromEmailID.'>' . "\r\n";
        $headers .= "Reply-To:  <".$fromEmailID.">" . "\r\n";
        $headers .= 'Cc: kris@mapicos.com' . "\r\n";

        mail($toEmailID, $subject, $mailMessage, $headers);
    }

}
