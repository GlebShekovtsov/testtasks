<?php
// Подключение к базе данных
$con = 'mysql:host=localhost;dbname=forum;charset=utf8';
$username = 'root';
$password = 'root';
try {
    $pdo = new PDO($con, $username, $password);
} catch (PDOException $e) {
    die("Ошибка подключения к базе данных: " . $e->getMessage());
}

// Обработка формы добавления комментария
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $comment = $_POST['comment'] ?? '';

    if (!empty($username) && !empty($comment)) {
        // Защита от SQL-инъекций с использованием подготовленных выражений
        $stmt = $pdo->prepare("INSERT INTO comments (username, comment) VALUES (:username, :comment)");
        $stmt->execute([':username' => $username, ':comment' => $comment]);
    }
}

// Получение всех комментариев из базы данных
$comments = $pdo->query("SELECT username, comment, created_at FROM comments ORDER BY created_at ASC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Комментарии</title>
</head>
<body>
    <h1>Комментарии</h1>

    <!-- Список комментариев -->
    <?php foreach ($comments as $comment): ?>
        <div>
            <strong><?= htmlspecialchars($comment['username']) ?></strong> (<?= $comment['created_at'] ?>):
            <p><?= nl2br(htmlspecialchars($comment['comment'])) ?></p>
        </div>
        <hr>
    <?php endforeach; ?>

    <!-- Форма добавления нового комментария -->
    <h2>Оставить комментарий</h2>
    <form method="post">
        <label for="username">Имя:</label>
        <input type="text" id="username" name="username" required><br>

        <label for="comment">Комментарий:</label><br>
        <textarea id="comment" name="comment" rows="4" required></textarea><br>

        <button type="submit">Отправить</button>
    </form>
</body>
</html>
