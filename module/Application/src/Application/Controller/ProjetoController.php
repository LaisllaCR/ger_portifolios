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
use Application\Model\ProjetoAcompanhamento;
use Application\Model\Usuario;
use Application\Model\ProjetoStatusJustificativa;
use Zend\Db\Sql\Ddl\Column\Date;

class ProjetoController extends AbstractActionController
{
	protected $projetoTable;
	protected $usuarioTable;
	protected $projetoStatusJustificativaTable;
	protected $projetoAcompanhamentoTable;
	
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
    
    public function getUsuarioTable()
    {
    	if (!$this->usuarioTable) {
    		$sm = $this->getServiceLocator();
    		$this->usuarioTable = $sm->get('Application\Model\UsuarioTable');
    	}
    	return $this->usuarioTable;
    }
    
    public function getProjetoStatusJustificativaTable()
    {
    	if (!$this->projetoStatusJustificativaTable) {
    		$sm = $this->getServiceLocator();
    		$this->projetoStatusJustificativaTable = $sm->get('Application\Model\ProjetoStatusJustificativaTable');
    	}
    	return $this->projetoStatusJustificativaTable;
    }
    
    public function getProjetoAcompanhamentoTable()
    {
    	if (!$this->projetoAcompanhamentoTable) {
    		$sm = $this->getServiceLocator();
    		$this->projetoAcompanhamentoTable = $sm->get('Application\Model\ProjetoAcompanhamentoTable');
    	}
    	return $this->projetoAcompanhamentoTable;
    }
    
    public function addAction()
    {    	
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$projeto = new Projeto();
    		$projetoStatusJustificativa = new ProjetoStatusJustificativa();
    		$dados_form = $request->getPost();
    	
    		if ($dados_form) {

    			$projeto->projeto_nome = $dados_form['projeto_nome'];
    			$projeto->projeto_data_inicio = $dados_form['projeto_data_inicio'];
    			$projeto->projeto_data_previsao_termino = $dados_form['projeto_data_previsao_termino'];
    			$projeto->projeto_data_real_termino = $dados_form['projeto_data_real_termino'];
    			$projeto->projeto_gerente_id = $dados_form['projeto_gerente_id'];
    			$projeto->projeto_orcamento_total = $dados_form['projeto_orcamento_total'];
    			$projeto->projeto_descricao = $dados_form['projeto_descricao'];
    			$projeto->projeto_status = 'Em analise';
    			$projeto->projeto_risco = $dados_form['riscoRadios'];
    			 
    			$id = $this->getProjetoTable()->saveProjeto($projeto);
    			
    			$projeto->projeto_id = $id;
    			
    			$this->getProjetoAcompanhamentoTable()->salvarDatasAcompanhamento($projeto);

    			$projetoStatusJustificativa->projeto_id = $id;
    			$projetoStatusJustificativa->projeto_status = 'Em analise';
    			$projetoStatusJustificativa->projeto_status_data = date('Y-m-d');
    			$projetoStatusJustificativa->projeto_status_justificativa = NULL;
    				
    			$this->getProjetoStatusJustificativaTable()->saveProjetoStatusJustificativa($projetoStatusJustificativa);
    				    	
    			return $this->redirect()->toRoute('projeto');
    		}
    	}
    	
    	return new ViewModel(array(
    			'projetos' => $this->getProjetoTable()->fetchAll(),
             'usuarios' => $this->getUsuarioTable()->fetchAll(),
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
    		   
    		    		 
    		if ($dados_form) {
    			
    			$projeto->projeto_id = $id; 
    			$projeto->projeto_nome = $dados_form['projeto_nome'];
    			$projeto->projeto_data_inicio = $dados_form['projeto_data_inicio'];
    			$projeto->projeto_data_previsao_termino = $dados_form['projeto_data_previsao_termino'];
    			$projeto->projeto_data_real_termino = $dados_form['projeto_data_real_termino'];
    			$projeto->projeto_gerente_id = $dados_form['projeto_gerente_id'];
    			$projeto->projeto_orcamento_total = $dados_form['projeto_orcamento_total'];
    			$projeto->projeto_descricao = $dados_form['projeto_descricao'];
    			$projeto->projeto_risco = $dados_form['riscoRadios'];
    			 
    			$this->getProjetoTable()->saveProjeto($projeto);
    			 
    			return $this->redirect()->toRoute('projeto');
    		}
    	}
    	 
    	return array(
    			'id' => $id,
    			'projeto' => $projeto,
             'usuarios' => $this->getUsuarioTable()->fetchAll(),
     	);
    	
    }
    
    public function statusAction()
    {
    	$id = (int) $this->params()->fromRoute('id', 0);
    	if (!$id) {
    		return $this->redirect()->toRoute('projeto', array(
    				'action' => 'index'
    		));
    	}
    
    	try {
    		$projeto = $this->getProjetoTable()->getProjeto($id);
    		$projetoStatusJustificativa = new ProjetoStatusJustificativa();
    		$projetoJustificativas = $this->getProjetoStatusJustificativaTable()->getProjetoStatusJustificativas($id);
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
    		$projeto->projeto_status = $dados_form['statusRadios'];
    		 
    		if ($dados_form) {
    			$this->getProjetoTable()->saveProjeto($projeto);
    			
    
    				$projetoStatusJustificativa->projeto_id = $projeto->projeto_id;
    				$projetoStatusJustificativa->projeto_status = $projeto->projeto_status;
    				$projetoStatusJustificativa->projeto_status_data = date('Y-m-d');
    				$projetoStatusJustificativa->projeto_status_justificativa = $dados_form['projeto_status_justificativa'];
    				 
    				$this->getProjetoStatusJustificativaTable()->saveProjetoStatusJustificativa($projetoStatusJustificativa);
    
    			return $this->redirect()->toRoute('projeto');
    		}
    	}
    
    	return array(
    			'id' => $id,
    			'projeto' => $projeto,
    			'usuarios' => $this->getUsuarioTable()->fetchAll(),
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
    			'usuarios' => $this->getUsuarioTable()->fetchAll(),
    	));
    }
}
