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

use Application\Model\Usuario;
use Application\Model\Perfil;
use Application\Controller\Login;
use Zend\Session\Container;

class UsuarioController extends AbstractActionController
{
	protected $usuarioTable;
	protected $perfilTable;
	
	public function indexAction()
     {
         return new ViewModel(array(
             'usuarios' => $this->getUsuarioTable()->fetchAll(),         		
             'perfis' => $this->getPerfilTable()->fetchAll(),
         ));
     }
    
    public function getUsuarioTable()
    {
    	if (!$this->usuarioTable) {
    		$sm = $this->getServiceLocator();
    		$this->usuarioTable = $sm->get('Application\Model\UsuarioTable');
    	}
    	return $this->usuarioTable;
    }
    
    public function getPerfilTable()
    {
    	if (!$this->perfilTable) {
    		$sm = $this->getServiceLocator();
    		$this->perfilTable = $sm->get('Application\Model\PerfilTable');
    	}
    	return $this->perfilTable;
    }
    
    public function addAction()
    {    	
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$usuario = new Usuario();
    		$dados_form = $request->getPost();
    	
    		if ($dados_form) {

    			$usuario->usuario_nome = $dados_form['usuario_nome'];
    			$usuario->usuario_email = $dados_form['usuario_email'];
    			$usuario->usuario_senha = md5($dados_form['usuario_senha']);
    			$usuario->perfil_id = $dados_form['perfil_id'];
    			    			 
    			$this->getUsuarioTable()->saveUsuario($usuario);
    			
				$sessao = new Container('usuario_dados');
				
				if (!$sessao->id) {
					return $this->redirect()->toRoute('login');
				}else{    	
    				return $this->redirect()->toRoute('usuario');
				}
    		}
    	}
    	
    	return new ViewModel(array(
    		'usuarios' => $this->getUsuarioTable()->fetchAll(),
            'perfis' => $this->getPerfilTable()->fetchAll(),
    	));
    }
    
    public function editAction()
    {
    	$id = (int) $this->params()->fromRoute('id', 0);
    	if (!$id) {
    		return $this->redirect()->toRoute('usuario', array(
    				'action' => 'index'
    		));
    	}
    
    	try {
    		$usuario = $this->getUsuarioTable()->getUsuario($id);
    	}
    	catch (\Exception $ex) {
    		return $this->redirect()->toRoute('usuario', array(
    				'action' => 'index'
    		));
    	}

    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$dados_form = $request->getPost();    	
    		
    		$usuario->usuario_id = $id;    
    		$usuario->usuario_nome = utf8_encode($dados_form['usuario_nome']);
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
    

    public function editSenhaAction()
    {
    	$id = (int) $this->params()->fromRoute('id', 0);
    	if (!$id) {
    		return $this->redirect()->toRoute('home', array(
    				'action' => 'index'
    		));
    	}
    
    	try {
    		$usuario = $this->getUsuarioTable()->getUsuario($id);
    	}
    	catch (\Exception $ex) {
    		return $this->redirect()->toRoute('home', array(
    				'action' => 'index'
    		));
    	}
    
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$dados_form = $request->getPost();
    
    		$usuario->usuario_id = $id;
    		$usuario->usuario_senha = $dados_form['usuario_senha'];
    		 
    		if ($dados_form) {
    			$this->getUsuarioTable()->saveUsuario($usuario);
    
    			return $this->redirect()->toRoute('home');
    		}
    	}
    
    	return array(
    			'id' => $id,
    			'usuario' => $usuario,
    	);
    	 
    }
    
    public function editUserAction()
    {
    	$id = (int) $this->params()->fromRoute('id', 0);
    	if (!$id) {
    		return $this->redirect()->toRoute('home', array(
    				'action' => 'index'
    		));
    	}
    
    	try {
    		$usuario = $this->getUsuarioTable()->getUsuario($id);
    	}
    	catch (\Exception $ex) {
    		return $this->redirect()->toRoute('home', array(
    				'action' => 'index'
    		));
    	}
    
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$dados_form = $request->getPost();
    
    		$usuario->usuario_id = $id;
    		$usuario->usuario_nome = utf8_encode($dados_form['usuario_nome']);
    		$usuario->usuario_email = $dados_form['usuario_email'];
    		$usuario->usuario_senha = $dados_form['usuario_senha'];
    		$usuario->perfil_id = $dados_form['perfil_id'];
    		 
    		if ($dados_form) {
    			$this->getUsuarioTable()->saveUsuario($usuario);
    			$login = new LoginController();
    			$login->atualizarDadosSessao($usuario);
    
    			return $this->redirect()->toRoute('home');
    		}
    	}
    
    	return array(
    			'id' => $id,
    			'usuario' => $usuario,
    	);
    
    }
    
    public function deleteAction()
    {
    	$id = (int) $this->params()->fromRoute('id', 0);
    	if (!$id) {
    		return $this->redirect()->toRoute('usuario');
    	}
    	
    	$request = $this->getRequest();
    	
    	if ($request->isPost()) {
    		$dados_form = $request->getPost(); 

    		if($dados_form['submit'] == "Sim"){
    			$id = (int) $request->getPost('id');
    			$this->getUsuarioTable()->deleteUsuario($id);
    		}
    	
    		return $this->redirect()->toRoute('usuario');
    	}
    	
    	return array(
    			'id'    => $id,
    			'usuario' => $this->getUsuarioTable()->getUsuario($id)
    	);    	
    }
    
	public function detalheAction()
    {
		 $request = $this->getRequest();
		 
		 
    	return new ViewModel(array(
    			'usuario' => $this->getUsuarioTable()->getUsuario($this->params('id')),
            'perfis' => $this->getPerfilTable()->fetchAll(),
    	));
    }
}
