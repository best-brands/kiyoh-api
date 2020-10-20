<?php

namespace BestBrands\KiyohClient\Models;

use DateTime;

/**
 * Class ReducedReview
 * @package BestBrands\KiyohClient\Models
 *
 * @method string getTenantId()
 * @method self setTenantId(string $tenantId)
 * @method string getLocationId()
 * @method self setLocationId(string $locationId)
 * @method string getReviewId()
 * @method self setReviewId(string $reviewId)
 * @method DateTime|null getUpdatedSince()
 */
class ReducedReview extends AModel
{
    protected string $tenantId = '';

    protected string $locationId = '';

    protected string $reviewId = '';

    protected ?DateTime $updatedSince = null;

    public function setUpdatedSince($updatedSince): self
    {
        $this->updatedSince = $this->_parseDate($updatedSince);

        return $this;
    }
}