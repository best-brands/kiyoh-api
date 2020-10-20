<?php

namespace BestBrands\KiyohClient\Models;

use DateTime;

/**
 * Class LocationStatistics
 *
 * @method string getLocationId()
 * @method self setLocationId(string $locationId)
 * @method string getUniqueId()
 * @method self setUniqueId(string $uniqueId)
 * @method string getCategoryName()
 * @method self setCategoryName(string $categoryName)
 * @method string getStreet()
 * @method self setStreet(string $street)
 * @method string getHouseNumber()
 * @method self setHouseNumber(string $houseNumber)
 * @method string getHouseNumberExtension()
 * @method self setHouseNumberExtension(string $houseNumberExtension)
 * @method string getPostCode()
 * @method self setPostCode(string $postcode)
 * @method string getCountry()
 * @method self setCountry(string $country)
 * @method float getAverageRating()
 * @method self setAverageRating(float $averageRating)
 * @method int getNumberReviews()
 * @method self setNumberReviews(int $numberReviews)
 * @method int getFiveStars()
 * @method self setFiveStars(int $fiveStars)
 * @method int getFourStars()
 * @method self setFourStars(int $fourStars)
 * @method int getThreeStars()
 * @method self setThreeStars(int $threeStars)
 * @method int getTwoStars()
 * @method self setTwoStars(int $twoStars)
 * @method int getOneStars()
 * @method self setOneStars(int $oneStars)
 * @method string getViewReviewUrl()
 * @method self setViewReviewUrl(string $viewReviewUrl)
 * @method string getCreateReviewUrl()
 * @method self setCreateReviewUrl(string $createReviewUrl)
 * @method string getCanonicalName()
 * @method self setCanonicalName(string $canonicalName)
 * @method string getLocationName()
 * @method self setLocationName(string $locationName)
 * @method DateTime|null getUpdatedSince()
 * @method DateTime|null getDateSince()
 * @method string getWebsite()
 * @method self setWebsite(string $website)
 */
class ReducedLocation extends AModel
{
    protected string $locationId = '';

    protected string $uniqueId = '';

    protected string $categoryName = '';

    protected string $street = '';

    protected string $houseNumber = '';

    protected string $houseNumberExtension = '';

    protected string $postCode = '';

    protected string $city = '';

    protected string $country = '';

    protected float $averageRating = 0;

    protected float $percentageRecommendation = 0;

    protected int $numberReviews = 0;

    protected int $fiveStars = 0;

    protected int $fourStars = 0;

    protected int $threeStars = 0;

    protected int $twoStars = 0;

    protected int $oneStars = 0;

    protected string $viewReviewUrl = '';

    protected string $createReviewUrl = '';

    protected string $canonicalName = '';

    protected string $locationName = '';

    protected ?DateTime $updatedSince = null;

    protected ?DateTime $dateSince = null;

    protected string $website = '';

    /**
     * @param $updatedSince
     *
     * @return ReducedLocation
     */
    public function setUpdatedSince($updatedSince): self
    {
        $this->updatedSince = $this->_parseDate($updatedSince);

        return $this;
    }

    /**
     * @param $dateSince
     *
     * @return $this
     */
    public function setDateSince($dateSince): self
    {
        $this->dateSince = $this->_parseDate($dateSince);

        return $this;
    }
}