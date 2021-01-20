<?php

declare(strict_types=1);

namespace JzIT\PidApi\Processor;

use Psr\Http\Message\ServerRequestInterface;

interface PostProcessorInterface
{
    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     *
     * @return \JzIT\PidApi\Processor\PostProcessorInterface
     */
    public function process(ServerRequestInterface $request): PostProcessorInterface;
}
