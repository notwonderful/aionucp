<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="{{ app()->getLocale() }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ config('app.name') }}</title>
    <!--[if mso]>
    <style type="text/css">
        table { border-collapse: collapse; }
    </style>
    <![endif]-->
</head>
<body style="margin: 0; padding: 0; background-color: #111010; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%;">

<table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="background-color: #111010;">
    <tr>
        <td align="center" style="padding: 32px 16px;">

            <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="600" style="max-width: 600px; width: 100%;">

                {{-- Top accent bar (like site banner) --}}
                <tr>
                    <td style="height: 3px; background: linear-gradient(90deg, #b83a2a, #cf4a35, #b83a2a); font-size: 0; line-height: 0;">&nbsp;</td>
                </tr>

                {{-- Header --}}
                <tr>
                    <td style="background-color: #1a1210; padding: 20px 36px; border-bottom: 1px solid #2a2118;">
                        <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td style="font-family: Arial, Helvetica, sans-serif; font-size: 18px; font-weight: bold; color: #e8e0d6; letter-spacing: 3px; text-transform: uppercase;">
                                    AION<span style="color: #b83a2a;">UCP</span>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                {{-- Content --}}
                <tr>
                    <td style="background-color: #161311; padding: 36px 36px 40px 36px; font-family: Arial, Helvetica, sans-serif; font-size: 15px; line-height: 1.7; color: #c4bbb0;">
                        @yield('content')
                    </td>
                </tr>

                {{-- Footer --}}
                <tr>
                    <td style="background-color: #1a1210; border-top: 1px solid #2a2118; padding: 20px 36px;">
                        <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%">
                            <tr>
                                <td style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; color: #5a504a; line-height: 1.6;">
                                    &copy; {{ date('Y') }} AionUCP
                                </td>
                                <td align="right" style="font-family: Arial, Helvetica, sans-serif; font-size: 11px; color: #453d37;">
                                    {{ __('Automated message') }}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

            </table>

        </td>
    </tr>
</table>

</body>
</html>
