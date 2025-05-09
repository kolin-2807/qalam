<?php include '../includes/header.php'; ?>
<!DOCTYPE html>
<html lang="kk">
<head>
  <meta charset="UTF-8">
  <title>Qalam | Корзина</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../assets/style/corzina.css">
</head>
<body>

<div class="shop-container">
  <div class="items-wrapper">

    <!-- 🟫 Junior -->
    <div class="item-card">
      <div class="item-content">
        <img src="../assets/images/Bronze.svg" alt="Junior">
        <p class="plan-short">Junior курстар мен сертификат.</p>
      </div>
      <a class="buy-button" href="../pages/Kaspiqr.php?plan=junior">Купить</a>
    </div>

    <!-- 🪙 Middle -->
    <div class="item-card">
      <div class="item-content">
        <img src="../assets/images/Silver.svg" alt="Middle">
        <p class="plan-short">Middle курстар, сертификат, жүлделер.</p>
      </div>
      <a class="buy-button" href="../pages/Kaspiqr.php?plan=middle">Купить</a>
    </div>

    <!-- 🥇 Full -->
    <div class="item-card">
      <div class="item-content">
        <img src="../assets/images/Gold.svg" alt="Full">
        <p class="plan-short">Толық қолжетімділік пен жұмысқа ұсыныс.</p>
      </div>
      <a class="buy-button" href="../pages/Kaspiqr.php?plan=full">Купить</a>
    </div>

  </div>

  <!-- ✅ Купить всё! -->
  <div class="buy-all-wrapper">
    <a class="buy-all-button" href="../pages/Kaspiqr.php?plan=full">Купить всё!</a>
  </div>
</div>

</body>
</html>
