<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>TRACESCI</title>
</head>

<body style="margin:0;padding:0;background:#f4f4f4;font-family:Arial,sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f4f4;padding:30px 0;">
        <tr>
            <td align="center">

                <table width="650" cellpadding="0" cellspacing="0" style="background:#fff;border-radius:10px;overflow:hidden;">

                    <tr>
                        <td style="background:#7a0d7d;padding:25px;text-align:center;">
                            <h1 style="color:#fff;margin:0;">
                                TRACESCI
                            </h1>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:30px;">
                            {!! $email_body !!}
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:20px;text-align:center;background:#f9f9f9;color:#666;">
                            © {{ date('Y') }} TRACESCI
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>