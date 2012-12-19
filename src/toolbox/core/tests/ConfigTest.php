<?php

/*
 * This file is part of the dayax package.
 *
 * (c) Toni Munthi <me@itstoni.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace toolbox\core\tests;

use toolbox\core\Config;
use dayax\core\test\TestCase;
use Symfony\Component\Finder\Finder;
class ConfigTest extends TestCase
{

    private $cwd;

    protected function setUp()
    {
        $this->cwd = getcwd();
        chdir(__DIR__ . '/resources');
        Config::load();
        print_r(Config::load());
        parent::setUp();
    }

    public function tearDown()
    {
        chdir($this->cwd);
        parent::tearDown();
    }

    public function testLoad()
    {
        $this->assertTrue(count(Config::getAll())>0,'should have configuration');
    }

    public function testShouldReturnDefaultValue()
    {
        $this->assertTrue(is_null(Config::get('bar', null)));
    }

    /**
     * @dataProvider getTestData
     */
    public function testGetMethodShouldReturnConfigValue($name, $expected)
    {
        $this->assertEquals($expected, Config::get($name));
    }

    public function getTestData()
    {
        return array(
            array('phpunit.coverage.html', 'log/report'),
            array('phpunit.coverage.clover', 'log/coverage.xml'),
        );
    }
}

?>
