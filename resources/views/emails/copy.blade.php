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
                <a href="https://ojolie-frontend.vercel.app" style="text-decoration: none;">
                    <img src="https://staging-ojolie-frontend-pfylq.ondigitalocean.app/images/ojolie-logo.svg" alt="" width="298" />
                </a>
            </td>
        </tr>
        <tr>
            <td align="center" valign="top" class="paddingtop30px" style="padding-top:30px;">
                <a href="https://staging-ojolie-frontend-pfylq.ondigitalocean.app/" class="href_airal" style="text-decoration: none; margin:0px 25px; padding:0px; font-family: Arial; font-weight:normal; font-size: 14px; color:#333333;">HOME</a>
                <a href="https://staging-ojolie-frontend-pfylq.ondigitalocean.app/browse-all" class="href_airal" style="text-decoration: none; margin:0px 25px; padding:0px; font-family: Arial; font-weight:normal; font-size: 14px; color:#333333;">CARDS </a>
                <a href="https://staging-ojolie-frontend-pfylq.ondigitalocean.app/about-us" class="href_airal" style="text-decoration: none; margin:0px 25px; padding:0px; font-family: Arial; font-weight:normal; font-size: 14px; color:#333333;">ABOUT OJOLIE</a>
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
                                                                <p style="line-height:1.5em;letter-spacing:1px;margin:0px;padding:0px;font-family:'Baskerville',Arial,Helvetica;font-weight:normal;font-size:20px;color:#333333">{{$ecardsentrecipient->ecardsentitem->user->getFullName()}} (<a href="mailto:{{$ecardsentrecipient->ecardsentitem->user->getEmail()}}" target="_blank">{{$ecardsentrecipient->ecardsentitem->user->getEmail()}}</a>) has sent you a card.</p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td align="center" valign="top" width="200">
                                                                <a href="https://staging-ojolie-frontend-pfylq.ondigitalocean.app/card/pickup/{{encrypt('e_'.$ecardsentrecipient->id)}}" style="text-decoration:none;width:200px;height:36px;font-family:Arial;font-size:16px;font-weight:bold;padding:20px;border:1px solid #333333;color:#333333;text-decoration:none" target="_blank">VIEW YOUR CARD</a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td align="center" valign="top" width="510" class="flexibleContainer">
                                                                <img src="https://staging-ojolie.dingerpay.org/storage/img/ecards/{{$ecardsentrecipient->ecardsentitem->ecard->getThumbnail()}}" width="425" style="height:auto;max-width:425px" tabindex="0" />
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
                                                        <img src="https://www.ojolie.com/cards/img/link_mail.png" alt="" width="335">
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
