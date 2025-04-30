<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt lại mật khẩu</title>
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
            <h1>Đặt lại mật khẩu</h1>
        </div>
        <div class="content">
            <p>Xin chào {{ $name }},</p>

            <p>Chúng tôi nhận được yêu cầu đặt lại mật khẩu cho tài khoản của bạn. Nhấp vào nút bên dưới để đặt lại mật khẩu:</p>

            <div style="text-align: center;">
                <a href="{{ $resetUrl }}" class="button">Đặt lại mật khẩu</a>
            </div>

            <p>Nếu bạn không thể nhấp vào nút trên, hãy sao chép và dán đường dẫn sau vào trình duyệt của bạn:</p>

            <p style="word-break: break-all;">{{ $resetUrl }}</p>

            <p>Lưu ý: Liên kết này sẽ hết hạn sau 1 giờ.</p>

            <p>Nếu bạn không yêu cầu đặt lại mật khẩu, vui lòng bỏ qua email này.</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Quản lý sách. Tất cả các quyền được bảo lưu.</p>
        </div>
    </div>
</body>
</html>
