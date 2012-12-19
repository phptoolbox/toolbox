<?php

/*
 * This file is part of the toolbox-standard package.
 *
 * (c) Toni Munthi <me@itstoni.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

$file = $_SERVER['SCRIPT_FILENAME'];
$dir = realpath(dirname($file).'/../');
if(is_file($file=$dir.DIRECTORY_SEPARATOR.'/autoload.php')){
    require_once $file;
}elseif(is_file($file=$dir.DIRECTORY_SEPARATOR.'/autoload.php.dist')){
    require_once $file;
}else{
    throw new Exception("Can't find valid autoload file.");
}
?>
