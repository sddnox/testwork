<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Моя форма</title>
    <style>
        body {
            background-color: black;
            color: green;
            font-family: 'Arial', sans-serif;
        }

        .container {
            width: 50%;
            margin: 0 auto;
            padding: 20px;
            text-align: center;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
        }

        button {
            background-color: green;
            color: black;
            padding: 10px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Моя форма</h2>
        <form action="ProcessForm.php" method="post">
            <label for="name">Имя:</label>
            <input type="text" name="name" required>

            <label for="email">Email:</label>
            <input type="email" name="email" required>

            <label for="phone">Телефон:</label>
            <input type="tel" name="phone" required>

            <label for="price">Цена:</label>
            <input type="number" name="price" required>

            <button type="submit">Отправить</button>
        </form>
    </div>
</body>
</html>
