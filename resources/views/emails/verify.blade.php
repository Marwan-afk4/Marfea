<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify Your Email - Marfea</title>
</head>
<body style="margin: 0; padding: 0; background-color: #e6f0f9; font-family: 'Segoe UI', Arial, sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #e6f0f9;">
        <tr>
            <td align="center" style="padding: 40px 15px;">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 12px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08); overflow: hidden;">
                    <tr>
                        <td align="center" style="background-color: #007BFF; padding: 30px;">
                            <h1 style="margin: 0; color: #ffffff; font-size: 30px; font-weight: bold; letter-spacing: 1px;">
                                Marfea
                            </h1>
                            <p style="margin: 5px 0 0; color: #cce6ff; font-size: 14px;">Empowering Healthcare</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 35px 30px;">
                            <h2 style="color: #003366;">Hello {{ $fullname }},</h2>
                            <h2 style="color: #003366;">Welcome to Marfea 👨‍⚕️</h2>
                            <p style="font-size: 16px; color: #555555;">
                                Please verify your email address to activate your Marfea account. Use the following verification code:
                            </p>
                            <div style="text-align: center; margin: 30px 0;">
                                <span style="display: inline-block; font-size: 36px; font-weight: bold; letter-spacing: 8px; background-color: #f0f8ff; padding: 18px 35px; border-radius: 10px; color: #007BFF;">
                                    {{ $code }}
                                </span>
                            </div>
                            <p style="font-size: 14px; color: #777777;">
                                If you didn’t request this code, you can safely ignore this email.
                            </p>
                            <p style="font-size: 14px; color: #555555;">
                                Best regards,<br><strong>Marfea Support Team</strong>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="background-color: #f5faff; padding: 20px; font-size: 12px; color: #999999;">
                            &copy; {{ date('Y') }} Marfea. All rights reserved.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
