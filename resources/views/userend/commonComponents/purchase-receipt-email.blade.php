<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Product Purchase Receipt</title>
</head>
<body>
    <h1>Brand Name</h1>

    <h2>Purchase Receipt</h2>

    <p>Hello {{ $nameOfUser }},</p>

    <p>Your Purchase Details: </p>

    <pre>
        Product: {{ $productName }}
        Price: {{ $orderInfo['price'] }}
        Quantity: {{ $orderInfo['quantity'] }}
        Total Amount: {{ $orderInfo['total_amount'] }}
    </pre>

    <p>Your Product is in process and will be delivered in 5 to 7 business days.</p>
    <p>Thank you for your purchase.</p>
</body>
</html>
