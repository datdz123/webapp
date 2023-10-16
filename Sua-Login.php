<?php
// Initialize variables
$username = "";
$password = "";
$id = "";
$error_message = "";

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $id = $_POST['id'];

    // Kết nối đến cơ sở dữ liệu (sử dụng thông tin kết nối của bạn)
    $servername = "localhost:3306";
    $database = "D16CNPM";
    $db_username = "root";
    $db_password = "";

    $connect = mysqli_connect($servername, $db_username, $db_password, $database);
    if (!$connect) {
        die("Không kết nối: " . mysqli_connect_error());
    }

    // Truy vấn dữ liệu của người dùng theo ID (cần kiểm tra xem có ID hợp lệ không)
    $query = "SELECT * FROM tbluser WHERE id = '$id'";
    $result = mysqli_query($connect, $query);

    if (!$result) {
        die("Lỗi truy vấn: " . mysqli_error($connect));
    }

    // Lấy dữ liệu của người dùng từ kết quả truy vấn
    $data = mysqli_fetch_array($result);

    // Xử lý biểu mẫu chỉnh sửa khi người dùng nhấn nút "Lưu"
    $update_query = "UPDATE tbluser SET username = '$username', password = '$password' WHERE id = '$id'";
    if (mysqli_query($connect, $update_query)) {
        echo ("Sửa thông tin thành công");
    } else {
        echo "Error: " . $update_query . "<br>" . mysqli_error($connect);
    }

    mysqli_close($connect);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Chỉnh sửa form đăng nhập sinh viên</title>
    <!-- Thêm Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Chỉnh sửa form đăng nhập sinh viên</h2>
    <form action="" method="post">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <div class="form-group">
            <label for="username">Tên người dùng:</label>
            <input type="text" class="form-control" name="username" id="username" value="<?php echo $username; ?>">
        </div>
        <div class="form-group">
            <label for="password">Mật khẩu:</label>
            <input type="password" class="form-control" name="password" id="password" value="<?php echo $password; ?>">
        </div>
        <button type="submit" class="btn btn-primary">Sửa</button>
        <a href="Danhsachlogin.php" class="btn btn-warning">Quay lại</a>
    </form>
</div>
</body>
</html>
