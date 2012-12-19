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

class Config
{
    static private $config = array();

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
        $cwd = getcwd().DIRECTORY_SEPARATOR.'config';

        if(is_file($file=$cwd.'/tools.ini')){
            $data = parse_ini_file($file,true);
            self::$config = $data;
        }
    }
}
?>
