<?php
/**
 * Created by PhpStorm.
 * User: belous
 * Date: 09.07.15
 * Time: 21:19
 */
namespace ShopBundle\Listener;

use ShopBundle\Entity\Property;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RequestContextAwareInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\SecurityContext;

/**
 * Устанавливает роутам значение _propertyId и проверяет имеет ли пользователь право дуступа к информации данного отеля
 * Class PropertyIdListener
 * @package AMK\BookingBundle\Listener
 */
class PropertyIdListener implements EventSubscriberInterface
{
    /** @var RequestContextAwareInterface  */
    private $router;

    /** @var SecurityContext  */
    private $context;

    /**
     * @param RequestContextAwareInterface $router
     * @param SecurityContext $oSecurityContext
     */
    public function __construct(RequestContextAwareInterface $router = null, SecurityContext $oSecurityContext = null)
    {
        $this->router = $router;
        $this->context = $oSecurityContext;
    }

    /**
     * @param Request $request
     */
    public function setRequest(Request $request = null )
    {
        if (null === $request) {
            return;
        }

        if (null !== $this->router) {
            $propertyId = $request->attributes->get('_propertyId') ? : 0;
            $this->router->getContext()->setParameter('_propertyId', (int)$propertyId);
        }
    }

    /**
     * @param FilterControllerEvent $event
     * @throws AccessDeniedException
     */
    public function security(FilterControllerEvent $event) {
        $request = $event->getRequest();
        $propertyId = $request->attributes->get('_propertyId');

        //проверяем имеет ли пользователь доступ к данноу отелю
        if($propertyId and !$this->isGranted($propertyId)) {
            throw new AccessDeniedException();
        }
    }

    /**
     * Проверяет имеет ли пользователь доступ к данному отелю
     * @param $propertyId
     * @return bool
     */
    private function isGranted($propertyId) {

        $token = $this->context->getToken();
        /** @var User $user */
        $user = $token->getUser();

        $userHotels = $user->getHotels()->filter(function($property) use ($propertyId) {
            /** @var Property $property */
            return $property->getId() == (int) $propertyId;
        });

        if(count($userHotels) == 0) {
            return false;
        }

        return true;
    }

    /**
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        $this->setRequest($request);
    }

    public static function getSubscribedEvents()
    {
        return array(
            // must be registered after the Router to have access to the _locale
            KernelEvents::REQUEST => array(array('onKernelRequest', 16)),
            KernelEvents::CONTROLLER => array(array('security', 16)),
        );
    }
}