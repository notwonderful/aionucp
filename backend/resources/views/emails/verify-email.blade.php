@extends('emails.layout')

@section('content')
<table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%">
    <tr>
        <td style="font-family: Arial, Helvetica, sans-serif; font-size: 11px; font-weight: bold; color: #c9a84c; text-transform: uppercase; letter-spacing: 2px; padding-bottom: 12px;">
            {{ __('Welcome') }}
        </td>
    </tr>
    <tr>
        <td style="font-family: Arial, Helvetica, sans-serif; font-size: 22px; font-weight: bold; color: #ede7df; padding-bottom: 8px; text-transform: uppercase; letter-spacing: 1px;">
            {{ __('Verify Your Email') }}
        </td>
    </tr>
    <tr>
        <td style="font-family: Arial, Helvetica, sans-serif; font-size: 14px; color: #8a8078; padding-bottom: 28px;">
            {{ __('Click the button below to verify your email address and activate your account.') }}
        </td>
    </tr>
    <tr>
        <td align="center" style="padding-bottom: 28px;">
            <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td style="background-color: #b83a2a; border-radius: 6px;">
                        <a href="{{ $verificationUrl }}" target="_blank" style="display: inline-block; padding: 13px 32px; font-family: Arial, Helvetica, sans-serif; font-size: 13px; font-weight: bold; color: #ffffff; text-decoration: none; text-transform: uppercase; letter-spacing: 1px;">
                            {{ __('Verify Email') }}
                        </a>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td style="font-family: Arial, Helvetica, sans-serif; font-size: 13px; color: #6b6058; padding-bottom: 20px;">
            {{ __('This link will expire in 60 minutes.') }}
        </td>
    </tr>
    <tr>
        <td style="border-top: 1px solid #2a2118; padding-top: 16px;">
            <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                    <td style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; color: #453d37; line-height: 1.6; word-break: break-all;">
                        {{ __('If the button doesn\'t work, copy and paste this link:') }}
                        <br />
                        <a href="{{ $verificationUrl }}" style="color: #b83a2a; text-decoration: none;">{{ $verificationUrl }}</a>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
@endsection
