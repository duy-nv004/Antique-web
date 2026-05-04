<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Antique Shop - Đồ cổ chính hãng">
    <meta name="keywords" content="đồ cổ, antique, đồ cổ Việt Nam, sưu tầm">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Antique Shop - Đồ cổ chính hãng</title>

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="{{ asset('client/css/bootstrap.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('client/css/font-awesome.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('client/css/elegant-icons.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('client/css/nice-select.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('client/css/jquery-ui.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('client/css/owl.carousel.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('client/css/slicknav.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('client/css/style.css') }}" type="text/css">

    <!-- Chat Widget Styles -->
    <style>
        .chat-widget-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .chat-widget {
            background: white;
            width: 400px;
            max-width: 90%;
            max-height: 80vh;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .chat-header {
            background: linear-gradient(135deg, #b8860b 0%, #daa520 100%);
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .chat-header-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .shop-avatar {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .chat-header h4 {
            margin: 0;
            font-size: 16px;
        }

        .chat-header .status {
            font-size: 12px;
            opacity: 0.9;
        }

        .close-btn {
            background: none;
            border: none;
            color: white;
            font-size: 20px;
            cursor: pointer;
            padding: 5px;
        }

        .chat-product-info {
            display: flex;
            gap: 12px;
            padding: 12px 20px;
            background: #f9f9f9;
            border-bottom: 1px solid #eee;
        }

        .chat-product-image {
            width: 60px;
            height: 60px;
            border-radius: 8px;
            overflow: hidden;
            flex-shrink: 0;
        }

        .chat-product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .chat-product-details h5 {
            margin: 0 0 4px 0;
            font-size: 14px;
            color: #333;
        }

        .chat-product-details .price {
            color: #b8860b;
            font-weight: bold;
            font-size: 14px;
            margin: 0;
        }

        .chat-product-details .note {
            font-size: 11px;
            color: #e74c3c;
            margin: 4px 0 0 0;
        }

        .chat-messages {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
            min-height: 250px;
            max-height: 350px;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .message {
            display: flex;
            flex-direction: column;
            max-width: 80%;
        }

        .shop-message {
            align-self: flex-start;
        }

        .customer-message {
            align-self: flex-end;
        }

        .message-content {
            padding: 10px 14px;
            border-radius: 16px;
            font-size: 14px;
            line-height: 1.4;
        }

        .shop-message .message-content {
            background: #f0f0f0;
            color: #333;
            border-bottom-left-radius: 4px;
        }

        .customer-message .message-content {
            background: #b8860b;
            color: white;
            border-bottom-right-radius: 4px;
        }

        .message-time {
            font-size: 10px;
            color: #999;
            margin-top: 4px;
        }

        .customer-message .message-time {
            text-align: right;
        }

        .chat-input {
            display: flex;
            gap: 10px;
            padding: 15px 20px;
            border-top: 1px solid #eee;
            background: white;
        }

        .chat-input input {
            flex: 1;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 25px;
            outline: none;
            font-size: 14px;
        }

        .chat-input input:focus {
            border-color: #b8860b;
        }

        .chat-input button {
            width: 42px;
            height: 42px;
            border: none;
            background: #b8860b;
            color: white;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.3s;
        }

        .chat-input button:hover {
            background: #8b6914;
        }

        /* Product Card Styles */
        .product__item {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s, box-shadow 0.3s;
            margin-bottom: 30px;
        }

        .product__item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .product__item__pic {
            height: 250px;
            background-size: cover;
            background-position: center;
            position: relative;
        }

        .product__item__pic__hover {
            position: absolute;
            bottom: -50px;
            left: 0;
            right: 0;
            display: flex;
            justify-content: center;
            gap: 10px;
            opacity: 0;
            transition: all 0.3s;
        }

        .product__item:hover .product__item__pic__hover {
            bottom: 15px;
            opacity: 1;
        }

        .contact-btn {
            background: linear-gradient(135deg, #b8860b 0%, #daa520 100%);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 25px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s;
        }

        .contact-btn:hover {
            background: linear-gradient(135deg, #8b6914 0%, #b8860b 100%);
            transform: scale(1.05);
        }

        .product__item__text {
            padding: 20px;
        }

        .product__item__text h6 {
            margin: 0 0 10px 0;
        }

        .product__item__text h6 a {
            color: #333;
            text-decoration: none;
            font-weight: 600;
            font-size: 16px;
        }

        .product__item__text .price {
            color: #b8860b;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .product-info {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .product-info .badge {
            background: #f5f5f5;
            color: #666;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 12px;
        }

        /* Section Title */
        .section-title {
            text-align: center;
            margin-bottom: 40px;
        }

        .section-title h2 {
            font-size: 32px;
            color: #333;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .section-title p {
            color: #666;
            font-size: 16px;
        }

        /* Featured Section */
        .featured {
            padding: 60px 0;
        }

        .spad {
            padding-top: 60px;
            padding-bottom: 60px;
        }

        /* Social Contact Options */
        .social-contact-options {
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .contact-intro {
            color: #555;
            font-size: 14px;
            line-height: 1.5;
            text-align: center;
            margin: 0;
        }

        .social-buttons {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .social-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            padding: 14px 20px;
            border: none;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            color: white;
        }

        .social-btn i {
            font-size: 20px;
        }

        .facebook-btn {
            background: linear-gradient(135deg, #1877f2 0%, #0d65d9 100%);
        }

        .facebook-btn:hover {
            background: linear-gradient(135deg, #0d65d9 0%, #1877f2 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(24, 119, 242, 0.4);
        }

        .instagram-btn {
            background: linear-gradient(135deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);
        }

        .instagram-btn:hover {
            background: linear-gradient(135deg, #bc1888 0%, #dc2743 50%, #f09433 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(225, 48, 108, 0.4);
        }

        .zalo-btn {
            background: linear-gradient(135deg, #0068ff 0%, #0044b5 100%);
        }

        .zalo-btn:hover {
            background: linear-gradient(135deg, #0044b5 0%, #0068ff 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 104, 255, 0.4);
        }

        .zalo-icon {
            width: 20px;
            height: 20px;
        }

        .contact-note {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 12px;
            background: #fff3cd;
            border-radius: 8px;
            font-size: 12px;
            color: #856404;
        }

        .contact-note i {
            color: #ffc107;
        }
    </style>
    @viteReactRefresh
    @vite(['resources/css/app.css', 'resources/js/main.jsx'])
</head>

<body>
    <div id="root"></div>

    <!-- Js Plugins -->
    <script src="{{ asset('client/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('client/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('client/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('client/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('client/js/jquery.slicknav.js') }}"></script>
    <script src="{{ asset('client/js/mixitup.min.js') }}"></script>
    <script src="{{ asset('client/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('client/js/main.js') }}"></script>
</body>

</html>