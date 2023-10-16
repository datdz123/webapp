<?php
// Initialize variables
$id = "";
$error_message = "";

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    // Xử lý biểu mẫu xóa tài khoản
    $delete_query = "DELETE FROM tbluser WHERE id = '$id'";
    if (mysqli_query($connect, $delete_query)) {
        echo ("Xóa tài khoản thành công");
    } else {
        echo "Error: " . $delete_query . "<br>" . mysqli_error($connect);
    }

    mysqli_close($connect);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Xóa tài khoản</title>
    <!-- Thêm Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Xóa tài khoản</h2>
    <form action="" method="post">
        <div class="form-group">
            <label for="id">ID người dùng:</label>
            <input type="text" class="form-control" name="id" id="id" value="<?php echo $id; ?>">
        </div>
        <button type="submit" class="btn btn-danger">Xóa</button>
        <a href="Danhsachlogin.php" class="btn btn-warning">Quay lại</a>
    </form>
</div>
</body>
</html>
