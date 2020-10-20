<?php

namespace BestBrands\KiyohClient\Models;

/**
 * Class LocationStatistics
 * @package BestBrands\KiyohClient\Models
 *
 * @method string getLocationId()
 * @method self setLocationId(string $locationId)
 * @method float getAverageRating()
 * @method self setAverageRating(float $averageRating)
 * @method int getNumberReviews()
 * @method self setNumberReviews(int $numberReviews)
 * @method int getRecommendation()
 * @method self setRecommendation(int $recommendation)
 * @method float getLast12MonthAverageRating()
 * @method self setLast12MonthAverageRating(float $last12MonthAverageRating)
 * @method int getLast12MonthRecommendation()
 * @method self setLast12MonthRecommendation(int $last12MonthRecommendation)
 * @method int getLast12MonthNumberReviews()
 * @method self setLast12MonthNumberReviews(int $last12MonthNumberReviews)
 * @method string getLocationName()
 * @method self setLocationName(string $locationName)
 * @method bool getLocationActive()
 * @method self setLocationActive(bool $locationActive)
 * @method string getViewReviewUrl()
 * @method self setViewReviewUrl(string $viewReviewUrl)
 * @method string getCreateReviewUrl()
 * @method self setCreateReviewUrl(string $createReviewUrl)
 */
class LocationStatistics extends AModel
{
    protected string $locationId;

    protected float $averageRating = 0;

    protected int $numberReviews = 0;

    protected int $recommendation = 0;

    protected float $last12MonthAverageRating = 0;

    protected int $last12MonthRecommendation = 0;

    protected int $last12MonthNumberReviews = 0;

    protected string $locationName = '';

    protected bool $locationActive = false;

    protected string $viewReviewUrl = '';

    protected string $createReviewUrl = '';
}
