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

use Application\Model\ProjetoMembro;
use Application\Model\ProjetoMembroTable;

use Application\Model\ProjetoAcompanhamento;
use Application\Model\ProjetoAcompanhamentoTable;

use Application\Model\Tarefa;
use Application\Model\TarefaTable;

use Application\Model\ProjetoTarefa;
use Application\Model\ProjetoTarefaTable;

use Application\Model\Usuario;
use Application\Model\UsuarioTable;

use Application\Model\Perfil;
use Application\Model\PerfilTable;

use Application\Model\PerfilAcesso;
use Application\Model\PerfilAcessoTable;

use Application\Model\ProjetoStatusJustificativa;
use Application\Model\ProjetoStatusJustificativaTable;

use Application\Model\Funcionalidade;
use Application\Model\FuncionalidadeTable;

use Application\Model\ProjetoSemana;
use Application\Model\ProjetoSemanaTable;

use Application\Model\ProjetoSemanaJustificativa;
use Application\Model\ProjetoSemanaJustificativaTable;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

use Zend\ModuleManager\ModuleManager;
use Zend\Session\Container;


class Module
{
	public function init(ModuleManager $moduleManager)
	{
		$sharedEvents = $moduleManager->getEventManager()->getSharedManager();
		 
		$sharedEvents->attach('Zend\Mvc\Controller\AbstractActionController', MvcEvent::EVENT_DISPATCH, array($this, 'verificaAutenticacao'), 100);
	}
	
