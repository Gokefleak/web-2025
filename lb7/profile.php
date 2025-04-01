<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Профиль</title>
    <link rel="stylesheet" href="profile.css">
    <base href="profilePicture/">
</head>
<body>
<?php
// ID из URL
$userId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Lекодируем JSON
$jsonData = file_get_contents('users.json');
$data = json_decode($jsonData, true);

// Ищем пользователя по id
$user = null;
foreach ($data as $entry) {
    if ($entry['id'] === $userId) {
        $user = $entry;
        break;
    }
}
?>

<?php if ($user): ?>
<div class="container">
    <div class="left-bar">
        <button type="button" class="home-button">
            <img src="home.png" alt="домой" class="home-icon">
        </button>
        <button type="button" class="profile-button">
            <img src="profile.png" alt="профиль" class="profile-icon">
        </button>
        <button type="button" class="plus-button">
            <img src="new_post.png" alt="новый пост" class="plus-icon">
        </button>
    </div>

    <div class="centre-side">
        <div class="image-container">
            <img src="<?= htmlspecialchars($user['avatar']) ?>" alt="Фото" class="image">
        </div>
        <p><span class="name"><?= htmlspecialchars($user['name']) ?></span></p>
        <p><span class="text"><?= htmlspecialchars($user['info']) ?></span></p>

        <?php
        $allImages = [];

        foreach ($user['posts'] as $post) {
            $images = is_array($post['image']) ? $post['image'] : [$post['image']];
            $allImages = array_merge($allImages, $images);
        }
        foreach (array_chunk($allImages, 3) as $imageGroup): ?>
            <div class="image-below-container">
                <?php foreach ($imageGroup as $img): ?>
                    <img src="<?= htmlspecialchars($img) ?>" alt="Ошибка с изображением" class="image-below">
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php else: ?>
    <p>Пользователь не найден</p>
<?php endif; ?>
</body>
</html>
