<?php

/*
 * This file is part of the toolbox package.
 *
 * (c) Anthonius Munthi <me@itstoni.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace toolbox\testcommand;

use Symfony\Component\Console\Command\Command;

/**
 * Description of FooCommand
 *
 * @author Anthonius Munthi <toni.munthi@gmail.com>
 */
class FooCommand extends Command
{
    protected function configure()
    {
        $this->setName('foo');
    }

    protected function execute(\Symfony\Component\Console\Input\InputInterface $input, \Symfony\Component\Console\Output\OutputInterface $output)
    {
    }
}

?>
