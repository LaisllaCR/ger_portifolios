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
use Application\Model\UsuarioTable;
use Application\Model\Usuario;
use Zend\Session\Config\StandardConfig;
use Zend\Session\SessionManager;
use Zend\Session\Config\SessionConfig;
use Zend\Session\Container;

class LoginController extends AbstractActionController
{		
    public function indexAction()
    {    	
		return new ViewModel(array(
		));	
    }

    protected $usuarioTable;
    
	public function getUsuarioTable()
	{
		if (!$this->usuarioTable) {
			$sm = $this->getServiceLocator();
			$this->usuarioTable = $sm->get('Application\Model\UsuarioTable');
		}
		return $this->usuarioTable;
	}
    
    public function logarAction()
    {

    	$request = $this->getRequest();
    	 
    	if ($request->isPost()) {
    	
    		$form_dados = $request->getPost();
    		 
    		if ($form_dados) {
					
    			$usuarioLogado = $this->getUsuarioTable()->getUsuarioLogin($form_dados['login'], $form_dados['senha']);
    			$dadosUsuarioLogado = $usuarioLogado->current();
    			
    			if(count($usuarioLogado) > 0){
    				$this->criarSessao($dadosUsuarioLogado, $form_dados['lembrar']);
    				return $this->redirect()->toRoute('orcamento');
    			}else{
    				return $this->redirect()->toRoute('login', array('erro'=>'1'));
    			}
    		
    		}
    	} 	
    }
    
    public function initSession($config)
    {
    	$sessionConfig = new SessionConfig();
    	$sessionConfig->setOptions($config);
    	$sessionManager = new SessionManager($sessionConfig);
    	$sessionManager->start();
    	Container::setDefaultManager($sessionManager);
    }
    
    public function criarSessao($usuarioLogadoDados , $lembrar)
    {	
    	$this->initSession(array(
    			'cookie_lifetime' => 1209600, 
    			'remember_me_seconds' => 1209600,
    			'use_cookies' => true,
    			'cookie_httponly' => true,
    	));
    	
    	$sessionTimer = new Container('usuario_dados');
    	$sessionTimer->id = $usuarioLogadoDados->usuario_id;
    	$sessionTimer->email = $usuarioLogadoDados->usuario_email;
    	$sessionTimer->senha = $usuarioLogadoDados->usuario_senha;
    	$sessionTimer->nome = $usuarioLogadoDados->usuario_nome;	    	
    }

	public function atualizarDadosSessao($usuario_dados)
	{
		$dados_sessao_atual = new Container('usuario_dados');

		$dados_sessao_atual->id = $usuario_dados->usuario_id;
		$dados_sessao_atual->email = $usuario_dados->usuario_email;
		$dados_sessao_atual->senha = $usuario_dados->usuario_senha;
		$dados_sessao_atual->nome = $usuario_dados->usuario_nome;
	}
	

	public function setRememberMe($rememberMe, $time = 1209600)
	{
    	$usuario_dados = new Container('usuario_dados');
    	
		if ($rememberMe == 1) {
			$cliente_dados->getManager()->rememberMe($time);
		}
	}
	 
	public function forgetMe()
	{
		$this->session->getManager()->forgetMe();
	}
	
	
	public function sairAction()
	{	
		$this->destruirSessao();

		return $this->redirect()->toRoute('home');
	}
    
    public function destruirSessao()
    {
    	$sessionTimer = new Container('usuario_dados');
    	$sessionTimer->getManager()->getStorage()->clear('usuario_dados');
    	$sessionTimer->getManager()->destroy();   
    }
}
















