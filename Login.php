<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Kết nối đến cơ sở dữ liệu (sử dụng thông tin kết nối của bạn)
    $servername = "localhost:3306";
    $database = "D16CNPM";
    $db_username = "root";
    $db_password = "";

    $connect = mysqli_connect($servername, $db_username, $db_password, $database);
    if (!$connect) {
        die("Không kết nối: " . mysqli_connect_error());
    }

    // Truy vấn dữ liệu của sinh viên theo username và password
    $query = "SELECT * FROM tbluser WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($connect, $query);

    if (!$result) {
        die("Lỗi truy vấn: " . mysqli_error($connect));
    }

    // Kiểm tra kết quả truy vấn
    if (mysqli_num_rows($result) == 1) {
        // Đăng nhập thành công, chuyển hướng đến trang quản lý sinh viên
        header("Location: themsinhvien.php");
        exit();
    } else {
        // Đăng nhập không thành công, hiển thị thông báo lỗi
        $error_message = "Tên người dùng hoặc mật khẩu không chính xác.";
    }

    mysqli_close($connect);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<main class="container">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <div class="row" id="loginForm">
        <section class="offset-md-3 col-md-6">

            <div class="card shadow p-5">
                <h3 class="text-center mb-3 font-time"> Login Form Sinh Vien! </h3>
                <form method="POST" action="">
                    <div class="form-group">
                        <input type="text" name="username" id="username" class="form-control rounded-pill" placeholder="Enter Your Username" value="" />
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" id="password" class="form-control rounded-pill" placeholder="Enter Your Password" value="" />
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="customCheck">
                            <label class="custom-control-label" for="customCheck">Remember Me</label>
                        </div>
                    </div>
                    <button class="btn btn-block btn-info rounded-pill" id="submit" name="login">Login</button>
<!--                    <p class="text-danger mt-2">--><?php //echo $error_message; ?><!--</p>-->
                </form>
                <hr>
                <div class="text-center">
                    <a class="font-time" href="#">Forgot Password?</a>
                </div>
                <div class="text-center">
                    <a class="font-time" href="dangky.php">Create an Account!</a>
                </div>
            </div>
        </section>
    </div>
</main>
</html>

<style>

    .font-time {
        font-family: sans-serif;
        font-weight: bold;
    }

    #loginForm {
        min-height: 100vh;
        align-items: center;
    }

</style>

