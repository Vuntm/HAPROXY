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
include 'D:\Application\VSC\PHP_MVC\HAproxy\HAPROXY\includes\database.php';

// Xóa server nếu có yêu cầu xóa từ form
if (isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];

    // Sử dụng hàm delete từ database.php
    $deleteResult = delete('`server`', 'id = ' . $delete_id);

    if ($deleteResult) { // Kiểm tra nếu xóa thành công
        header("Location: index.php"); // Chuyển hướng tới trang index
        exit();
    } else {
        // Xử lý lỗi xóa (tuỳ chọn: hiển thị thông báo lỗi)
        echo "Failed to delete server. Please try again.";
    }
}


// Lấy tất cả dữ liệu từ đối tượng PDOStatement
$listServer = getAll('SELECT * FROM `server`');

?>
<div class="container">
    <div class="row">
    <form class="col-md-6 col-lg-auto mb-3 mb-lg-0 me-lg-3">
        <input type="search" class="form-control mb-3" placeholder="Tìm kiếm IP Local..." id="searchIpLocal" aria-label="Search IP Local">
    </form>
    <form class="col-md-6 col-lg-auto mb-3 mb-lg-0 me-lg-3">
        <input type="search" class="form-control mb-3" placeholder="Tìm kiếm IP Public..." id="searchIpPublic" aria-label="Search IP Public">
    </form>
    </div>
    <div class="table-responsive small">
        <table class="table table-striped table-sm" id="serverTable">
        <thead>
        <tr>
            <th data-sort="id">id</th>
            <th data-sort="service">Service</th>
            <th data-sort="ip_public">IP Public</th>
            <th data-sort="ip_local">IP Local</th>
            <th data-sort="physical_host">Cổng vật lý</th>
            <th data-sort="firewall">Firewall</th>
            <th data-sort="switch">Switch</th>
            <th data-sort="port_switch">Port Switch</th>
            <th data-sort="status">Trạng thái</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($listServer as $row): ?>
        <tr>
            <td data-col="id"><?php echo $row['id']; ?></td>
            <td data-col="service"><?php echo $row['service']; ?></td>
            <td data-col="ip_public"><?php echo $row['ip_public']; ?></td>
            <td data-col="ip_local"><?php echo $row['ip_local']; ?></td>
            <td data-col="physical_host"><?php echo $row['physical_host']; ?></td>
            <td data-col="firewall"><?php echo $row['firewall']; ?></td>
            <td data-col="switch"><?php echo $row['switch']; ?></td>
            <td data-col="port_switch"><?php echo $row['port_switch']; ?></td>
            <td data-col="status"><?php echo $row['status'] == 0 ? "Hoạt động" : "Không hoạt động"; ?></td>
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

    document.addEventListener("DOMContentLoaded", function() {
        const headers = document.querySelectorAll('th[data-sort]');
        headers.forEach(header => {
            header.addEventListener('click', () => {
                const column = header.getAttribute('data-sort');
                sortTable(column);
            });
        });

        let sortAscending = true; // Biến để lưu trạng thái hiện tại của sắp xếp

        function sortTable(column) {
            const table = document.getElementById('serverTable');
            const tbody = table.querySelector('tbody');
            const rows = Array.from(tbody.getElementsByTagName('tr'));

            rows.sort((a, b) => {
                const aValue = a.querySelector(`td[data-col="${column}"]`).textContent;
                const bValue = b.querySelector(`td[data-col="${column}"]`).textContent;
                let result = 0;
                
                if (!isNaN(aValue) && !isNaN(bValue)) {
                    result = aValue - bValue;
                } else {
                    result = aValue.localeCompare(bValue);
                }

                return sortAscending ? result : -result; // Sử dụng biến sortAscending để quyết định cách sắp xếp
            });

            rows.forEach(row => tbody.appendChild(row));
            sortAscending = !sortAscending; // Đảo ngược giá trị của biến sortAscending sau mỗi lần sắp xếp
        }
    });

    document.addEventListener("DOMContentLoaded", function() {
        const searchIpLocalInput = document.getElementById('searchIpLocal');
        const searchIpPublicInput = document.getElementById('searchIpPublic');

        searchIpLocalInput.addEventListener('input', function() {
            filterTable('ip_local', searchIpLocalInput.value);
        });

        searchIpPublicInput.addEventListener('input', function() {
            filterTable('ip_public', searchIpPublicInput.value);
        });

        function filterTable(column, keyword) {
            const table = document.getElementById('serverTable');
            const tbody = table.querySelector('tbody');
            const rows = tbody.getElementsByTagName('tr');

            for (let row of rows) {
                const cell = row.querySelector(`td[data-col="${column}"]`);
                if (cell) {
                    const text = cell.textContent || cell.innerText;
                    const isVisible = text.toLowerCase().includes(keyword.toLowerCase());
                    row.style.display = isVisible ? '' : 'none';
                }
            }
        }
    });
</script>
<style>
  thead tr th:hover{
    cursor: pointer;
  }
</style>
</body>
</html>
