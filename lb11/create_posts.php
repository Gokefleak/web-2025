<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Новый пост</title>
  <link rel="stylesheet" href="create_posts.css">
  <style>
    .image-counter {
      position: absolute;
      bottom: 10px;
      right: 10px;
      font-size: 14px;
      color: white;
      background-color: rgba(0, 0, 0, 0.6);
      padding: 4px 8px;
      border-radius: 10px;
      z-index: 10;
    }

    .photo-container {
      position: relative;
    }

    .photo-area {
      position: relative;
      width: 100%;
      max-width: 400px;
      margin: auto;
    }

    .display {
      max-width: 100%;
      height: auto;
      display: none;
    }

    .slider-buttons {
      position: absolute;
      top: 50%;
      width: 100%;
      display: flex;
      justify-content: space-between;
      transform: translateY(-50%);
      z-index: 2;
    }

    .slider-buttons button {
      background: none;
      border: none;
      cursor: pointer;
    }
  </style>
</head>
<body>
  <div class="header">Новый пост</div>

  <div class="photo-container">
    <div class="photo-area" id="photo-area">
      <div class="slider-buttons">
        <button id="prev-btn"><img src="postPicture/left_arrow.png" alt="prev"></button>
        <button id="next-btn"><img src="postPicture/right_arrow.png" alt="next"></button>
      </div>
      <div id="add-photo-content" class="photo-content">
        <img src="postPicture/photos.png" alt="иконка" class="icon">
        <button class="center-add-button" id="center-add-photo" onclick="document.getElementById('file-input').click()">Добавить фото</button>
      </div>
      <img id="preview" src="" alt="" class="display">
      <div id="image-counter" class="image-counter" style="display: none;">1 / 1</div>
    </div>

    <button class="bottom-add-button" onclick="document.getElementById('file-input').click()">+ Добавить фото</button>
  </div>

  <input type="file" id="file-input" multiple accept="image/*" style="display:none" onchange="handleFiles(this.files)">

  <textarea id="caption" placeholder="Добавьте подпись..." oninput="checkShareButton()"></textarea>

  <button id="share-button" class="share-button" disabled>Поделиться</button>

  <script>
    let images = [];
    let currentIndex = 0;

    const preview = document.getElementById('preview');
    const shareButton = document.getElementById('share-button');
    const prevBtn = document.getElementById('prev-btn');
    const nextBtn = document.getElementById('next-btn');
    const addPhotoContent = document.getElementById('add-photo-content');
    const imageCounter = document.getElementById('image-counter');

    function handleFiles(files) {
      for (let file of files) {
        const reader = new FileReader();
        reader.onload = function(e) {
          images.push(e.target.result);
          if (images.length === 1) {
            preview.src = images[0];
            preview.style.display = 'block';
            addPhotoContent.style.display = 'none';
          }
          updateSliderButtons();
          updateImageCounter();
          checkShareButton();
        };
        reader.readAsDataURL(file);
      }
    }

    function updateSliderButtons() {
      if (images.length > 1) {
        prevBtn.style.display = 'inline';
        nextBtn.style.display = 'inline';
      } else {
        prevBtn.style.display = 'none';
        nextBtn.style.display = 'none';
      }
    }

    prevBtn.onclick = () => switchImage(-1);
    nextBtn.onclick = () => switchImage(1);

    function switchImage(direction) {
      currentIndex = (currentIndex + direction + images.length) % images.length;
      preview.src = images[currentIndex];
      updateImageCounter();
    }

    function updateImageCounter() {
      if (images.length > 1) {
        imageCounter.style.display = 'block';
        imageCounter.textContent = `${currentIndex + 1} / ${images.length}`;
      } else {
        imageCounter.style.display = 'none';
      }
    }

    function checkShareButton() {
      const text = document.getElementById('caption').value.trim();
      if (images.length > 0 && text.length > 0) {
        shareButton.disabled = false;
        shareButton.style.opacity = '1';
        shareButton.style.cursor = 'pointer';
        shareButton.style.background = '#3897f0';
      } else {
        shareButton.disabled = true;
        shareButton.style.opacity = '0.5';
        shareButton.style.cursor = 'not-allowed';
        shareButton.style.background = 'gray';
      }
    }

    shareButton.onclick = () => {
      const caption = document.getElementById('caption').value.trim();
      console.log({ caption, images });
    };
  </script>
</body>
</html>
