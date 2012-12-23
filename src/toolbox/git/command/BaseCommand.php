<?php

/*
 * This file is part of the toolbox package.
 *
 * (c) Anthonius Munthi <me@itstoni.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace toolbox\git\command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Description of BaseCommand
 *
 * @author Anthonius Munthi <toni.munthi@gmail.com>
 */
abstract class BaseCommand extends Command
{
    protected function runGit($command)
    {    	
    	passthru($command,$return);
    	
        if(0!==$return){
        	throw new Exception('git.command_failed');
        }
        return $return;
    }
}

?>
