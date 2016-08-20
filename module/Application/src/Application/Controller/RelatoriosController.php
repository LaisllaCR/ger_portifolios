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

//use Application\Model\Relatorios;

class RelatoriosController extends AbstractActionController
{
//	protected $relatoriosTable;
	protected $projetoTable;
	protected $indicadorProjetoTable;
	protected $indicadorTable;

    public function getProjetoTable()
    {
    	if (!$this->projetoTable) {
    		$sm = $this->getServiceLocator();
    		$this->projetoTable = $sm->get('Application\Model\ProjetoTable');
    	}
    	return $this->projetoTable;
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
    
	public function indexAction()
     {
		$indicadores = $this->getIndicadorTable()->fetchAll();
     	$indicadoresForaLimite = $this->getIndicadorTable()->getIndicadoresForaLimite();
     	$projetos = $this->getProjetoTable()->fetchAll();
     	
     	$maior_valor = $this->getTotalIndicadoresForaLimitePorIndicador($indicadores, $indicadoresForaLimite); 
     	$maior_valor_projeto = $this->getTotalIndicadoresForaLimitePorProjeto($projetos);     
     	$projetos_fora_limite = $this->getForaLimitePorProjeto();
      	
     	/*
     	echo '<pre>';
     	print_r($projetos_fora_limite);
     	die;
     	*/
     	
         return new ViewModel(array(
         		'totalIndicadores' => count($indicadores),
         		'totalIndicadoresForaLimite' => count($indicadoresForaLimite),
         		'indicadorForaLimite' => $maior_valor['indicador_nome'],
         		'projetoForaLimite' => $maior_valor_projeto['projeto_nome'],
         		'projetosForaLimite' => $projetos_fora_limite,
            // 'relatorioss' => $this->getRelatoriosTable()->fetchAll(),
         ));
     }
     
     
     public function getTotalIndicadoresForaLimitePorIndicador($indicadores, $indicadoresForaLimite)
     {
     	$array_indicador = Array();
     	
     	//quantidade de indicadores fora do limite por indicador
     	foreach ($indicadoresForaLimite as $indicador){
     		if(!isset($array_indicador[$indicador['indicador_id']])){
     			$array_indicador[$indicador['indicador_id']] = 0;
     		}
     		 
     		$array_indicador[$indicador['indicador_id']] = $array_indicador[$indicador['indicador_id']] + 1;
     	}
     	
     	$array_indicadores = Array();
     	
     	foreach ($indicadores as $indicador_dados){
     		$array_indicadores[$indicador_dados->indicador_id] = utf8_decode($indicador_dados->indicador_nome);
     	}
     	
     	$maior_valor = array('indicador_nome' => '', 'indicador_quantidade' => 0);
     	
     	foreach ($array_indicador as $chave=>$valor){
     		if($valor > $maior_valor['indicador_quantidade']){
     			$maior_valor = array('indicador_nome' => $array_indicadores[$chave], 'indicador_quantidade' => $valor);
     		}
     	}
     	//quantidade de indicadores fora do limite por indicador
     	
     	return $maior_valor;
     	
     }
     
     public function getTotalIndicadoresForaLimitePorProjeto($projetos)
     {

     	$indicadoresForaLimite = $this->getIndicadorTable()->getIndicadoresForaLimite();
     	$array_indicador = Array();
     
     	//quantidade de indicadores fora do limite por indicador
     	foreach ($indicadoresForaLimite as $indicador){
     		if(!isset($array_indicador[$indicador['projeto_id']])){
     			$array_indicador[$indicador['projeto_id']] = 0;
     		}
     
     		$array_indicador[$indicador['projeto_id']] = $array_indicador[$indicador['projeto_id']] + 1;
     	}
     
     	$array_projetos = Array();
     
     	foreach ($projetos as $projeto_dados){
     		$array_projetos[$projeto_dados->projeto_id] = utf8_decode($projeto_dados->projeto_nome);
     	}
     
     	$maior_valor = array('projeto_nome' => '', 'projeto_quantidade' => 0);
     
     	foreach ($array_indicador as $chave=>$valor){
     		if($valor > $maior_valor['projeto_quantidade']){
     			$maior_valor = array('projeto_nome' => $array_projetos[$chave], 'projeto_quantidade' => $valor);
     		}
     	}
     	//quantidade de indicadores fora do limite por indicador
     
     	return $maior_valor;
     
     }
     
     public function getForaLimitePorProjeto()
     {
     	$projetos = $this->getProjetoTable()->fetchAll();
     
     	$indicadoresForaLimite = $this->getIndicadorTable()->getIndicadoresForaLimite();
     	$array_indicador = Array();
     	 
     	//quantidade de indicadores fora do limite por indicador
     	foreach ($indicadoresForaLimite as $indicador){
     		if(!isset($array_indicador[$indicador['projeto_id']])){
     			$array_indicador[$indicador['projeto_id']] = 0;
     		}
     		 
     		$array_indicador[$indicador['projeto_id']] = $array_indicador[$indicador['projeto_id']] + 1;
     	}
     	 
     	$array_projetos = Array();
     	 
     	foreach ($projetos as $projeto_dados){
     		$array_projetos[$projeto_dados->projeto_id] = utf8_decode($projeto_dados->projeto_nome);
     	}
     	      	 
     	foreach ($array_indicador as $chave=>$valor){
     		$projetos_fora_limite[] = array('projeto_id' => $chave,'projeto_nome' => $array_projetos[$chave], 'projeto_quantidade' => $valor);
     	}
     	//quantidade de indicadores fora do limite por indicador
     	 
     	return $projetos_fora_limite;
     	 
     }
    
 /*   public function getRelatoriosTable()
    {
    	if (!$this->relatoriosTable) {
    		$sm = $this->getServiceLocator();
    		$this->relatoriosTable = $sm->get('Application\Model\RelatoriosTable');
    	}
    	return $this->relatoriosTable;
    }
*/
}
