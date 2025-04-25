<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Level 1 — Көктемгі ауыл</title>
  <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      font-family: 'Press Start 2P', cursive;
      background: url('../assets/levelOne/springWarrior.png') no-repeat center center fixed;
      background-size: cover;
      overflow-x: hidden;
    }

    .map-container {
      position: relative;
      width: 100vw;
      height: 100vh;
    }

    .task-point {
      position: absolute;
      width: 60px;
      height: 60px;
      background-color: rgba(255, 255, 255, 0.8);
      border: 3px solid #00ccff;
      border-radius: 50%;
      cursor: pointer;
      display: flex;
      justify-content: center;
      align-items: center;
      text-align: center;
      font-size: 8px;
      color: #000;
      text-decoration: none;
      transition: transform 0.3s;
    }

    .task-point:hover {
      transform: scale(1.1);
    }

    .task-point.locked {
      background-color: rgba(0, 0, 0, 0.6);
      color: #fff;
      border: 2px dashed #999;
      cursor: default;
    }
  </style>
</head>
<body>
<div class="map-container">
  <a href="task_solve.php?id=1" class="task-point" style="top: 89%; left: 80%;">Hello<br>World</a>
  <a href="task_solve.php?id=2" class="task-point locked" style="top: 80.5%; left: 58.5%;">Айнымалы</a>
  <a href="task_solve.php?id=3" class="task-point locked" style="top: 78%; left: 30%;">Қосу</a>
  <a href="task_solve.php?id=4" class="task-point locked" style="top: 54%; left: 14.5%;">Input</a>
</div>

</body>
</html>
