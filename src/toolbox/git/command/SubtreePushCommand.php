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

use toolbox\core\Config;

/**
 * Description of GitPushCommand
 *
 * @author Anthonius Munthi <toni.munthi@gmail.com>
 */
class SubtreePushCommand extends BaseCommand
{
    protected function configure()
    {
        $this->setName('git:subtree:push');
        $this->addArgument('branch',null,'Define a branch to split','master');             
    }

    protected function execute(\Symfony\Component\Console\Input\InputInterface $input, \Symfony\Component\Console\Output\OutputInterface $output)
    {
        $cwd = getcwd();

        $chdir = !is_null(Config::get('git.directory',null)) ? Config::get('git.directory'):__DIR__.'/dev';
        if(!is_dir($chdir)){        	
            throw new InvalidArgumentException('toolbox.git_subtree_push_invalid_config');            
        }

        $output->writeln("\n\n<info>Working in directory: <comment>".$chdir."</comment></info>");
        chdir($chdir);
        $dirs = Config::get('git_split_dir');
        $branch = $input->getArgument('branch');

        $tpl = "git subtree push --prefix=%prefix% %repo% %branch%";
        foreach($dirs as $prefix=>$repo){
            $cmd = strtr($tpl,array(
                '%prefix%'=>$prefix,
                '%repo%'=>$repo,
                '%branch%'=>$branch,
            ));
            $output->writeln("\n\n");
            $output->writeln(sprintf('<info>Push from <comment>%s</comment> to <comment>%s</comment> branch <comment>%s</comment></info>',$prefix,$repo,$branch));
            $output->writeln('<comment>'.$cmd.'</comment>');
            $this->runGit($cmd);
        }
        $output->writeln("\n\n");

        chdir($cwd);
    }
}

?>
