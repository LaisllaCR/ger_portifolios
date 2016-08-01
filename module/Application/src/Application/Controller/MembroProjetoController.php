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

class MembroProjetoController extends AbstractActionController
{
	protected $membroProjetoTable;
	protected $projetoTable;
	protected $usuarioTable;
	
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
     	 
     	return new ViewModel(array(
     			'id' => $id,
     			'projeto' => $this->getProjetoTable()->getProjeto($id),
     			'usuarios' => $this->getUsuarioTable()->fetchAll(),
     			'membrosProjeto' => $membrosProjeto
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
    			 
    			$this->getMembroProjetoTable()->saveMembroProjeto($membroProjeto);

    			return $this->redirect()->toRoute('membro_projeto/consulta', array(
    					'action' => 'consulta', 'id' => $id
    			));
    		}
    	}
    	
    	return new ViewModel(array(
    			'id' => $id,
     			'usuarios' => $this->getUsuarioTable()->fetchAll(),
     			'projeto' => $this->getProjetoTable()->getProjeto($id),
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
		 
		 
    	return new ViewModel(array(
     			'usuarios' => $this->getUsuarioTable()->fetchAll(),
    			'membro' => $this->getMembroProjetoTable()->getProjetoMembro($this->params('id')),
    	));
    }
}
