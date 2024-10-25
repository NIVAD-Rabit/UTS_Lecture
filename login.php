<?php
session_start();
include 'db_connect.php';
include 'header.php';

$alert = '';

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT user_id, password_hash, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($user_id, $password_hash, $role);

    if ($stmt->fetch() && password_verify($password, $password_hash)) {
        $_SESSION['user_id'] = $user_id;
        $_SESSION['role'] = $role;

        if ($role === 'admin') {
            header("Location: admin_dashboard.php");
        } else {
            header("Location: index.php");
        }
        exit();
    } else {
        $alert = '<div class="alert alert-danger" role="alert">Login gagal! Email atau password salah.</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Login</h3>
                    </div>
                    <div class="card-body">
                        <?php echo $alert; ?>
                        <form method="post" action="login.php">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email:</label>
                                <input type="email" class="form-control" name="email" id="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password:</label>
                                <input type="password" class="form-control" name="password" id="password" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" name="login" class="btn btn-primary">Login</button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <a href="reset_password.php" class="text-decoration-none">Forgot Password?</a><br>
                        <a href="register.php" class="text-decoration-none">Don’t have an account? Register</a><br>
                        <a href="index.php" class="btn btn-secondary mt-2">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
