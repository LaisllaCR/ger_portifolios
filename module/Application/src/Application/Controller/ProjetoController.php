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
use Application\Model\ProjetoMembro;
use Application\Model\ProjetoStatusJustificativa;
use Application\Model\IndicadorProjeto;
use Application\Model\ProjetoTarefa;

use Zend\Db\Sql\Ddl\Column\Date;
use Zend\Session\Container;

class ProjetoController extends AbstractActionController
{
	protected $projetoTable;
	protected $usuarioTable;
	
	protected $projetoStatusJustificativaTable;
	protected $indicadorProjetoTable;
	protected $projetoAcompanhamentoTable;
	protected $membroProjetoTable;
	protected $tarefaProjetoTable;
	
	public function indexAction()
    {
     	$session_dados = new Container('usuario_dados');
     	if(isset($session_dados->id)){
     		if($session_dados->perfil == 1 || $session_dados->perfil == 2){
		         return new ViewModel(array(
		             'projetos' => $this->getProjetoTable()->fetchAll(),
		         ));     			
     		}else{
     			$membros_projetos = $this->getMembroProjetoTable()->fetchAll();
     			
     			$projetos_usuario_sessao = Array();
     			
     			foreach ($membros_projetos as $membro){
     				if($membro->usuario_id == $session_dados->id){
     					$projetos_usuario_sessao[] = $membro->projeto_id;
     				}
     			}

     			$projetos = $this->getProjetoTable()->fetchAll();
     			$dados_projetos_usuario_sessao = Array();
     			foreach ($projetos as $projeto){
     				if(in_array($projeto->projeto_id, $projetos_usuario_sessao)){
     					$dados_projetos_usuario_sessao[] = $projeto;
     				}
     			}
     			
		         return new ViewModel(array(
		             'projetos' => $dados_projetos_usuario_sessao,
		         ));     			
     		}
     	}
     }
    

     public function getIndicadorProjetoTable()
     {
     	if (!$this->indicadorProjetoTable) {
     		$sm = $this->getServiceLocator();
     		$this->indicadorProjetoTable = $sm->get('Application\Model\IndicadorProjetoTable');
     	}
     	return $this->indicadorProjetoTable;
     }
     
    public function getMembroProjetoTable()
    {
    	if (!$this->membroProjetoTable) {
    		$sm = $this->getServiceLocator();
    		$this->membroProjetoTable = $sm->get('Application\Model\ProjetoMembroTable');
    	}
    	return $this->membroProjetoTable;
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
    			'justificativas' => $projetoJustificativas,
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
    			
    			// exclui projeto
    			$this->getProjetoTable()->deleteProjeto($id);
    			
    			// exclui indicadores do projeto
    			$this->getIndicadorProjetoTable()->deleteIndicadoresProjeto($id);

    			// exclui acompanhamento
    			$this->getProjetoAcompanhamentoTable()->deleteProjetoAcompanhamentos($id);
    			
    			// exclui justificativas de status do projeto
    			$this->getProjetoStatusJustificativaTable()->deleteProjetoStatusJustificativas($id);
    			
    			// exclui tarefas
    			$this->getTarefaProjetoTable()->deleteTarefasProjeto($id);
    			
    			// exclui membros
    			$this->getMembroProjetoTable()->deleteProjetoMembros($id);
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
		 $id = $this->params('id');

		 $membrosProjeto = $this->getMembroProjetoTable()->getMembrosProjeto($id);
		 
    	return new ViewModel(array(
     			'membrosProjeto' => $membrosProjeto,
    			'projeto' => $this->getProjetoTable()->getProjeto($id),
    			'usuarios' => $this->getUsuarioTable()->fetchAll(),
    	));
    }
}
