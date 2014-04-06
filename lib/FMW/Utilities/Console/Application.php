<?php

namespace FMW\Utilities\Console;

use Symfony\Component\Console\Input\InputArgument,
    Symfony\Component\Console;

/**
 *
 * Classe Application
 *
 * @author Hugo Mastromauro <hugomastromauro@gmail.com>
 * @version 2.0
 * @copyright  GPL © 2014, catayaphp.com.
 * @access public
 * @package Console
 * @subpackage Utilities
 *
 */
class Application 
	extends Console\Command\Command {
	
	/**
	 * @see Console\Command\Command
	 */
	protected function configure()
	{
		
		// @todo: Criar interface de controle
		$this
			->setName('app:create-controller')
			->setDescription('Criar controlador.')
			->setDefinition(array(
				new InputArgument(
						'dest-path', InputArgument::REQUIRED, 'Requerido.'
				)
		))
		->setHelp(<<<EOT
Cria controlador.
EOT
		);
	}
	
	/**
	 * @see Console\Command\Command
	 */
	protected function execute(Console\Input\InputInterface $input, Console\Output\OutputInterface $output)
	{
		$destPath = realpath($input->getArgument('dest-path'));
		$this->createController($destPath, $output);
	}
	
	/**
	 * @param string $destPath
	 * @param Console\Output\OutputInterface $output
	 */
	public function createController($destPath, $output)
	{
		$output->write('Implementar' . PHP_EOL);
	}
}