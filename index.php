<?php

if (isset($_GET['info']) && $_GET['info'] === 'php') {
    phpinfo();
}

echo "<h1>CI/CD Test</h1><br><a href=\"?info=php\">phpInfo</a>";