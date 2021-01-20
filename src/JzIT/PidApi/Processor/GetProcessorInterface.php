<?php

declare(strict_types=1);

namespace JzIT\PidApi\Processor;

use Psr\Http\Message\ServerRequestInterface;

interface GetProcessorInterface
{
    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     *
     * @return \JzIT\PidApi\Processor\GetProcessorInterface
     */
    public function process(ServerRequestInterface $request): GetProcessorInterface;

    /**
     * @return object
     */
    public function getResponse(): object;
}
