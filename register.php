<?php
include 'db.php';

$success = '';
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);
    $full_name = trim($_POST['full_name']);

    // Check if any fields are empty
    if (empty($username) || empty($password) || empty($full_name)) {
        $error = "All fields are required.";
    } else {
        // Insert into database
        $stmt = $conn->prepare("INSERT INTO users (username, password, full_name) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $password, $full_name);

        if ($stmt->execute()) {
            $success = "Registration successful!";
        } else {
            $error = "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register page</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-center">Register</h2>

        <?php if ($success): ?>
            <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4"><?= $success ?></div>
        <?php elseif ($error): ?>
            <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4"><?= $error ?></div>
        <?php endif; ?>

        <form action="" method="POST" class="space-y-4">
            <div>
                <label for="username" class="block text-sm font-medium">Username</label>
                <input type="text" id="username" name="username" class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring focus:ring-blue-300" required>
            </div>
            <div>
                <label for="password" class="block text-sm font-medium">Password</label>
                <input type="password" id="password" name="password" class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring focus:ring-blue-300" required>
            </div>
            <div>
                <label for="full_name" class="block text-sm font-medium">Full Name</label>
                <input type="text" id="full_name" name="full_name" class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring focus:ring-blue-300" required>
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white font-semibold py-2 px-4 rounded hover:bg-blue-600 transition">Register</button>
        </form>

        <p class="text-center text-sm mt-4">
            Already have an account?
            <a href="index.php" class="text-blue-500 hover:underline">Login here</a>
        </p>
    </div>
</body>
</html>
