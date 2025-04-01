<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Посты</title>
    <link rel="stylesheet" href="posts.css">
    <base href="postPicture/">
</head>
<body>

    <?php
    $json_data = file_get_contents('users.json');
    $data = json_decode($json_data, true);
    
    if (!empty($data)) {
    ?>
    
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
            
            <?php foreach ($data as $user): ?>
            <div class="image-container">
                <img src="<?= htmlspecialchars($user['avatar']) ?>" alt="Фото" class="image">
                <span class="text"><?= htmlspecialchars($user['name']) ?></span>
                <button type="button" class="edit-button">
                    <img src="edit.png" alt="Испарвление" class="edit-icon">
                </button>
            </div>
            
            <?php foreach ($user['posts'] as $post): ?>
            <div class="image-below-container">
                <button type="button" class="left-button" disabled>
                    <img src="left_arrow.png" alt="стрелка влево" class="left-icon">
                </button>
                <button type="button" class="right-button" disabled>
                    <img src="right_arrow.png" alt="стрелка вправо" class="right-icon">
                </button>
                <?php 
                // Определяем какое изображение показывать (первое в массиве или единственное)
                $imageToShow = is_array($post['image']) ? $post['image'][0] : $post['image'];
                $imageCount = is_array($post['image']) ? count($post['image']) : 1;
                ?>
                <img src="<?= htmlspecialchars($imageToShow) ?>" alt="Изображение под текстом" class="image-below">
                <div class="ellipse">1/<?= $imageCount ?></div>
            </div>

            <button type="button" class="like-button">
                <img src="like.png" alt="Лайк" class="like-icon">
                <span class="like-count"><?= $post['likes'] ?></span>
            </button>

            <?php if (!empty($post['text'])): ?>
            <div class="info-text"><?= htmlspecialchars($post['text']) ?></div>
            <?php endif; ?>

            <div class="time-text">
                <?php
                $hours = floor($post['timeAgo'] / 60);
                $minutes = $post['timeAgo'] % 60;
    
                if ($hours > 0) {
                    echo $hours . ' час' . ($hours > 1 ? 'а' : '') . ' назад';
                } else {
                    echo $minutes . ' минут' . 
                         ($minutes % 10 == 1 && $minutes != 11 ? 'у' : 
                         ($minutes % 10 >= 2 && $minutes % 10 <= 4 && ($minutes < 10 || $minutes > 20) ? 'ы' : '')) . 
                         ' назад';
                }
                ?>
            </div>
            <?php endforeach; ?>
            <?php endforeach; ?>
            
        </div>
    </div>
    
    <?php
    } else {
        echo '<p>Нет данных для отображения</p>';
    }
    ?>

</body>
</html>