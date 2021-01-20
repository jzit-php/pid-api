<?php

declare(strict_types=1);

namespace JzIT\PidApi\Processor;

use Generated\Transfer\Pid\PidMachineTransfer;
use Generated\Transfer\Pid\PidStatsRequestTransfer;
use Generated\Transfer\Pid\PidStatsTransfer;
use Generated\Transfer\Pid\PidUserTransfer;
use JzIT\Pid\Business\PidFacadeInterface;
use JzIT\Serializer\Wrapper\SerializerInterface;
use Psr\Http\Message\ServerRequestInterface;

class PostProcessor implements PostProcessorInterface
{
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
     * @return \JzIT\PidApi\Processor\PostProcessorInterface
     */
    public function process(ServerRequestInterface $request): PostProcessorInterface
    {
        $json = $request->getBody()->getContents();

        $transfer = $this->serializer->deserialize((string)$json, PidStatsRequestTransfer::class, 'json');

        if (($transfer instanceof PidStatsRequestTransfer) === false) {
            throw new \Exception(sprintf('No valid post request!'));
        }

        //ToDo: extract and create Mapper
        $pidStats = new PidStatsTransfer();
        $user = new PidUserTransfer();
        $machine = new PidMachineTransfer();

        $machine
            ->setName($transfer->getMaschine())
            ->setModel($transfer->getModel());

        $user
            ->setName($transfer->getUser())
            ->setMachine($machine)
            ->setHash($transfer->getHash());

        $data = $transfer->getData();
        $pidStats
            ->setUser($user)
            ->setMachine($machine)
            ->setOutput((float)$data->getOutput())
            ->setSollTemp((float)$data->getSollTemp())
            ->setKi((float)$data->getKi())
            ->setKd((float)$data->getKd())
            ->setTemp((float)$data->getTemp())
            ->setKp((float)$data->getKp());

        $this->pidFacade->writePidStat($pidStats);

        return $this;
    }
}
