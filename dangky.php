<?php
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    // Thêm bất kỳ thông tin khác mà bạn muốn thu thập ở đây

    // Kết nối đến cơ sở dữ liệu (sử dụng thông tin kết nối của bạn)
    $servername = "localhost";
    $database = "D16CNPM";
    $db_username = "root";
    $db_password = "";

    $connect = mysqli_connect($servername, $db_username, $db_password, $database);
    if (!$connect) {
        die("Không kết nối: " . mysqli_connect_error());
    }

    // Kiểm tra xem tên người dùng đã tồn tại trong cơ sở dữ liệu chưa
    $check_username_query = "SELECT * FROM tbluser WHERE username = '$username'";
    $check_username_result = mysqli_query($connect, $check_username_query);

    if (mysqli_num_rows($check_username_result) > 0) {
        $error_message = "Tên người dùng đã tồn tại. Vui lòng chọn tên người dùng khác.";
    } else {
        // Thêm dữ liệu tài khoản mới vào cơ sở dữ liệu
        $insert_query = "INSERT INTO tbluser (username, password) VALUES ('$username', '$password')";
        if (mysqli_query($connect, $insert_query)) {
            // Đăng ký thành công, bạn có thể chuyển hướng người dùng đến trang đăng nhập hoặc thực hiện các hoạt động khác.
            header("Location: Login.php");
            exit();
        } else {
            // Đăng ký không thành công, hiển thị thông báo lỗi hoặc xử lý lỗi khác theo ý muốn.
            $error_message = "Lỗi khi thực hiện đăng ký: " . mysqli_error($connect);
        }
    }

    mysqli_close($connect);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Đăng ký tài khoản
                </div>
                <div class="card-body">
                    <form method="POST" action="">
                        <div class="form-group">
                            <label for="username">Tên người dùng:</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Mật khẩu:</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <!-- Thêm các trường thông tin khác mà bạn muốn thu thập -->
                        <button type="submit" class="btn btn-primary">Đăng ký</button>
                        <p class="text-danger mt-2"><?php echo $error_message; ?></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
