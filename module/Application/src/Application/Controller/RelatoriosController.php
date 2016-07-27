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

//use Application\Model\Relatorios;

class RelatoriosController extends AbstractActionController
{
//	protected $relatoriosTable;
	
	public function indexAction()
     {
         return new ViewModel(array(
             'relatorioss' => $this->getRelatoriosTable()->fetchAll(),
         ));
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
