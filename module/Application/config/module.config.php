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
												'type' => 'literal',
												'options' => array(
														'route'    => '/add',
														'defaults' => array(
																'controller' => 'Application\Controller\IndicadorProjeto',
																'action'     => 'add'
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
														'route'    => '/edit/:id',
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
														'route'    => '/delete/:id',
														'defaults' => array(
																'controller' => 'Application\Controller\IndicadorProjeto',
																'action'     => 'delete'
														),
														'constraints' => array(
																'id' => '\d+'
														)
												)
										),
								)
						),
						
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
            'Application\Controller\IndicadorProjeto' => Controller\IndicadorProjetoController::class
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
