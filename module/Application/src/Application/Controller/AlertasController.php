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
use Zend\Mail\Message;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part as MimePart;
use Zend\Mail\Transport\SmtpOptions;

use Application\Model\Usuario;
use Application\Model\Projeto;
use Application\Model\ProjetoStatusJustificativa;
use Application\Service\AlertaService;

class AlertasController extends AbstractActionController
{
	protected $service;
	
	public function __construct(AlertaService $service)
	{
		$this->service = $service;
	}
	
	protected $usuarioTable;
	protected $projetoTable;
	protected $projetoStatusJustificativaTable;
	
    public function getUsuarioTable()
    {
    	if (!$this->usuarioTable) {
    		$sm = $this->getServiceLocator();
    		$this->usuarioTable = $sm->get('Application\Model\UsuarioTable');
    	}
    	return $this->usuarioTable;
    }

	public function getProjetoTable()
	{
		if (!$this->projetoTable) {
			$sm = $this->getServiceLocator();
			$this->projetoTable = $sm->get('Application\Model\ProjetoTable');
		}
		return $this->projetoTable;
	}	

	public function getProjetoStatusJustificativaTable()
	{
		if (!$this->projetoStatusJustificativaTable) {
			$sm = $this->getServiceLocator();
			$this->projetoStatusJustificativaTable = $sm->get('Application\Model\ProjetoStatusJustificativaTable');
		}
		return $this->projetoStatusJustificativaTable;
	}
	
