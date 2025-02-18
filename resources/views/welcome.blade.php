<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Point Of Sales</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            text-align: center;
            position: relative;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            transition: 0.3s;
        }
        .container:hover {
            transform: scale(1.03);
            box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.3);
        }
        .profile-card {
            position: absolute;
            right: 20px;
            background: white;
            color: black;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            transition: 0.3s;
            cursor: pointer;
        }
        .profile-card:hover {
            transform: scale(1.05);
            box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.3);
        }
        h1 {
            color: #343a40;
        }
        .categories {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-top: 20px;
        }
        .category {
            padding: 15px;
            background: #007bff;
            color: white;
            font-weight: bold;
            border-radius: 5px;
            transition: 0.3s;
            cursor: pointer;
        }
        .category:hover {
            background: #0056b3;
        }
        .transaction {
            margin-top: 30px;
            padding: 15px;
            border-radius: 5px;
            background: #ffc107;
            color: black;
            cursor: pointer;
        }
        .transaction:hover {
            background: #e0a800;
        }
    </style>
</head>
<body>
    <div class="profile-card" onclick="window.location.href='/POS/public/profile'">
        <h3>Profile</h3>
    </div>
    
    <div class="container">
        <h1>Welcome to Point Of Sales</h1>
        
        <h2>Categories</h2>
        <div class="categories">
            <div class="category" onclick="location.href='/POS/public/foodAndBeverage'">Food and Beverage</div>
            <div class="category" onclick="location.href='/POS/public/beautyHealth'">Beauty Health</div>
            <div class="category" onclick="location.href='/POS/public/homeCare'">Home Care</div>
            <div class="category" onclick="location.href='/POS/public/babyKid'">Baby Kid</div>
        </div>

        <h2>Transaction</h2>
        <div class="transaction" onclick="window.location.href='/POS/public/transaction'">Go to POS Transaction</div>
    </div>
</body>
</html>