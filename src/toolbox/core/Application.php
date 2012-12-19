<?php

namespace toolbox\core;

use Symfony\Component\Console\Application as BaseApplication;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Console\Output\ConsoleOutput;
use toolbox\core\Config;

/**
 * Description of Applcation
 *
 * @author toni
 */
class Application extends BaseApplication
{
    public function __construct()
    {
        parent::__construct('toolbox', '1.0.0');
        $this->loadConfig();
        $this->scanCommand();
    }

    private function loadConfig()
    {
        try{
            Config::load();
        }catch(\Exception $e){
            $this->renderException($e, new ConsoleOutput());
            throw $e;
        }
    }

    private function scanCommand()
    {
        $dirs = array(
            __NAMESPACE__.'\\command' =>__DIR__.'/command',
        );

        if(!is_null($config=Config::get('command',null))){
            if(isset($config['directory']) || isset($config['namespace'])){
                $ns = isset($config['namespace']) ? $config['namespace'] : "\\";
                $udir = isset($config['directory']) ? $config['directory'] : 'toolbox/command';
                $dirs[$ns] = $udir;
            }
        }

        foreach($dirs as $namespace=>$dir){
            $i = Finder::create()
                    ->files()
                    ->name('*Command.php')
                    ->in($dir)
            ;

            foreach($i as $file){
                $this->addFile($file,$namespace);
            }//end foreach file
        }//end dir for each

    }

    private function addFile(\SplFileInfo $file,$namespace)
    {
        $class = $namespace.'\\'.$file->getBasename('.php');
        require_once($file);
        if(class_exists($class,true)){
            $this->add(new $class());
        }
    }
}

?>
