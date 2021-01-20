<?php

declare(strict_types=1);

namespace JzIT\PidApi\Processor;

use JzIT\Pid\Business\PidFacadeInterface;
use JzIT\Serializer\Wrapper\SerializerInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetProcessor implements GetProcessorInterface
{
    /**
     * @var object
     */
    protected $response;

    /**
     * @var \JzIT\Serializer\Wrapper\SerializerInterface
     */
    protected $serializer;

    /**
     * @var \JzIT\Pid\Business\PidFacadeInterface
     */
    protected $pidFacade;

    /**
     * PostProcessor constructor.
     *
     * @param \JzIT\Serializer\Wrapper\SerializerInterface $serializer
     * @param \JzIT\Pid\Business\PidFacadeInterface $pidFacade
     */
    public function __construct(SerializerInterface $serializer, PidFacadeInterface $pidFacade)
    {
        $this->serializer = $serializer;
        $this->pidFacade = $pidFacade;
    }

    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     *
     * @return \JzIT\PidApi\Processor\GetProcessorInterface
     */
    public function process(ServerRequestInterface $request): GetProcessorInterface
    {
        $json = $request->getBody()->getContents();



        return $this;
    }

    /**
     * @return object
     */
    public function getResponse(): object
    {
        return $this->response;
    }
}
