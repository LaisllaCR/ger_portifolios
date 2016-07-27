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

use Application\Model\ProjetoTarefa;

class TarefaProjetoController extends AbstractActionController
{
	protected $tarefaProjetoTable;
	protected $projetoTable;
	
	public function indexAction()
     {
         return new ViewModel(array(
             'tarefas' => $this->getTarefaProjetoTable()->fetchAll(),
         ));
     }
     
     public function consultaAction()
     {
     	$id = (int) $this->params()->fromRoute('id', 0);
     
     	if (!$id) {
     		return $this->redirect()->toRoute('tarefa_projeto', array(
     				'action' => 'index'
     		));
     	}
     	 
     	try {
     		$tarefasProjeto = $this->getTarefaProjetoTable()->getTarefasProjeto($id);
     	}
     	catch (\Exception $ex) {
     		return $this->redirect()->toRoute('tarefa_projeto', array(
     				'action' => 'index'
     		));
     	}
     	 
     	return new ViewModel(array(
     			'id' => $id,
     			'projeto' => $this->getProjetoTable()->getProjeto($id),
     			'tarefasProjeto' => $tarefasProjeto
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
    
    public function getTarefaProjetoTable()
    {
    	if (!$this->tarefaProjetoTable) {
    		$sm = $this->getServiceLocator();
    		$this->tarefaProjetoTable = $sm->get('Application\Model\ProjetoTarefaTable');
    	}
    	return $this->tarefaProjetoTable;
    }
    
    public function addAction()
    {    	
    	$id = (int) $this->params()->fromRoute('id', 0);
    	$request = $this->getRequest();
    	
    	if ($request->isPost()) {
    		$tarefaProjeto = new ProjetoTarefa();
    		$dados_form = $request->getPost();
    	
    		if ($dados_form) {

    			$tarefaProjeto->tarefa_nome = $dados_form['tarefa_nome'];
    			$tarefaProjeto->projeto_id = $id;
    			$tarefaProjeto->tarefa_descricao = $dados_form['tarefa_descricao'];
    			$tarefaProjeto->tarefa_status = $dados_form['tarefa_status'];
    			$tarefaProjeto->tarefa_data_inicio = $dados_form['tarefa_data_inicio'];
    			$tarefaProjeto->tarefa_data_previsao_termino = $dados_form['tarefa_data_previsao_termino'];
    			$tarefaProjeto->tarefa_data_termino = $dados_form['tarefa_data_termino'];
    			 
    			$this->getTarefaProjetoTable()->saveTarefaProjeto($tarefaProjeto);

    			return $this->redirect()->toRoute('tarefa_projeto/consulta', array(
    					'action' => 'consulta', 'id' => $id
    			));
    		}
    	}
    	
    	return new ViewModel(array(
    			'id' => $id,
     			'projeto' => $this->getProjetoTable()->getProjeto($id),
    			'tarefas' => $this->getTarefaProjetoTable()->fetchAll(),
    	));
    }
    
    public function editAction()
    {
    	$id = (int) $this->params()->fromRoute('id', 0);
    	$projeto_id = (int) $this->params()->fromRoute('projeto_id', 0);
    	    	
    	if (!$id) {
    		return $this->redirect()->toRoute('tarefa_projeto', array(
    				'action' => 'index'
    		));
    	}
    
    	try {
    		$tarefaProjeto = $this->getTarefaProjetoTable()->getTarefaProjeto($id);
    	}
    	catch (\Exception $ex) {
    		return $this->redirect()->toRoute('tarefa_projeto', array(
    				'action' => 'index'
    		));
    	}

    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$dados_form = $request->getPost();    	
    		
    		$tarefaProjeto->tarefa_id = $id; 
    		$tarefaProjeto->projeto_id = $projeto_id;    
    		$tarefaProjeto->tarefa_nome = $dados_form['tarefa_nome'];
    		$tarefaProjeto->tarefa_descricao = $dados_form['tarefa_descricao'];
    		$tarefaProjeto->tarefa_status = $dados_form['tarefa_status'];
    		$tarefaProjeto->tarefa_data_inicio = $dados_form['tarefa_data_inicio'];
    		$tarefaProjeto->tarefa_data_previsao_termino = $dados_form['tarefa_data_previsao_termino'];
    		$tarefaProjeto->tarefa_data_termino = $dados_form['tarefa_data_termino'];
    		 
    		if ($dados_form) {
    			$this->getTarefaProjetoTable()->saveTarefaProjeto($tarefaProjeto);

    			return $this->redirect()->toRoute('tarefa_projeto/consulta', array(
    					'action' => 'consulta', 'id' => $projeto_id
    			));
    		}
    	}
    	 
    	return array(
    			'id' => $id,
    			'projeto_id' => $projeto_id,
     			'projeto' => $this->getProjetoTable()->getProjeto($projeto_id),
    			'tarefa' => $tarefaProjeto,
     	);
    	
    }
    
    public function deleteAction()
    {
    	$id = (int) $this->params()->fromRoute('id', 0);
    	$projeto_id = (int) $this->params()->fromRoute('projeto_id', 0);
    	
    	if (!$id) {
    		return $this->redirect()->toRoute('tarefa_projeto');
    	}
    	
    	$request = $this->getRequest();
    	
    	if ($request->isPost()) {
    		$dados_form = $request->getPost(); 

    		if($dados_form['submit'] == "Sim"){
    			$id = (int) $request->getPost('id');
    			$this->getTarefaProjetoTable()->deleteTarefaProjeto($id);
    		}

    		return $this->redirect()->toRoute('tarefa_projeto/consulta', array(
    				'action' => 'consulta', 'id' => $projeto_id
    		));
    	}
    	
    	return array(
    			'id'    => $id,
    			'projeto_id'    => $projeto_id,
     			'projeto' => $this->getProjetoTable()->getProjeto($projeto_id),
    			'tarefa' => $this->getTarefaProjetoTable()->getTarefaProjeto($id)
    	);    	
    }
    
	public function detalheAction()
    {
		 $request = $this->getRequest();
		 
		 
    	return new ViewModel(array(
    			'tarefa' => $this->getTarefaProjetoTable()->getTarefaProjeto($this->params('id')),
    	));
    }
}
