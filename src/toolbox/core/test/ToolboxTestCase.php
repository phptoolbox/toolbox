<?php

namespace toolbox\core\test;

use dayax\core\test\TestCase;
use toolbox\core\test\TestApplication;
use PHPUnit_Framework_TestCase;

use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\StreamOutput;

class ToolboxTestCase extends TestCase
{
	static protected $application;    
    
    static public function getApplication()
    {
    	if(!is_object(static::$application)){
    		$app = new TestApplication();
    		$app->setAutoExit(false);
    		static::$application = $app;
    	}
    	return self::$application;
    }
    
    public function runCommand($command)
    {
    	$application = static::getApplication();
    	$fp = tmpfile();
    	$input = new StringInput($command);
    	$output = new StreamOutput($fp);
    	 
    	$application->run($input, $output);
    	 
    	fseek($fp, 0);    	
    	while (!feof($fp)) {
    		$output = fread($fp, 4096);
    	}
    	fclose($fp);    	    	    
    	return "\n".$output."\n";
    }
}