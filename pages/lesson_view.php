<?php
$videoId = $_GET['id'] ?? '';
$videoTitle = $_GET['title'] ?? 'Бейне сабақ';

if (!$videoId) {
    echo "Сабақ табылмады!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="kk">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($videoTitle) ?></title>
  <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      background-color: #000;
      font-family: 'Press Start 2P', cursive;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      color: white;
    }

    .video-wrapper {
      margin-top: 40px;
      max-width: 960px;
      width: 90%;
      aspect-ratio: 16 / 9;
    }

    iframe {
      width: 100%;
      height: 100%;
      border: none;
    }

    .title {
      margin-top: 20px;
      font-size: 12px;
      text-align: center;
    }

    .back-btn {
      margin-top: 30px;
      font-size: 10px;
      background: #00ff88;
      padding: 8px 20px;
      color: black;
      text-decoration: none;
    }
  </style>
</head>
<body>

<h2 class="title"><?= htmlspecialchars($videoTitle) ?></h2>

<div class="video-wrapper">
    <iframe src="https://www.youtube.com/embed/<?= htmlspecialchars($videoId) ?>?autoplay=1" allowfullscreen></iframe>
</div>

<a href="level1_map.php" class="back-btn">← Картаға қайту</a>

</body>
</html>