	public function verificaAutenticacao($e)
	{
		// vamos descobrir onde estamos?
		$controller = $e->getTarget();
		$rota = $controller->getEvent()->getRouteMatch()->getMatchedRouteName();
		$sessao = new Container('usuario_dados');
		 
		//echo $rota;

		if ($rota != 'login' && $rota != 'login/default' && $rota != 'usuario/add') {
			/*
			if(!in_array($rota, $sessao->funcionalidades_usuario)){
				return $controller->redirect()->toRoute('home');			
			}
							*/
			if (!$sessao->id) {
				return $controller->redirect()->toRoute('login');
			}
			 
		}
	}
	
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
	    					'Application\Model\ProjetoMembroTable' =>  function($sm) {
		    					$tableGateway = $sm->get('ProjetoMembroTableGateway');
		    					$table = new ProjetoMembroTable($tableGateway);
		    					return $table;
	    					},
	    					'ProjetoMembroTableGateway' => function ($sm) {
		    					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
		    					$resultSetPrototype = new ResultSet();
		    					$resultSetPrototype->setArrayObjectPrototype(new ProjetoMembro());
		    					return new TableGateway('projeto_membro', $dbAdapter, null, $resultSetPrototype);
	    					},
	    					'Application\Model\ProjetoAcompanhamentoTable' =>  function($sm) {
		    					$tableGateway = $sm->get('ProjetoAcompanhamentoTableGateway');
		    					$table = new ProjetoAcompanhamentoTable($tableGateway);
		    					return $table;
	    					},
	    					'ProjetoAcompanhamentoTableGateway' => function ($sm) {
		    					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
		    					$resultSetPrototype = new ResultSet();
		    					$resultSetPrototype->setArrayObjectPrototype(new ProjetoAcompanhamento());
		    					return new TableGateway('projeto_acompanhamento', $dbAdapter, null, $resultSetPrototype);
	    					},
	    					'Application\Model\TarefaTable' =>  function($sm) {
		    					$tableGateway = $sm->get('TarefaTableGateway');
		    					$table = new TarefaTable($tableGateway);
		    					return $table;
	    					},
	    					'TarefaTableGateway' => function ($sm) {
		    					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
		    					$resultSetPrototype = new ResultSet();
		    					$resultSetPrototype->setArrayObjectPrototype(new Tarefa());
		    					return new TableGateway('tarefa', $dbAdapter, null, $resultSetPrototype);
	    					},
	    					'Application\Model\ProjetoTarefaTable' =>  function($sm) {
		    					$tableGateway = $sm->get('ProjetoTarefaTableGateway');
		    					$table = new ProjetoTarefaTable($tableGateway);
		    					return $table;
	    					},
	    					'ProjetoTarefaTableGateway' => function ($sm) {
		    					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
		    					$resultSetPrototype = new ResultSet();
		    					$resultSetPrototype->setArrayObjectPrototype(new ProjetoTarefa());
		    					return new TableGateway('projeto_tarefa', $dbAdapter, null, $resultSetPrototype);
	    					},
	    					'Application\Model\UsuarioTable' =>  function($sm) {
		    					$tableGateway = $sm->get('UsuarioTableGateway');
		    					$table = new UsuarioTable($tableGateway);
		    					return $table;
	    					},
	    					'UsuarioTableGateway' => function ($sm) {
		    					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
		    					$resultSetPrototype = new ResultSet();
		    					$resultSetPrototype->setArrayObjectPrototype(new Usuario());
		    					return new TableGateway('usuario', $dbAdapter, null, $resultSetPrototype);
	    					},
	    					'Application\Model\PerfilAcessoTable' =>  function($sm) {
		    					$tableGateway = $sm->get('PerfilAcessoTableGateway');
		    					$table = new PerfilAcessoTable($tableGateway);
		    					return $table;
	    					},
	    					'PerfilAcessoTableGateway' => function ($sm) {
		    					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
		    					$resultSetPrototype = new ResultSet();
		    					$resultSetPrototype->setArrayObjectPrototype(new PerfilAcesso());
		    					return new TableGateway('perfil_acesso', $dbAdapter, null, $resultSetPrototype);
	    					},
	    					'Application\Model\ProjetoStatusJustificativaTable' =>  function($sm) {
		    					$tableGateway = $sm->get('ProjetoStatusJustificativaTableGateway');
		    					$table = new ProjetoStatusJustificativaTable($tableGateway);
		    					return $table;
	    					},
	    					'ProjetoStatusJustificativaTableGateway' => function ($sm) {
		    					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
		    					$resultSetPrototype = new ResultSet();
		    					$resultSetPrototype->setArrayObjectPrototype(new ProjetoStatusJustificativa());
		    					return new TableGateway('projeto_status_justificativa', $dbAdapter, null, $resultSetPrototype);
	    					},
	    					'Application\Model\PerfilTable' =>  function($sm) {
		    					$tableGateway = $sm->get('PerfilTableGateway');
		    					$table = new PerfilTable($tableGateway);
		    					return $table;
	    					},
	    					'PerfilTableGateway' => function ($sm) {
		    					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
		    					$resultSetPrototype = new ResultSet();
		    					$resultSetPrototype->setArrayObjectPrototype(new Perfil());
		    					return new TableGateway('perfil', $dbAdapter, null, $resultSetPrototype);
	    					},
	    					'Application\Model\FuncionalidadeTable' =>  function($sm) {
		    					$tableGateway = $sm->get('FuncionalidadeTableGateway');
		    					$table = new FuncionalidadeTable($tableGateway);
		    					return $table;
	    					},
	    					'FuncionalidadeTableGateway' => function ($sm) {
		    					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
		    					$resultSetPrototype = new ResultSet();
		    					$resultSetPrototype->setArrayObjectPrototype(new Funcionalidade());
		    					return new TableGateway('funcionalidade', $dbAdapter, null, $resultSetPrototype);
	    					},
	    					'Application\Model\ProjetoSemanaTable' =>  function($sm) {
		    					$tableGateway = $sm->get('ProjetoSemanaTableGateway');
		    					$table = new ProjetoSemanaTable($tableGateway);
		    					return $table;
	    					},
	    					'ProjetoSemanaTableGateway' => function ($sm) {
		    					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
		    					$resultSetPrototype = new ResultSet();
		    					$resultSetPrototype->setArrayObjectPrototype(new ProjetoSemana());
		    					return new TableGateway('projeto_semana', $dbAdapter, null, $resultSetPrototype);
	    					},
	    					'Application\Model\ProjetoSemanaJustificativaTable' =>  function($sm) {
		    					$tableGateway = $sm->get('ProjetoSemanaJustificativaTableGateway');
		    					$table = new ProjetoSemanaJustificativaTable($tableGateway);
		    					return $table;
	    					},
	    					'ProjetoSemanaJustificativaTableGateway' => function ($sm) {
		    					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
		    					$resultSetPrototype = new ResultSet();
		    					$resultSetPrototype->setArrayObjectPrototype(new ProjetoSemanaJustificativa());
		    					return new TableGateway('projeto_semana_justificativa', $dbAdapter, null, $resultSetPrototype);
	    					},
    					),
    				);
    }
}
