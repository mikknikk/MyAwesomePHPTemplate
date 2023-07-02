<?php
/** functions.php
 * All PHP functions can be found here. Required from main.php.
 */

// Add this to all protected pages
function protectedPage() {
    if (!isset($_SESSION['user']) || !isLoggedIn($_SESSION['user'])) {
        redirect(LOGIN_PAGE);
    }
}

// Redirect the user to another page
function redirect($page = LOGIN_PAGE, $error = null) {
    if (!in_array($page, ALLOWED_PAGES)) $page = LOGIN_PAGE;
    if ($error == null) {
        header('Location: ' . $page . '.php');
        exit;
    } else {
        header('Location: ' . $page . '.php?error=' . urlencode($error));
        exit;
    }
}

// Check if the user is logged in
function isLoggedIn($username) {
    return isset($_SESSION['user']) && $_SESSION['user'] === $username;
}

// Generate and store CSRF token
function generateCsrfToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
}

// Validate CSRF token
function validateCsrfToken($token, $page) {
    $ok = isset($_SESSION['csrf_token']) && $_SESSION['csrf_token'] === $token && $token != null && $token != "";
    if (!$ok && LOGS['csrf']['write_logs']) {
        $username = $_SESSION['user'] ?? null;
        writeToLog('csrf', $page . ': CSRF token validation failed. (User="' . $username . '" SESSION[csrf]="' . $_SESSION['csrf'] . '" POST[csrf]="' . $_POST['csrf'] . '")');
    }
    return $ok;
}

// Log out
function logout() {
    $username = $_SESSION['user'] ?? null;
    // Unset user session data
    unset($_SESSION['user']);
    writeToLog('login', 'User "' . $username . '" logged out.');
    // Redirect to login page
    redirect(LOGIN_PAGE);
}

// Log in
function login($username, $password) {
    // Verify the password if the user exists
    if (in_array($username, array_keys(USERS))) {
        if (password_verify($password, USERS[$username])) {
            // Store user in the session
            $_SESSION['user'] = $username;
            writeToLog('login', 'User "' . $username . '" logged in.');
            // Redirect to index page
            redirect(INDEX_PAGE);
        } else {
            // Incorrect password
            writeToLog('login', 'User "' . $username . '" tried to log in with an incorrect password.');
            $error = 'Invalid username or password.';
            redirect(LOGIN_PAGE, $error);
        }
    } else {
        // User not found
        writeToLog('login', 'User "' . $username . '" tried to log in but does not exist.');
        $error = 'Invalid username or password.';
        redirect(LOGIN_PAGE, $error);
    }
}

// Write a line to a log file
function writeToLog($log, $line) {
    if (!isset(LOGS[$log]) || !LOGS[$log]['write_logs']) {
        return false;
    }

    // Check if the logging directory exists
    if (!is_dir(LOG_DIR)) {
        mkdir(LOG_DIR, 0740, true);
    }

    // Check if selected log file exists
    if (!file_exists(LOG_DIR . LOGS[$log]['file'])) {
        touch(LOG_DIR . LOGS[$log]['file']);
    }

    return file_put_contents(LOG_DIR . LOGS[$log]['file'], date("Y-m-d H:i:s") . " | " . $line . "\n", FILE_APPEND);
}
