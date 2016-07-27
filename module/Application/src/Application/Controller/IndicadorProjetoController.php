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
use Application\Model\IndicadorProjeto;
use Application\Model\Indicador;

class IndicadorProjetoController extends AbstractActionController
{
	protected $indicadorProjetoTable;
	protected $indicadorTable;
	protected $projetoTable;
	
	public function indexAction()
     {
    	$id = (int) $this->params()->fromRoute('id', 0);
    	
    	if (!$id) {
    		return $this->redirect()->toRoute('projeto', array(
    				'action' => 'index'
    		));
    	}
    
    	try {
    		$indicadoresProjeto = $this->getIndicadorProjetoTable()->getIndicadoresProjeto($id);
    	}
    	catch (\Exception $ex) {
    		return $this->redirect()->toRoute('projeto', array(
    				'action' => 'index'
    		));
    	}

         return new ViewModel(array(
             'id' => $id,
         	 'indicadoresProjeto' => $indicadoresProjeto
         ));
     }
     

     public function consultaAction()
     {
     	$id = (int) $this->params()->fromRoute('id', 0);
     	
     	if (!$id) {
     		return $this->redirect()->toRoute('projeto', array(
     				'action' => 'index'
     		));
     	}
     
     	try {
     		$indicadoresProjeto = $this->getIndicadorProjetoTable()->getIndicadoresProjeto($id);
     		$indicadores = $this->getIndicadorTable()->fetchAll();
     	}
     	catch (\Exception $ex) {
     		return $this->redirect()->toRoute('projeto', array(
     				'action' => 'index'
     		));
     	}
     
     	return new ViewModel(array(
     			'id' => $id,
     			'projeto' => $this->getProjetoTable()->getProjeto($id),
     			'indicadoresProjeto' => $indicadoresProjeto,
     			'indicadores' => $indicadores
     	));
     }
    
    public function getIndicadorProjetoTable()
    {
    	if (!$this->indicadorProjetoTable) {
    		$sm = $this->getServiceLocator();
    		$this->indicadorProjetoTable = $sm->get('Application\Model\IndicadorProjetoTable');
    	}
    	return $this->indicadorProjetoTable;
    }
    
    public function getIndicadorTable()
    {
    	if (!$this->indicadorTable) {
    		$sm = $this->getServiceLocator();
    		$this->indicadorTable = $sm->get('Application\Model\IndicadorTable');
    	}
    	return $this->indicadorTable;
    }
    
    public function getProjetoTable()
    {
    	if (!$this->projetoTable) {
    		$sm = $this->getServiceLocator();
    		$this->projetoTable = $sm->get('Application\Model\ProjetoTable');
    	}
    	return $this->projetoTable;
    }
    
    public function addAction()
    {    	
    	$id = (int) $this->params()->fromRoute('id', 0);
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$indicadorProjeto = new IndicadorProjeto();
    		$dados_form = $request->getPost();
    	
    		if ($dados_form) {

    			$indicadorProjeto->indicador_id = $dados_form['indicador_id'];
    			$indicadorProjeto->projeto_id = $id;
    			$indicadorProjeto->usuario_id = 1;
    			$indicadorProjeto->projeto_fase = $dados_form['projeto_fase'];
    			$indicadorProjeto->valor_minimo = $dados_form['valor_minimo'];
    			$indicadorProjeto->valor_maximo = $dados_form['valor_maximo'];

    			$indicadorProjeto->indicador_projeto_valor = NULL;
    			$indicadorProjeto->indicador_projeto_descricao = NULL;
    			
    			$this->getIndicadorProjetoTable()->saveIndicadorProjeto($indicadorProjeto);

    			return $this->redirect()->toRoute('indicador_projeto/consulta', array(
    					'action' => 'consulta', 'id' => $id
    			));
    		}
    	}
    	
    	$indicadorTable = $this->indicadorTable;
    	
