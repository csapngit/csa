<?php
$target = storage_path('storage/app/images');
$link = public_path('storage/images');
symlink($target, $link);
