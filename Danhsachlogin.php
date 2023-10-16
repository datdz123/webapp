<!DOCTYPE html>
<html>
<head>
    <title>Thêm tài khoản</title>
    <!-- Thêm Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <form action="" method="post">
        <h2 class="text-center">Thêm tài khoản</h2>
        <div class="form-group">
            <label for="username">Tên người dùng:</label>
            <input type="text" class="form-control" name="username" id="username">
        </div>
        <div class="form-group">
            <label for="password">Mật khẩu:</label>
            <input type="password" class="form-control" name="password" id="password">
        </div>
        <button type="submit" class="btn btn-primary d-flex mx-auto">Thêm tài khoản</button>
    </form>

    <?php
    $servername = "localhost:3306";
    $database = "D16CNPM";
    $username = "root";
    $password = "";

    $connect = mysqli_connect($servername, $username, $password, $database);
    //Nếu kết nối bị lỗi thì xuất báo lỗi và thoát.
    if (!$connect) {
        die("Không kết nối :" . mysqli_connect_error());
        exit();
    }

    $newUsername = "";
    $newPassword = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if(isset($_POST["username"])) { $newUsername = $_POST['username']; }
        if(isset($_POST["password"])) { $newPassword = $_POST['password']; }

        //Code xử lý, insert dữ liệu vào table tbluser
        $sql = "INSERT INTO tbluser (username, password) VALUES ('$newUsername', '$newPassword')";
        if (mysqli_query($connect, $sql)) {
            echo "Thêm tài khoản thành công";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($connect);
        }
    }
    ?>

    <table class="table table-bordered mt-4">
        <thead class="thead-light">
        <tr>
            <th>ID</th>
            <th>Tên người dùng</th>
            <th>Mật khẩu</th>
            <th>Sửa</th>
            <th>Xóa</th>
        </tr>
        </thead>
        <tbody>

        <?php
        // Lấy dữ liệu từ database và hiển thị danh sách người dùng
        $query = mysqli_query($connect, "SELECT * FROM tbluser");
        if (!$query) {
            die("Lỗi truy vấn: " . mysqli_error($connect));
        }

        while ($data = mysqli_fetch_array($query)) {
            ?>
            <tr>
                <td><?php echo $data["id"]; ?></td>
                <td><?php echo $data["username"]; ?></td>
                <td><?php echo $data["password"]; ?></td>
                <td><a href="sua-login.php?id=<?php echo $data['id']; ?>" class="btn btn-warning">Sửa</a></td>
                <td><a href="xoa-login.php?id=<?php echo $data['id']; ?>" class="btn btn-danger">Xóa</a></td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
</div>
</body>
</html>
