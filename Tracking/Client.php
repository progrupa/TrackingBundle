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

    /**
     * @param $identifier
     * @return Entry|null
     */
    public function getUniversalTracker($identifier)
    {
        try {
            $response = $this->http->request(
                'get',
                sprintf('pgut/%s', $identifier)
            );

            if ($response->getStatusCode() == 200) {
                $entry = $this->serializer->deserialize($response->getBody()->getContents(), Entry::class, 'json');

                return $entry;
            }
        } catch (ClientException $ce) {
            if ($ce->getCode() == 404) {
                return null;    //  The info is just not there
            } else {
                //  Log an error and keep going
                $this->logger->error(sprintf("Error loading tracking data: %s", $ce->getMessage()));
            }
        } catch (RequestException $re) {
            //  Log an error and keep going
            $this->logger->error(sprintf("Error loading tracking data: %s", $re->getMessage()));
        } catch (RuntimeException $sre) {
            //  Log an error and keep going
            $this->logger->error(sprintf("Error loading tracking data: %s", $sre->getMessage()));
        }
        return null;
    }
}
