<!DOCTYPE html>
<html>
<head>
    <title>Home Page</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Thiết lập font chữ mặc định */
body {
    font-family: Arial, sans-serif;
}

/* Tạo phần tiêu đề trang */
header {
    background-color: #f3f4f6;
    padding: 1rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

/* Kiểu cho nút logout */
.logout {
    text-decoration: none;
    background-color: #f56565;
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 0.25rem;
}

.logout:hover {
    background-color: #e53e3e;
}

/* Phần chính của trang */
main {
    max-width: 800px;
    margin: 0 auto;
    padding: 1rem;
}

/* Kiểu cho form */
form {
    margin-bottom: 1rem;
}

input[type="text"],
input[type="password"],
input[type="email"],
input[type="submit"] {
    width: 100%;
    padding: 0.5rem;
    margin-bottom: 0.5rem;
    border-radius: 0.25rem;
    border: 1px solid #d1d5db;
    transition: border-color 0.3s ease;
}

input[type="text"]:focus,
input[type="password"]:focus,
input[type="email"]:focus,
input[type="submit"]:focus {
    outline: none;
    border-color: #4f46e5;
}

input[type="submit"] {
    background-color: #4f46e5;
    color: white;
    border: none;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #4338ca;
}s

/* Bảng */
table {
    width: 100%;
    border-collapse: collapse;
}

th,
td {
    border: 1px solid #d1d5db;
    padding: 0.5rem;
    text-align: left;
}

th {
    background-color: #f3f4f6;
}

tr:nth-child(even) {
    background-color: #f9fafb;
}

    </style>
</head>
<body>
    <header class="bg-gray-200 p-4 flex justify-between items-center">
        <h1 class="text-xl font-bold">Thông tin học sinh</h1>
        <a class="logout" href="signin_page.php">Đăng xuất</a>

    </header>

    <main class="container mx-auto p-4">
        <form method="POST" action="">
        <input type="text" name="masv" placeholder="ma sv" required class="p-2 rounded-md mb-2">
            <input type="text" name="fullname" placeholder="Họ tên" required class="p-2 rounded-md mb-2">
            <input type="password" name="password" placeholder="Mật khẩu" required class="p-2 rounded-md mb-2">
            <input type="email" name="email" placeholder="Email" required class="p-2 rounded-md mb-2">
            <input type="submit" name="add" value="Thêm" class="bg-green-500 text-white p-2 rounded-md">
        </form>

        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr>
                    <th class="p-2 border-b">masv</th>
                    <th class="p-2 border-b">ID</th>
                    <th class="p-2 border-b">Họ tên</th>
                    <th class="p-2 border-b">Email</th>
                    <th class="p-2 border-b">Thao tác</th>

                    

                </tr>
            </thead>
            <tbody>
                <?php
                // Kết nối tới cơ sở dữ liệu
                $conn = mysqli_connect('localhost', 'root', '', 'your_database_name');

                // Kiểm tra kết nối
                if (!$conn) {
                    die('Không thể kết nối tới cơ sở dữ liệu: ' . mysqli_connect_error());
                }

                // Xử lý thao tác thêm
                if (isset($_POST['add'])) {
                    $masv=$_POST['masv'];
                    $fullname = $_POST['fullname'];
                    $password = $_POST['password'];
                    $email = $_POST['email'];


                    $query = "INSERT INTO students (masv,fullname, password, email) VALUES ('$masv','$fullname', '$password', '$email')";
                    if (mysqli_query($conn, $query)) {
                        echo "Học sinh đã được thêm thành công.";
                    } else {
                        echo "Lỗi: " . mysqli_error($conn);
                    }
                }

                // Truy vấn dữ liệu từ bảng 'users'
                $query = "SELECT * FROM students";
                $result = mysqli_query($conn, $query);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td class='p-2 border-b text-align'>" . $row['masv'] ."</td>";
                        echo "<td class='p-2 border-b text-align'>" . $row['id'] . "</td>";
                        echo "<td class='p-2 border-b text-align'>" . $row['fullname'] . "</td>";
                        echo "<td class='p-2 border-b text-align'>" . $row['email'] . "</td>";

                      
                        echo "<td class='p-2 border-b'><a href='edit.php?id=" . $row['id'] . "'>Sửa</a> | <a href='delete.php?id=" . $row['id'] . "'>Xóa</a></td>";
                    
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4' class='p-2 border-b'>Không có dữ liệu</td></tr>";
                }

                // Đóng kết nối
                mysqli_close($conn);
                ?>
                
            </tbody>
        </table>
    </main>
</body>
</html>
