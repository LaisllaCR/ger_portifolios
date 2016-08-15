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

use Application\Model\ProjetoSemanaJustificativa;
use Application\Model\ProjetoSemana;

use Zend\Db\Sql\Ddl\Column\Date;
use Zend\Session\Container;
use Zend\Db\Sql\Predicate\Between;

class ProjetoController extends AbstractActionController
{
	protected $projetoTable;
	protected $usuarioTable;
	
	protected $projetoStatusJustificativaTable;
	protected $indicadorProjetoTable;
	protected $projetoAcompanhamentoTable;
	protected $membroProjetoTable;
	protected $tarefaProjetoTable;
	
	protected $projetoSemanaTable;
	protected $projetoSemanaJustificativaTable;
	
	public function indexAction()
    {
     	$session_dados = new Container('usuario_dados');
     	//if(isset($session_dados->id)){
     	//	if($session_dados->perfil == 1 || $session_dados->perfil == 2){
		         return new ViewModel(array(
		             'projetos' => $this->getProjetoTable()->fetchAll(),
		         ));     			
     	/*	}else{
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
     	}*/
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
     	$session_dados = new Container('usuario_dados');
     	
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

    			/*** Acompanhamento dos projetos de alto risco*/
    			    			    			
    			$this->salvarDatasAcompanhamento($projeto);    			
				
				/*** Acompanhamento dos projetos de alto risco*/
				
    			$projetoStatusJustificativa->projeto_id = $id;
    			$projetoStatusJustificativa->projeto_status = 'Em analise';
    			$projetoStatusJustificativa->usuario_id = $session_dados->id;
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
    			
    			$projeto->projeto_data_inicio_anterior = $dados_form['projeto_data_inicio_anterior'];
    			$projeto->projeto_data_previsao_termino_anterior = $dados_form['projeto_data_previsao_termino_anterior'];
    			$projeto->projeto_data_real_termino_anterior = $dados_form['projeto_data_real_termino_anterior'];
    			
    			$projeto->projeto_gerente_id = $dados_form['projeto_gerente_id'];
    			$projeto->projeto_orcamento_total = $dados_form['projeto_orcamento_total'];
    			$projeto->projeto_descricao = $dados_form['projeto_descricao'];
    			$projeto->projeto_risco = $dados_form['riscoRadios'];
    			 
    			$this->getProjetoTable()->saveProjeto($projeto);
    			
    			
    			/*** Acompanhamento dos projetos de alto risco ****/
    			    			    			
    			$semanas = $this->getProjetoSemanaTable()->getProjetoSemanas($projeto->projeto_id);
    			$array_semanas = Array();
    			
    			foreach ($semanas as $semana){
    				$array_semanas[$semana->projeto_semana] = array(
    						"projeto_semana_id" => $semana->projeto_semana_id, 
    						"projeto_semana_data_inicio" => $semana->projeto_semana_data_inicio, 
    						"projeto_semana_data_fim" => $semana->projeto_semana_data_fim);
    			}
    			
    			$this->atualizarDatasAcompanhamento($projeto, $array_semanas);    	
    			
				
				/*** Acompanhamento dos projetos de alto risco*/
    			 
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

    	if($projeto->projeto_risco == "Alto risco"){
    		$valida = $this->verificarAcompanhamento($projeto);
    		if($valida == true){
    			return $this->redirect()->toRoute('acompanhamento_projeto/consulta', array(
    					'action' => 'consulta', 'id' => $projeto->projeto_id
    			));
    		}
    	}
    
    	$request = $this->getRequest();
    	$session_dados = new Container('usuario_dados');
    	
    	if ($request->isPost() && isset($session_dados->id)) {
    		$dados_form = $request->getPost();
        
    		$projeto->projeto_id = $id;
    		$projeto->projeto_status = $dados_form['statusRadios'];
    		 
    		if ($dados_form) {
    			$this->getProjetoTable()->saveProjeto($projeto);
    			
    
    				$projetoStatusJustificativa->projeto_id = $projeto->projeto_id;
    				$projetoStatusJustificativa->projeto_status = $projeto->projeto_status;
    				$projetoStatusJustificativa->projeto_status_data = date('Y-m-d');
    				$projetoStatusJustificativa->projeto_status_justificativa = $dados_form['projeto_status_justificativa'];
					$projetoStatusJustificativa->usuario_id = $session_dados->id;
    				    				
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
    
    public function salvarDatasAcompanhamento(Projeto $projeto)
    {    	
    	if (is_object($projeto)) {
    			
    			
    		$dataInicio = $projeto->projeto_data_inicio;
    
    		if(empty($projeto->projeto_data_real_termino) || $projeto->projeto_data_real_termino == NULL){
    			$dataFinal =$projeto->projeto_data_previsao_termino;
    		}else{
    			$dataFinal =$projeto->projeto_data_real_termino;
    		}
    
    		$array_datas = Array();
    		$array_datas[] = $dataInicio;
    			
    		while (strtotime($dataInicio) < strtotime($dataFinal)){
    			$dataInicio = date('Y-m-d', strtotime("+7 days",strtotime($dataInicio)));
    			$array_datas[] = $dataInicio;
    		}
    
    		$ultimo = end($array_datas);
    
    		if(strtotime($ultimo) > strtotime($dataFinal)){
    			$pos = count($array_datas) - 1;
    			$array_datas[$pos] = $dataFinal;
    		}    			
    
    		$count = 0;
    		$array_datas_bd = Array();
    		foreach ($array_datas as $data){
    			if(!empty($array_datas[$count +1])){

    				$projetoSemana = new ProjetoSemana();    				
    				
    				$projetoSemana->projeto_id = $projeto->projeto_id;
    				$projetoSemana->projeto_semana = $count +1;
    				$projetoSemana->projeto_semana_data_inicio = $data;
    				$projetoSemana->projeto_semana_data_fim = $array_datas[$count +1];    
    
    				$this->getProjetoSemanaTable()->saveProjetoSemana($projetoSemana);
    			}
    
    			$count++;
    		}
    		
    	}
    }
    
    public function atualizarDatasAcompanhamento(Projeto $projeto, $array_semanas)
    {    	
    	if (is_object($projeto)) {
    		 
    		 
    		$dataInicio = $projeto->projeto_data_inicio;
    
    		if(empty($projeto->projeto_data_real_termino) || $projeto->projeto_data_real_termino == NULL){
    			$dataFinal =$projeto->projeto_data_previsao_termino;
    		}else{
    			$dataFinal =$projeto->projeto_data_real_termino;
    		}
    
    		$array_datas = Array();
    		$array_datas[] = $dataInicio;

    		while (strtotime($dataInicio) < strtotime($dataFinal)){
    			$dataInicio = date('Y-m-d', strtotime("+7 days",strtotime($dataInicio)));
    			$array_datas[] = $dataInicio;
    		}
    
    		$ultimo = end($array_datas);
    
    		if(strtotime($ultimo) > strtotime($dataFinal)){
    			$pos = count($array_datas) - 1;
    			$array_datas[$pos] = $dataFinal;
    		}    


    		$dif = array_diff_key($array_semanas,$array_datas);
    		foreach ($dif as $semana){
    			$this->getProjetoSemanaTable()->deleteProjetoSemana($semana['projeto_semana_id']);
    		}
    		
    		if(count($array_semanas) == count($array_datas)){
    			
    			$count = 0;
    			$array_datas_bd = Array();
    			foreach ($array_datas as $data){
    				 
    				if(!empty($array_datas[$count +1])){
    			
    					$projetoSemana = new ProjetoSemana();
    			
    					$projetoSemana->projeto_id = $projeto->projeto_id;
    					$projetoSemana->projeto_semana = $count +1;
    					$projetoSemana->projeto_semana_data_inicio = $data;
    					$projetoSemana->projeto_semana_data_fim = $array_datas[$count +1];
		    			$projetoSemana->projeto_semana_id = $array_semanas[$projetoSemana->projeto_semana]['projeto_semana_id'];
		    			
    					$this->getProjetoSemanaTable()->atualizaProjetoSemana($projetoSemana);
    				}
    			
    				$count++;
    			}
    			
    		}
    		
    		if(count($array_semanas) > count($array_datas)){
    			
    			$count = 0;
    			$array_datas_bd = Array();
    			foreach ($array_datas as $data){
    				 
    				if(!empty($array_datas[$count +1])){
    			
    					$projetoSemana = new ProjetoSemana();
    			
    					$projetoSemana->projeto_id = $projeto->projeto_id;
    					$projetoSemana->projeto_semana = $count +1;
    					$projetoSemana->projeto_semana_data_inicio = $data;
    					$projetoSemana->projeto_semana_data_fim = $array_datas[$count +1];
		    			$projetoSemana->projeto_semana_id = $array_semanas[$projetoSemana->projeto_semana]['projeto_semana_id'];
		    			
    					$this->getProjetoSemanaTable()->atualizaProjetoSemana($projetoSemana);
    				}
    			
    				$count++;
    			}
    			
    			$dif = array_diff_key($array_semanas,$array_datas);
    			foreach ($dif as $semana){
    				$this->getProjetoSemanaTable()->deleteProjetoSemana($semana->projeto_Semana_id);
    			}
    			
    		}
    		

    		if(count($array_semanas) < count($array_datas)){
    			$count = 0;
    			$array_datas_bd = Array();
    			
    			foreach ($array_datas as $data){
    				 
    				if(!empty($array_datas[$count +1])){
    			
    					$projetoSemana = new ProjetoSemana();
    			
    					$projetoSemana->projeto_id = $projeto->projeto_id;
    					$projetoSemana->projeto_semana = $count +1;
    					$projetoSemana->projeto_semana_data_inicio = $data;
    					$projetoSemana->projeto_semana_data_fim = $array_datas[$count +1];
    			
    					if(key_exists($projetoSemana->projeto_semana, $array_semanas)){
    							
    						$projetoSemana->projeto_semana_id = $array_semanas[$projetoSemana->projeto_semana]['projeto_semana_id'];
    						$this->getProjetoSemanaTable()->atualizaProjetoSemana($projetoSemana);
    					}else{
    						$this->getProjetoSemanaTable()->saveProjetoSemana($projetoSemana);
    					}
    				}
    			
    				$count++;
    			}
    		}
    		
    		
    			

    		
    		

    
    	}
    }
}
