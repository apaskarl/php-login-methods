<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login_php";

try {
    // Create PDO connection
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Handle login logic
    $login_error = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $user = trim($_POST["username"]);
        $pass = trim($_POST["password"]);

        // Prepare the statement
        $stmt = $conn->prepare("SELECT user_id, username, password FROM users WHERE username = :username");
        
        // Bind parameters and execute
        $stmt->execute([':username' => $user]);
        
        // Fetch the user
        $user_data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user_data) {
            if (password_verify($pass, $user_data['password'])) {
                $_SESSION["loggedin"] = true;
                $_SESSION["id"] = $user_data['user_id'];
                $_SESSION["username"] = $user_data['username'];
                header("Location: ../home.php");
                exit;
            } else {
                $login_error = "Invalid password.";
            }
        } else {
            $login_error = "No account found with that username.";
        }
    }
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Connection is automatically closed when script ends
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login Method: PDO</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
  <div class="flex flex-col items-center justify-center w-full h-screen bg-gray-50">
    <h1 class="font-bold text-xl mb-4">PDO</h1>
    <?php if (!empty($login_error)): ?>
      <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-3 w-[30%] text-center">
        <?= htmlspecialchars($login_error) ?>
      </div>
    <?php endif; ?>
    <form action="" method="post" class="p-5 border bg-white shadow-sm rounded-2xl w-[30%] space-y-3">
      <div>
        <label for="username" class="font-medium text-sm">Username</label>
        <input type="text" id="username" name="username" required class="mt-2 border px-3 py-2 w-full rounded-xl" />
      </div>
      <div>
        <label for="password" class="font-medium text-sm">Password</label>
        <input type="password" id="password" name="password" required class="mt-2 border px-3 py-2 w-full rounded-xl" />
      </div>
      <button type="submit" class="bg-blue-500 py-3 w-full text-white font-bold rounded-xl">Login</button>
    </form>
    <p class="text-center text-sm mt-4">
      Don't have an account?
      <a href="../register.php" class="text-blue-500 hover:underline">Register here</a>
    </p>
  </div>
</body>
</html>
