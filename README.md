# MyAwesomePHPTemplate
A simple PHP template for a password-protected webpage with login, logout, CSRF token validation, a simple logging system, and no need for a database.

Not to be used in any serious circumstances because users and their passwords are stored in plain text in an array in conf.php, but might be a useful starting point for insignificant personal projects.

Rename conf.php.example to conf.php and make appropriate changes there. If you are planning to have logs, make sure that the app has permissions to write files in the configured logging directory.