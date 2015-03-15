<html><head><title>Setting up database</title></head><body>

<h3>Setting up...</h3>

<?php // Example 21-3: setup.php
include_once 'functions.php';

createTable($mysqli, 'members',
            'id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            user VARCHAR(16),
            pass VARCHAR(16),
            INDEX(user(6))');

createTable($mysqli, 'messages', 
            'id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            auth VARCHAR(16),
            recip VARCHAR(16),
            pm CHAR(1),
            time INT UNSIGNED,
            message VARCHAR(4096),
            INDEX(auth(6)),
            INDEX(recip(6))');

createTable($mysqli, 'friends',
            'user VARCHAR(16),
            friend VARCHAR(16),
            INDEX(user(6)),
            INDEX(friend(6))');

createTable($mysqli, 'profiles',
            'user VARCHAR(16),
            text VARCHAR(4096),
            INDEX(user(6))');
?>

<br />...done.
</body></html>
