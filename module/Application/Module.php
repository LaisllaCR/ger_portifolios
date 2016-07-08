<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Application\Model\Projeto;
use Application\Model\ProjetoTable;
use Application\Model\Indicador;
use Application\Model\IndicadorTable;
use Application\Model\IndicadorProjeto;
use Application\Model\IndicadorProjetoTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    public function getServiceConfig()
    {
    	return array(
    			'factories' => array(
	    					'Application\Model\ProjetoTable' =>  function($sm) {
		    					$tableGateway = $sm->get('ProjetoTableGateway');
		    					$table = new ProjetoTable($tableGateway);
		    					return $table;
	    					},
	    					'ProjetoTableGateway' => function ($sm) {
		    					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
		    					$resultSetPrototype = new ResultSet();
		    					$resultSetPrototype->setArrayObjectPrototype(new Projeto());
		    					return new TableGateway('projeto', $dbAdapter, null, $resultSetPrototype);
	    					},
	    					'Application\Model\IndicadorTable' =>  function($sm) {
		    					$tableGateway = $sm->get('IndicadorTableGateway');
		    					$table = new IndicadorTable($tableGateway);
		    					return $table;
	    					},
	    					'IndicadorTableGateway' => function ($sm) {
		    					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
		    					$resultSetPrototype = new ResultSet();
		    					$resultSetPrototype->setArrayObjectPrototype(new Indicador());
		    					return new TableGateway('indicadores', $dbAdapter, null, $resultSetPrototype);
	    					},
	    					'Application\Model\IndicadorProjetoTable' =>  function($sm) {
		    					$tableGateway = $sm->get('IndicadorProjetoTableGateway');
		    					$table = new IndicadorProjetoTable($tableGateway);
		    					return $table;
	    					},
	    					'IndicadorProjetoTableGateway' => function ($sm) {
		    					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
		    					$resultSetPrototype = new ResultSet();
		    					$resultSetPrototype->setArrayObjectPrototype(new IndicadorProjeto());
		    					return new TableGateway('indicadores_projeto', $dbAdapter, null, $resultSetPrototype);
	    					},
    					),
    				);
    }
}
