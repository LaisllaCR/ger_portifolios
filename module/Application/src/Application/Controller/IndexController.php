<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Model\Projeto;
use Application\Model\Usuario;
use Application\Model\Indicador;
use Application\Model\TarefaProjeto;
use Application\Model\IndicadorProjeto;

class IndexController extends AbstractActionController
{
	protected $projetoTable;
	protected $usuarioTable;
	protected $tarefaProjetoTable;
	protected $indicadorTable;
	protected $indicadorProjetoTable;
	
    public function indexAction()
    {
    	$projetos = $this->getProjetoTable()->fetchAll();
    	
    	$tarefas = Array();
    	$indicadores = Array();
    	
    	if(is_array($projetos)){
	    	foreach ($projetos as $projeto){
	    		$tarefas[$projeto->projeto_id] = $this->getTarefaProjetoTable()->getTarefasProjeto($projeto->projeto_id);
	    		$indicadores[$projeto->projeto_id] = $this->getIndicadorProjetoTable()->getIndicadores($projeto->projeto_id);
	    	}
    	}

    	return new ViewModel(array(
    		'projetos' => $this->getProjetoTable()->fetchAll(),
    		'projeto_tarefas' => $tarefas,
    		'projeto_indicadores' => $indicadores,
    		'tarefas' => $this->getTarefaProjetoTable()->fetchAll(),
    		'projetos_cancelados' => $this->getProjetoTable()->getProjetoStatus('Cancelado'),
    		'indicadores' => $this->getIndicadorTable()->fetchAll(),
             'usuarios' => $this->getUsuarioTable()->fetchAll(),
    	));
    }

    public function getIndicadorProjetoTable()
    {
    	if (!$this->indicadorProjetoTable) {
    		$sm = $this->getServiceLocator();
    		$this->indicadorProjetoTable = $sm->get('Application\Model\IndicadorProjetoTable');
    	}
    	return $this->indicadorProjetoTable;
    }
    
    public function getIndicadorTable()
    {
    	if (!$this->indicadorTable) {
    		$sm = $this->getServiceLocator();
    		$this->indicadorTable = $sm->get('Application\Model\IndicadorTable');
    	}
    	return $this->indicadorTable;
    }

    public function getTarefaProjetoTable()
    {
    	if (!$this->tarefaProjetoTable) {
    		$sm = $this->getServiceLocator();
    		$this->tarefaProjetoTable = $sm->get('Application\Model\ProjetoTarefaTable');
    	}
    	return $this->tarefaProjetoTable;
    }
    
    public function getUsuarioTable()
    {
    	if (!$this->usuarioTable) {
    		$sm = $this->getServiceLocator();
    		$this->usuarioTable = $sm->get('Application\Model\UsuarioTable');
    	}
    	return $this->usuarioTable;
    }
    
    
    public function getProjetoTable()
    {
    	if (!$this->projetoTable) {
    		$sm = $this->getServiceLocator();
    		$this->projetoTable = $sm->get('Application\Model\ProjetoTable');
    	}
    	return $this->projetoTable;
    }
}
