<?php
namespace Application;

use Zend\Mvc\ModuleRouteListener;

class Module
{
    public function onBootstrap($event)
    {
        $application = $event->getApplication();
        $configuration = $application->getServiceManager()->get('Configuration');


        $event->getApplication()->getServiceManager()->get('translator');

        $eventManager = $event->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $eventManager->attach(\Zend\Mvc\MvcEvent::EVENT_DISPATCH_ERROR, array($this, 'onDispatchErrorLog'));

        // trigger login after authentication in zfc user event manager
        $zfcAuthEventManager = $event->getApplication()->getServiceManager()->get('ZfcUser\Authentication\Adapter\AdapterChain')->getEventManager();
        $zfcAuthEventManager->attach('authenticate', array($this, 'onDispatchAuthenticate'));

        // trigger logout
        $eventManager->attach(\Zend\Mvc\MvcEvent::EVENT_FINISH, array($this, 'onFinish'));

        // Session
        $this->onBootstrapSession($configuration['session']);
    }


    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }


    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }


     /**
     * On bootstrap create session
     *
     * @param array $configuration
     * @return void
     */
    public function onBootstrapSession($configuration)
    {
        $sessionConfig = new \Zend\Session\Config\SessionConfig();
        $sessionConfig->setOptions($configuration);

        $sessionManager = new \Zend\Session\SessionManager($sessionConfig);
        $sessionManager->start();
    }


    public function onDispatchErrorLog(\Zend\Mvc\MvcEvent $event)
    {
        if ($event->getError() === 'error-exception') {
            $exception = $event->getParam('exception');

            $event->getApplication()->getServiceManager()->get('Zend\Log\Logger')->crit($exception);
        }
    }


    public function onDispatchAuthenticate($event)
    {
        $authenticationRes = $event->getMessages();
        $authenticationMessage = strtolower(str_replace(' ', '', $authenticationRes[0]));
        if ($authenticationMessage === 'authenticationsuccessful.') {
            // add anything after autherntication

        }
    }


    public function onFinish(\Zend\Mvc\MvcEvent $event)
    {
        $app        = $event->getTarget();
        $match      = $app->getMvcEvent()->getRouteMatch();
        $controller = $match->getParam('controller');
        $action     = $match->getParam('action');

        if($controller == 'zfcuser' && ($action == 'logout')){
            //var_dump('logout');exit;
            //$session = new \Zend\Session\Container('***');
            //$session->getManager()->destroy();
        }
    }
}