	public function indexAction()
     {
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
     					'password' => ''
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
     
     public function projetosCanceladosAction()
     {
     	$mes = date('m');
     	
     	switch ($mes){
     	
     		case 1: $mes_ext = "Janeiro"; break;
     		case 2: $mes_ext = "Fevereiro"; break;
     		case 3: $mes_ext = "Março"; break;
     		case 4: $mes_ext = "Abril"; break;
     		case 5: $mes_ext = "Maio"; break;
     		case 6: $mes_ext = "Junho"; break;
     		case 7: $mes_ext = "Julho"; break;
     		case 8: $mes_ext = "Agosto"; break;
     		case 9: $mes_ext = "Setembro"; break;
     		case 10: $mes_ext = "Outubro"; break;
     		case 11: $mes_ext = "Novembro"; break;
     		case 12: $mes_ext = "Dezembro"; break;
     	
     	}
     	
     	
     	$projetos_cancelados = $this->getProjetoTable()->getProjetosCancelados($mes);
     	
     	$html = "";
     	foreach ($projetos_cancelados as $projeto){
     		
     		$html .= '<tr>
						<td width="50">&nbsp;</td>
						<td width="500" align="left">
							<div class="contentEditableContainer contentTextEditable">
								<div class="contentEditable" >
									<div style="font-family:Helvetica, Arial, sans-serif;font-size:16px;line-height:160%;color:#181818;font-weight:bold;">'.utf8_encode($projeto['projeto_nome']).'</div>
									<div style="font-family:Helvetica, Arial, sans-serif;font-size:14px;line-height:160%;color:#181818;"><small>'.$projeto['projeto_status'].' em '.date('d/m/Y', strtotime($projeto['projeto_status_data'])).'</small></div>
								</div>
							</div>
							<div style="height:5px;">&nbsp;</div>
							<div class="contentEditableContainer contentTextEditable">
								<div class="contentEditable" >
									<p >'.utf8_encode($projeto['projeto_status_justificativa']).'</p>
								</div>
							</div>
																		
						</td>
					</tr>';   		
     	}
     	
     	$html = $this->gerarHtmlCancelados($html, 'Projetos Cancelados em '.$mes_ext);
     	
     	$altaDirecao = $this->getUsuarioTable()->getUsuarioPerfil(6);
     	
     	foreach ($altaDirecao as $usuario){     	
     		$this->enviarEmail($html, 'Projetos Cancelados em '.$mes_ext, $usuario->usuario_email);
     	}
     	die;
     }
     
     public function enviarEmailAltaDirecao($html, $titulo)
     {
     	$altaDirecao = $this->getUsuarioTable()->getUsuarioPerfil(6);
     	
     	foreach ($altaDirecao as $usuario){
     		$this->enviarEmail($html, $titulo, $usuario->usuario_email);
     	}
     }
     
     public function gerarHtmlForaLimites($indicadores){
     
     	$html = new MimePart('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

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
										<td style="color:#fff;" class="bgItem">
											<table cellpadding="0" style="border-collapse:collapse;" cellspacing="0" border="0" align="center" width="600">
												<tr>
													<td width="400" valign="top" style="padding-top:40px;padding-bottom:20px;">
														<br/>
														<div class="contentEditableContainer contentTextEditable">
															<div class="contentEditable" >
																<div style="font-size:23px;font-family:Heveltica, Arial, sans-serif;color:#fff;">'.utf8_encode('3 ou mais indicadores estão fora do limite esperado!').'</div>
															</div>
														</div>
														
														<div class="contentEditableContainer contentTextEditable">
															<div class="contentEditable"  style="padding:20px 10px 0 0;margin:0;font-family:Helvetica, Arial, sans-serif;font-size:15px;line-height:150%;">
																<p style="color:#FFEECE;">'.utf8_encode('Sistema de Gerenciamento de Portfolio de Projetos').'</strong></p>
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
												<div class="contentEditable" >
													<div style="font-family:Helvetica, Arial, sans-serif;font-size:16px;line-height:160%;color:#181818;font-weight:bold;">'.utf8_encode($indicadores->projeto_id).'</div>
													<div style="font-family:Helvetica, Arial, sans-serif;font-size:20px;line-height:160%;color:#181818;"><small>'.utf8_encode($indicadores->projeto_fase).'</small></div>
												</div>
											</div>
											<div style="height:20px;">&nbsp;</div>
											<div class="contentEditableContainer contentTextEditable">
												<div class="contentEditable" >
													<ul>
														<li>Qualidade</li>
														<li>Eficiência</li>
														<li>Lucratividade</li>
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
													<span style="font-size:13px;color:#181818;font-family:Helvetica, Arial, sans-serif;line-height:200%;"><a href="http://www.gerportifolios.esy.es/public"> Sistema de Gerenciamento de Portfolio de Projetos by Laislla Ramos</a></span>
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
</html>
     			
     			
     			');
     	

     	return $html;
     	
     }
     
     public function gerarHtmlCancelados($msg, $titulo){
     	
     	$html = new MimePart('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
     	
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
										<td style="color:#fff;" class="bgItem">
											<table cellpadding="0" style="border-collapse:collapse;" cellspacing="0" border="0" align="center" width="600">
												<tr>
													<td width="400" valign="top" style="padding-top:40px;padding-bottom:20px;">
														<br/>
														<div class="contentEditableContainer contentTextEditable">
															<div class="contentEditable" >
																<div style="font-size:23px;font-family:Heveltica, Arial, sans-serif;color:#fff;">'.$titulo.'</div>
															</div>
														</div>
     	
														<div class="contentEditableContainer contentTextEditable">
															<div class="contentEditable"  style="padding:20px 10px 0 0;margin:0;font-family:Helvetica, Arial, sans-serif;font-size:15px;line-height:150%;">
																<p style="color:#FFEECE;">Sistema de Gerenciamento de '.utf8_encode('Portfolio').' de Projetos</strong></p>
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
									'.$msg.'
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
													<span style="font-size:13px;color:#181818;font-family:Helvetica, Arial, sans-serif;line-height:200%;"><a href="gerportifolios.esy.es/public"> Sistema de Gerenciamento de Portfolio de Projetos by Laislla Ramos</a></span>
													<br/>
													<span style="font-size:11px;color:#555;font-family:Helvetica, Arial, sans-serif;line-height:200%;">laisllaramos@gmail.com</span>
													<br/>
													<span style="font-size:13px;color:#181818;font-family:Helvetica, Arial, sans-serif;line-height:200%;">
														<a target="_blank" href="" style="text-decoration:none;color:#555">Cancelar alertas</a></span>
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
</html>
     			');
     	
     	return $html;
     }
     
}
