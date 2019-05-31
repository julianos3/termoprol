<?php
namespace AgenciaS3;

class Application extends \Illuminate\Foundation\Application
{

    public function publicPath()
    {
        $path = '/home/garupi5f';
        return $path . DIRECTORY_SEPARATOR . 'public_html';
    }
}