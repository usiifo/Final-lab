<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<body>
    <h1>Environment Variables</h1>
    <ul>
        <li>DB_HOST: <?php echo getenv('DB_HOST'); ?></li>
        <li>DB_USERNAME: <?php echo getenv('DB_USERNAME'); ?></li>
        <li>DB_PASSWORD: <?php echo getenv('DB_PASSWORD'); ?></li>
        <li>DB_DATABASE: <?php echo getenv('DB_DATABASE'); ?></li>
        <li>DB_PORT: <?php echo getenv('DB_PORT'); ?></li>
    </ul>
</body>
</html>