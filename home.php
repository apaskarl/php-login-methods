<?php
session_start();

// Handle logout if form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['logout'])) {
    $_SESSION = [];
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit;
}

// Redirect to login if not logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: login.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Home</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

  <div class="text-center bg-white p-10 rounded-2xl shadow-lg space-y-4">
    <h1 class="text-2xl font-bold">Welcome, <?php echo htmlspecialchars($_SESSION["username"]); ?>!</h1>
    <form method="post">
      <input type="hidden" name="logout" value="1">
      <button type="submit" class="mt-4 px-6 py-2 bg-red-500 text-white font-semibold rounded-xl hover:bg-red-600">
        Logout
      </button>
    </form>
  </div>

</body>
</html>
