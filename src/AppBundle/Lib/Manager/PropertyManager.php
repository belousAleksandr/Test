<?php
namespace AppBundle\Lib\Manager;
use AppBundle\Exception\PropertyNotFound;
use Doctrine\ORM\EntityManager;
use ShopBundle\Entity\Property;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Created by PhpStorm.
 * User: belous
 * Date: 19.07.15
 * Time: 21:27
 */

class PropertyManager {

    /** @var ContainerInterface  */
    protected $container;

    /**
     * @param ContainerInterface $containerInterface
     */
    public function __construct(ContainerInterface $containerInterface){
        $this->container = $containerInterface;
    }

    /**
     * @param null $id
     * @return Property
     * @throws PropertyNotFound
     */
    public function getProperty($id = null) {
        $repository = $this->getPropertyRepository();

        //если id не задано то берем id из request
        if(is_null($id)){
            /** @var Request $request */
            $request = $this->get('request');
            $id = $request->get('_propertyId');
        }

        /** @var Property $property */
        $property = $repository->find($id);

        //если в базе нет property с таки id то выдаем Exception
        if(is_null($property)) {
            throw new PropertyNotFound('Property is not found.');
        }

        return $property;
    }

    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    public function getPropertyRepository (){
        return $this->getEntityManager()->getRepository(Property::REPOSITORY);
    }

    /**
     * Entity manager
     * @return EntityManager
     */
    protected function getEntityManager () {
        return $this->get('doctrine.orm.entity_manager');
    }

    /**
     * @param $serviceName
     * @return object
     */
    protected function get($serviceName) {
        return $this->container->get($serviceName);
    }

}