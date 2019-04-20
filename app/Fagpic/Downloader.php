<?php

namespace App\Fagpic;

interface Downloader
{
    public function download(array $urls, string $save_path);
}
