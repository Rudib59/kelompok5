<?php

// Modul 7 Soal 3: pintu masuk Laravel di Vercel (serverless).
// Filesystem Vercel read-only kecuali /tmp, jadi cache dan view dikompilasi ke /tmp.
$tmp = '/tmp/storage';
foreach (['app', 'framework/cache', 'framework/sessions', 'framework/views', 'logs'] as $dir) {
    if (! is_dir("$tmp/$dir")) {
        mkdir("$tmp/$dir", 0777, true);
    }
}

require __DIR__ . '/../public/index.php';
