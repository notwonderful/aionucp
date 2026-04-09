@extends('emails.layout')

@section('content')
<table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%">
    <tr>
        <td style="font-family: Arial, Helvetica, sans-serif; font-size: 11px; font-weight: bold; color: #b83a2a; text-transform: uppercase; letter-spacing: 2px; padding-bottom: 12px;">
            {{ __('Authentication') }}
        </td>
    </tr>
    <tr>
        <td style="font-family: Arial, Helvetica, sans-serif; font-size: 22px; font-weight: bold; color: #ede7df; padding-bottom: 8px; text-transform: uppercase; letter-spacing: 1px;">
            {{ __('Verification Code') }}
        </td>
    </tr>
    <tr>
        <td style="font-family: Arial, Helvetica, sans-serif; font-size: 14px; color: #8a8078; padding-bottom: 28px;">
            {{ __('Use the code below to complete your authentication.') }}
        </td>
    </tr>
    <tr>
        <td align="center" style="padding-bottom: 28px;">
            <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="background-color: #1e1a16; border-radius: 6px;">
                <tr>
                    <td style="padding: 24px 20px; text-align: center; font-family: 'Courier New', Courier, monospace; font-size: 38px; font-weight: bold; color: #ede7df; letter-spacing: 10px;">
                        {{ $code }}
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td style="font-family: Arial, Helvetica, sans-serif; font-size: 13px; color: #6b6058; padding-bottom: 4px;">
            {{ __('This code will expire in 10 minutes.') }}
        </td>
    </tr>
    <tr>
        <td style="font-family: Arial, Helvetica, sans-serif; font-size: 13px; color: #6b6058;">
            {{ __('If you did not request this code, please ignore this email.') }}
        </td>
    </tr>
</table>
@endsection
