@extends('emails.layout')

@section('content')
<table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%">
    <tr>
        <td style="font-family: Arial, Helvetica, sans-serif; font-size: 11px; font-weight: bold; color: #c9a84c; text-transform: uppercase; letter-spacing: 2px; padding-bottom: 12px;">
            {{ __('Donation') }}
        </td>
    </tr>
    <tr>
        <td style="font-family: Arial, Helvetica, sans-serif; font-size: 22px; font-weight: bold; color: #ede7df; padding-bottom: 8px; text-transform: uppercase; letter-spacing: 1px;">
            {{ __('Thank you!') }}
        </td>
    </tr>
    <tr>
        <td style="font-family: Arial, Helvetica, sans-serif; font-size: 14px; color: #8a8078; padding-bottom: 28px;">
            {{ __('Your payment has been processed successfully.') }}
        </td>
    </tr>
    <tr>
        <td style="padding-bottom: 28px;">
            <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="background-color: #1e1a16; border-radius: 6px;">
                <tr>
                    <td style="padding: 20px 24px; border-bottom: 1px solid #2a2118;">
                        <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%">
                            <tr>
                                <td style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; color: #6b6058; text-transform: uppercase; letter-spacing: 1px;">
                                    {{ __('Credited') }}
                                </td>
                                <td align="right" style="font-family: Arial, Helvetica, sans-serif; font-size: 20px; color: #c9a84c; font-weight: bold;">
                                    {{ $amountToll }} Toll
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 16px 24px;">
                        <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%">
                            <tr>
                                <td style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; color: #6b6058; text-transform: uppercase; letter-spacing: 1px;">
                                    {{ __('Amount paid') }}
                                </td>
                                <td align="right" style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #c4bbb0;">
                                    {{ $amountMoney }} {{ $currency }}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td style="font-family: Arial, Helvetica, sans-serif; font-size: 13px; color: #6b6058;">
            {{ __('The Toll has been added to your account balance.') }}
        </td>
    </tr>
</table>
@endsection
