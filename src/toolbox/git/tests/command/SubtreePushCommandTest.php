<?php

namespace toolbox\git\tests\command;

use toolbox\git\command\SubtreePushCommand;

use Symfony\Component\Console\Tester\CommandTester;

use toolbox\core\test\ToolboxTestCase;
use toolbox\core\test\TestApplication;


class SubtreePushCommandTest extends ToolboxTestCase
{
	/**
	 * @expectedException        \InvalidArgumentException
	 */
	public function testShouldThrowExceptionWhenConfigNotConfigured()
	{		
		$tester = new CommandTester(new SubtreePushCommand());
		$tester->execute(array(),array());
	}
}