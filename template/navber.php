<!-- <nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php"><i class="fa fa-id-card-o" aria-hidden="true"></i> OTC管理</a>
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">登録 <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="new_otc.php">新規登録</a></li>
            <li><a href="warehousing.php">入庫入力</a></li>
            <li><a href="proceeds.php">販売登録</a></li>
            <li><a href="returned.php">返品登録</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">一覧表示 <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="otc_list_2.php">OTC一覧</a></li>
            <li><a href="otc_list_new.php">OTC一覧【入荷順】</a></li>
            <li><a href="kiki_list.php">医療機器一覧</a></li>
            <li><a href="hygiene_list.php">衛生用品一覧</a></li>
            <li role="presentation" class="divider"></li>
            <li><a href="warehousing_kiki_list.php">【入庫】高度、特定保守一覧</a></li>
            <li><a href="sale_kiki_list.php">【出庫】高度、特定保守一覧</a></li>
            <li><a href="inout_kiki_list.php">【出入庫】高度、特定保守一覧</a></li>
            <li role="presentation" class="divider"></li>
            <li><a href="calendar.php">販売一覧</a></li>
            <li><a href="sales_calendar.php">月間売上</a></li>
            <li><a href="warehousing_list.php">入庫一覧</a></li>
            <li><a href="expiration.php">期限一覧</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">編集 <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="otc_list.php">OTC編集</a></li>
            <li><a href="inventory.php">棚卸し（バーコード）</a></li>
            <li><a href="inventory_table.php">棚卸し表</a></li>
            <li><a href="inventory_table_input.php">棚卸し表 入力</a></li>
            <li><a href="inventory_table_check.php">棚卸し表 チェック</a></li>
            <li><a href="inventory_table_final.php">棚卸し表 最終</a></li>
          </ul>
        </li>
        <li>
          <a href="setting.php">設定</a>
        </li>
      </ul>

      <ul class="nav navbar-nav navbar-right">
        <li><a href="sale.php">販売登録</a></li>
      </ul>
    </div>
  </div>
</nav>

 -->





<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Navbar</a>
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
            <li><a href="new_otc.php" class="dropdown-item">新規登録</a></li>
            <li><a href="warehousing.php" class="dropdown-item">入庫入力</a></li>
            <li><a href="proceeds.php" class="dropdown-item">販売登録</a></li>
            <li><a href="returned.php" class="dropdown-item">返品登録</a></li>
            </ul>
        </li>
        <li class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" data-bs-toggle="dropdown">
            一覧表示 
            </a>
            <ul class="dropdown-menu">
              <li><a href="otc_list_2.php" class="dropdown-item">OTC一覧</a></li>
              <li><a href="otc_list_new.php" class="dropdown-item">OTC一覧【入荷順】</a></li>
              <li><a href="kiki_list.php" class="dropdown-item">医療機器一覧</a></li>
              <li><a href="hygiene_list.php" class="dropdown-item">衛生用品一覧</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a href="warehousing_kiki_list.php" class="dropdown-item">【入庫】高度、特定保守一覧</a></li>
              <li><a href="sale_kiki_list.php" class="dropdown-item">【出庫】高度、特定保守一覧</a></li>
              <li><a href="inout_kiki_list.php" class="dropdown-item">【出入庫】高度、特定保守一覧</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a href="calendar.php" class="dropdown-item">販売一覧</a></li>
              <li><a href="sales_calendar.php" class="dropdown-item">月間売上</a></li>
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