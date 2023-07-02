<?php
/** html.php
 * PHP functions for generating HTML. Required from main.php.
 * Read more about the heredoc syntax from the PHP manual:
 * https://www.php.net/manual/en/language.types.string.php#language.types.string.syntax.heredoc
 */

// Build HTML header
function buildHtmlHeader($pageTitle = APP_NAME) {
    if ($pageTitle != APP_NAME) {
        $pageTitle .= " | " . APP_NAME;
    }
    $header = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>$pageTitle</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

HTML;

    echo $header;
}

// Build HTML footer
function buildHtmlFooter() {
    $footer = <<<HTML
</body>
</html>
HTML;

    echo $footer;
}
