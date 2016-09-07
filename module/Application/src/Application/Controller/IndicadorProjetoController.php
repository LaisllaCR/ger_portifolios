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
use Application\Controller\AlertaControllerFactory;

use Zend\Mail\Message;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part as MimePart;
use Zend\Mail\Transport\SmtpOptions;

use Application\Model\Usuario;
use Application\Model\ProjetoStatusJustificativa;
use Application\Service\AlertaService;
use Application\Model\ProjetoSemanaJustificativa;
use Application\Model\ProjetoSemana;
use Zend\Session\Container;
use Application\Model\Logs;


class IndicadorProjetoController extends AbstractActionController
{
	protected $indicadorProjetoTable;
	protected $logsTable;
	protected $usuarioTable;
	protected $indicadorTable;
	protected $projetoTable;
	protected $projetoSemanaTable;
	protected $projetoSemanaJustificativaTable;

	public function getUsuarioTable()
	{
		if (!$this->usuarioTable) {
			$sm = $this->getServiceLocator();
			$this->usuarioTable = $sm->get('Application\Model\UsuarioTable');
		}
		return $this->usuarioTable;
	}
	
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

     	$projeto = $this->getProjetoTable()->getProjeto($id);

     	if($projeto->projeto_risco == "Alto risco"){
     		$valida = $this->verificarAcompanhamento($projeto);
     		if($valida == true){
     			return $this->redirect()->toRoute('acompanhamento_projeto/consulta', array(
     					'action' => 'consulta', 'id' => $projeto->projeto_id
     			));
     		}
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
    			
    			$id_ind = $this->getIndicadorProjetoTable()->saveIndicadorProjeto($indicadorProjeto);
    			
    			$acao = "indicador_projeto/add";
    			$this->salvarLog($acao, $id_ind);

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
    			$acao = "indicador_projeto/edit";
    			$this->salvarLog($acao, $id);

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

    			$acao = "indicador_projeto/delete";
    			$this->salvarLog($acao, $id);
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
    
	public function detalheAction()
    {
		 $request = $this->getRequest();
    	$id = (int) $this->params()->fromRoute('id', 0);
    	$projeto_id = (int) $this->params()->fromRoute('projeto_id', 0);

    	$acao = "indicador_projeto/detalhe";
    	$this->salvarLog($acao, $id);
		 
    	return new ViewModel(array(
            	'indicadores' => $this->getIndicadorTable()->fetchAll(),
     			'projeto' => $this->getProjetoTable()->getProjeto($projeto_id),
    			'indicadorProjeto' => $this->getIndicadorProjetoTable()->getIndicadorProjeto($this->params('id')),
    	));
    }
    
 	public function analiseAction()
    {
 		$service = new \Application\Service\AlertaService();
 		$controller = new AlertasController($service);
 		
    	$id = (int) $this->params()->fromRoute('id', 0);
    	$projeto_id = (int) $this->params()->fromRoute('projeto_id', 0);
    	
    	if (!$id) {
    		return $this->redirect()->toRoute('indicador_projeto', array(
    				'action' => 'index'
    		));
    	}
    
    	try {
    		$indicadorProjeto = $this->getIndicadorProjetoTable()->getIndicadorProjeto($id);
    		$projeto = $this->getProjetoTable()->getProjeto($indicadorProjeto->projeto_id);
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
    		$indicadorProjeto->indicador_projeto_descricao = utf8_encode($dados_form['indicador_projeto_descricao']);
    		
    		if($indicadorProjeto->indicador_projeto_valor > $indicadorProjeto->valor_maximo){
    			$indicadores = $this->verificarIndicadoresFase($indicadorProjeto);
    			$quant_fora_limite = count($indicadores);
    			
    			if($quant_fora_limite >= 2){
    				
    				$html = $this->gerarHtmlForaLimites($indicadorProjeto, $projeto, $indicadores);
    				$this->enviarEmailAltaDirecao($html, utf8_encode('3 ou mais indicadores estão fora do limite esperado!'));
    			}
    		
    		}
    		    		 
    		if ($dados_form) {
    			$this->getIndicadorProjetoTable()->saveIndicadorProjeto($indicadorProjeto);

    			$acao = "indicador_projeto/analise";
    			$this->salvarLog($acao, $id);

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
    
    public function enviarEmailAltaDirecao($html, $titulo)
    {
    	$altaDirecao = $this->getUsuarioTable()->getUsuarioPerfil(6);
    
    	foreach ($altaDirecao as $usuario){
    		$this->enviarEmail($html, $titulo, $usuario->usuario_email);
    	}
    }
     
    public function gerarHtmlForaLimites($indicadores, $projeto, $indicadoresBD)
    {    	     	    	
    	$html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
    
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<title>[SUBJECT]</title>
	<style type="text/css">
    
		#outlook a {padding:0;}
		body{width:100% !important; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; margin:0; padding:0;}
		.ExternalClass {width:100%;}
		.ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height: 100%;}
		#backgroundTable {margin:0; padding:0; width:100% !important; line-height: 100% !important;}
		img {outline:none; text-decoration:none; -ms-interpolation-mode: bicubic;}
		a img {border:none;display:inline-block;}
		.image_fix {display:block;}
    
		h1, h2, h3, h4, h5, h6 {color: black !important;}
    
		h1 a, h2 a, h3 a, h4 a, h5 a, h6 a {color: blue !important;}
    
		h1 a:active, h2 a:active,  h3 a:active, h4 a:active, h5 a:active, h6 a:active {
			color: red !important;
		}
    
		h1 a:visited, h2 a:visited,  h3 a:visited, h4 a:visited, h5 a:visited, h6 a:visited {
			color: purple !important;
		}
    
		table td {border-collapse: collapse;}
    
		table { border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; }
    
		a {color: #000;}
    
		@media only screen and (max-device-width: 480px) {
    
			a[href^="tel"], a[href^="sms"] {
				text-decoration: none;
				color: black; /* or whatever your want */
				pointer-events: none;
				cursor: default;
			}
    
			.mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
				text-decoration: default;
				color: orange !important; /* or whatever your want */
				pointer-events: auto;
				cursor: default;
			}
		}
    
    
		@media only screen and (min-device-width: 768px) and (max-device-width: 1024px) {
			a[href^="tel"], a[href^="sms"] {
				text-decoration: none;
				color: blue; /* or whatever your want */
				pointer-events: none;
				cursor: default;
			}
    
			.mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
				text-decoration: default;
				color: orange !important;
				pointer-events: auto;
				cursor: default;
			}
		}
    
		p {
			margin:0;
			color:#555;
			font-family:Helvetica, Arial, sans-serif;
			font-size:16px;
			line-height:160%;
		}
		a.link2{
			text-decoration:none;
			font-family:Helvetica, Arial, sans-serif;
			font-size:16px;
			color:#fff;
			border-radius:4px;
		}
		h2{
			color:#181818;
			font-family:Helvetica, Arial, sans-serif;
			font-size:22px;
			font-weight: normal;
		}
    
		.bgItem{
			background:#F4A81C;
		}
		.bgBody{
			background:#ffffff;
		}
    
	</style>
    
<script type="colorScheme" class="swatch active">
  {
    "name":"Default",
    "bgBody":"ffffff",
    "link":"f2f2f2",
    "color":"555555",
    "bgItem":"F4A81C",
    "title":"181818"
  }
</script>
    
</head>
<body>
	<!-- Wrapper/Container Table: Use a wrapper table to control the width and the background color consistently of your email. Use this approach instead of setting attributes on the body tag. -->
	<table cellpadding="0" width="100%" cellspacing="0" border="0" id="backgroundTable" class="bgBody">
		<tr>
			<td>
    
				<!-- Tables are the most common way to format your email consistently. Set your table widths inside cells and in most cases reset cellpadding, cellspacing, and border to zero. Use nested tables as a way to space effectively in your message. -->
    
				<table cellpadding="0" cellspacing="0" border="0" align="center" width="100%" style="border-collapse:collapse;">
					<tr>
						<td class="movableContentContainer">
				
							<div class="movableContent">
								<table cellpadding="0" cellspacing="0" border="0" align="center" width="100%" style="border-collapse:collapse;">
									<tr>
										<td style="color:#fff; background-color: #F4A81C;" class="bgItem">
											<table cellpadding="0" style="border-collapse:collapse;" cellspacing="0" border="0" align="center" width="600">
												<tr>
													<td width="400" valign="top" style="padding-top:40px;padding-bottom:20px;">
														<br/>
														<div class="contentEditableContainer contentTextEditable">
															<div class="contentEditable" >
																<div style="font-size:23px;font-family:Heveltica, Arial, sans-serif;color:#fff;">'.('3 ou mais indicadores estão fora do limite esperado!').'</div>
															</div>
														</div>
    
														<div class="contentEditableContainer contentTextEditable">
															<div class="contentEditable"  style="padding:20px 10px 0 0;margin:0;font-family:Helvetica, Arial, sans-serif;font-size:15px;line-height:150%;">
																<p style="color:#FFEECE;">'.('Sistema de Gerenciamento de Portfolio de Projetos').'</strong></p>
															</div>
														</div>
    
													</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
							</div>
    
							<div class="movableContent" align="center" style="text-align:center;">
								<table cellpadding="0" cellspacing="0" border="0" align="center" width="600">
									<tr>
										<td width="100%" colspan="3" align="center" style="padding-bottom:20px;">
											<div class="contentEditableContainer contentTextEditable">
												<div class="contentEditable"  >
												</div>
											</div>
    
										</td>
									</tr>
									<tr>
										<td width="50">&nbsp;</td>
										<td width="500" align="left">
											<div class="contentEditableContainer contentTextEditable">
												<div class="contentEditable">
													<div style="font-family:Helvetica, Arial, sans-serif;font-size:16px;line-height:160%;color:#181818;font-weight:bold;">'.utf8_decode($projeto->projeto_nome).'</div>
													<div style="font-family:Helvetica, Arial, sans-serif;font-size:20px;line-height:160%;color:#181818;"><small>'.$indicadores->projeto_fase.'</small></div>
												</div>
											</div>
											<div style="height:20px;">&nbsp;</div>
											<div class="contentEditableContainer contentTextEditable">
												<div class="contentEditable" >
													<ul>';
    	foreach($indicadoresBD as $indicador){
    		$html .= '<li>'.$indicador["indicador_nome"].'</li>';
    	}
														
														$html .='
													</ul>
												</div>
											</div>
    
										</td>
									</tr>
								</table>
							</div>
    
							<div class="movableContent">
								<table cellpadding="0" cellspacing="0" border="0" align="center" width="600">
									<tr>
										<td width="100%" colspan="2" style="padding-top:65px;">
											<hr style="height:1px;border:none;color:#333;background-color:#ddd;" />
										</td>
									</tr>
									<tr>
										<td width="60%" height="70" valign="middle" style="padding-bottom:20px;">
											<div class="contentEditableContainer contentTextEditable">
												<div class="contentEditable" >
													<span style="font-size:13px;color:#181818;font-family:Helvetica, Arial, sans-serif;line-height:200%;"><a href="http://gerportifolios.esy.es/public"> Sistema de Gerenciamento de Portfolio de Projetos by Laislla Ramos </a></span>
													<br/>
													<span style="font-size:11px;color:#555;font-family:Helvetica, Arial, sans-serif;line-height:200%;">laisllaramos@gmail.com</span>
													<br/>
													<span style="font-size:13px;color:#181818;font-family:Helvetica, Arial, sans-serif;line-height:200%;">
												</div>
											</div>
										</td>
    
									</tr>
								</table>
							</div>
    
						</td>
					</tr>
				</table>
<!-- END BODY -->
    
			</td>
		</tr>
	</table>
	<!-- End of wrapper table -->
</body>
</html>';
    
    
     		$html2 = new MimePart($html);
    
    
    	return $html2;
    
    }
    
    public function enviarEmail($html, $titulo, $destinatario)
    {
    	$message = new Message();
    	$message->addTo($destinatario) // destinatarios
    	->addFrom('laisllaramos@gmail.com')
    	->setSubject($titulo);
    	 
    	// Setup SMTP transport using LOGIN authentication
    	$transport = new SmtpTransport();
    	$options   = new SmtpOptions(array(
    			'host'              => 'smtp.gmail.com',
    			'connection_class'  => 'login',
    			'connection_config' => array(
    					'ssl'       => 'tls',
    					'username' => 'laisllaramos@gmail.com',
    					'password' => 'RockNRoll1721'
    			),
    			'port' => 587,
    	));
    	 
    
    	$html->type = "text/html";
    	 
    	$body = new MimeMessage();
    	$body->addPart($html);
    	 
    	$message->setBody($body);
    	 
    	$transport->setOptions($options);
    	$transport->send($message);
    }
    
    
     
    
    public function verificarIndicadoresFase($indicadorProjeto)
    {
    	$indicadores = $this->getIndicadorProjetoTable()->getCountIndicadorFaseProjeto($indicadorProjeto);
    	
    	return $indicadores;
    }
    
    public function enviarEmailAlertaIndicadoresFase($indicadorProjeto){
    	
    }
    
}
