<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

return array(
		
		'router'          => array(
				'routes' => array(
						'projeto' => array(
								'type' => 'literal',
								'options' => array(
										'route'    => '/projeto',
										'defaults' => array(
												'controller' => 'Application\Controller\Projeto',
												'action'     => 'index',
										)
								),
								'may_terminate' => true,
								'child_routes'  => array(
										'detalhe' => array(
												'type' => 'segment',
												'options' => array(
														'route'    => '/:id',
														'defaults' => array(
																'action' => 'detalhe'
														),
														'constraints' => array(
																'id' => '\d+'
														)
												)
										),
										'add' => array(
												'type' => 'literal',
												'options' => array(
														'route'    => '/add',
														'defaults' => array(
																'controller' => 'Application\Controller\Projeto',
																'action'     => 'add'
														)
												)
										),
										'edit' => array(
												'type' => 'segment',
												'options' => array(
														'route'    => '/edit/:id',
														'defaults' => array(
																'controller' => 'Application\Controller\Projeto',
																'action'     => 'edit'
														),
														'constraints' => array(
																'id' => '\d+'
														)
												)
										),
										'status' => array(
												'type' => 'segment',
												'options' => array(
														'route'    => '/status/:id',
														'defaults' => array(
																'controller' => 'Application\Controller\Projeto',
																'action'     => 'status'
														),
														'constraints' => array(
																'id' => '\d+'
														)
												)
										),
										'delete' => array(
												'type' => 'segment',
												'options' => array(
														'route'    => '/delete/:id',
														'defaults' => array(
																'controller' => 'Application\Controller\Projeto',
																'action'     => 'delete'
														),
														'constraints' => array(
																'id' => '\d+'
														)
												)
										),
								)
						),

						'indicador' => array(
								'type' => 'literal',
								'options' => array(
										'route'    => '/indicador',
										'defaults' => array(
												'controller' => 'Application\Controller\Indicador',
												'action'     => 'index',
										)
								),
								'may_terminate' => true,
								'child_routes'  => array(
										'detalhe' => array(
												'type' => 'segment',
												'options' => array(
														'route'    => '/:id',
														'defaults' => array(
																'action' => 'detalhe'
														),
														'constraints' => array(
																'id' => '\d+'
														)
												)
										),
										'add' => array(
												'type' => 'literal',
												'options' => array(
														'route'    => '/add',
														'defaults' => array(
																'controller' => 'Application\Controller\Indicador',
																'action'     => 'add'
														)
												)
										),
										'edit' => array(
												'type' => 'segment',
												'options' => array(
														'route'    => '/edit/:id',
														'defaults' => array(
																'controller' => 'Application\Controller\Indicador',
																'action'     => 'edit'
														),
														'constraints' => array(
																'id' => '\d+'
														)
												)
										),
										'delete' => array(
												'type' => 'segment',
												'options' => array(
														'route'    => '/delete/:id',
														'defaults' => array(
																'controller' => 'Application\Controller\Indicador',
																'action'     => 'delete'
														),
														'constraints' => array(
																'id' => '\d+'
														)
												)
										),
								)
						),

						'acompanhamento_projeto' => array(
								'type' => 'literal',//segment
								'options' => array(
										'route'    => '/acompanhamento_projeto',///:id
										'defaults' => array(
												'controller' => 'Application\Controller\AcompanhamentoProjeto',
												'action'     => 'index',
										),
										/*'constraints' => array(
										 'id' => '\d+'
										)*/
								),
								'may_terminate' => true,
								'child_routes'  => array(
										'detalhe' => array(
												'type' => 'segment',
												'options' => array(
														'route'    => '/detalhe/:id',
														'defaults' => array(
																'action' => 'detalhe'
														),
														'constraints' => array(
																'id' => '\d+'
														)
												)
										),
										'add' => array(
												'type' => 'segment',
												'options' => array(
														'route'    => '/add/:id',
														'defaults' => array(
																'controller' => 'Application\Controller\AcompanhamentoProjeto',
																'action'     => 'add'
														),
														'constraints' => array(
																'id' => '\d+'
														)
												)
										),
										'consulta' => array(
												'type' => 'segment',
												'options' => array(
														'route'    => '/consulta/:id',
														'defaults' => array(
																'controller' => 'Application\Controller\AcompanhamentoProjeto',
																'action'     => 'consulta'
														),
														'constraints' => array(
																'id' => '\d+'
														)
												)
										),
										'edit' => array(
												'type' => 'segment',
												'options' => array(
														'route'    => '/:projeto_id/edit/:id',
														'defaults' => array(
																'controller' => 'Application\Controller\AcompanhamentoProjeto',
																'action'     => 'edit'
														),
														'constraints' => array(
																'id' => '\d+'
														)
												)
										),
										'delete' => array(
												'type' => 'segment',
												'options' => array(
														'route'    => '/:projeto_id/delete/:id',
														'defaults' => array(
																'controller' => 'Application\Controller\AcompanhamentoProjeto',
																'action'     => 'delete'
														),
														'constraints' => array(
																'id' => '\d+'
														)
												)
										),
								)
						),

						'membro_projeto' => array(
								'type' => 'literal',//segment
								'options' => array(
										'route'    => '/membro_projeto',///:id
										'defaults' => array(
												'controller' => 'Application\Controller\MembroProjeto',
												'action'     => 'index',
										),
										/*'constraints' => array(
										 'id' => '\d+'
										)*/
								),
								'may_terminate' => true,
								'child_routes'  => array(
										'detalhe' => array(
												'type' => 'segment',
												'options' => array(
														'route'    => '/detalhe/:id',
														'defaults' => array(
																'action' => 'detalhe'
														),
														'constraints' => array(
																'id' => '\d+'
														)
												)
										),
										'add' => array(
												'type' => 'segment',
												'options' => array(
														'route'    => '/add/:id',
														'defaults' => array(
																'controller' => 'Application\Controller\MembroProjeto',
																'action'     => 'add'
														),
														'constraints' => array(
																'id' => '\d+'
														)
												)
										),
										'consulta' => array(
												'type' => 'segment',
												'options' => array(
														'route'    => '/consulta/:id',
														'defaults' => array(
																'controller' => 'Application\Controller\MembroProjeto',
																'action'     => 'consulta'
														),
														'constraints' => array(
																'id' => '\d+'
														)
												)
										),
										'edit' => array(
												'type' => 'segment',
												'options' => array(
														'route'    => '/:projeto_id/edit/:id',
														'defaults' => array(
																'controller' => 'Application\Controller\MembroProjeto',
																'action'     => 'edit'
														),
														'constraints' => array(
																'id' => '\d+'
														)
												)
										),
										'delete' => array(
												'type' => 'segment',
												'options' => array(
														'route'    => '/:projeto_id/delete/:id',
														'defaults' => array(
																'controller' => 'Application\Controller\MembroProjeto',
																'action'     => 'delete'
														),
														'constraints' => array(
																'id' => '\d+'
														)
												)
										),
								)
						),
						

						'tarefa_projeto' => array(
								'type' => 'literal',//segment
								'options' => array(
										'route'    => '/tarefa_projeto',///:id
										'defaults' => array(
												'controller' => 'Application\Controller\TarefaProjeto',
												'action'     => 'index',
										),
										/*'constraints' => array(
										 'id' => '\d+'
										)*/
								),
								'may_terminate' => true,
								'child_routes'  => array(
										'detalhe' => array(
												'type' => 'segment',
												'options' => array(
														'route'    => '/detalhe/:id',
														'defaults' => array(
																'action' => 'detalhe'
														),
														'constraints' => array(
																'id' => '\d+'
														)
												)
										),
										'add' => array(
												'type' => 'segment',
												'options' => array(
														'route'    => '/add/:id',
														'defaults' => array(
																'controller' => 'Application\Controller\TarefaProjeto',
																'action'     => 'add'
														),
														'constraints' => array(
																'id' => '\d+'
														)
												)
										),
										'consulta' => array(
												'type' => 'segment',
												'options' => array(
														'route'    => '/consulta/:id',
														'defaults' => array(
																'controller' => 'Application\Controller\TarefaProjeto',
																'action'     => 'consulta'
														),
														'constraints' => array(
																'id' => '\d+'
														)
												)
										),
										'edit' => array(
												'type' => 'segment',
												'options' => array(
														'route'    => '/:projeto_id/edit/:id',
														'defaults' => array(
																'controller' => 'Application\Controller\TarefaProjeto',
																'action'     => 'edit'
														),
														'constraints' => array(
																'id' => '\d+'
														)
												)
										),
										'delete' => array(
												'type' => 'segment',
												'options' => array(
														'route'    => '/:projeto_id/delete/:id',
														'defaults' => array(
																'controller' => 'Application\Controller\TarefaProjeto',
																'action'     => 'delete'
														),
														'constraints' => array(
																'id' => '\d+'
														)
												)
										),
								)
						),
						
					
						'indicador_projeto' => array(
								'type' => 'literal',//segment
								'options' => array(
										'route'    => '/indicador_projeto',///:id
										'defaults' => array(
												'controller' => 'Application\Controller\IndicadorProjeto',
												'action'     => 'index',
										),
										/*'constraints' => array(
												'id' => '\d+'
										)*/
								),
								'may_terminate' => true,
								'child_routes'  => array(
										'detalhe' => array(
												'type' => 'segment',
												'options' => array(
														'route'    => '/detalhe/:id',
														'defaults' => array(
																'action' => 'detalhe'
														),
														'constraints' => array(
																'id' => '\d+'
														)
												)
										),
										'add' => array(
												'type' => 'segment',
												'options' => array(
														'route'    => '/add/:id',
														'defaults' => array(
																'controller' => 'Application\Controller\IndicadorProjeto',
																'action'     => 'add'
														),
														'constraints' => array(
																'id' => '\d+'
														)
												)
										),
										'consulta' => array(
												'type' => 'segment',
												'options' => array(
														'route'    => '/consulta/:id',
														'defaults' => array(
																'controller' => 'Application\Controller\IndicadorProjeto',
																'action'     => 'consulta'
														),
														'constraints' => array(
																'id' => '\d+'
														)
												)
										),
										'edit' => array(
												'type' => 'segment',
												'options' => array(
														'route'    => '/:projeto_id/edit/:id',
														'defaults' => array(
																'controller' => 'Application\Controller\IndicadorProjeto',
																'action'     => 'edit'
														),
														'constraints' => array(
																'id' => '\d+'
														)
												)
										),
										'delete' => array(
												'type' => 'segment',
												'options' => array(
														'route'    => '/:projeto_id/delete/:id',
														'defaults' => array(
																'controller' => 'Application\Controller\IndicadorProjeto',
																'action'     => 'delete'
														),
														'constraints' => array(
																'id' => '\d+'
														)
												)
										),
										'analise' => array(
												'type' => 'segment',
												'options' => array(
														'route'    => '/:projeto_id/analise/:id',
														'defaults' => array(
																'controller' => 'Application\Controller\IndicadorProjeto',
																'action'     => 'analise'
														),
														'constraints' => array(
																'id' => '\d+'
														)
												)
										),
								)
						),
						

						'perfil-acesso' => array(
								'type' => 'literal',
								'options' => array(
										'route'    => '/perfil-acesso',
										'defaults' => array(
												'controller' => 'Application\Controller\PerfilAcesso',
												'action'     => 'index',
										)
								),
								'may_terminate' => true,
								'child_routes'  => array(
										'add' => array(
												'type' => 'literal',
												'options' => array(
														'route'    => '/add',
														'defaults' => array(
																'controller' => 'Application\Controller\PerfilAcesso',
																'action'     => 'add'
														)
												)
										),
										'edit' => array(
												'type' => 'segment',
												'options' => array(
														'route'    => '/edit/:id',
														'defaults' => array(
																'controller' => 'Application\Controller\PerfilAcesso',
																'action'     => 'edit'
														),
														'constraints' => array(
																'id' => '\d+'
														)
												)
										),
										'delete' => array(
												'type' => 'segment',
												'options' => array(
														'route'    => '/delete/:id',
														'defaults' => array(
																'controller' => 'Application\Controller\PerfilAcesso',
																'action'     => 'delete'
														),
														'constraints' => array(
																'id' => '\d+'
														)
												)
										),
								)
						),
						
						'usuario' => array(
								'type' => 'literal',
								'options' => array(
										'route'    => '/usuario',
										'defaults' => array(
												'controller' => 'Application\Controller\Usuario',
												'action'     => 'index',
										)
								),
								'may_terminate' => true,
								'child_routes'  => array(
										'detalhe' => array(
												'type' => 'segment',
												'options' => array(
														'route'    => '/:id',
														'defaults' => array(
																'action' => 'detalhe'
														),
														'constraints' => array(
																'id' => '\d+'
														)
												)
										),
										'add' => array(
												'type' => 'literal',
												'options' => array(
														'route'    => '/add',
														'defaults' => array(
																'controller' => 'Application\Controller\Usuario',
																'action'     => 'add'
														)
												)
										),
										'edit' => array(
												'type' => 'segment',
												'options' => array(
														'route'    => '/edit/:id',
														'defaults' => array(
																'controller' => 'Application\Controller\Usuario',
																'action'     => 'edit'
														),
														'constraints' => array(
																'id' => '\d+'
														)
												)
										),
										'edit-senha' => array(
												'type' => 'segment',
												'options' => array(
														'route'    => '/edit-senha/:id',
														'defaults' => array(
																'controller' => 'Application\Controller\Usuario',
																'action'     => 'edit-senha'
														),
														'constraints' => array(
																'id' => '\d+'
														)
												)
										),
										'edit-user' => array(
												'type' => 'segment',
												'options' => array(
														'route'    => '/edit-user/:id',
														'defaults' => array(
																'controller' => 'Application\Controller\Usuario',
																'action'     => 'edit-user'
														),
														'constraints' => array(
																'id' => '\d+'
														)
												)
										),
										'delete' => array(
												'type' => 'segment',
												'options' => array(
														'route'    => '/delete/:id',
														'defaults' => array(
																'controller' => 'Application\Controller\Usuario',
																'action'     => 'delete'
														),
														'constraints' => array(
																'id' => '\d+'
														)
												)
										),
								)
						),
						
						
						'login' => array(
								'type'    => 'segment',
								'options' => array(
										'route'    => '/login[/:action][/:id]',
										'constraints' => array(
												'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
												'id'     => '[0-9]+',
										),
										'defaults' => array(
												'controller' => 'Application\Controller\Login',
												'action'     => 'index',
										),
								),
						),
						
						'relatorios' => array(
								'type' => 'literal',
								'options' => array(
										'route'    => '/relatorios',
										'defaults' => array(
												'controller' => 'Application\Controller\Relatorios',
												'action'     => 'index',
										)
								),
								'may_terminate' => true,
								'child_routes'  => array(
										'detalhe' => array(
												'type' => 'segment',
												'options' => array(
														'route'    => '/:id',
														'defaults' => array(
																'action' => 'detalhe'
														),
														'constraints' => array(
																'id' => '\d+'
														)
												)
										),
										)),
						

						'alertas' => array(
								'type' => 'literal',
								'options' => array(
										'route'    => '/alertas',
										'defaults' => array(
												'controller' => 'Application\Controller\Alertas',
												'action'     => 'index',
										)
								),
								'may_terminate' => true,
								'child_routes'  => array(
										'projetos-cancelados' => array(
												'type' => 'segment',
												'options' => array(
														'route'    => '/:mes',
														'defaults' => array(
																'action' => 'projetos-cancelados'
														),
														'constraints' => array(
																'id' => '\d+'
														)
												)
										),
								),
							),
										
						
						
						/*
						 * 
						 * 'add' => array(
												'type' => 'literal',
												'options' => array(
														'route'    => '/add',
														'defaults' => array(
																'controller' => 'Application\Controller\Projeto',
																'action'     => 'add'
														)
												)
										),
						 */
						
						'application' => array(
								'type'    => 'Literal',
								'options' => array(
										'route'    => '/application',
										'defaults' => array(
												'__NAMESPACE__' => 'Application\Controller',
												'controller'    => 'Index',
												'action'        => 'index',
										),
								),
								'may_terminate' => true,
								'child_routes' => array(
										'default' => array(
												'type'    => 'Segment',
												'options' => array(
														'route'    => '/[:controller[/:action]]',
														'constraints' => array(
																'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
																'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
														),
														'defaults' => array(
														),
												),
										),
								),
						),
						
						'home' => array(
								'type' => 'Zend\Mvc\Router\Http\Literal',
								'options' => array(
										'route'    => '/',
										'defaults' => array(
												'controller' => 'Application\Controller\Index',
												'action'     => 'index',
										),
								),
						),
				)
		),
		
		/*
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /application/:controller/:action
            'application' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/application',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
        		
        		'projeto' => array(
        				'type'    => 'segment',
        				'options' => array(
        						'route'    => '/projeto[/:action][/:id]',
        						'constraints' => array(
        								'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
        								'id'     => '[0-9]+',
        						),
        						'defaults' => array(
        								'controller' => 'Application\Controller\Projeto',
        								'action'     => 'index',
        						),
        				),
        		),
        		
        		'login' => array(
        				'type'    => 'segment',
        				'options' => array(
        						'route'    => '/login[/:action][/:id]',
        						'constraints' => array(
        								'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
        								'id'     => '[0-9]+',
        						),
        						'defaults' => array(
        								'controller' => 'Application\Controller\Login',
        								'action'     => 'index',
        						),
        				),
        		),
        ),
    ),
		*/	
		
    'service_manager' => array(
		'invokables' => array(
				'Application\Service\AlertaService' => 'Application\Service\AlertaService'
		),
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'factories' => array(
            'translator' => 'Zend\Mvc\Service\TranslatorServiceFactory',
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Application\Controller\Index' => Controller\IndexController::class,
            'Application\Controller\Projeto' => Controller\ProjetoController::class,
            'Application\Controller\Login' => Controller\LoginController::class,
            'Application\Controller\Indicador' => Controller\IndicadorController::class,
            'Application\Controller\IndicadorProjeto' => Controller\IndicadorProjetoController::class,
            'Application\Controller\Usuario' => Controller\UsuarioController::class,
            'Application\Controller\TarefaProjeto' => Controller\TarefaProjetoController::class,
            'Application\Controller\MembroProjeto' => Controller\MembroProjetoController::class,
            'Application\Controller\AcompanhamentoProjeto' => Controller\AcompanhamentoProjetoController::class,
            'Application\Controller\Alertas' => Controller\AlertasController::class,
            'Application\Controller\PerfilAcesso' => Controller\PerfilAcessoController::class,
            'Application\Controller\Relatorios' => Controller\RelatoriosController::class
        ),

    	'factories' => array(
    			'Application\Controller\AlertasController' => 'Application\Factory\AlertaControllerFactory'
    	),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
);
