<?php

declare(strict_types=1);

namespace JzIT\PidApi\Controller;

use JzIT\PidApi\PidApiConstants;
use JzIT\PidApi\Processor\GetProcessorInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;
use Zend\Diactoros\Response\EmptyResponse;
use Zend\Diactoros\Response\JsonResponse;

class GetController
{
    /**
     * @var \JzIT\PidApi\Processor\GetProcessorInterface
     */
    protected $getProcessor;

    /**
     * @param \JzIT\PidApi\Processor\GetProcessorInterface $getProcessor
     */
    public function __construct(
        GetProcessorInterface $getProcessor
    ) {
        $this->getProcessor = $getProcessor;
    }

    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $this->getProcessor->process($request);
        } catch (Throwable $e) {
            return new JsonResponse($e->getMessage());
        }

        return new EmptyResponse(200);
    }

    /**
     * @return string
     */
    public function getRoute(): string
    {
        return PidApiConstants::ROUTE_PID_STATS;
    }
}
