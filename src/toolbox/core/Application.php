<?php

namespace toolbox\core;

use Symfony\Component\Console\Application as BaseApplication;
use Symfony\Component\Finder\Finder;

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
        $this->scanCommand();
    }

    private function scanCommand()
    {
        $i = Finder::create()
                ->files()
                ->name('*Command.php')
                ->in(__DIR__.'/command')
        ;
        foreach($i as $file){
            $this->addFile($file);
        }
    }

    private function addFile(\SplFileInfo $file)
    {
        $class = __NAMESPACE__.'\\command'.'\\'.$file->getBasename('.php');

        if(class_exists($class,true)){
            $this->add(new $class());
        }
    }
}

?>