    	return new ViewModel(array(
    			'id' => $id,
            	'indicadores' => $this->getIndicadorTable()->fetchAll(),
     			'projeto' => $this->getProjetoTable()->getProjeto($id),
    			'indicadorProjetos' => $this->getIndicadorProjetoTable()->fetchAll(),
    	));
    }
    
    public function editAction()
    {
    	$id = (int) $this->params()->fromRoute('id', 0);
    	$projeto_id = (int) $this->params()->fromRoute('projeto_id', 0);
    	
    	if (!$id) {
    		return $this->redirect()->toRoute('indicador_projeto', array(
    				'action' => 'index'
    		));
    	}
    
    	try {
    		$indicadorProjeto = $this->getIndicadorProjetoTable()->getIndicadorProjeto($id);
    	}
    	catch (\Exception $ex) {
    		return $this->redirect()->toRoute('indicador_projeto', array(
    				'action' => 'index'
    		));
    	}

    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$dados_form = $request->getPost();    
    		
    		$indicadorProjeto->indicador_projeto_id = $id;    
    		$indicadorProjeto->indicador_id = $dados_form['indicador_id'];
    		$indicadorProjeto->projeto_id = $projeto_id;
    		$indicadorProjeto->usuario_id = 1;
    		$indicadorProjeto->projeto_fase = $dados_form['projeto_fase'];
    		$indicadorProjeto->valor_minimo = $dados_form['valor_minimo'];
    		$indicadorProjeto->valor_maximo = $dados_form['valor_maximo'];
    		
    		$indicadorProjeto->indicador_projeto_valor = $dados_form['indicador_projeto_valor'];
    		$indicadorProjeto->indicador_projeto_descricao = $dados_form['indicador_projeto_descricao'];
    		 
    		if ($dados_form) {
    			$this->getIndicadorProjetoTable()->saveIndicadorProjeto($indicadorProjeto);

    			return $this->redirect()->toRoute('indicador_projeto/consulta', array(
    					'action' => 'consulta', 'id' => $projeto_id
    			));
    		}
    	}
    	 
    	return array(
            	'indicadores' => $this->getIndicadorTable()->fetchAll(),
    			'id' => $id,
    			'projeto_id' => $projeto_id,
     			'projeto' => $this->getProjetoTable()->getProjeto($projeto_id),
    			'indicadorProjeto' => $indicadorProjeto,
     	);
    	
    }
    
    public function deleteAction()
    {
    	$id = (int) $this->params()->fromRoute('id', 0);
    	$projeto_id = (int) $this->params()->fromRoute('projeto_id', 0);
    	if (!$id) {
    		return $this->redirect()->toRoute('indicadorProjeto');
    	}
    	
    	$request = $this->getRequest();
    	
    	if ($request->isPost()) {
    		$dados_form = $request->getPost(); 

    		if($dados_form['submit'] == "Sim"){
    			$id = (int) $request->getPost('id');
    			$this->getIndicadorProjetoTable()->deleteIndicadorProjeto($id);
    		}


    		return $this->redirect()->toRoute('indicador_projeto/consulta', array(
    				'action' => 'consulta', 'id' => $projeto_id
    		));
    	}
    	
    	return array(
    			'id'    => $id,
    			'projeto_id' => $projeto_id,
            	'indicadores' => $this->getIndicadorTable()->fetchAll(),
     			'projeto' => $this->getProjetoTable()->getProjeto($projeto_id),
    			'indicadorProjeto' => $this->getIndicadorProjetoTable()->getIndicadorProjeto($id)
    	);    	
    }
    
	public function detalheAction()
    {
		 $request = $this->getRequest();
		 
		 
    	return new ViewModel(array(
            	'indicadores' => $this->getIndicadorTable()->fetchAll(),
    			'indicadorProjeto' => $this->getIndicadorProjetoTable()->getIndicadorProjeto($this->params('id')),
    	));
    }
    
 	public function analiseAction()
    {
    	$id = (int) $this->params()->fromRoute('id', 0);
    	$projeto_id = (int) $this->params()->fromRoute('projeto_id', 0);
    	
    	if (!$id) {
    		return $this->redirect()->toRoute('indicador_projeto', array(
    				'action' => 'index'
    		));
    	}
    
    	try {
    		$indicadorProjeto = $this->getIndicadorProjetoTable()->getIndicadorProjeto($id);
    	}
    	catch (\Exception $ex) {
    		return $this->redirect()->toRoute('indicador_projeto', array(
    				'action' => 'index'
    		));
    	}

    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$dados_form = $request->getPost();    
    		
    		$indicadorProjeto->indicador_projeto_id = $id;    
    		    		
    		$indicadorProjeto->projeto_id = $projeto_id;
    		$indicadorProjeto->usuario_id = 1;

    		$indicadorProjeto->indicador_id = $dados_form['indicador_id'];
    		$indicadorProjeto->projeto_fase = $dados_form['projeto_fase'];
    		$indicadorProjeto->valor_minimo = $dados_form['valor_minimo'];
    		$indicadorProjeto->valor_maximo = $dados_form['valor_maximo'];
    		
    		$indicadorProjeto->indicador_projeto_valor = $dados_form['indicador_projeto_valor'];
    		$indicadorProjeto->indicador_projeto_descricao = $dados_form['indicador_projeto_descricao'];
    		    		 
    		if ($dados_form) {
    			$this->getIndicadorProjetoTable()->saveIndicadorProjeto($indicadorProjeto);

    			return $this->redirect()->toRoute('indicador_projeto/consulta', array(
    					'action' => 'consulta', 'id' => $projeto_id
    			));
    		}
    	}
    	 
    	return array(
            	'indicadores' => $this->getIndicadorTable()->fetchAll(),
    			'id' => $id,
    			'projeto_id' => $projeto_id,
     			'projeto' => $this->getProjetoTable()->getProjeto($projeto_id),
    			'indicadorProjeto' => $indicadorProjeto,
     	);
    	
    }
}
