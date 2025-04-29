<?php include '../includes/header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/style/Kubok.css">
    <title>Raitings</title>
</head>
<body>
<div class="raiting-container">
<h3>Raitings</h3>
<div class="raiting-back">
<div class="leaderboard">
  <div class="leaderboard-header">
    <div>#</div>
    <div>User ID</div>
    <div>Name</div>
    <div>Points</div>
    <div>Level</div>
    <div>Progress</div>
  </div>

  <!-- Top 10 users -->
  <div class="leaderboard-row"><div>1</div><div>#U001</div><div>CodeMaster</div><div>3250</div><div>Senior</div><div>98%</div></div>
  <div class="leaderboard-row"><div>2</div><div>#U002</div><div>DevPro</div><div>3120</div><div>Senior</div><div>96%</div></div>
  <div class="leaderboard-row"><div>3</div><div>#U003</div><div>AlgoKing</div><div>2890</div><div>Mid</div><div>91%</div></div>
  <div class="leaderboard-row"><div>4</div><div>#U004</div><div>PythonGirl</div><div>2740</div><div>Mid</div><div>89%</div></div>
  <div class="leaderboard-row"><div>5</div><div>#U005</div><div>DebugHero</div><div>2600</div><div>Mid</div><div>85%</div></div>
  <div class="leaderboard-row"><div>6</div><div>#U006</div><div>BitWarrior</div><div>2490</div><div>Mid</div><div>82%</div></div>
  <div class="leaderboard-row"><div>7</div><div>#U007</div><div>StackJumper</div><div>2410</div><div>Junior</div><div>78%</div></div>
  <div class="leaderboard-row"><div>8</div><div>#U008</div><div>NullPointer</div><div>2360</div><div>Junior</div><div>75%</div></div>
  <div class="leaderboard-row"><div>9</div><div>#U009</div><div>Refactorer</div><div>2300</div><div>Junior</div><div>72%</div></div>
  <div class="leaderboard-row"><div>10</div><div>#U010</div><div>CodeNinja</div><div>2250</div><div>Junior</div><div>70%</div></div>

  <!-- Current user (out of top 10) -->
  <div class="leaderboard-current-user">
    <div>23</div>
    <div>#U999</div>
    <div>You</div>
    <div>1680</div>
    <div>Junior</div>
    <div>56%</div>
</div>
</div>
<div>
    <button class="btn reward">Claim Reward</button>
    <button class="btn progress">View Progress</button>
    <button class="btn course">Go to Course</button>
  </div>
</div>
  </div>
<?php include '../includes/footer.php'; ?>
</body>
</html>