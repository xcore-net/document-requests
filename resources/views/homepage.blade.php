<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>صفحة البداية</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #333;
            color: #fff;
            padding: 20px 0;
        }
        .wrapper {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .logo img {
            max-width: 100px;
            height: auto;
        }
        .nav-area ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
        }
        .nav-area li {
            margin-right: 20px;
        }
        .nav-area a {
            text-decoration: none;
            color: #fff;
            font-weight: bold;
        }
        .welcome-text {
            text-align: center;
            margin-top: 50px;
        }
        .welcome-text h1 {
            font-size: 36px;
            margin-bottom: 20px;
        }
        .welcome-text a {
            display: inline-block;
            background-color: #ff6600;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <header>
        <div class="wrapper">
            <div class="logo"><img alt="Logo" src="logo.png"></div>
            <ul class="nav-area">
                <li><a href="#">الرئيسية</a></li>
                <li><a href="#">من نحن</a></li>
                <li><a href="#">الخدمات</a></li>
                <li><a href="#">الأعمال</a></li>
                <li><a href="#">اتصل بنا</a></li>
            </ul>
        </div>
        <div class="welcome-text">
            <form action="{{ route('request.index') }}" method="get">
                <button class="btn btn-danger"> تقديم طلب</button>
            </form>
        </div>
    </header>
</body>
</html>
