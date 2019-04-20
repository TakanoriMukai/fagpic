<?php

namespace App\Fagpic;

class HttpDownloader implements Downloader
{
    const BUFFER_SIZE = 1024;
    private $save_paths = array();

    public function download(array $urls, string $save_path)
    {
        $total_size = 0;
        $faild_count = 0;

        foreach($urls as $url)
        {
            // ファイル名にyyyymmddhhssをつける。
            $save_name = date('YmdHis').'_'.basename($url);
            
            $fp = fopen($url, 'r');1
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
            array_push($this->save_paths, $save_path.''.$save_name);
        }
    }

    public function getPath()
    {
        return $this->save_paths; 
    }
}
