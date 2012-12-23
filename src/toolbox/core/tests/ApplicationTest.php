<?php

/*
 * This file is part of the toolbox package.
 *
 * (c) Anthonius Munthi <me@itstoni.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace toolbox\core\tests;

use toolbox\core\test\TestApplication;
use toolbox\core\test\ToolboxTestCase;

/**
 * Description of ApplicationTest
 *
 * @author Anthonius Munthi <toni.munthi@gmail.com>
 */
class ApplicationTest extends ToolboxTestCase
{
    private $cwd;

    protected function setUp()
    {
        $this->cwd = getcwd();
    }

    protected function tearDown()
    {
        chdir($this->cwd);
    }

    public function testShouldAddUserCommand()
    {
        $cwd = getcwd();
        chdir(__DIR__.'/resources');

        $app = new TestApplication();

        $this->assertTrue($app->has('foo'));
        chdir($cwd);
    }
    
    public function testShouldExecuteCommand()
    {       	    	
    	$output = $this->runCommand('--list');
    	$this->assertContains('toolbox version', $output);
    }
}

?>
