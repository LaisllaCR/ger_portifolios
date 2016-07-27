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

use Application\Model\Indicador;

class IndicadorController extends AbstractActionController
{
	protected $indicadorTable;
	
	public function indexAction()
     {
         return new ViewModel(array(
             'indicadores' => $this->getIndicadorTable()->fetchAll(),
         ));
     }
    
    public function getIndicadorTable()
    {
    	if (!$this->indicadorTable) {
    		$sm = $this->getServiceLocator();
    		$this->indicadorTable = $sm->get('Application\Model\IndicadorTable');
    	}
    	return $this->indicadorTable;
    }
    
    public function addAction()
    {    	
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$indicador = new Indicador();
    		$dados_form = $request->getPost();
    	
    		if ($dados_form) {

    			$indicador->indicador_nome = $dados_form['indicador_nome'];
    			 
    			$this->getIndicadorTable()->saveIndicador($indicador);
    	
    			return $this->redirect()->toRoute('indicador');
    		}
    	}
    	
    	return new ViewModel(array(
    			'indicadores' => $this->getIndicadorTable()->fetchAll(),
    	));
    }
    
    public function editAction()
    {
    	$id = (int) $this->params()->fromRoute('id', 0);
    	if (!$id) {
    		return $this->redirect()->toRoute('indicador', array(
    				'action' => 'index'
    		));
    	}
    
    	try {
    		$indicador = $this->getIndicadorTable()->getIndicador($id);
    	}
    	catch (\Exception $ex) {
    		return $this->redirect()->toRoute('indicador', array(
    				'action' => 'index'
    		));
    	}

    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$dados_form = $request->getPost();    	
    		
    		$indicador->indicador_id = $id;    
    		$indicador->indicador_nome = $dados_form['indicador_nome'];
    		 
    		if ($dados_form) {
    			$this->getIndicadorTable()->saveIndicador($indicador);
    			 
    			return $this->redirect()->toRoute('indicador');
    		}
    	}
    	 
    	return array(
    			'id' => $id,
    			'indicador' => $indicador,
     	);
    	
    }
    
    public function deleteAction()
    {
    	$id = (int) $this->params()->fromRoute('id', 0);
    	if (!$id) {
    		return $this->redirect()->toRoute('indicador');
    	}
    	
    	$request = $this->getRequest();
    	
    	if ($request->isPost()) {
    		$dados_form = $request->getPost(); 

    		if($dados_form['submit'] == "Sim"){
    			$id = (int) $request->getPost('id');
    			$this->getIndicadorTable()->deleteIndicador($id);
    		}
    	
    		return $this->redirect()->toRoute('indicador');
    	}
    	
    	return array(
    			'id'    => $id,
    			'indicador' => $this->getIndicadorTable()->getIndicador($id)
    	);    	
    }
    
	public function detalheAction()
    {
		 $request = $this->getRequest();
		 
		 
    	return new ViewModel(array(
    			'indicador' => $this->getIndicadorTable()->getIndicador($this->params('id')),
    	));
    }
}
