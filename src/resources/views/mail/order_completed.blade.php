@php
$user = Nowyouwerkn\WeCommerce\Models\User::where('id', $user_id)->first();
$order = Nowyouwerkn\WeCommerce\Models\Order::where('id', $order_id)->first();
$order->cart = unserialize($order->cart);

$tax = $order->cart->totalPrice * 0.0825;
@endphp

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
  <title>Gracias por tu Compra - Detalles de Orden</title>

  <link href='http://fonts.googleapis.com/css?family=Montserrat:400,500,300,600,700' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Work+Sans:300,400,500,600,700' rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet"> 
  <link href="https://fonts.googleapis.com/css?family=Condiment" rel="stylesheet"> 

  <style type="text/css">
    body{ margin:0; padding:0; -webkit-text-size-adjust: none; -ms-text-size-adjust: none; background:#000;}

    span.preheader{display: none; font-size: 1px;}

    html { width: 100%; }

    table { border-spacing: 0; border-coll apse: collapse;}

    .ReadMsgBody { width: 100%; background-color: #FFFFFF; }

    .ExternalClass { width: 100%; background-color: #FFFFFF; }

    .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalCl ass font, .ExternalClass td, .ExternalClass div { line-height: 100%; }

    a,a:hover { text-decoration:none; color:#FFF;}

    img { display: block !important; }

    table td { border-collapse: collapse; }


    @media only screen and (max-width:640px)

    {
      body {width:auto!important;}
      table [class=main] {width:85% !important;}
      table [class=full] {width:100% !important; margin:0px auto;}
      table [class=two-left-inner] {width:90% !important; margin:0px auto;}
      td[class="two-left"] { display: block; width: 100% !important; }
      table [class=menu-icon] { display:none;}
      img[class="image-full"] { width: 100% !important; }
      table[class=menu-icon] { display:none;}

    }

    @media only screen and (max-width:479px)
    {
      body {width:auto!important;}
      table [class=main] {width:93% !important;}
      table [class=full] {width:100% !important; margin:0px auto;}
      td[class="two-left"] { display: block; width: 100% !important; }
      table [class=two-left-inner] {width:90% !important; margin:0px auto;}
      table [class=menu-icon] { display:none;}
      img[class="image-full"] { width: 100% !important; }
      table[class=menu-icon] { display:none;}

    }
  </style>

</head>

<body yahoo="fix" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

  <!--Main Table Start-->

  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#000">
    <tr>
      <td align="center" valign="top">

        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td align="center" valign="top"><table width="600" border="0" align="center" cellpadding="0" cellspacing="0" class="main">
              <tr>
                <td height="60" align="center" valign="top" style="font-size:60px; line-height:60px;">&nbsp;</td>
              </tr>
            </table></td>
          </tr>
        </table>

        <!--
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td align="center" valign="top"><table width="600" border="0" align="center" cellpadding="0" cellspacing="0" class="main">
              <tr>
                <td align="center" valign="top" style="background:#fff;"><table width="500" border="0" cellspacing="0" cellpadding="0" class="two-left-inner">
                  <tr>
                    <td height="35" align="center" valign="top" style="font-size:35px; line-height:35px;">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="center" valign="top"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="50%" align="left" valign="top" class="two-left"><table border="0" align="left" cellpadding="0" cellspacing="0" class="full">
                          <tr>
                            <td align="center" valign="top"><a href="#"><img mc:edit="tm5-01" editable="true" src="logo.png" width="100%" height="23" alt="" /></a></td>
                          </tr>
                        </table></td>

                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td height="35" align="center" valign="top" style="font-size:35px; line-height:35px;">&nbsp;</td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
        </table>
        -->

        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td align="center" valign="top"><table width="600" border="0" align="center" cellpadding="0" cellspacing="0" class="main">
              <tr>
                <td align="center" valign="top" style="background:#b6b9ae;"><table width="500" border="0" cellspacing="0" cellpadding="0" class="two-left-inner">
                  <tr>
                    <td height="55" align="center" valign="top" style="font-size:55px; line-height:55px;">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="center" valign="top"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="225" align="left" valign="top" class="two-left"><table width="100%" border="0" align="right" cellpadding="0" cellspacing="0" class="full">
                          <tr>
                            <td align="left" valign="top" style="font-family:'Open Sans', Verdana, Arial; font-size:14px; color:#FFF; font-weight:bold;" mc:edit="tm5-04"><multiline>Envio a:</multiline></td>
                          </tr>
                          <tr>
                            <td height="5" align="left" valign="top" style="font-size:5px; line-height:5px;">&nbsp;</td>
                          </tr>
                          <tr>
                            <td align="left" valign="top" style="font-family:'Open Sans', Verdana, Arial; font-size:14px; color:#FFF; font-weight:normal; line-height:24px;" mc:edit="tm5-05"><multiline>{{ $user->name }} <br />
                              {{ $order->street . ' ' . $order->street_num }}, {{ $order->postal_code }},<br />
                              {{ $order->city . ' ' . $order->state }}.</multiline></td>
                            </tr>
                          </table></td>
                          <td width="150" align="left" valign="top" class="two-left"><table width="100%" border="0" align="right" cellpadding="0" cellspacing="0" class="full">

                            <tr>
                              <td height="15" align="left" valign="top" style="font-size:15px; line-height:15px;">&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="top" style="font-family:'Open Sans', Verdana, Arial; font-size:14px; color:#FFF; font-weight:bold;" mc:edit="tm5-06"><multiline>Orden #</multiline></td>
                            </tr>
                            <tr>
                              <td height="5" align="left" valign="top" style="font-size:5px; line-height:5px;">&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="top" style="font-family:'Open Sans', Verdana, Arial; font-size:14px; color:#FFF; font-weight:normal; line-height:24px;" mc:edit="tm5-07"><multiline>#00{{ $order->id }}</multiline></td>
                            </tr>
                            <tr>
                              <td align="left" valign="top" style="font-family:'Open Sans', Verdana, Arial; font-size:14px; color:#FFF; font-weight:normal; line-height:24px;">&nbsp;</td>
                            </tr>
                          </table></td>
                          <td width="125" align="left" valign="top" class="two-left"><table width="125" border="0" align="right" cellpadding="0" cellspacing="0" class="full">
                            <tr>
                              <td align="left" valign="top"><table width="125" border="0" align="left" cellpadding="0" cellspacing="0">
                                <tr>
                                  <td height="15" align="left" valign="top" style="font-size:15px; line-height:15px;">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top" style="font-family:'Open Sans', Verdana, Arial; font-size:12px; color:#FFF; font-weight:bold;" mc:edit="tm5-08"><multiline>Total de Compra</multiline></td>
                                </tr>
                                <tr>
                                  <td height="5" align="left" valign="top" style="font-size:5px; line-height:5px;">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top" style="font-family:'Open Sans', Verdana, Arial; font-size:30px; color:#FFF; font-weight:bold;" mc:edit="tm5-09"><multiline>$ {{ $order->payment_total }}</multiline>
                                  </td>
                                </tr>
                              </table></td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td height="55" align="center" valign="top" style="font-size:55px; line-height:55px;">&nbsp;</td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
        </table>

        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="menu-icon">
          <tr>
            <td align="center" valign="top"><table width="600" border="0" align="center" cellpadding="0" cellspacing="0" class="main">
              <tr>
                <td align="center" valign="top" style="background:#FFF;"><table width="500" border="0" cellspacing="0" cellpadding="0" class="two-left-inner">
                  <tr>
                    <td height="65" align="center" valign="top" style="font-size:65px; line-height:65px;">&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="35" align="center" valign="top" style="font-size:35px; line-height:35px;"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="155" align="left" valign="top" class="two-left" style="font-family:'Open Sans', sans-serif, Verdana; font-size:15px; color:#333; line-height:22px; font-weight:bold;" mc:edit="tm5-10"><multiline>Descripción</multiline></td>
                        <td width="115" align="left" valign="top" class="two-left" style="font-family:'Open Sans', sans-serif, Verdana; font-size:15px; color:#333; line-height:22px; font-weight:bold;" mc:edit="tm5-11"><multiline>Precio Unitario</multiline></td>
                        <td width="115" align="left" valign="top" class="two-left" style="font-family:'Open Sans', sans-serif, Verdana; font-size:15px; color:#333; line-height:22px; font-weight:bold;" mc:edit="tm5-12"><multiline>Cantidad</multiline></td>
                        <td width="115" align="left" valign="top" class="two-left" style="font-family:'Open Sans', sans-serif, Verdana; font-size:15px; color:#333; line-height:22px; font-weight:bold;" mc:edit="tm5-13"><multiline>Subtotal</multiline></td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td height="25" align="center" valign="top" style="font-size:25px; line-height:25px; border-bottom:#CCC solid 1px;">&nbsp;</td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
        </table>

        @foreach($order->cart->items as $item)
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td align="center" valign="top"><table width="600" border="0" align="center" cellpadding="0" cellspacing="0" class="main">
              <tr>
                <td align="center" valign="top" style="background:#FFF;"><table width="500" border="0" cellspacing="0" cellpadding="0" class="two-left-inner">

                  <tr>
                    <td height="35" align="center" valign="top" style="font-size:35px; line-height:35px;"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">

                      <tr>
                        <td colspan="4" align="left" valign="top" style="font-family:'Open Sans', sans-serif, Verdana; font-size:13px; color:#333; line-height:30px; font-weight:normal;">&nbsp;</td>
                      </tr>
                      <tr>
                        <td width="155" align="left" valign="top" style="font-family:'Open Sans', sans-serif, Verdana; font-size:12px; color:#71746f; line-height:22px; font-weight:normal;" class="two-left" mc:edit="tm5-14"><multiline><b style="font-size:15px;">{{ $item['item']['name'] }}</b> <br/>Talla: {{ $item['variant'] }}</multiline></td>
                        <td width="115" align="left" valign="bottom" style="font-family:'Open Sans', sans-serif, Verdana; font-size:13px; color:#71746f; line-height:22px; font-weight:normal;" class="two-left" mc:edit="tm5-15"><multiline>$ {{ number_format($item['item']['price']) }}</multiline></td>
                        <td width="115" align="left" valign="bottom" style="font-family:'Open Sans', sans-serif, Verdana; font-size:13px; color:#71746f; line-height:22px; font-weight:normal;" class="two-left" mc:edit="tm5-16"><multiline>{{ $item['qty'] }}</multiline></td>
                        <td width="115" align="left" valign="bottom" style="font-family:'Open Sans', sans-serif, Verdana; font-size:13px; color:#71746f; line-height:22px; font-weight:normal;" class="two-left" mc:edit="tm5-17"><multiline>$ {{ number_format($item['price']) }}</multiline></td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td height="35" align="center" valign="top" style="font-size:35px; line-height:35px; border-bottom:#CCC solid 1px;">&nbsp;</td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
        </table>
        @endforeach
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td align="center" valign="top"><table width="600" border="0" align="center" cellpadding="0" cellspacing="0" class="main">
              <tr>
                <td align="center" valign="top" style="background:#FFF;"><table width="500" border="0" cellspacing="0" cellpadding="0" class="two-left-inner">

                  <tr>
                    <td height="35" align="center" valign="top" style="border-top:#CCC solid 1px;"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                      <tr>
                        <td align="left" valign="top" style="font-family:'Open Sans', sans-serif, Verdana; font-size:13px; color:#333; line-height:30px; font-weight:normal;">&nbsp;</td>
                      </tr>
                      <tr>
                        <td align="right" valign="top" class="two-left"><table border="0" align="right" cellpadding="0" cellspacing="0" class="full">
                          <tr>
                            <td align="left" valign="top"><table width="215" border="0" align="left" cellpadding="0" cellspacing="0">
                              <tr>
                                <td width="100" align="left" valign="top" style="font-family:'Open Sans', sans-serif, Verdana; font-size:26px; color:#71746f; line-height:22px; font-weight:bold;" class="two-left" mc:edit="tm5-26"><multiline>IVA <small>(Incluido en el producto)</small></multiline></td>
                                <td width="115" align="left" valign="top" style="font-family:'Open Sans', sans-serif, Verdana; font-size:20px; color:#71746f; line-height:22px; font-weight:bold;" class="two-left" mc:edit="tm5-27"><multiline>$ {{ number_format($tax, 2) }}</multiline></td>
                              </tr>
                            </table></td>
                          </tr>
                        </table></td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td height="35" align="center" valign="top" style="font-size:35px; line-height:35px;">&nbsp;</td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
        </table>

        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td align="center" valign="top"><table width="600" border="0" align="center" cellpadding="0" cellspacing="0" class="main">
              <tr>
                <td align="center" valign="top" style="background:#FFF;"><table width="500" border="0" cellspacing="0" cellpadding="0" class="two-left-inner">

                  <tr>
                    <td height="35" align="center" valign="top" style="border-top:#CCC solid 1px;"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                      <tr>
                        <td height="40" colspan="2" align="left" valign="top" style="font-family:'Open Sans', sans-serif, Verdana; font-size:13px; color:#333; line-height:30px; font-weight:normal;">&nbsp;</td>
                      </tr>
                      <tr>
                        <td align="right" valign="top"><table border="0" align="right" cellpadding="0" cellspacing="0" class="full">
                          <tr>
                            <td align="left" valign="top"><table width="280" border="0" align="left" cellpadding="0" cellspacing="0">
                              <tr>
                                <td width="165" align="left" valign="top" style="font-family:'Open Sans', sans-serif, Verdana; font-size:26px; color:#333; line-height:22px; font-weight:bold;" class="two-left" mc:edit="tm5-28"><multiline>Total</multiline></td>
                                <td width="115" align="left" valign="top" style="font-family:'Open Sans', sans-serif, Verdana; font-size:20px; color:#333; line-height:22px; font-weight:bold;" class="two-left" mc:edit="tm5-29"><multiline>$ {{ $order->payment_total }}</multiline></td>
                              </tr>
                            </table></td>
                          </tr>
                        </table></td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td height="55" align="center" valign="top" style="font-size:55px; line-height:55px;">&nbsp;</td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
        </table>

        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td align="center" valign="top"><table width="600" border="0" align="center" cellpadding="0" cellspacing="0" class="main">
              <tr>
                <td align="center" valign="top" style="background:#b6b9ae;"><table width="500" border="0" cellspacing="0" cellpadding="0" class="two-left-inner">
                  <tr>
                    <td height="10" align="center" valign="top" style="font-size:10px; line-height:10px;">&nbsp;</td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
        </table>

        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td align="center" valign="top"><table width="600" border="0" align="center" cellpadding="0" cellspacing="0" class="main">
              <tr>
                <td align="center" valign="top"><table width="260" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td height="40" align="center" valign="top" style="font-size:40px; line-height:40px;">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="center" valign="top" style="font-family:'Open Sans', sans-serif, Verdana; font-size:12px; color:#4b4b4c; line-height:30px; font-weight:normal;" mc:edit="tm5-30"><multiline>&copy; Notificación de Tienda</multiline></td>
                  </tr>

</table></td>
</tr>
</table></td>
</tr>
</table>

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" valign="top"><table width="600" border="0" align="center" cellpadding="0" cellspacing="0" class="main">
      <tr>
        <td height="55" align="center" valign="top" style="font-size:55px; line-height:55px;">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>


</td>
</tr>
</table>

<!--Main Table End-->

</body>
</html>
