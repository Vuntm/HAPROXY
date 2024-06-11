<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
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
<?php
$conn = new PDO('sqlite:./database.sqlite');
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Xóa server nếu có yêu cầu xóa từ form
if (isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];
    $stmt = $conn->prepare('DELETE FROM `server` WHERE id = :id');
    $stmt->bindParam(':id', $delete_id);
    $stmt->execute();
    header("Location: index.php"); // Chuyển hướng trở lại trang index sau khi xóa
    exit();
}

$listServer = $conn->query('SELECT * FROM `server`');

// Lấy tất cả dữ liệu từ đối tượng PDOStatement
$data = $listServer->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="container">
    <div class="table-responsive small">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th>id</th>
                    <th>Server</th>
                    <th>IP Public</th>
                    <th>IP Local</th>
                    <th>Cổng vật lý</th>
                    <th>Firewall</th>
                    <th>Switch</th>
                    <th>Port Switch</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $row): ?>
                <tr>
                    <td><?php echo ($row['id']); ?></td>
                    <td><?php echo ($row['service']); ?></td>
                    <td><?php echo ($row['ip_public']); ?></td>
                    <td><?php echo ($row['ip_local']); ?></td>
                    <td><?php echo ($row['physical_host']); ?></td>
                    <td><?php echo ($row['firewall']); ?></td>
                    <td><?php echo ($row['switch']); ?></td>
                    <td><?php echo ($row['port_switch']); ?></td>
                    <td><?php echo $row['status'] == 0 ? "Hoạt động" : "Không hoạt động"; ?></td>
                    <td>
                        <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">Sửa</a>
                        <button class="btn btn-danger btn-sm delete-btn" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="<?php echo $row['id']; ?>">Xóa</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Xác nhận xóa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Bạn có chắc chắn muốn xóa server này không?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <form id="deleteForm" method="post">
                    <input type="hidden" id="delete_id" name="delete_id">
                    <button type="submit" class="btn btn-danger">Xóa</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
    var deleteButtons = document.querySelectorAll('.delete-btn');
    var deleteForm = document.getElementById('deleteForm');
    var deleteIdInput = document.getElementById('delete_id');

    deleteButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var serverId = button.getAttribute('data-id');
            deleteIdInput.value = serverId;
        });
    });
</script>
</body>
</html>
