<?php
namespace Application;

use Application\Model\Wepon;
use Application\Model\WeponsTable;
use Application\Model\Type;
use Application\Model\TypesTable;
use Application\Model\Skill;
use Application\Model\SkillsTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module{
  public function onBootstrap(MvcEvent $e){
    $eventManager        = $e->getApplication()->getEventManager();
    $moduleRouteListener = new ModuleRouteListener();
    $moduleRouteListener->attach($eventManager);
  }

  public function getConfig(){
    return include __DIR__ . '/config/module.config.php';
  }

  public function getAutoloaderConfig(){
    return array(
      'Zend\Loader\StandardAutoloader' => array(
        'namespaces' => array(
          __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
        ),
      ),
    );
  }

  public function getServiceConfig(){
    return array(
      'factories' => array(
        'Application\Model\WeponsTable' =>  function($sm) {
          $weponGateway = $sm->get('ApplicationWeponGateway');
          $wepon = new WeponsTable($weponGateway);
          return $wepon;
        },
        'ApplicationWeponGateway' => function ($sm) {
          $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
          $resultSetPrototype = new ResultSet();
          $resultSetPrototype->setArrayObjectPrototype(new Wepon());
          return new TableGateway('wepons', $dbAdapter, null, $resultSetPrototype);
        },

        'Application\Model\TypesTable' =>  function($sm) {
          $typeGateway = $sm->get('ApplicationTypeGateway');
          $type = new TypesTable($typeGateway);
          return $type;
        },
        'ApplicationTypeGateway' => function ($sm) {
          $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
          $resultSetPrototype = new ResultSet();
          $resultSetPrototype->setArrayObjectPrototype(new Type());
          return new TableGateway('types', $dbAdapter, null, $resultSetPrototype);
        },

        'Application\Model\SkillsTable' =>  function($sm) {
          $skillGateway = $sm->get('ApplicationSkillGateway');
          $skill = new SkillsTable($skillGateway);
          return $skill;
        },
        'ApplicationSkillGateway' => function ($sm) {
          $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
          $resultSetPrototype = new ResultSet();
          $resultSetPrototype->setArrayObjectPrototype(new Skill());
          return new TableGateway('skills', $dbAdapter, null, $resultSetPrototype);
        },
      ),
    );
  }
}
