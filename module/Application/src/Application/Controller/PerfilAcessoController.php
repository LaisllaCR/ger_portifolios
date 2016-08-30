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

use Application\Model\PerfilAcesso;
use Application\Model\Perfil;
use Application\Model\Funcionalidade;
use Zend\Session\Container;
use Application\Model\Logs;
use Application\Model\Usuario;

class PerfilAcessoController extends AbstractActionController
{
	protected $perfilAcessoTable;
	protected $perfilTable;
	protected $funcionalidadeTable;
	protected $usuarioTable;
	protected $logsTable;
	

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

	public function getUsuarioTable()
	{
		if (!$this->usuarioTable) {
			$sm = $this->getServiceLocator();
			$this->usuarioTable = $sm->get('Application\Model\UsuarioTable');
		}
		return $this->usuarioTable;
	}
	
	public function indexAction()
     {
		$array_perfis = Array();
		$array_perfis_acessos = Array();
		
		$perfis = $this->getPerfilTable()->fetchAll();
		
		foreach ($perfis as $perfil){
		
			$perfis_acessos = $this->getPerfilAcessoTable()->getPerfilAcessos($perfil->perfil_id);
			
			foreach ($perfis_acessos as $perfil_acesso){
				$array_perfis[$perfil->perfil_id][] = $perfil_acesso->funcionalidade_id;
			}
		}
		
         return new ViewModel(array(
             'perfilAcessos' => $this->getPerfilAcessoTable()->fetchAll(),
             'perfis' => $this->getPerfilTable()->fetchAll(),
             'funcionalidades' => $this->getFuncionalidadeTable()->fetchAll(),
             'array_perfis' => $array_perfis
         ));
     }
    
    public function getPerfilAcessoTable()
    {
    	if (!$this->perfilAcessoTable) {
    		$sm = $this->getServiceLocator();
    		$this->perfilAcessoTable = $sm->get('Application\Model\PerfilAcessoTable');
    	}
    	return $this->perfilAcessoTable;
    }
    
    public function getPerfilTable()
    {
    	if (!$this->perfilTable) {
    		$sm = $this->getServiceLocator();
    		$this->perfilTable = $sm->get('Application\Model\PerfilTable');
    	}
    	return $this->perfilTable;
    }
    
    public function getFuncionalidadeTable()
    {
    	if (!$this->funcionalidadeTable) {
    		$sm = $this->getServiceLocator();
    		$this->funcionalidadeTable = $sm->get('Application\Model\FuncionalidadeTable');
    	}
    	return $this->funcionalidadeTable;
    }
    
    public function addAction()
    {    	
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$perfilAcesso = new PerfilAcesso();
    		$dados_form = $request->getPost();
    	
    		if ($dados_form) {
    			
    			$this->getPerfilAcessoTable()->deletePerfilAcesso($dados_form['perfil_id']);
    			    			
    			foreach ($dados_form['funcionalidades'] as $funcionalidade_id){
    				
    				$perfilAcesso->perfil_id = $dados_form['perfil_id'];
    				$perfilAcesso->funcionalidade_id = $funcionalidade_id;    				    				
    				
    				$this->getPerfilAcessoTable()->savePerfilAcesso($perfilAcesso);
    			}    			 

    			$acao = "perfil-acesso/edit";
    			$this->salvarLog($acao, $dados_form['perfil_id']);
    			
    			return $this->redirect()->toRoute('perfil-acesso');
    		}
    	}
    	
    	return new ViewModel(array(
    			'perfilAcessos' => $this->getPerfilAcessoTable()->fetchAll(),
    	));
    }
    
    public function editAction()
    {
    	$id = (int) $this->params()->fromRoute('id', 0);
    	
    	if (!$id) {
    		return $this->redirect()->toRoute('perfil-acesso', array(
    				'action' => 'index'
    		));
    	}
    
    	try {
    		$perfilAcesso = $this->getPerfilAcessoTable()->getPerfilAcessos($id);
    		$array_perfis = Array();
    		$array_perfis_acessos = Array();
    		
    		$perfis = $this->getPerfilTable()->fetchAll();
    		
    		foreach ($perfis as $perfil){
    		
    			$perfis_acessos = $this->getPerfilAcessoTable()->getPerfilAcessos($perfil->perfil_id);
    			    			
    			if(count($perfis_acessos) == 0){
    				$array_perfis[$perfil->perfil_id] = Array();
    			}else{    				
	    			foreach ($perfis_acessos as $perfil_acesso){
	    				$array_perfis[$perfil->perfil_id][] = $perfil_acesso->funcionalidade_id;
	    			}
    			}
    		}
    		
    		$perfil_dados = $this->getPerfilTable()->getPerfil($id);
    	}
    	catch (\Exception $ex) {
    		return $this->redirect()->toRoute('perfil-acesso', array(
    				'action' => 'index'
    		));
    	}
    
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$perfilAcesso = new PerfilAcesso();
    		$dados_form = $request->getPost();
    		 
    		if ($dados_form) {
    			 
    			$this->getPerfilAcessoTable()->deletePerfilAcesso($dados_form['perfil_id']);
    	
    			foreach ($dados_form['funcionalidades'] as $funcionalidade_id){
    	
    				$perfilAcesso->perfil_id = $dados_form['perfil_id'];
    				$perfilAcesso->funcionalidade_id = $funcionalidade_id;
    	
    				$this->getPerfilAcessoTable()->savePerfilAcesso($perfilAcesso);

    			}
    			 
    			return $this->redirect()->toRoute('perfil-acesso/edit');
    		}
    	}
    	
       	return array(
    			'perfil_dados' => $perfil_dados,
    			'id' => $id,
    			'perfilAcessos' => $this->getPerfilAcessoTable()->fetchAll(),
    			'perfis' => $this->getPerfilTable()->fetchAll(),
    			'funcionalidades' => $this->getFuncionalidadeTable()->fetchAll(),
    			'array_perfis' => $array_perfis
    	);
    }
       
    public function deleteAction()
    {
    	$id = (int) $this->params()->fromRoute('id', 0);
    	if (!$id) {
    		return $this->redirect()->toRoute('perfil-acesso');
    	}
    	
    	$request = $this->getRequest();
    	
    	if ($request->isPost()) {
    		$dados_form = $request->getPost(); 

    		if($dados_form['submit'] == "Sim"){
    			$id = (int) $request->getPost('id');
    			$this->getPerfilAcessoTable()->deletePerfilAcesso($id);
    		}
    	
    		return $this->redirect()->toRoute('perfil-acesso');
    	}
    	
    	return array(
    			'id'    => $id,
    			'perfilAcesso' => $this->getPerfilAcessoTable()->getPerfilAcesso($id)
    	);    	
    }
    
}
