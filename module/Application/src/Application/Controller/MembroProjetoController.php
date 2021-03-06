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

use Application\Model\ProjetoMembro;
use Application\Model\Projeto;
use Application\Model\Usuario;
use Application\Model\ProjetoSemanaJustificativa;
use Application\Model\ProjetoSemana;
use Application\Model\Logs;
use Zend\Session\Container;

class MembroProjetoController extends AbstractActionController
{
	protected $membroProjetoTable;
	protected $logsTable;
	protected $projetoTable;
	protected $usuarioTable;
	protected $projetoSemanaTable;
	protected $projetoSemanaJustificativaTable;

	public function salvarLog($acao, $id)
	{
		$session_dados = new Container('usuario_dados');
		$log = new Logs();
		 
		$log->acao = $acao;
		$log->data = date('Y-m-d');
		$log->usuario_id = $session_dados->id;
		$log->id = $id;
		 
		$this->getLogsTable()->saveLogs($log);
	}

     public function getLogsTable()
     {
     	if (!$this->logsTable) {
     		$sm = $this->getServiceLocator();
     		$this->logsTable = $sm->get('Application\Model\LogsTable');
     	}
     	return $this->logsTable;
     }
	
	public function indexAction()
     {
         return new ViewModel(array(
             'membros' => $this->getMembroProjetoTable()->fetchAll(),
         ));
     }
     
     public function consultaAction()
     {
     	$id = (int) $this->params()->fromRoute('id', 0);
     
     	if (!$id) {
     		return $this->redirect()->toRoute('membro_projeto', array(
     				'action' => 'index'
     		));
     	}
     	
     	try {
     		$membrosProjeto = $this->getMembroProjetoTable()->getMembrosProjeto($id);
     	}
     	catch (\Exception $ex) {
     		return $this->redirect()->toRoute('membro_projeto', array(
     				'action' => 'index'
     		));
     	}
     	
     	$projeto = $this->getProjetoTable()->getProjeto($id);

     	if($projeto->projeto_risco == "Alto risco"){
     		$valida = $this->verificarAcompanhamento($projeto);
     		if($valida == true){
     			return $this->redirect()->toRoute('acompanhamento_projeto/consulta', array(
     					'action' => 'consulta', 'id' => $projeto->projeto_id
     			));
     		}
     	}
     	 
     	return new ViewModel(array(
     			'id' => $id,
     			'projeto' => $this->getProjetoTable()->getProjeto($id),
     			'usuarios' => $this->getUsuarioTable()->fetchAll(),
     			'membrosProjeto' => $membrosProjeto
     	));
     }
     

     public function getProjetoSemanaTable()
     {
     	if (!$this->projetoSemanaTable) {
     		$sm = $this->getServiceLocator();
     		$this->projetoSemanaTable = $sm->get('Application\Model\ProjetoSemanaTable');
     	}
     	return $this->projetoSemanaTable;
     }
     
     public function getProjetoSemanaJustificativaTable()
     {
     	if (!$this->projetoSemanaJustificativaTable) {
     		$sm = $this->getServiceLocator();
     		$this->projetoSemanaJustificativaTable = $sm->get('Application\Model\ProjetoSemanaJustificativaTable');
     	}
     	return $this->projetoSemanaJustificativaTable;
     }
     
