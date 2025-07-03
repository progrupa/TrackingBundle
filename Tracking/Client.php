<?php

namespace Progrupa\TrackingBundle\Tracking;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use JMS\Serializer\Exception\RuntimeException;
use JMS\Serializer\SerializerInterface;
use Psr\Log\LoggerInterface;

class Client
{
    /** @var  \GuzzleHttp\ClientInterface */
    private $http;
    /** @var  SerializerInterface */
    private $serializer;
    /** @var LoggerInterface */
    private $logger;

    /**
     * Client constructor.
     * @param \GuzzleHttp\ClientInterface $http
     * @param SerializerInterface $serializer
     */
    public function __construct(\GuzzleHttp\ClientInterface $http, SerializerInterface $serializer, LoggerInterface $logger)
    {
        $this->http = $http;
        $this->serializer = $serializer;
        $this->logger = $logger;
    }

    public function getUniversalTracker(string $identifier): ?Entry
    {
        try {
            $response = $this->http->request(
                'get',
                sprintf('pgut-get/%s', $identifier)
            );

            if ($response->getStatusCode() == 200) {
                $entry = $this->serializer->deserialize($response->getBody()->getContents(), Entry::class, 'json');

                return $entry;
            } else {    //  other codes mean no data
                return null;
            }
        } catch (\Throwable $re) {
            //  Log an error and keep going
            $this->logger->error(sprintf("Error loading tracking data: %s", $re->getMessage()));
        }
        return null;
    }

    public function getTrackerBatch(array $hashes): array
    {
        try {
            $response = $this->http->request(
                'post',
                'pgut-batch',
                [
                    'json' => $hashes,
                    'verify' => false   //  Disable SSL verification for local development
                ]
            );
            if ($response->getStatusCode() == 200) {
                return json_decode($response->getBody()->getContents(), true);
            } else {    //  other codes mean no data
                return [];
            }
        } catch (\Throwable $re) {
            //  Log an error and keep going
            $this->logger->error(sprintf("Error loading tracking data: %s", $re->getMessage()));
        }
        return [];
    }
}
