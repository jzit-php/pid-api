<?php

declare(strict_types=1);

namespace JzIT\PidApi\Controller;

use JzIT\PidApi\PidApiConstants;
use JzIT\PidApi\Processor\PostProcessorInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;
use Zend\Diactoros\Response\EmptyResponse;
use Zend\Diactoros\Response\JsonResponse;

class PostController
{
    /**
     * @var \JzIT\PidApi\Processor\PostProcessorInterface
     */
    protected $postProcessor;

    /**
     * @param \JzIT\PidApi\Processor\PostProcessorInterface $postProcessor
     */
    public function __construct(
        PostProcessorInterface $postProcessor
    )
    {
        $this->postProcessor = $postProcessor;
    }

    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $this->postProcessor->process($request);
        } catch (Throwable $e) {
            return new JsonResponse(
                [
                    'message' => $e->getMessage(),
                    'trace' => $e->getTrace()
                ]
            );
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
