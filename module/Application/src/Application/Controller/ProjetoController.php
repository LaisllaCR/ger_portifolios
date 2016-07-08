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

class ProjetoController extends AbstractActionController
{
	protected $projetoTable;
	
	public function indexAction()
     {
         return new ViewModel(array(
             'projetos' => $this->getProjetoTable()->fetchAll(),
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
    
    public function addAction()
    {    	
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$projeto = new Projeto();
    		$dados_form = $request->getPost();
    	
    		if ($dados_form) {

    			$projeto->projeto_nome = $dados_form['projeto_nome'];
    			$projeto->projeto_data_inicio = $dados_form['projeto_data_inicio'];
    			$projeto->projeto_data_previsao_termino = $dados_form['projeto_data_previsao_termino'];
    			$projeto->projeto_data_real_termino = $dados_form['projeto_data_real_termino'];
    			$projeto->projeto_gerente_id = $dados_form['projeto_gerente_id'];
    			$projeto->projeto_orcamento_total = $dados_form['projeto_orcamento_total'];
    			$projeto->projeto_descricao = $dados_form['projeto_descricao'];
    			$projeto->projeto_status = $dados_form['statusRadios'];
    			$projeto->projeto_risco = $dados_form['riscoRadios'];
    			 
    			$this->getProjetoTable()->saveProjeto($projeto);
    	
    			return $this->redirect()->toRoute('projeto');
    		}
    	}
    	
    	return new ViewModel(array(
    			'projetos' => $this->getProjetoTable()->fetchAll(),
    	));
    }
    
    public function editAction()
    {
    	$id = (int) $this->params()->fromRoute('id', 0);
    	if (!$id) {
    		return $this->redirect()->toRoute('projeto', array(
    				'action' => 'index'
    		));
    	}
    
    	try {
    		$projeto = $this->getProjetoTable()->getProjeto($id);
    	}
    	catch (\Exception $ex) {
    		return $this->redirect()->toRoute('projeto', array(
    				'action' => 'index'
    		));
    	}

    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$dados_form = $request->getPost();    	
    		
    		$projeto->projeto_id = $id;    
    		$projeto->projeto_nome = $dados_form['projeto_nome'];
    		$projeto->projeto_data_inicio = $dados_form['projeto_data_inicio'];
    		$projeto->projeto_data_previsao_termino = $dados_form['projeto_data_previsao_termino'];
    		$projeto->projeto_data_real_termino = $dados_form['projeto_data_real_termino'];
    		$projeto->projeto_gerente_id = $dados_form['projeto_gerente_id'];
    		$projeto->projeto_orcamento_total = $dados_form['projeto_orcamento_total'];
    		$projeto->projeto_descricao = $dados_form['projeto_descricao'];
    		$projeto->projeto_status = $dados_form['statusRadios'];
    		$projeto->projeto_risco = $dados_form['riscoRadios'];
    		 
    		if ($dados_form) {
    			$this->getProjetoTable()->saveProjeto($projeto);
    			 
    			return $this->redirect()->toRoute('projeto');
    		}
    	}
    	 
    	return array(
    			'id' => $id,
    			'projeto' => $projeto,
     	);
    	
    }
    
    public function deleteAction()
    {
    	$id = (int) $this->params()->fromRoute('id', 0);
    	if (!$id) {
    		return $this->redirect()->toRoute('projeto');
    	}
    	
    	$request = $this->getRequest();
    	
    	if ($request->isPost()) {
    		$dados_form = $request->getPost(); 

    		if($dados_form['submit'] == "Sim"){
    			$id = (int) $request->getPost('id');
    			$this->getProjetoTable()->deleteProjeto($id);
    		}
    	
    		return $this->redirect()->toRoute('projeto');
    	}
    	
    	return array(
    			'id'    => $id,
    			'projeto' => $this->getProjetoTable()->getProjeto($id)
    	);    	
    }
    
	public function detalheAction()
    {
		 $request = $this->getRequest();
		 
		 
    	return new ViewModel(array(
    			'projeto' => $this->getProjetoTable()->getProjeto($this->params('id')),
    	));
    }
}
