<?php
echo "<h1>Test Submission Controller</h1>";
echo "<p>Current time: " . date('Y-m-d H:i:s') . "</p>";
echo "<p>PHP Version: " . phpversion() . "</p>";
echo "<p>Server: " . $_SERVER['SERVER_SOFTWARE'] . "</p>";

// Test file exists
$controller_path = './application/controllers/user/Submission.php';
echo "<p>Controller file exists: " . (file_exists($controller_path) ? 'YES' : 'NO') . "</p>";

if (file_exists($controller_path)) {
    echo "<p>Controller file size: " . filesize($controller_path) . " bytes</p>";
    echo "<p>Controller file permissions: " . substr(sprintf('%o', fileperms($controller_path)), -4) . "</p>";
}

// Test URL routing
echo "<h2>Test URLs:</h2>";
echo "<ul>";
echo "<li><a href='http://localhost/arsdoc/index.php/user/submission/test_no_auth'>Test No Auth</a></li>";
echo "<li><a href='http://localhost/arsdoc/index.php/user/submission/debug_form/1'>Debug Form</a></li>";
echo "<li><a href='http://localhost/arsdoc/user/submission/test_no_auth'>Test No Auth (Clean URL)</a></li>";
echo "<li><a href='http://localhost/arsdoc/user/submission/debug_form/1'>Debug Form (Clean URL)</a></li>";
echo "</ul>";

// Test .htaccess
echo "<h2>URL Rewrite Test:</h2>";
$htaccess_path = './.htaccess';
echo "<p>.htaccess file exists: " . (file_exists($htaccess_path) ? 'YES' : 'NO') . "</p>";

if (file_exists($htaccess_path)) {
    echo "<p>.htaccess content:</p>";
    echo "<pre>" . htmlspecialchars(file_get_contents($htaccess_path)) . "</pre>";
}

// Test mod_rewrite
if (function_exists('apache_get_modules')) {
    $modules = apache_get_modules();
    echo "<p>mod_rewrite enabled: " . (in_array('mod_rewrite', $modules) ? 'YES' : 'NO') . "</p>";
} else {
    echo "<p>Cannot check mod_rewrite status</p>";
}
?>
