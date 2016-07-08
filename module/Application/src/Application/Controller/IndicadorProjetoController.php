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

use Application\Model\IndicadorProjeto;
use Application\Model\Indicador;

class IndicadorProjetoController extends AbstractActionController
{
	protected $indicadorProjetoTable;
	protected $indicadorTable;
	
	public function indexAction()
     {
    	$id = (int) $this->params()->fromRoute('id', 0);
    	
    	if (!$id) {
    		return $this->redirect()->toRoute('projeto', array(
    				'action' => 'index'
    		));
    	}
    
    	try {
    		$indicadoresProjeto = $this->getIndicadorProjetoTable()->getIndicadoresProjeto($id);
    	}
    	catch (\Exception $ex) {
    		return $this->redirect()->toRoute('projeto', array(
    				'action' => 'index'
    		));
    	}

         return new ViewModel(array(
             'id' => $id,
         	 'indicadoresProjeto' => $indicadoresProjeto
         ));
     }
     

     public function consultaAction()
     {
     	$id = (int) $this->params()->fromRoute('id', 0);
     	
     	if (!$id) {
     		return $this->redirect()->toRoute('projeto', array(
     				'action' => 'index'
     		));
     	}
     
     	try {
     		$indicadoresProjeto = $this->getIndicadorProjetoTable()->getIndicadoresProjeto($id);
     	}
     	catch (\Exception $ex) {
     		return $this->redirect()->toRoute('projeto', array(
     				'action' => 'index'
     		));
     	}
     
     	return new ViewModel(array(
     			'id' => $id,
     			'indicadoresProjeto' => $indicadoresProjeto
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
    
    public function addAction()
    {    	
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$indicadorProjeto = new IndicadorProjeto();
    		$dados_form = $request->getPost();
    	
    		if ($dados_form) {

    			$indicadorProjeto->indicador_id = $dados_form['indicador_id'];
    			$indicadorProjeto->projeto_id = 3;
    			$indicadorProjeto->usuario_id = 1;
    			$indicadorProjeto->projeto_fase = $dados_form['projeto_fase'];
    			$indicadorProjeto->valor_minimo = $dados_form['valor_minimo'];
    			$indicadorProjeto->valor_maximo = $dados_form['valor_maximo'];
    			 
    			$this->getIndicadorProjetoTable()->saveIndicadorProjeto($indicadorProjeto);
    	
    			return $this->redirect()->toRoute('indicador_projeto');
    		}
    	}
    	
    	$indicadorTable = $this->indicadorTable;
    	
    	return new ViewModel(array(
            	'indicadores' => $this->getIndicadorTable()->fetchAll(),
    			'indicadorProjetos' => $this->getIndicadorProjetoTable()->fetchAll(),
    	));
    }
    
    public function editAction()
    {
    	$id = (int) $this->params()->fromRoute('id', 0);
    	if (!$id) {
    		return $this->redirect()->toRoute('indicador_projeto', array(
    				'action' => 'index'
    		));
    	}
    
    	try {
    		$indicadorProjeto = $this->getIndicadorProjetoTable()->getIndicadorProjeto($id);
    	}
    	catch (\Exception $ex) {
    		return $this->redirect()->toRoute('indicadorProjeto', array(
    				'action' => 'index'
    		));
    	}

    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$dados_form = $request->getPost();    	
    		
    		$indicadorProjeto->indicador_projeto_id = $id;    
    		$indicadorProjeto->indicador_id = $dados_form['indicador_id'];
    		$indicadorProjeto->projeto_id = 3;
    		$indicadorProjeto->usuario_id = 1;
    		$indicadorProjeto->projeto_fase = $dados_form['projeto_fase'];
    		$indicadorProjeto->valor_minimo = $dados_form['valor_minimo'];
    		$indicadorProjeto->valor_maximo = $dados_form['valor_maximo'];
    		 
    		if ($dados_form) {
    			$this->getIndicadorProjetoTable()->saveIndicadorProjeto($indicadorProjeto);
    			 
    			return $this->redirect()->toRoute('indicador_projeto');
    		}
    	}
    	 
    	return array(
            	'indicadores' => $this->getIndicadorTable()->fetchAll(),
    			'id' => $id,
    			'indicadorProjeto' => $indicadorProjeto,
     	);
    	
    }
    
    public function deleteAction()
    {
    	$id = (int) $this->params()->fromRoute('id', 0);
    	if (!$id) {
    		return $this->redirect()->toRoute('indicadorProjeto');
    	}
    	
    	$request = $this->getRequest();
    	
    	if ($request->isPost()) {
    		$dados_form = $request->getPost(); 

    		if($dados_form['submit'] == "Sim"){
    			$id = (int) $request->getPost('id');
    			$this->getIndicadorProjetoTable()->deleteIndicadorProjeto($id);
    		}
    	
    		return $this->redirect()->toRoute('indicador_projeto');
    	}
    	
    	return array(
    			'id'    => $id,
    			'indicadorProjeto' => $this->getIndicadorProjetoTable()->getIndicadorProjeto($id)
    	);    	
    }
    
	public function detalheAction()
    {
		 $request = $this->getRequest();
		 
		 
    	return new ViewModel(array(
    			'indicadorProjeto' => $this->getIndicadorProjetoTable()->getIndicadorProjeto($this->params('id')),
    	));
    }
}
