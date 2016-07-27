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

use Application\Model\ProjetoAcompanhamento;
use Application\Model\Projeto;

class AcompanhamentoProjetoController extends AbstractActionController
{
	protected $acompanhamentoProjetoTable;
	protected $projetoTable;
	
	public function indexAction()
     {
         return new ViewModel(array(
             'acompanhamentos' => $this->getAcompanhamentoProjetoTable()->fetchAll(),
         ));
     }
     
     public function consultaAction()
     {
     	$id = (int) $this->params()->fromRoute('id', 0);
     
     	if (!$id) {
     		return $this->redirect()->toRoute('acompanhamento_projeto', array(
     				'action' => 'index'
     		));
     	}
     	 
     	try {
     		$acompanhamentosProjeto = $this->getAcompanhamentoProjetoTable()->getAcompanhamentosProjeto($id);
     	}
     	catch (\Exception $ex) {
     		return $this->redirect()->toRoute('acompanhamento_projeto', array(
     				'action' => 'index'
     		));
     	}
     	 
     	return new ViewModel(array(
     			'id' => $id,
     			'projeto' => $this->getProjetoTable()->getProjeto($id),
     			'acompanhamentosProjeto' => $acompanhamentosProjeto
     	));
     }

     public function getProjetoTable()
     {
     	if (!$this->projetoTable) {
     		$sm = $this->getServiceLocator();
     		$this->projetoTable = $sm->get('Application\Model\ProjetoTable');
     	}
     	return $this->projetoTable;
     }
    
    public function getAcompanhamentoProjetoTable()
    {
    	if (!$this->acompanhamentoProjetoTable) {
    		$sm = $this->getServiceLocator();
    		$this->acompanhamentoProjetoTable = $sm->get('Application\Model\ProjetoAcompanhamentoTable');
    	}
    	return $this->acompanhamentoProjetoTable;
    }
    
    public function addAction()
    {    	
    	$id = (int) $this->params()->fromRoute('id', 0);
    	$request = $this->getRequest();
    	
    	if ($request->isPost()) {
    		$acompanhamentoProjeto = new ProjetoAcompanhamento();
    		$dados_form = $request->getPost();
    	
    		if ($dados_form) {

    			$acompanhamentoProjeto->projeto_acompanhamento_descricao = $dados_form['projeto_acompanhamento_descricao'];
    			$acompanhamentoProjeto->projeto_acompanhamento_data = $dados_form['projeto_acompanhamento_data'];
    			$acompanhamentoProjeto->projeto_id = $id;
    			 
    			$this->getAcompanhamentoProjetoTable()->saveAcompanhamentoProjeto($acompanhamentoProjeto);

    			return $this->redirect()->toRoute('acompanhamento_projeto/consulta', array(
    					'action' => 'consulta', 'id' => $id
    			));
    		}
    	}
    	
    	return new ViewModel(array(
    			'id' => $id,
     			'projeto' => $this->getProjetoTable()->getProjeto($id),
    			'acompanhamentos' => $this->getAcompanhamentoProjetoTable()->fetchAll(),
    	));
    }
    
    public function editAction()
    {
    	$id = (int) $this->params()->fromRoute('id', 0);
    	$projeto_id = (int) $this->params()->fromRoute('projeto_id', 0);
    	    	
    	if (!$id) {
    		return $this->redirect()->toRoute('acompanhamento_projeto', array(
    				'action' => 'index'
    		));
    	}
    
    	try {
    		$acompanhamentoProjeto = $this->getAcompanhamentoProjetoTable()->getProjetoAcompanhamento($id);
    	}
    	catch (\Exception $ex) {
    		return $this->redirect()->toRoute('acompanhamento_projeto', array(
    				'action' => 'index'
    		));
    	}

    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$dados_form = $request->getPost(); 
    		
    		$acompanhamentoProjeto->projeto_acompanhamento_id = $id; 
    		$acompanhamentoProjeto->projeto_id = $projeto_id;    
    		$acompanhamentoProjeto->projeto_acompanhamento_descricao = $dados_form['projeto_acompanhamento_descricao'];
    		$acompanhamentoProjeto->projeto_acompanhamento_data_inicio = $dados_form['projeto_acompanhamento_data_inicio'];
    		$acompanhamentoProjeto->projeto_acompanhamento_data_termino = $dados_form['projeto_acompanhamento_data_termino'];
    		$acompanhamentoProjeto->projeto_acompanhamento_semana = $dados_form['projeto_acompanhamento_semana'];
    		 
    		if ($dados_form) {
    			$this->getAcompanhamentoProjetoTable()->saveAcompanhamentoProjeto($acompanhamentoProjeto);

    			return $this->redirect()->toRoute('acompanhamento_projeto/consulta', array(
    					'action' => 'consulta', 'id' => $projeto_id
    			));
    		}
    	}
    	 
    	return array(
    			'id' => $id,
    			'projeto_id' => $projeto_id,
     			'projeto' => $this->getProjetoTable()->getProjeto($projeto_id),
    			'acompanhamento' => $acompanhamentoProjeto,
     	);
    	
    }
    
    public function deleteAction()
    {
    	$id = (int) $this->params()->fromRoute('id', 0);
    	$projeto_id = (int) $this->params()->fromRoute('projeto_id', 0);
    	
    	if (!$id) {
    		return $this->redirect()->toRoute('acompanhamento_projeto');
    	}
    	
    	$request = $this->getRequest();
    	
    	if ($request->isPost()) {
    		$dados_form = $request->getPost(); 

    		if($dados_form['submit'] == "Sim"){
    			$id = (int) $request->getPost('id');
    			$this->getAcompanhamentoProjetoTable()->deleteProjetoAcompanhamento($id);
    		}

    		return $this->redirect()->toRoute('acompanhamento_projeto/consulta', array(
    				'action' => 'consulta', 'id' => $projeto_id
    		));
    	}
    	
    	return array(
    			'id'    => $id,
    			'projeto_id'    => $projeto_id,
     			'projeto' => $this->getProjetoTable()->getProjeto($projeto_id),
    			'acompanhamento' => $this->getAcompanhamentoProjetoTable()->getProjetoAcompanhamento($id)
    	);    	
    }
    
	public function detalheAction()
    {
		 $request = $this->getRequest();
		 
		 
    	return new ViewModel(array(
    			'acompanhamento' => $this->getAcompanhamentoProjetoTable()->getProjetoAcompanhamento($this->params('id')),
    	));
    }   
 	
}
