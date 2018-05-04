<?php 

namespace Deveosys\AdminBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

class InstallFOSUserTemplatesCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('deveosys:install:fosuser_templates')
            ->setDescription('Generate FOSUser templates in app/Resources/FOSUserBundle')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {

    	$projectDir = $this->getContainer()->get('kernel')->getProjectDir();
    	$target = $projectDir.'/app/Resources/FOSUserBundle';
    	$source = __DIR__.'/../Resources/FOSUserBundle';

    	$fileSystem = new Filesystem();

    	$output->writeln('<info>Installing DeveosysAdmin version of FOSUserBundle templates in <comment>app/Resources/FOSUserBundle</comment></info>');

    	try {

    		$fileSystem->mkdir($target);

			$directoryIterator = new \RecursiveDirectoryIterator($source, \RecursiveDirectoryIterator::SKIP_DOTS);
			$iterator = new \RecursiveIteratorIterator($directoryIterator, \RecursiveIteratorIterator::SELF_FIRST);
			foreach ($iterator as $item) {
			    if ($item->isDir()) {
			        $targetDir = $target.DIRECTORY_SEPARATOR.$iterator->getSubPathName();
			        $fileSystem->mkdir($targetDir);
			    } else {
			        $targetFilename = $target.DIRECTORY_SEPARATOR.$iterator->getSubPathName();
			        $fileSystem->copy($item, $targetFilename);
			    }
			}
		} catch (IOExceptionInterface $exception) {
			$output->writeln($exception->getMessage());
		}

		$output->writeln('<info>Done !</info>');
    }
}