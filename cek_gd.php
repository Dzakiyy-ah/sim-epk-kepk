<?php
if (extension_loaded('gd') && function_exists('gd_info')) {
    echo "Ekstensi GD telah diaktifkan.";
} else {
    echo "Ekstensi GD tidak diaktifkan.";
}
?>