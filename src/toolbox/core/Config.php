<?php

/*
 * This file is part of the dayax package.
 *
 * (c) Toni Munthi <me@itstoni.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace toolbox\core;

use Symfony\Component\Finder\Finder;

class Config
{
    static private $config = array();
    static private $isLoaded = false;
    static public function get($name,$default = null)
    {
        $keys = explode('.', $name);
        $config = self::$config;
        if(count($keys) > 1){
            $section = array_shift($keys);
            $config = isset(self::$config[$section]) ? self::$config[$section]:array();
        }
        $key = implode('.',$keys);
        return isset($config[$key]) ? $config[$key]:$default;
    }

    static public function getAll()
    {
        return self::$config;
    }

    static public function load()
    {
        if(true===self::$isLoaded){
            return;
        }
        $dir = getcwd().DIRECTORY_SEPARATOR.'toolbox';
        if(!is_dir($dir)){
            throw new \InvalidArgumentException('toolbox.inexistent_config_dir',$dir);
        }

        $iterator = Finder::create();
        $iterator
            ->in($dir)
            ->files()
        ;
        $data = array();
        foreach($iterator as $file){
            $parsed = parse_ini_file($file, true);
            $data = array_merge($data,$parsed);
        }

        self::$config = array_merge(self::$config,$data);
        self::$isLoaded = true;

    }
}
?>
