<div style="margin:auto;padding:10px;width:600px;display:block;">
    <p style="line-height: 1.5em; letter-spacing: 1px; text-align:center; padding:30px 0px; font-family: 'Baskerville', Arial, Helvetica; font-weight:normal; font-size: 20px; color:#333333;">{{ $ecardsentrecipient->ecardsentitem->user->getFullName() }} ({{ $ecardsentrecipient->ecardsentitem->user->getEmail() }}) has sent you a card.</p>
    @if ($ecardsentrecipient->ecardsentitem->email_message != null)
    <p style="line-height: 1.5em; letter-spacing: 1px; text-align:center; padding:30px 0px; font-family: 'Baskerville', Arial, Helvetica; font-weight:normal; font-size: 20px; color:#333333;">Message <br/>{{ $ecardsentrecipient->ecardsentitem->email_message }}</p>
    @endif
    <p><a style="width: 160px; height: auto; font-size: 16px; text-align: center; margin: auto;font-weight: bold; padding: 20px;border: 1px solid #333333;color: #333333; text-decoration: none; display: block;"  href="https://staging-ojolie.dingerpay.org/api/product/ecardpickup/redirect/{{encrypt('e_'.$ecardsentrecipient->id)}}" target="_blank">VIEW YOUR CARD</a></p>

    <img src="https://staging-ojolie.dingerpay.org/storage/img/ecards/{{ $ecardsentrecipient->ecardsentitem->ecard->getThumbnail() }}.jpg" width="425" style="height: auto;max-width: 425px;margin: 45px auto;display: block;" tabindex="0" />
</div>
