<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm server</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<div>
<header class="p-3 mb-3 border-bottom">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 link-body-emphasis text-decoration-none">
          <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"></use></svg>
        </a>

        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
        <li><a href="index.php" class="nav-link px-2 link-body-emphasis">Trang chủ</a></li>
        <li><a href="add.php" class="nav-link px-2 link-body-emphasis">Thêm server</a></li>
        </ul>
        <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search">
          <input type="search" class="form-control" placeholder="Search..." aria-label="Search">
        </form>

        <div class="dropdown text-end">
          <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="https://github.com/mdo.png" alt="mdo" width="32" height="32" class="rounded-circle">
          </a>
          <ul class="dropdown-menu text-small">
            <li><a class="dropdown-item" href="#">Profile</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Sign out</a></li>
          </ul>
        </div>
      </div>
    </div>
  </header>
  <div class="container">
        <h4>Thêm mới server</h4>
        <form action="add.php" method="post">
        <input type="hidden" name="id">
        <div class="mb-3">
            <label for="server" class="form-label">Tên Server</label>
            <input type="text" class="form-control" id="service" name="service">
        </div>
        <div class="mb-3">
            <label for="ip_public" class="form-label">Địa chỉ IP Public</label>
            <input type="text" class="form-control" id="ip_public" name="ip_public">
        <div class="mb-3">
            <label for="ip_local" class="form-label">Địa chỉ IP Local</label>
            <input type="text" class="form-control" id="ip_local" name="ip_local">
        </div>
        <div class="mb-3">
            <label for="physical_host" class="form-label">Cổng vật lý</label>
            <input type="text" class="form-control" id="physical_host" name="physical_host" >
        </div>
        <div class="mb-3">
            <label for="firewall" class="form-label">Firewall</label>
            <input type="text" class="form-control" id="firewall" name="firewall">
        </div>
        <div class="mb-3">
            <label for="switch" class="form-label">Switch</label>
            <input type="text" class="form-control" id="switch" name="switch">
        </div>
        <div class="mb-3">
            <label for="port_switch" class="form-label">Port Switch</label>
            <input type="text" class="form-control" id="port_switch" name="port_switch">
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Trạng thái</label>
            <select class="form-select" id="status" name="status">
                <option value="0">Hoạt động</option>
                <option value="1">Không hoạt động</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Lưu</button>
            <button type="submit" class="btn btn-primary">Thêm</button>
        </form>
</div>
  <?php
  if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $service = $_POST['service'];
    $ip_public = $_POST['ip_public'];
    $ip_local = $_POST['ip_local'];
    $physical_host = $_POST['physical_host'];
    $firewall = $_POST['firewall'];
    $switch = $_POST['switch'];
    $port_switch = $_POST['port_switch'];
    $status = $_POST['status'];
    $query = "INSERT INTO `server`(`service`,ip_public,ip_local,physical_host,firewall,switch,port_switch,`status`) VALUES('$service','$ip_public','$ip_local','$physical_host','$firewall','$switch','$port_switch','$status')";
    $conn = new PDO('sqlite:./database.sqlite');
    $createTable = $conn->query("CREATE TABLE IF NOT EXISTS `server` (
      `id`	INTEGER NOT NULL UNIQUE,
      `service`	TEXT,
      `ip_public`	varchar,
      `ip_local`	varchar,
      `physical_host`	varchar,
      `firewall`	varchar,
      `switch`	varchar,
      `port_switch`	varchar,
      `status`	INTEGER,
      PRIMARY KEY(`id` AUTOINCREMENT)
  )
  ");
    $conn->exec($query);
}
    
  ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>