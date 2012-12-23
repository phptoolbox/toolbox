<?php

namespace toolbox\git\tests\command;

use toolbox\git\command\SubtreePushCommand;

use Symfony\Component\Console\Tester\CommandTester;

use toolbox\core\test\ToolboxTestCase;
use toolbox\core\test\TestApplication;
use toolbox\core\Config;

class SubtreePushCommandTest extends ToolboxTestCase
{
	private $cwd;
	
	public function setUp()
	{
		$this->cwd = getcwd();
	}
	
	public function tearDown()
	{
		chdir($this->cwd);
	}
	
	/**
	 * @expectedException        \InvalidArgumentException
	 */
	public function testShouldThrowExceptionWhenConfigNotConfigured()
	{		
		$tester = new CommandTester(new SubtreePushCommand());
		$tester->execute(array(),array());
	}
	
	/**
	 * @expectedException        \InvalidArgumentException
	 */
	public function testShouldThrowWhenNoSplitDirConfigured()
	{
		chdir(__DIR__.'/resources/fix1');
		$t = new CommandTester(new SubtreePushCommand());		
		$t->execute(array(),array());	
	}
	
	public function testShouldRunWhenGitConfigured()
	{		
		chdir(__DIR__.'/resources/fix2');	
		Config::load(true);
		$t = new CommandTester(new SubtreePushCommand());
		$t->execute(array(),array());
	}
		
	
}