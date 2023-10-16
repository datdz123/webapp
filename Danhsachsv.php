
<?php
$servername = "localhost:3306";
$database = "D16CNPM";
$username = "root";
$password = "";
$connect = mysqli_connect($servername, $username, $password, $database);

if (!$connect) {
    die("Không kết nối: " . mysqli_connect_error());
    exit();
}

$masv = "";
$ho_ten = "";
$que_quan = "";
$showSuccessModal = false;
$showErrorModal = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST["masv"])) { $masv = $_POST['masv']; }
    if(isset($_POST["ho_ten"])) { $ho_ten = $_POST['ho_ten']; }
    if(isset($_POST["lop"])) { $lop = $_POST['lop']; }
    if(isset($_POST["que_quan"])) { $que_quan = $_POST['que_quan']; }

    // Kiểm tra xem mã sinh viên đã tồn tại hay chưa
    $check_query = "SELECT * FROM tblsinhvien WHERE masv = '$masv'";
    $check_result = mysqli_query($connect, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // Nếu mã sinh viên đã tồn tại, hiển thị modal lỗi
        $showErrorModal = true;
    } else {
        // Nếu mã sinh viên không tồn tại, thực hiện thêm bản ghi mới
        $sql = "INSERT INTO tblsinhvien (masv, ho_ten, lop, que_quan) VALUES ('$masv', '$ho_ten', '$lop', '$que_quan')";
        if (mysqli_query($connect, $sql)) {
            // Nếu thêm thành công, bạn có thể hiển thị modal thông báo thành công ở phần JavaScript
        } else {
            // Nếu có lỗi khi thêm, bạn có thể xử lý lỗi ở đây
            echo "Lỗi: " . $sql . "<br>" . mysqli_error($connect);
        }
    }
}

$query = mysqli_query($connect, "SELECT * FROM tblsinhvien");
if (!$query) {
    die("Lỗi truy vấn: " . mysqli_error($connect));
}
?>

<!-- Your HTML here -->

<script>
    document.addEventListener("DOMContentLoaded", function () {
        if(<?php echo $showSuccessModal ? 'true' : 'false'; ?>) {
            $('#successModal').modal('show');
        }
        if(<?php echo $showErrorModal ? 'true' : 'false'; ?>) {
            $('#errorModal').modal('show');
        }
    });
</script>

<!DOCTYPE html>
<html>
<head>
    <title>Danh sách sinh viên</title>
    <!-- Thêm Bootstrap CSS -->
    <link rel="stylesheet" href="Css/Trangchu.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="">
<div class="container mt-5">
    <!-- Modal Popup -->
    <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Thông báo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Dữ liệu đã được thêm thành công.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Popup for Error -->
    <div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="errorModalLabel">Thông báo lỗi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Mã sinh viên đã tồn tại.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>

    <h1 class="text-center text-primary" style="padding-bottom: 5%; padding-top: 5%;"> Danh sách sinh viên</h1>
    <form action="" method="post">
        <h2 class="text-center">Thêm sinh viên</h2>
        <div class="form-group">
            <label for="masv">Mã sinh viên:</label>
            <input type="text" class="form-control" name="masv" id="masv">
        </div>
        <div class="form-group">
            <label for="ho_ten">Họ tên:</label>
            <input type="text" class="form-control" name="ho_ten" id="ho_ten">
        </div>
        <div class="form-group">
            <label for="lop">Lớp:</label>
            <input type="text" class="form-control" name="lop" id="lop">
        </div>
        <div class="form-group">
            <label for="que_quan">Quê quan:</label>
            <textarea class="form-control" name="que_quan" id="que_quan" rows="4"></textarea>
        </div>
        <button id="submitBtn" type="submit" class="btn btn-primary d-flex mx-auto mb-5">Thêm sinh viên</button>
    </form>

    <table class="table table-bordered pt-5 text-center ">
        <thead class="thead-light">
        <tr>
            <th>Mã sinh viên</th>
            <th>Họ tên</th>
            <th>Lớp</th>
            <th>Quê quan</th>
            <th>Sửa</th>
            <th>Xóa</th>
        </tr>
        </thead>
        <tbody>

        <?php
        // Khởi tạo biến đếm $i = 0
        $i = 0;
        while ($data = mysqli_fetch_array($query)) {
            if ($i == 4) {
                echo "</tr>";
                $i = 0;
            }
            ?>
            <tr>
                <td><?php echo $data["masv"]; ?></td>
                <td><?php echo $data["ho_ten"]; ?></td>
                <td><?php echo $data["lop"]; ?></td>
                <td><?php echo $data["que_quan"]; ?></td>
                <td><a href="sua_sinh_vien.php?masv=<?php echo $data['masv']; ?>" class="btn btn-warning">Sửa</a></td>
                <td><a href="xoa_sinh_vien.php?masv=<?php echo $data['masv']; ?>" class="btn btn-danger">Xóa</a></td>
            </tr>
            <?php
            $i++;
        }
        ?>
        </tbody>
    </table>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>

