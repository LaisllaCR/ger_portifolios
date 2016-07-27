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

class PerfilAcessoController extends AbstractActionController
{
	protected $perfilAcessoTable;
	protected $perfilTable;
	protected $funcionalidadeTable;
	
	public function indexAction()
     {
         return new ViewModel(array(
             'perfilAcessos' => $this->getPerfilAcessoTable()->fetchAll(),
             'perfis' => $this->getPerfilTable()->fetchAll(),
             'funcionalidades' => $this->getFuncionalidadeTable()->fetchAll(),
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

    			$perfilAcesso->perfil_id = $dados_form['perfil_id'];
    			$perfilAcesso->funcionalidade_id = $dados_form['funcionalidade_id'];
    			 
    			$this->getPerfilAcessoTable()->savePerfilAcesso($perfilAcesso);
    	
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
    	}
    	catch (\Exception $ex) {
    		return $this->redirect()->toRoute('perfil-acesso', array(
    				'action' => 'index'
    		));
    	}
    
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$dados_form = $request->getPost();
    
    		$usuario->usuario_id = $id;
    		$usuario->usuario_nome = $dados_form['usuario_nome'];
    		$usuario->usuario_email = $dados_form['usuario_email'];
    		$usuario->usuario_senha = $dados_form['usuario_senha'];
    		$usuario->perfil_id = $dados_form['perfil_id'];
    		 
    		if ($dados_form) {
    			$this->getUsuarioTable()->saveUsuario($usuario);
    
    			return $this->redirect()->toRoute('usuario');
    		}
    	}
    
    	return array(
    			'id' => $id,
    			'usuario' => $usuario,
    			'perfis' => $this->getPerfilTable()->fetchAll(),
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
