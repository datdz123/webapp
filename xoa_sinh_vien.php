<?php
if (isset($_GET['masv'])) {
    $masv = $_GET['masv'];
    $servername = "localhost:3306";
    $database = "D16CNPM";
    $username = "root";
    $password = "";
    $connect = mysqli_connect($servername, $username, $password, $database);
    if (!$connect) {
        die("Không kết nối: " . mysqli_connect_error());
    }
    // Truy vấn dữ liệu của sinh viên theo masv
    $query = mysqli_query($connect, "SELECT * FROM tblsinhvien WHERE masv = '$masv'");
    if (!$query) {
        die("Lỗi truy vấn: " . mysqli_error($connect));
    }
    // Lấy dữ liệu của sinh viên từ kết quả truy vấn
    $data = mysqli_fetch_array($query);
    // Xử lý biểu mẫu xóa khi người dùng nhấn nút "Xóa"
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $delete_query = "DELETE FROM tblsinhvien WHERE masv = '$masv'";
        if (mysqli_query($connect, $delete_query)) {
            echo "Xóa thông tin thành công";
        } else {
            echo "Error: " . $delete_query . "<br>" . mysqli_error($connect);
        }
    }
    mysqli_close($connect);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Xóa sinh viên</title>
    <!-- Thêm Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Xóa sinh viên</h2>
    <form action="" method="post">
        <div class="form-group">
            <label for="ho_ten">Họ tên:</label>
            <input type="text" class="form-control" name="ho_ten" id="ho_ten" value="<?php echo $data['ho_ten']; ?>" readonly>
        </div>
        <div class="form-group">
            <label for="lop">Lớp:</label>
            <input type="text" class="form-control" name="lop" id="lop" value="<?php echo $data['lop']; ?>" readonly>
        </div>
        <div class="form-group">
            <label for="que_quan">Quê quan:</label>
            <textarea class="form-control" name="que_quan" id="que_quan" rows="4" readonly><?php echo $data['que_quan']; ?></textarea>
        </div>
        <button type="submit" class="btn btn-danger">Xóa</button>
        <a href="Danhsachsv.php" class="btn btn-warning">Quay lại</a>
    </form>
</div>
</body>
</html>