     public function verificarAcompanhamento($projeto)
     {
     	$semanas = $this->getProjetoSemanaTable()->getProjetoSemanas($projeto->projeto_id);
     	$hoje = date('Y-m-d');
     
     	foreach ($semanas as $semana)
     	{
     		$justificativa_semana = $this->getProjetoSemanaJustificativaTable()->getProjetoSemanaJustificativa($semana->projeto_semana_id);
     
     		if($justificativa_semana->projeto_semana_justificativa == NULL){
     
     			if($hoje > $semana->projeto_semana_data_fim){
     				return true;
     			}
     		}
     	}
     
     	return false;
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
    
    public function getMembroProjetoTable()
    {
    	if (!$this->membroProjetoTable) {
    		$sm = $this->getServiceLocator();
    		$this->membroProjetoTable = $sm->get('Application\Model\ProjetoMembroTable');
    	}
    	return $this->membroProjetoTable;
    }
    
    public function addAction()
    {    	
    	$id = (int) $this->params()->fromRoute('id', 0);
    	$request = $this->getRequest();
    	
    	if ($request->isPost()) {
    		$membroProjeto = new ProjetoMembro();
    		$dados_form = $request->getPost();
    	
    		if ($dados_form) {

    			$membroProjeto->usuario_id = $dados_form['usuario_id'];
    			$membroProjeto->projeto_id = $id;
    			$membroProjeto->projeto_membro_papel = $dados_form['projeto_membro_papel'];
    			 
    			$id_mem = $this->getMembroProjetoTable()->saveMembroProjeto($membroProjeto);
    			
    			$acao = "membro_projeto/add";
    			$this->salvarLog($acao, $id_mem);

    			return $this->redirect()->toRoute('membro_projeto/consulta', array(
    					'action' => 'consulta', 'id' => $id
    			));
    		}
    	}
    	
    	return new ViewModel(array(
    			'id' => $id,
     			'usuarios' => $this->getUsuarioTable()->fetchAll(),
     			'projeto' => $this->getProjetoTable()->getProjeto($id),
    			'membros_cadastrados' => $this->getMembroProjetoTable()->getMembrosProjeto($id),
    			'membros' => $this->getMembroProjetoTable()->fetchAll(),
    	));
    }
    
    public function editAction()
    {
    	$id = (int) $this->params()->fromRoute('id', 0);
    	$projeto_id = (int) $this->params()->fromRoute('projeto_id', 0);
    	    	
    	if (!$id) {
    		return $this->redirect()->toRoute('membro_projeto', array(
    				'action' => 'index'
    		));
    	}
    
    	try {
    		$membroProjeto = $this->getMembroProjetoTable()->getProjetoMembro($id);
    	}
    	catch (\Exception $ex) {
    		return $this->redirect()->toRoute('membro_projeto', array(
    				'action' => 'index'
    		));
    	}

    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$dados_form = $request->getPost();    	
    		
    		$membroProjeto->projeto_membro_id = $id; 
    		$membroProjeto->projeto_id = $projeto_id;    
    		$membroProjeto->usuario_id = $dados_form['usuario_id'];
    		$membroProjeto->projeto_membro_papel = $dados_form['projeto_membro_papel'];
    		 
    		if ($dados_form) {
    			$this->getMembroProjetoTable()->saveMembroProjeto($membroProjeto);
    			
    			$acao = "membro_projeto/edit";
    			$this->salvarLog($acao, $id);

    			return $this->redirect()->toRoute('membro_projeto/consulta', array(
    					'action' => 'consulta', 'id' => $projeto_id
    			));
    		}
    	}
    	 
    	return array(
    			'id' => $id,
    			'projeto_id' => $projeto_id,
     			'usuarios' => $this->getUsuarioTable()->fetchAll(),
     			'projeto' => $this->getProjetoTable()->getProjeto($projeto_id),
    			'membros' => $this->getMembroProjetoTable()->fetchAll(),
    			'membro' => $membroProjeto,
     	);
    	
    }
    
    public function deleteAction()
    {
    	$id = (int) $this->params()->fromRoute('id', 0);
    	$projeto_id = (int) $this->params()->fromRoute('projeto_id', 0);
    	
    	if (!$id) {
    		return $this->redirect()->toRoute('membro_projeto');
    	}
    	
    	$request = $this->getRequest();
    	
    	if ($request->isPost()) {
    		$dados_form = $request->getPost(); 

    		if($dados_form['submit'] == "Sim"){
    			$id = (int) $request->getPost('id');
    			$this->getMembroProjetoTable()->deleteProjetoMembro($id);
    			
    			$acao = "membro_projeto/delete";
    			$this->salvarLog($acao, $id);
    		}

    		return $this->redirect()->toRoute('membro_projeto/consulta', array(
    				'action' => 'consulta', 'id' => $projeto_id
    		));
    	}
    	
    	return array(
    			'id'    => $id,
     			'usuarios' => $this->getUsuarioTable()->fetchAll(),
    			'projeto_id'    => $projeto_id,
     			'projeto' => $this->getProjetoTable()->getProjeto($projeto_id),
    			'membro' => $this->getMembroProjetoTable()->getProjetoMembro($id)
    	);    	
    }
    
	public function detalheAction()
    {
		 $request = $this->getRequest();
    	$id = (int) $this->params()->fromRoute('id', 0);
    	$projeto_id = (int) $this->params()->fromRoute('projeto_id', 0);

    	$acao = "membro_projeto/detalhe";
    	$this->salvarLog($acao, $id);
		 
    	return new ViewModel(array(
     			'usuarios' => $this->getUsuarioTable()->fetchAll(),
     			'projeto' => $this->getProjetoTable()->getProjeto($projeto_id),
    			'membro' => $this->getMembroProjetoTable()->getProjetoMembro($this->params('id')),
    	));
    }
}
