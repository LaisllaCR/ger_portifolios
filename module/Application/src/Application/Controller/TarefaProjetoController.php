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
use Zend\Session\Container;
use Application\Model\Logs;
use Application\Model\Usuario;
use Application\Model\ProjetoSemanaJustificativa;
use Application\Model\ProjetoSemana;
use Application\Model\ProjetoMembro;

class TarefaProjetoController extends AbstractActionController
{
	protected $membroProjetoTable;
	protected $logsTable;
	protected $usuarioTable;
	protected $tarefaProjetoTable;
	protected $projetoTable;
	protected $projetoSemanaTable;
	protected $projetoSemanaJustificativaTable;
	
	public function indexAction()
     {
     }


     public function getLogsTable()
     {
     	if (!$this->logsTable) {
     		$sm = $this->getServiceLocator();
     		$this->logsTable = $sm->get('Application\Model\LogsTable');
     	}
     	return $this->logsTable;
     }
     
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
             	'usuarios' => $this->getUsuarioTable()->fetchAll(),
     			'projeto' => $this->getProjetoTable()->getProjeto($id),
     			'tarefasProjeto' => $tarefasProjeto
     	));
     }

     public function getMembroProjetoTable()
     {
     	if (!$this->membroProjetoTable) {
     		$sm = $this->getServiceLocator();
     		$this->membroProjetoTable = $sm->get('Application\Model\ProjetoMembroTable');
     	}
     	return $this->membroProjetoTable;
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

    			$tarefaProjeto->tarefa_nome = utf8_encode($dados_form['tarefa_nome']);
    			$tarefaProjeto->usuario_id = $dados_form['usuario_id'];
    			$tarefaProjeto->projeto_id = $id;
    			$tarefaProjeto->tarefa_descricao = utf8_encode($dados_form['tarefa_descricao']);
    			$tarefaProjeto->tarefa_status = $dados_form['tarefa_status'];
    			$tarefaProjeto->tarefa_data_inicio = $dados_form['tarefa_data_inicio'];
    			$tarefaProjeto->tarefa_data_previsao_termino = $dados_form['tarefa_data_previsao_termino'];
    			$tarefaProjeto->tarefa_data_termino = $dados_form['tarefa_data_termino'];
    			 
    			$id_tar = $this->getTarefaProjetoTable()->saveTarefaProjeto($tarefaProjeto);
    			
    			$acao = "tarefa_projeto/add";
    			$this->salvarLog($acao, $id_tar);

    			return $this->redirect()->toRoute('tarefa_projeto/consulta', array(
    					'action' => 'consulta', 'id' => $id
    			));
    		}
    	}
    	
    	return new ViewModel(array(
    			'id' => $id,
             	'membros' => $this->getMembroProjetoTable()->getDadosMembro($id),
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
    		$tarefaProjeto->usuario_id = $dados_form['usuario_id'];
    		$tarefaProjeto->tarefa_nome = utf8_encode($dados_form['tarefa_nome']);
    		$tarefaProjeto->tarefa_descricao = utf8_encode($dados_form['tarefa_descricao']);
    		$tarefaProjeto->tarefa_status = $dados_form['tarefa_status'];
    		$tarefaProjeto->tarefa_data_inicio = $dados_form['tarefa_data_inicio'];
    		$tarefaProjeto->tarefa_data_previsao_termino = $dados_form['tarefa_data_previsao_termino'];
    		$tarefaProjeto->tarefa_data_termino = $dados_form['tarefa_data_termino'];
    		 
    		if ($dados_form) {
    			$this->getTarefaProjetoTable()->saveTarefaProjeto($tarefaProjeto);
    			
    			$acao = "tarefa_projeto/edit";
    			$this->salvarLog($acao, $id);

    			return $this->redirect()->toRoute('tarefa_projeto/consulta', array(
    					'action' => 'consulta', 'id' => $projeto_id
    			));
    		}
    	}
    	 
    	return array(
    			'id' => $id,
    			'projeto_id' => $projeto_id,
             	'membros' => $this->getMembroProjetoTable()->getDadosMembro($projeto_id),
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
    			$acao = "tarefa_projeto/delete";
    			$this->salvarLog($acao, $id);
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
    	$id = (int) $this->params()->fromRoute('id', 0);
    	$projeto_id = (int) $this->params()->fromRoute('projeto_id', 0);

    	$acao = "tarefa_projeto/detalhe";
    	$this->salvarLog($acao, $id);
		 
    	return new ViewModel(array(
             	'usuarios' => $this->getUsuarioTable()->fetchAll(),
     			'projeto' => $this->getProjetoTable()->getProjeto($projeto_id),
    			'tarefa' => $this->getTarefaProjetoTable()->getTarefaProjeto($this->params('id')),
    	));
    }
}
