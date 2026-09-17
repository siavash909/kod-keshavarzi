<?php
$db_host = "fdb1028.awardspace.net";
$db_name = "4789814_shop";
$db_user = "4789814_shop";
$db_pass = "رمز-دیتابیس-خودت-اینجا";

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name, 3306);
if ($conn->connect_error) die("خطا در اتصال به دیتابیس: " . $conn->connect_error);
$conn->set_charset("utf8mb4");
$conn->query("CREATE TABLE IF NOT EXISTS orders (
id INT AUTO_INCREMENT PRIMARY KEY,
customer_name VARCHAR(100) NOT NULL,
phone VARCHAR(30) NOT NULL,
fertilizer_type VARCHAR(100) NOT NULL,
amount INT NOT NULL,
address TEXT NOT NULL,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
$name = trim($_POST["customer_name"] ?? "");
$phone = trim($_POST["phone"] ?? "");
$fertilizer = trim($_POST["fertilizer_type"] ?? "");
$amount = (int)($_POST["amount"] ?? 0);
$address = trim($_POST["address"] ?? "");
if ($name === "" || $phone === "" || $fertilizer === "" || $amount <= 0 || $address === "") die("لطفاً همه اطلاعات فرم را کامل وارد کنید.");
$stmt = $conn->prepare("INSERT INTO orders (customer_name, phone, fertilizer_type, amount, address) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssis", $name, $phone, $fertilizer, $amount, $address);
if ($stmt->execute()) echo "<div style='font-family:Tahoma;text-align:center;margin-top:80px'><h2 style='color:green'>✅ سفارش با موفقیت ثبت شد</h2><a href='order.html'>بازگشت به فرم سفارش</a></div>";
else echo "خطا: " . htmlspecialchars($stmt->error);
$stmt->close();
}
$conn->close();
?>