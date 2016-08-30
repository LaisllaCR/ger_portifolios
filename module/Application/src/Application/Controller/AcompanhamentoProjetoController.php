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
use Application\Model\ProjetoSemana;
use Application\Model\ProjetoSemanaTable;
use Application\Model\ProjetoSemanaJustificativa;
use Application\Model\ProjetoSemanaJustificativaTable;
use Zend\Session\Container;
use Application\Model\Usuario;
use Application\Model\Logs;

class AcompanhamentoProjetoController extends AbstractActionController
{
	protected $acompanhamentoProjetoTable;
	protected $projetoTable;
	protected $projetoSemanaTable;
	protected $projetoSemanaJustificativaTable;
	protected $usuarioTable;
	protected $logsTable;
	
	public function indexAction()
     {
     	$id = (int) $this->params()->fromRoute('id', 0);
         return new ViewModel(array(
     			'id' => $id,
             'acompanhamentos' => $this->getAcompanhamentoProjetoTable()->fetchAll(),
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
     
    public function getUsuarioTable()
    {
    	if (!$this->usuarioTable) {
    		$sm = $this->getServiceLocator();
    		$this->usuarioTable = $sm->get('Application\Model\UsuarioTable');
    	}
    	return $this->usuarioTable;
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
     		$acompanhamentosProjeto = $this->getProjetoSemanaTable()->getProjetoSemanas($id);
     	}
     	catch (\Exception $ex) {
     		return $this->redirect()->toRoute('acompanhamento_projeto', array(
     				'action' => 'index'
     		));
     	}
     	 
     	$semanas = $this->getProjetoSemanaTable()->getProjetoSemanas($id);
     	$hoje = date('Y-m-d');
     	 
     	$cont = 0;
     	foreach ($semanas as $semana)
     	{
     		$justificativa_semana = $this->getProjetoSemanaJustificativaTable()->getProjetoSemanaJustificativa($semana->projeto_semana_id);
     	
     		if(!isset($justificativa_semana->projeto_semana_justificativa)){			 
     			if($hoje > $semana->projeto_semana_data_fim){
     				$cont++;
     			}
     		}
     	}
     	
     	return new ViewModel(array(
     			'validaAcompanhamento' => ( $cont > 0 ? 'sim' : 'nao' ),
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

    	$session_dados = new Container('usuario_dados');
    	
    	if ($request->isPost()) {
    		$acompanhamentoProjeto = new ProjetoAcompanhamento();
    		$dados_form = $request->getPost();
    	
    		if ($dados_form) {

    			$acompanhamentoProjeto->projeto_acompanhamento_descricao = $dados_form['projeto_acompanhamento_descricao'];
    			$acompanhamentoProjeto->projeto_acompanhamento_data = $dados_form['projeto_acompanhamento_data'];
    			$acompanhamentoProjeto->projeto_id = $id;
    			$acompanhamentoProjeto->usuario_id = $session_dados->id;
    			 
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
    	$session_dados = new Container('usuario_dados');
    	
    	$projeto_semana_id = (int) $this->params()->fromRoute('id', 0);
    	$projeto_id = (int) $this->params()->fromRoute('projeto_id', 0);
    	$projetoSemana = $this->getProjetoSemanaTable()->getProjetoSemana($projeto_semana_id);
    	    	    	
    	if (!$projeto_semana_id) {
    		return $this->redirect()->toRoute('acompanhamento_projeto', array(
    				'action' => 'index'
    		));
    	}
    
    	try {
    		
    		if($this->getProjetoSemanaJustificativaTable()->getProjetoSemanaJustificativa($projeto_semana_id)){
     			$acompanhamentoProjeto = $this->getProjetoSemanaJustificativaTable()->getProjetoSemanaJustificativa($projeto_semana_id);
    		}else{ 
    			$acompanhamentoProjeto = new ProjetoSemanaJustificativa();
    			$acompanhamentoProjeto->projeto_semana_id = $projeto_semana_id;
    			$acompanhamentoProjeto->projeto_semana_justificativa = NULL;
    			$acompanhamentoProjeto->usuario_id = $session_dados->id;
    			
    			$id = $this->getProjetoSemanaJustificativaTable()->saveProjetoSemanaJustificativa($acompanhamentoProjeto);
    			
    			$acompanhamentoProjeto = $this->getProjetoSemanaJustificativaTable()->getProjetoSemanaJustificativa($projeto_semana_id);
    			
    		}
    	} catch (\Exception $ex) {
    		return $this->redirect()->toRoute('acompanhamento_projeto', array(
    				'action' => 'index'
    		));
    	}

    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$dados_form = $request->getPost(); 
    		
    		/*$acompanhamentoProjeto->projeto_acompanhamento_id = $id; 
    		$acompanhamentoProjeto->projeto_id = $projeto_id;    
    		$acompanhamentoProjeto->projeto_acompanhamento_descricao = $dados_form['projeto_acompanhamento_descricao'];
    		$acompanhamentoProjeto->projeto_acompanhamento_data_inicio = $dados_form['projeto_acompanhamento_data_inicio'];
    		$acompanhamentoProjeto->projeto_acompanhamento_data_termino = $dados_form['projeto_acompanhamento_data_termino'];
    		$acompanhamentoProjeto->projeto_acompanhamento_semana = $dados_form['projeto_acompanhamento_semana'];*/
    		
    		$acompanhamentoProjeto->projeto_semana_id = $projeto_semana_id;
    		$acompanhamentoProjeto->projeto_semana_justificativa = utf8_encode($dados_form['projeto_semana_justificativa']);
    			$acompanhamentoProjeto->usuario_id = $session_dados->id;
    		    		 
    		if ($dados_form) {
    			$this->getProjetoSemanaJustificativaTable()->saveProjetoSemanaJustificativa($acompanhamentoProjeto);
    			$acao = "acompanhamento_projeto/edit";
    			$this->salvarLog($acao, $projeto_id);
    			//$this->getAcompanhamentoProjetoTable()->saveAcompanhamentoProjeto($acompanhamentoProjeto);

    			return $this->redirect()->toRoute('acompanhamento_projeto/consulta', array(
    					'action' => 'consulta', 'id' => $projeto_id
    			));
    		}
    	}
    	 
    	return array(
    			'projeto_semana_id' => $projeto_semana_id,
    			'projeto_semana' => $projetoSemana,
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
    
	public function detalheAction()
    {
    	$projeto_semana_id = (int) $this->params()->fromRoute('id', 0);
    	$projeto_id = (int) $this->params()->fromRoute('projeto_id', 0);
    	
		$request = $this->getRequest();

		$acompanhamentoProjeto = $this->getProjetoSemanaJustificativaTable()->getProjetoSemanaJustificativa($projeto_semana_id);
    	$projetoSemana = $this->getProjetoSemanaTable()->getProjetoSemana($projeto_semana_id);

    	$acao = "acompanhamento_projeto/detalhe";
    	$this->salvarLog($acao, $projeto_id);
    	
    	return new ViewModel(array(
    			'projetoSemana' => $projetoSemana,
    			'acompanhamento' => $acompanhamentoProjeto,
     			'projeto' => $this->getProjetoTable()->getProjeto($projeto_id),
    			//'acompanhamento' => $this->getAcompanhamentoProjetoTable()->getProjetoAcompanhamento($this->params('id')),
    	));
    }   
 	
}
