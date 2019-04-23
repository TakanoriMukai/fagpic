<?php

namespace App\Fagpic;

class HttpDownloader implements Downloader
{
    const BUFFER_SIZE = 1024;
    private $save_paths = array();

    public function download(string $url, string $save_path)
    {
        $total_size = 0;
        $faild_count = 0;

            // ファイル名にyyyymmddhhssをつける。
            $save_name = date('YmdHis').'_'.basename($url);
            
            $fp = fopen($url, 'r');
            $fpw = fopen($save_path.''.$save_name, 'w');
            $size = 0;

            while(!feof($fp))
            {
                $buffer = fread($fp, HttpDownloader::BUFFER_SIZE);
                if($buffer === false)
                {
                    $size = false;
                    $faild_count++;
                    continue;
                }

                $wsize = fwrite($fpw, $buffer);
                if( $wsize === false)
                {
                    $size = false;
                    $faild_count++;
                    continue;
                }

                $size += $wsize;
            }

            fclose($fp);
            fclose($fpw);
            
            $total_size += $size;
        return $save_name;
    }

    public function getPath()
    {
        return $this->save_paths; 
    }
}
