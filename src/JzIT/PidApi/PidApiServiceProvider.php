<?php

declare(strict_types=1);

namespace JzIT\PidApi;

use Http\Factory\Diactoros\ResponseFactory;
use Di\Container;
use JzIT\Container\ServiceProvider\AbstractServiceProvider;
use JzIT\Container\ServiceProvider\ServiceProviderInterface;
use JzIT\Http\HttpConstants;
use JzIT\PidApi\Controller\PostController;
use JzIT\PidApi\Processor\PostProcessor;
use JzIT\PidApi\Processor\PostProcessorInterface;
use League\Route\Router;
use League\Route\Strategy\JsonStrategy;
use League\Route\Strategy\StrategyInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Zend\Diactoros\ServerRequestFactory;
use Zend\HttpHandlerRunner\Emitter\SapiStreamEmitter;

/**
 * Class PidApiServiceProvider
 *
 * @package JzIT\PidApi
 * @method \JzIT\PidApi\PidApiFactory getFactory()
 */
class PidApiServiceProvider extends AbstractServiceProvider
{
    /**
     * @param \Di\Container $container
     */
    public function register(Container $container): void
    {
        $this->addPostController($container);
//        $this->addGetController($container);
    }

    /**
     * @param \Di\Container $container
     *
     * @return \JzIT\Container\ServiceProvider\ServiceProviderInterface
     */
    protected function addPostController(Container $container): ServiceProviderInterface
    {
        $self = $this;
        $router = $container->get(HttpConstants::SERVICE_NAME_ROUTER);

        $container->set(HttpConstants::SERVICE_NAME_ROUTER, function () use ($self, $router) {
            $postController = $self->getFactory()->createPostController();
            $router->map(HttpConstants::POST, $postController->getRoute(), $postController);

            return $router;
        });
        return $this;
    }

    /**
     * @param \Di\Container $container
     *
     * @return \JzIT\Container\ServiceProvider\ServiceProviderInterface
     */
    protected function addGetController(Container $container): ServiceProviderInterface
    {
        $self = $this;
        $router = $container->get(HttpConstants::SERVICE_NAME_ROUTER);

        $container->set(HttpConstants::SERVICE_NAME_ROUTER, function () use ($self, $router) {
            $getController = $self->getFactory()->createGetController();

            $router->map(HttpConstants::GET, $getController->getRoute(), $getController);

            return $router;
        });

        return $this;
    }
}
