<?php

namespace App\Fagpic;

interface Downloader
{
    public function download(string $url, string $save_path);
}
