<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Посты</title>
    <link rel="stylesheet" href="posts2.css">
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
            
            <?php foreach ($user['posts'] as $postId => $post): ?>
            <div class="image-container">
                <img src="<?= htmlspecialchars($user['avatar']) ?>" alt="Фото" class="image">
                <span class="text"><?= htmlspecialchars($user['name']) ?></span>
                <button type="button" class="edit-button">
                    <img src="edit.png" alt="Испарвление" class="edit-icon">
                </button>
            </div>
            <div class="image-below-container" data-post-id="<?= $postId ?>">
                <button type="button" class="left-button">
                    <img src="left_arrow.png" alt="стрелка влево" class="left-icon">
                </button>
                <button type="button" class="right-button">
                    <img src="right_arrow.png" alt="стрелка вправо" class="right-icon">
                </button>
                <?php
                $images = is_array($post['image']) ? $post['image'] : [$post['image']];
                $imageCount = count($images);
                ?>
                <img src="<?= htmlspecialchars($images[0]) ?>" 
                     alt="Изображение под текстом" 
                     class="image-below"
                     data-images='<?= json_encode($images) ?>'
                     data-current-index="0">
                <div class="ellipse">1/<?= $imageCount ?></div>
            </div>

            <button type="button" class="like-button">
                <img src="like.png" alt="Лайк" class="like-icon">
                <span class="like-count"><?= $post['likes'] ?></span>
            </button>

            <?php if (!empty($post['text'])): ?>
            <div class="post-text">
                <div class="post-text__content post-text__content--collapsed" data-post-id="<?= $postId ?>">
                    <?= htmlspecialchars($post['text']) ?>
                </div>
                <button class="post-text__toggle-button hidden">ещё</button>
            </div>
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
    <!-- Окно -->
    <div id="modal" class="modal hidden">
        <div class="modal-content">
            <span id="modal-close" class="modal-close">&times;</span>
            <button type="button" class="left-button">
                <img src="left_arrow.png" alt="стрелка влево" class="left-icon">
            </button>
            <img id="modal-image" src="" alt="Просмотр изображения" class="modal-image">
            <button type="button" class="right-button">
                <img src="right_arrow.png" alt="стрелка вправо" class="right-icon">
            </button>
            <div id="modal-counter" class="modal-counter">1/1</div>
        </div>
    </div>


    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Переключение изображений в посте
        document.querySelectorAll('.left-button, .right-button').forEach(button => {
            button.addEventListener('click', function () {
                const container = this.closest('.image-below-container');
                const img = container.querySelector('.image-below');
                const counter = container.querySelector('.ellipse');

                const images = JSON.parse(img.dataset.images);
                let currentIndex = parseInt(img.dataset.currentIndex);
                const direction = this.classList.contains('left-button') ? -1 : 1;

                currentIndex = (currentIndex + direction + images.length) % images.length;

                img.src = images[currentIndex];
                img.dataset.currentIndex = currentIndex;
                counter.textContent = (currentIndex + 1) + '/' + images.length;
            });
        });

        // Открытие окна
        document.querySelectorAll('.image-below').forEach(image => {
            image.addEventListener('click', function () {
                const images = JSON.parse(this.dataset.images);
                let currentIndex = parseInt(this.dataset.currentIndex);

                const modal = document.getElementById('modal');
                const modalImg = document.getElementById('modal-image');
                const modalCounter = document.getElementById('modal-counter');

                modal.dataset.images = JSON.stringify(images);
                modal.dataset.currentIndex = currentIndex;

                modalImg.src = images[currentIndex];
                modalCounter.textContent = (currentIndex + 1) + '/' + images.length;

                modal.classList.remove('hidden');

                // Добавление esc
                document.addEventListener('keydown', escKeyHandler);
            });
        });

        // Обработчик закрытия по esc
        function escKeyHandler(event) {
            if (event.key === 'Escape') {
                closeModal();
            }
        }

        // Функция закрытия
        function closeModal() {
            const modal = document.getElementById('modal');
            modal.classList.add('hidden');
            document.removeEventListener('keydown', escKeyHandler);
        }
        
        function initTextToggler() {
            document.querySelectorAll('.post-text__content').forEach(content => {
                const button = content.nextElementSibling;
            
                // Проверяем, нужно ли показывать кнопку "ещё"
                if (content.scrollHeight > content.clientHeight) {
                    button.classList.remove('hidden');
                }
            });
        }

        // Обработчик клика на кнопку
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('post-text__toggle-button')) {
                const content = e.target.previousElementSibling;
            
                if (content.classList.contains('post-text__content--collapsed')) {
                    // Показываем полный текст
                    content.classList.remove('post-text__content--collapsed');
                    e.target.textContent = 'свернуть';
                } else {
                    // Сворачиваем текст
                    content.classList.add('post-text__content--collapsed');
                    e.target.textContent = 'ещё';
                }
            }
        });

        // Инициализация при загрузке
        initTextToggler();
    
        // Инициализация при изменении размера окна
        window.addEventListener('resize', initTextToggler);


        // Кнопка закрытия
        document.getElementById('modal-close').addEventListener('click', closeModal);

        // ереключение изображений в окне
        document.querySelector('#modal .left-button').addEventListener('click', function () {
            updateModalImage(-1);
        });
        document.querySelector('#modal .right-button').addEventListener('click', function () {
            updateModalImage(1);
        });

        function updateModalImage(direction) {
            const modal = document.getElementById('modal');
            const modalImg = document.getElementById('modal-image');
            const modalCounter = document.getElementById('modal-counter');

            let images = JSON.parse(modal.dataset.images);
            let currentIndex = parseInt(modal.dataset.currentIndex);

            currentIndex = (currentIndex + direction + images.length) % images.length;

            modal.dataset.currentIndex = currentIndex;
            modalImg.src = images[currentIndex];
            modalCounter.textContent = (currentIndex + 1) + '/' + images.length;
        }
        const posts = document.querySelectorAll(".post-text");

        posts.forEach(post => {
            const content = post.querySelector(".post-text__content");
            const button = post.querySelector(".post-text__toggle-button");

            if (content.scrollHeight > content.clientHeight + 1) {
                button.classList.add("visible");
                button.addEventListener("click", () => {
                    content.classList.toggle("post-text__content--collapsed");
                    button.textContent = content.classList.contains("post-text__content--collapsed") ? "ещё" : "свернуть";
                });
            }
        });
        document.querySelectorAll(".post-text").forEach(function (block) {
            const content = block.querySelector(".post-text__content");
            const button = block.querySelector(".post-text__toggle-button");

            // Проверка: если текста больше 2 строк, показываем кнопку
            const lineHeight = parseFloat(getComputedStyle(content).lineHeight);
            const maxHeight = lineHeight * 2;

            if (content.scrollHeight > maxHeight) {
                button.classList.add("visible");
            }

            // Клик по кнопке
            button.addEventListener("click", function () {
                const isCollapsed = content.classList.contains("post-text__content--collapsed");

                if (isCollapsed) {
                    content.classList.remove("post-text__content--collapsed");
                    button.textContent = "свернуть";
                } else {
                    content.classList.add("post-text__content--collapsed");
                    button.textContent = "ещё";
                }
            });
        });


    });
    
    </script>


    <?php
    } else {
        echo '<p>Нет данных для отображения</p>';
    }
    ?>

</body>
</html>
