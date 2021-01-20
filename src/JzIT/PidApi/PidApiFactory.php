<?php

namespace JzIT\PidApi;

use JzIT\Kernel\AbstractFactory;
use JzIT\Pid\Business\PidFacade;
use JzIT\Pid\Business\PidFacadeInterface;
use JzIT\Pid\Persistence\PidRepository;
use JzIT\Pid\Persistence\PidRepositoryInterface;
use JzIT\Pid\PidConstants;
use JzIT\PidApi\Controller\GetController;
use JzIT\PidApi\Controller\PostController;
use JzIT\PidApi\Processor\GetProcessor;
use JzIT\PidApi\Processor\GetProcessorInterface;
use JzIT\PidApi\Processor\PostProcessor;
use JzIT\PidApi\Processor\PostProcessorInterface;
use JzIT\Serializer\SerializerConstants;

/**
 * Class PidFactory
 *
 * @package JzIT\Pid
 * @method \JzIT\PidApi\PidApiConfig getConfig()
 */
class PidApiFactory extends AbstractFactory
{
    /**
     * @return \JzIT\PidApi\Controller\PostController
     */
    public function createPostController(): PostController
    {
        return new PostController(
            $this->createPostProcessor()
        );
    }

    /**
     * @return \JzIT\PidApi\Controller\GetController
     */
    public function createGetController(): GetController
    {
        return new GetController(
            $this->createGetProcessor()
        );
    }

    /**
     * @return \JzIT\PidApi\Processor\PostProcessorInterface
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    protected function createPostProcessor(): PostProcessorInterface
    {
        return new PostProcessor(
            $this->container->get(SerializerConstants::CONTAINER_SERVICE_NAME),
            $this->container->get(PidConstants::FACADE)
        );
    }

    /**
     * @return \JzIT\PidApi\Processor\GetProcessorInterface
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    protected function createGetProcessor(): GetProcessorInterface
    {
        return new GetProcessor(
            $this->container->get(SerializerConstants::CONTAINER_SERVICE_NAME),
            $this->container->get(PidConstants::FACADE)
        );
    }
}
