<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width"/>
    <title>Modular Template Patterns</title>

</head>
<body style="background: #ffffff;">
<center>
    <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable" style="border-collapse:collapse; height:100% !important; margin:0; padding:0; width:100% !important;">
        <tr>
            <td align="center" valign="top" class="paddingtop30px" style="padding-top:30px;">

                    <img src="{{$header_image}}" alt="" width="298">

            </td>
        </tr>

        <tr>
            <td align="center" valign="top" id="bodyCell" style="height:100% !important; margin:0; padding-top:62px; width:100% !important;">

                <table border="0" cellpadding="0" cellspacing="0" width="700" id="emailBody" style="border-collapse:collapse; background-color:#F5F5F5;">
                    <tr>
                        <td align="center" valign="top">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;">
                                <tr>
                                    <td align="center" valign="top" width="585" class="flexibleContainer paddingtop62px" style="padding-top:62px;">
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" valign="top">
                                        <table border="0" cellpadding="0" cellspacing="0" width="585" class="flexibleContainer bg-color" style="border-collapse:collapse; background:#ffffff;">
                                            <tr>
                                                <td align="center" valign="top" width="585" class="flexibleContainer paddingtop55px" style="padding-top:55px;">
                                                    <table border="0" cellpadding="0" cellspacing="0" width="510" class="flexibleContainer" style="border-collapse:collapse;">
                                                        <tr>
                                                            <td align="center" valign="top" width="510" class="flexibleContainer">
                                                                <p class="p_bashkerville"  style="line-height: 1.5em; letter-spacing: 1px; margin:0px; padding:0px; font-family: 'Baskerville', Arial, Helvetica; font-weight:normal; font-size: 20px; color:#333333;">Thank you for signing up for an account with Ojolie. You need to verify your account first.</p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td align="center" valign="top" width="510" class="flexibleContainer">
                                                                <p><a target="_blank" href="https://staging-ojolie.dingerpay.org/account/verify/{{encrypt($user->id)}}"><button class="p_bashkerville"  style="line-height: 1.5em; letter-spacing: 1px; margin:0px; padding:0px; font-family: 'Baskerville', Arial, Helvetica; font-weight:normal; font-size: 20px; color:#333333; padding:10px; ">Click here to verify</button></a></p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td align="center" valign="top" width="510" class="flexibleContainer paddingtop30px" style="padding-top: 30px;">
                                                                <p class="p_bashkerville"  style="line-height: 1.5em; letter-spacing: 1px; margin:0px; padding:0px; font-family: 'Baskerville', Arial, Helvetica; font-weight:normal; font-size: 20px; color:#333333;">Kind Wishes,</p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td align="center" valign="top" width="510" class="flexibleContainer paddingtop30px" style="padding-top: 30px;">
                                                                <p class="p_bashkerville"  style="line-height: 1.5em; letter-spacing: 1px; margin:0px; padding:0px; font-family: 'Baskerville', Arial, Helvetica; font-weight:normal; font-size: 20px; color:#333333;">The Ojolie Team</p>
                                                            </td>
                                                        </tr>
                                                    </table>


                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="center" valign="top" width="637" class="flexibleContainer paddingtop52px paddingbottom60px" style="padding-top: 52px; padding-bottom: 0px;">
                                                    <a href="https://ojolie-frontend.vercel.app">
                                                        <img src="{{$footer_image}}" alt="" width="335">
                                                    </a>
                                                </td>
                                            </tr>


                                        </table>
                                        <!-- // FLEXIBLE CONTAINER -->
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" valign="top" width="585" class="flexibleContainer paddingtop62px" style="padding-top: 62px;">
                                    </td>
                                </tr>
                            </table>
                            <!-- // CENTERING TABLE -->
                        </td>
                    </tr>
                    <!-- // MODULE ROW -->
                </table>
                <!-- // EMAIL CONTAINER -->
            </td>
        </tr>
    </table>
</center>
</body>
</html>
