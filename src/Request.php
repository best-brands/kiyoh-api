<?php

namespace BestBrands\KiyohClient;

use BestBrands\KiyohClient\Models\Invitee;
use DateTime;
use GuzzleHttp\RequestOptions;

/**
 * Class Request
 * @package BestBrands\KiyohClient
 */
class Request
{
    /** @var string[] the base headers to use */
    protected array $headers = [
        'Accept'       => 'application/json',
        'Content-Type' => 'application/json',
    ];

    /**
     * This operation will get the locations statistics that have reviews added since a certain date, or will get
     * locations which are updated since a certain date. This operation is categorized as an HTTP GET operation.
     *
     * @param DateTime $since
     * @param DateTime|null $updated_since
     * @param array $params
     * @return array
     */
    public function getLatestStatistics(DateTime $since, ?DateTime $updated_since = null, array $params = []): array
    {
        $url = '/v1/publication/review/locations/latest';
        $data = [
            RequestOptions::HEADERS => $this->headers,
            RequestOptions::QUERY   => array_merge(
                $params,
                [
                    'dateSince'    => $since->format(DATE_ATOM),
                    'updatedSince' => ($updated_since ? $updated_since : $since)->format(DATE_ATOM),
                ]
            ),
        ];
        $response = [
            200 => [
                '$type' => 'OBJ_ARRAY',
                '$ref' => 'BestBrands\\KiyohClient\\Models\\ReducedLocation',
            ],
        ];

        return ['get', $url, $data, $response];
    }

    /**
     * This operation will get the reviews for external reviews.
     *
     * @param string $locationId
     * @param array $params
     *
     * The additional parameters can include the following:
     * ```php
     * $params = [
     *     'reviewId' => 1,
     *     'orderBy'  => 'CREATE_DATE' | 'UPDATE_DATE' | 'RATING',
     *     'sortOrder' => 'ASC' | 'DESC',
     *     'limit'     => 10,
     * ];
     * ```
     *
     * @return array
     */
    public function getReviews(string $locationId, array $params = []): array
    {
        $url = '/v1/publication/review/external';
        $data = [
            RequestOptions::HEADERS => $this->headers,
            RequestOptions::QUERY   => array_merge(
                array_map(
                    fn($item) => $item instanceof DateTime
                        ? $item->format(DATE_ATOM)
                        : $item,
                    $params
                ),
                [
                    'locationId' => $locationId,
                    'tenantId'   => 98,
                ]
            ),
        ];
        $response = [
            200 => [
                '$type' => 'OBJ',
                '$ref' => 'BestBrands\\KiyohClient\\Models\\Location',
                'reviews' => [
                    '$type' => 'OBJ_ARRAY',
                    '$ref' => 'BestBrands\\KiyohClient\\Models\\Review',
                    'reviewContent' => [
                        '$type' => 'OBJ_ARRAY',
                        '$ref' => 'BestBrands\\KiyohClient\\Models\\ReviewContentItem',
                    ],
                ],
            ],
        ];

        return ['get', $url, $data, $response];
    }

    /**
     * This operation will get the reviews that have been removed since a certain date. This operation is categorized as
     * an HTTP GET operation.
     *
     * @param DateTime $updatedSince
     *
     * @return array
     */
    public function getLastRemovedReview(DateTime $updatedSince): array
    {
        $url = '/v1/publication/review/removed/latest/';
        $data = [
            RequestOptions::HEADERS => $this->headers,
            RequestOptions::QUERY   => [
                'updatedSince' => $updatedSince->format(DATE_ATOM),
            ],
        ];
        $response = [];

        return ['get', $url, $data, $response];
    }

    /**
     * This operation is used to get the average scores of rating question of a location.
     *
     * @param string $locationId The account id for which the statistics are requested
     *
     * @return array
     */
    public function getLocationStatistics(string $locationId): array
    {
        $url = '/v1/publication/review/external/location/statistics';
        $data = [
            RequestOptions::HEADERS => $this->headers,
            RequestOptions::QUERY   => [
                'locationId' => $locationId,
            ],
        ];
        $response = [
            200 => [
                '$type' => 'OBJ',
                '$ref' => 'BestBrands\\KiyohClient\\Models\\LocationStatistics',
            ],
        ];

        return ['get', $url, $data, $response];
    }

    /**
     * Send an invite
     *
     * @param Invitee $invitee
     *
     * @return array
     */
    public function invite(Invitee $invitee): array
    {
        $url = '/v1/invite/external';
        $data = [
            RequestOptions::HEADERS => $this->headers,
            RequestOptions::JSON    => $invitee->__toArray(),
        ];
        $response = [
            200 => [
                '$type' => 'OBJ',
                '$ref' => 'BestBrands\\KiyohClient\\Models\\Response',
            ],
        ];

        return ['post', $url, $data, $response];
    }
}