<?php
namespace Application\Factory;

use Application\Controller\AlertasController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AlertaControllerFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $sl)
	{
		$sl = $sl->getServiceLocator();
		$service    = $sl->get('Application\Service\AlertaService');
		$controller = new AlertasController($service);

		return $controller;
	}
}