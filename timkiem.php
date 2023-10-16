<?php
$servername = "localhost";
$database = "D16CNPM";
$username = "root";
$password = "";

$connect = mysqli_connect($servername, $username, $password, $database);
if (!$connect) {
    die("Không kết nối: " . mysqli_connect_error());
    exit();
}

// Định nghĩa biến và chuỗi truy vấn ban đầu
$search = "";
$query = "SELECT masv, ho_ten, lop, que_quan FROM tblsinhvien";

// Kiểm tra nếu có sử dụng chức năng tìm kiếm
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["search"])) {
    $search = mysqli_real_escape_string($connect, $_GET["search"]);
    $query .= " WHERE masv LIKE '%$search%' OR ho_ten LIKE '%$search%'";
}

// Thực hiện truy vấn SQL
$result = mysqli_query($connect, $query);
if (!$result) {
    die("Lỗi truy vấn: " . mysqli_error($connect));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Danh sách sinh viên</title>
    <!-- Thêm Bootstrap CSS hoặc CSS tùy chỉnh cho giao diện -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Danh sách sinh viên</h2>

    <!-- Form tìm kiếm -->
    <form class="mb-3" method="get">
        <div class="input-group">
            <input type="text" class="form-control" name="search" placeholder="Tìm kiếm theo mã hoặc họ tên" value="<?= $search ?>">
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit">Tìm kiếm</button>
            </div>
        </div>
    </form>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Mã sinh viên</th>
            <th>Họ tên</th>
            <th>Lớp</th>
            <th>Quê quan</th>
        </tr>
        </thead>
        <tbody>
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row["masv"] . "</td>";
            echo "<td>" . $row["ho_ten"] . "</td>";
            echo "<td>" . $row["lop"] . "</td>";
            echo "<td>" . $row["que_quan"] . "</td>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>
</div>
</body>
</html>
