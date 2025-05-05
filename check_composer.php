<?php
echo "PHP is working\n";
if (file_exists('vendor/autoload.php')) {
    echo "Vendor directory exists\n";
} else {
    echo "Vendor directory does not exist\n";
}
if (file_exists('composer.json')) {
    echo "composer.json exists\n";
} else {
    echo "composer.json does not exist\n";
}
