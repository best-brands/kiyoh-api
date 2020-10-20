<?php

namespace BestBrands\KiyohClient;

use BestBrands\KiyohClient\Exceptions\KiyohException;
use BestBrands\KiyohClient\Exceptions\Notice;
use BestBrands\KiyohClient\Models\Invitee;
use BestBrands\KiyohClient\Models\Location;
use BestBrands\KiyohClient\Models\LocationStatistics;
use BestBrands\KiyohClient\Models\ReducedLocation;
use BestBrands\KiyohClient\Models\Response;
use Closure;
use DateTime;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Promise\Promise;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Promise\Utils;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Throwable;

/**
 * Class Client
 * @package BestBrands\KiyohClient
 *
 * @method ReducedLocation[] getLatestStatistics(DateTime $since, ?DateTime $updated_since = null, int $limit = 50)
 * @method PromiseInterface getLatestStatisticsAsync(DateTime $since, ?DateTime $updated_since = null, int $limit = 50)
 * @method Location getReviews(string $locationId, DateTime $since, array $params = [])
 * @method PromiseInterface getReviewsAsync(string $locationId, DateTime $since, array $params = [])
 * @method string getLastRemovedReview(DateTime $updatedSince)
 * @method PromiseInterface getLastRemovedReviewAsync(DateTime $updatedSince)
 * @method LocationStatistics getLocationStatistics(string $locationId)
 * @method PromiseInterface getLocationStatisticsAsync(string $locationId)
 * @method Response invite(Invitee $invitee)
 * @method PromiseInterface inviteAsync(Invitee $invitee)
 */
class Client
{
    /** @var string base url */
    const API_URL_KIYOH_COM = 'https://www.kiyoh.com/';

    /** @var string base url */
    const API_URL_KLANTEN_VERTELLEN = 'https://www.klantenvertellen.nl';

    /** @var string[] all the base urls that are allowed */
    private const BASE_URLS = [
        self::API_URL_KIYOH_COM,
        self::API_URL_KLANTEN_VERTELLEN,
    ];

    /** @var \GuzzleHttp\Client */
    protected \GuzzleHttp\Client $client;

    /** @var Request request dispatcher */
    protected Request $request;

    /** @var Populator */
    protected Populator $populator;

    /** @var string holds the current API client id */
    protected string $token;

    /** @var string holds the base url for the api requests */
    protected string $baseUrl;

    /**
     * Client constructor.
     *
     * @param string $token
     * @param string $base_url
     * @throws Notice
     */
    public function __construct(string $token, string $base_url = self::API_URL_KIYOH_COM)
    {
        $stack = HandlerStack::create();
        $stack->push(Middleware::mapRequest($this->getRequestHandler()));
        $stack->push(Middleware::retry($this->getRetryHandler()));

        if (!in_array(($this->baseUrl = $base_url), self::BASE_URLS))
            throw new Notice('Unrecognized base url');

        $this->token = $token;
        $this->client = new \GuzzleHttp\Client([
            'handler'  => $stack,
            'base_uri' => $this->baseUrl,
            'timeout'  => 1
        ]);
        $this->request = new Request();
        $this->populator = new Populator();
    }

    /**
     * Unwrap an array of async requests, very useful when stacking multiple
     *
     * @param array $promises
     *
     * @return array
     * @throws Throwable
     */
    public function unwrap(array $promises)
    {
        return Utils::unwrap($promises);
    }

    /**
     * Get the retry handler
     *
     * @return Closure
     */
    private function getRetryHandler()
    {
        return function ($retries, ?RequestInterface $request, ?ResponseInterface $response, ?RequestException $exception) {
            if ($response && $response->getStatusCode() !== 200)
                throw new KiyohException(json_decode($response->getBody(), true));

            return false;
        };
    }

    /**
     * Get the request handler
     *
     * @return Closure
     */
    private function getRequestHandler()
    {
        return function (RequestInterface $request) {
            return $request->withHeader('X-Publication-Api-Token', $this->token);
        };
    }

    /**
     * Dispatch the request. This is some serious sorcery not to be touched.
     *
     * @param string $method
     * @param array $args
     *
     * @return array|string|Promise
     * @throws GuzzleException|KiyohException
     */
    public function __call(string $method, array $args)
    {
        if ($async = (substr($method, -5) === 'Async'))
            $method = substr($method, 0, -5);

        [$method, $url, $data, $response] = call_user_func_array([$this->request, $method], $args);

        return ($async)
            ? $this->handleAsyncRequest($method, $url, $data, $response)
            : $this->handleRequest($method, $url, $data, $response);
    }

    /**
     * Handle a non-blocking request
     *
     * @param $method
     * @param $url
     * @param $data
     * @param $responseFormat
     *
     * @return PromiseInterface
     */
    private function handleAsyncRequest($method, $url, $data, array $responseFormat): PromiseInterface
    {
        return $this->client->requestAsync($method, $url, $data)
            ->then(function (ResponseInterface $response) use (&$responseFormat) {
                return $this->handleResponse($response, $responseFormat);
            });
    }

    /**
     * Handle a blocking request
     *
     * @param string $method
     * @param string $url
     * @param array $data
     * @param array $responseFormat
     *
     * @return array|mixed|StreamInterface
     * @throws GuzzleException|KiyohException
     */
    private function handleRequest(string $method, string $url, array $data, array $responseFormat)
    {
        try {
            $result = $this->client->request($method, $url, $data);
        } catch (RequestException $exception) {
            return $this->handleResponse($exception->getResponse(), $responseFormat);
        }

        return $this->handleResponse($result, $responseFormat);
    }

    /**
     * Handle the response accordingly
     *
     * @param ResponseInterface $response
     * @param array $responseFormat
     *
     * @return array|mixed|StreamInterface
     * @throws KiyohException
     */
    private function handleResponse(ResponseInterface $response, array $responseFormat)
    {
        if ($response->getStatusCode() !== 200) {
            throw new KiyohException(json_decode($response->getBody(), true));
        } else if ($responseFormat && isset($responseFormat[$response->getStatusCode()])) {
            return $this->populator->populate(
                $responseFormat[$response->getStatusCode()],
                json_decode($response->getBody(), true)
            );
        }

        return $response->getBody();
    }
}