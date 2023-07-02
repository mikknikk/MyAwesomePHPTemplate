<?php
/** login.php
 * Login logic and form.
 */

// Require main.php
require_once("main.php");

// Login logic
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate CSRF token
    $ok = validateCsrfToken($_POST['csrf_token'], 'login.php');
    if (!$ok) {
        $error = 'CSRF token validation failed. Please try again.';
        redirect(LOGIN_PAGE, $error);
    }

    // Get submitted username and password
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Try to log in with the given credentials
    login($username, $password);
}
?>
<?php buildHtmlHeader('Login'); ?>
    <h1>Login</h1>
    <?php if ($error): ?>
        <p id="error-message" class="error-message" role="alert"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <form action="login.php" method="POST">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        <div>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div>
            <input type="submit" value="Login">
        </div>
    </form>
<?php buildHtmlFooter(); ?>
