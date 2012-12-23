<?php

namespace toolbox\core;

use dayax\core\Dayax;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Console\Application as BaseApplication;
use Symfony\Component\Console\Input\InputOption;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use toolbox\core\Shell;
use toolbox\core\Config;

/**
 * Description of Application
 *
 * @author toni
 */
class Application extends BaseApplication
{
    public function __construct()
    {
        parent::__construct('toolbox', '1.0.0');
        $this->getDefinition()->addOption(new InputOption('--shell', '-s', InputOption::VALUE_NONE, 'Launch the shell.'));
        $this->getDefinition()->addOption(new InputOption('--process-isolation', null, InputOption::VALUE_NONE, 'Launch commands from shell as a separate processes.'));
        $this->getDefinition()->addOption(new InputOption('--no-debug', null, InputOption::VALUE_NONE, 'Switches off debug mode.'));
        $this->loadConfig();
        $this->scanCommand();
    }

    private function loadConfig()
    {
        try{
            Config::load();
        }catch(\Exception $e){
        	//FIXME: Implement exception handling
        }
    }

    private function scanCommand()
    {    	
        $dirs = array(
            __NAMESPACE__.'\\command' =>__DIR__.'/command',
        );
        
        foreach(Dayax::getLoader()->getPrefixes() as $prefix=>$paths){
        	if($prefix === __NAMESPACE__ || false===strpos($prefix,'toolbox')){
        		continue;
        	}
        	foreach($paths as $dir){
        		$path = strtr($dir.'/'.$prefix.'/command',array(
        				"\\"=>"/",
        				"//"=>'/',
        	    ));        		 	
        		if(!is_dir($path)){
        			continue;
        		}
        		$dirs[$prefix.'\\command']=$path;
        	}
        }        

        if(!is_null($config=Config::get('command',null))){
            if(isset($config['directory']) || isset($config['namespace'])){
                $ns = isset($config['namespace']) ? $config['namespace'] : "\\";
                $udir = isset($config['directory']) ? $config['directory'] : 'toolbox/command';
                $dirs[$ns] = $udir;
            }
        }

        foreach($dirs as $namespace=>$dir){
        	if(!is_dir($dir)){
        		continue;
        	}
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
        	$r = new \ReflectionClass($class);
        	if($r->isAbstract()){
        		return;
        	}        	
            $this->add(new $class());
        }
    }

    /**
     * Runs the current application.
     *
     * @param InputInterface  $input  An Input instance
     * @param OutputInterface $output An Output instance
     *
     * @return integer 0 if everything went fine, or an error code
     */
    public function doRun(InputInterface $input, OutputInterface $output)
    {
        //$this->registerCommands();

        if (true === $input->hasParameterOption(array('--shell', '-s'))) {
            $shell = new Shell($this);
            $shell->setProcessIsolation($input->hasParameterOption(array('--process-isolation')));
            $shell->run();

            return 0;
        }

        return parent::doRun($input, $output);
    }
}

?>
