<?php 
    $folder = __DIR__.'/'; 

    $files = glob($folder . "*.svg");

    foreach ($files as $file) {
        if (is_file($file)) {
            unlink($file);
        }
    }

    echo "Semua file .svg sudah dihapus.";

    $files = glob($folder . "*.png");

    foreach ($files as $file) {
        if (is_file($file)) {
            unlink($file);
        }
    }

    echo "Semua file .png sudah dihapus.";
?>