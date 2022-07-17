<nav class="navbar navbar-expand-lg navbar-dark bg-info">
  <div class="container-fluid">
    <a class="navbar-brand" href="<?= h(HOME_URL); ?>"><i class="bi bi-shop"></i> OTC管理</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" data-bs-toggle="dropdown">
            登録 
            </a>
            <ul class="dropdown-menu">
            <li><a href="new_otc.php" class="dropdown-item"><i class="bi bi-file-earmark-plus"></i>新規登録</a></li>
            <li><a href="warehousing.php" class="dropdown-item"><i class="bi bi-arrow-right"></i><i class="bi bi-shop-window"></i>入庫入力</a></li>
            <li><a href="proceeds.php" class="dropdown-item"><i class="bi bi-arrow-right"></i><i class="bi bi-person-fill"></i>売上登録</a></li>
            <li><a href="returned.php" class="dropdown-item"><i class="bi bi-reply-fill"></i>返品登録</a></li>
            </ul>
        </li>
        <li class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" data-bs-toggle="dropdown">
            一覧表示 
            </a>
            <ul class="dropdown-menu">
              <li><a href="otc_list_2.php" class="dropdown-item"><i class="bi bi-list-columns-reverse"></i>OTC一覧</a></li>
              <li><a href="otc_list_new.php" class="dropdown-item"><i class="bi bi-stars"></i>新入荷一覧</a></li>
              <li><a href="kiki_list.php" class="dropdown-item">医療機器一覧</a></li>
              <li><a href="hygiene_list.php" class="dropdown-item">衛生用品一覧</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a href="warehousing_kiki_list.php" class="dropdown-item">【入庫】高度、特定保守一覧</a></li>
              <li><a href="sale_kiki_list.php" class="dropdown-item">【出庫】高度、特定保守一覧</a></li>
              <li><a href="inout_kiki_list.php" class="dropdown-item">【出入庫】高度、特定保守一覧</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a href="calendar.php" class="dropdown-item"><i class="bi bi-calendar-week"></i>販売一覧</a></li>
              <li><a href="sales_calendar.php" class="dropdown-item"><i class="bi bi-currency-yen"></i>月間売上</a></li>
              <li><a href="warehousing_list.php" class="dropdown-item">入庫一覧</a></li>
              <li><a href="expiration.php" class="dropdown-item">期限一覧</a></li>
            </ul>
        </li>
        <li class="nav-item dropdown">
          <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" data-bs-toggle="dropdown">
            編集
          </a>
          <ul class="dropdown-menu">
            <li><a href="otc_list.php" class="dropdown-item">OTC編集</a></li>
            <li><a href="inventory.php" class="dropdown-item">棚卸し（バーコード）</a></li>
            <li><a href="inventory_table.php" class="dropdown-item">棚卸し表</a></li>
            <li><a href="inventory_table_input.php" class="dropdown-item">棚卸し表 入力</a></li>
            <li><a href="inventory_table_check.php" class="dropdown-item">棚卸し表 チェック</a></li>
            <li><a href="inventory_table_final.php" class="dropdown-item">棚卸し表 最終</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="setting.php">設定</a>
        </li>
      </ul>
    </div>
  </div>
</nav>