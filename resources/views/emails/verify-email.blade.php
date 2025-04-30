<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác thực địa chỉ email</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #4A6FDC;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .content {
            padding: 20px;
            background-color: #f7f7f7;
        }
        .button {
            display: inline-block;
            background-color: #4A6FDC;
            color: white;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 4px;
            margin: 20px 0;
        }
        .footer {
            font-size: 12px;
            color: #777;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Xác thực email của bạn</h1>
        </div>
        <div class="content">
            <p>Xin chào {{ $name }},</p>

            <p>Cảm ơn bạn đã đăng ký tài khoản. Vui lòng xác nhận địa chỉ email của bạn bằng cách nhấp vào nút bên dưới:</p>

            <div style="text-align: center;">
                <a href="{{ $verificationUrl }}" class="button">Xác nhận địa chỉ email</a>
            </div>

            <p>Nếu bạn không thể nhấp vào nút trên, hãy sao chép và dán đường dẫn sau vào trình duyệt của bạn:</p>

            <p style="word-break: break-all;">{{ $verificationUrl }}</p>

            <p>Lưu ý: Liên kết này sẽ hết hạn sau 24 giờ.</p>

            <p>Nếu bạn không đăng ký tài khoản, vui lòng bỏ qua email này.</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Quản lý sách. Tất cả các quyền được bảo lưu.</p>
        </div>
    </div>
</body>
</html>
