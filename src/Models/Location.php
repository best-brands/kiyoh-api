<?php

namespace BestBrands\KiyohClient\Models;

/**
 * Class Location
 * @package BestBrands\KiyohClient\Models
 *
 * @method float getLast12MonthAverageRating()
 * @method self setLast12MonthAverageRating(float $last12MonthAverageRating)
 * @method int getLast12MonthNumberReviews()
 * @method self setLast12MonthNumberReviews(int $last12MonthNumberReviews)
 * @method float getLast12MonthPercentageRecommendation()
 * @method self setLast12MonthPercentageRecommendation(float $last12MonthPercentageRecommendation)
 * @method Review[] getReviews()
 */
class Location extends ReducedLocation
{
    protected float $last12MonthAverageRating = 0;

    protected int $last12MonthNumberReviews = 0;

    protected float $last12MonthPercentageRecommendation = 0;

    /** @var Review[] */
    protected array $reviews = [];

    /**
     * Set the reviews
     *
     * @param Review[] $reviews
     *
     * @return Location
     */
    public function setReviews(array $reviews): self
    {
        $this->_checkIfPureArray($reviews, Review::class);
        $this->reviews = $reviews;

        return $this;
    }
}