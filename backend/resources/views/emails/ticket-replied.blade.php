@extends('emails.layout')

@section('content')
<table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%">
    <tr>
        <td style="font-family: Arial, Helvetica, sans-serif; font-size: 11px; font-weight: bold; color: #b83a2a; text-transform: uppercase; letter-spacing: 2px; padding-bottom: 12px;">
            {{ __('Support') }}
        </td>
    </tr>
    <tr>
        <td style="font-family: Arial, Helvetica, sans-serif; font-size: 22px; font-weight: bold; color: #ede7df; padding-bottom: 8px; text-transform: uppercase; letter-spacing: 1px;">
            {{ __('New Reply') }}
        </td>
    </tr>
    <tr>
        <td style="font-family: Arial, Helvetica, sans-serif; font-size: 14px; color: #8a8078; padding-bottom: 24px;">
            <strong style="color: #c4bbb0;">{{ $senderName }}</strong> {{ __('replied to') }} <strong style="color: #c4bbb0;">{{ $ticketSubject }}</strong>
        </td>
    </tr>
    <tr>
        <td style="padding-bottom: 28px;">
            <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="background-color: #1e1a16; border-left: 3px solid #b83a2a; border-radius: 4px;">
                <tr>
                    <td style="padding: 16px 20px; font-family: Arial, Helvetica, sans-serif; font-size: 14px; color: #8a8078; line-height: 1.6; font-style: italic;">
                        &ldquo;{{ $messagePreview }}&rdquo;
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td align="center" style="padding-bottom: 8px;">
            <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td style="background-color: #b83a2a; border-radius: 6px;">
                        <a href="{{ $actionUrl }}" target="_blank" style="display: inline-block; padding: 13px 32px; font-family: Arial, Helvetica, sans-serif; font-size: 13px; font-weight: bold; color: #ffffff; text-decoration: none; text-transform: uppercase; letter-spacing: 1px;">
                            {{ __('View Ticket') }}
                        </a>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
@endsection
