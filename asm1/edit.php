<?php
// Kết nối tới cơ sở dữ liệu
$conn = mysqli_connect('localhost', 'root', '', 'your_database_name');

// Kiểm tra kết nối
if (!$conn) {
    die('Không thể kết nối tới cơ sở dữ liệu: ' . mysqli_connect_error());
}

// Lấy ID từ URL
if(isset($_GET['id'])) {
    $id = $_GET['id'];
}

// Lấy thông tin sinh viên từ cơ sở dữ liệu
$sql = "SELECT * FROM students WHERE id=$id";
$qr = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($qr);

// Xử lý khi nhấn nút "Lưu"
if (isset($_POST['sbm'])){
    $fullname = $_POST['fullname'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $masv = $_POST['masv'];

    if ($fullname != "" && $password != "" && $email != "" && $masv != "") {
        // Sử dụng prepared statement để tránh SQL injection
        $sql = "UPDATE students SET fullname = ?, password = ?, email = ?, masv = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssssi", $fullname, $password, $email, $masv, $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        header("location: home_page.php");
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sửa thông tin học sinh</title>
    <style>
        /* CSS styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        h1 {
            color: #333;
        }

        form {
            margin-bottom: 20px;
        }

        input[type="text"], input[type="password"] {
            padding: 5px;
        }

        input[type="submit"] {
            padding: 5px 10px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>Sửa thông tin học sinh</h1>

    <form method="POST" action="">
        <input type="text" name="fullname" value="<?php echo isset($row['fullname']) ? $row['fullname'] : ''; ?>" placeholder="Họ tên" required>
        <input type="password" name="password" placeholder="Mật khẩu" value="<?php echo isset($row['password']) ? $row['password'] : ''; ?>">
        <input type="email" name="email" value="<?php echo isset($row['email']) ? $row['email'] : ''; ?>" placeholder="Email" required>
        <input type="text" name="masv" value="<?php echo isset($row['masv']) ? $row['masv'] : ''; ?>" placeholder="masv" required>
        <input type="submit" name="sbm" value="Lưu">
    </form>

</body>
</html>
