<?php
namespace toolbox\core\command;

use Symfony\Component\Console\Command\Command;

/**
 * Description of BuildCommand
 *
 * @author toni
 */
class BuildCommand extends Command
{
    protected function configure()
    {
        $this->setName('build')
            ->setDescription('Build a package')
        ;
    }
}

?>
