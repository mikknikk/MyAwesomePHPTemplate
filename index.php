<?php
/** index.php
 * An index page for users that are logged in.
 */

// Require main.php
require_once('main.php');

// Make the page visible only for logged-in users
protectedPage();

// Get the username if the user is logged in
$username = $_SESSION['user'] ?? '';

?>
<?php buildHtmlHeader('Index'); ?>
    <h1>Welcome, <?php echo $username; ?>!</h1>
    <p><a href="?logout=true">Logout</a></p>
<?php buildHtmlFooter(); ?>
