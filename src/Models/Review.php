<?php
/**********************************************************************************************************************
 * Any components or design related choices are copyright protected under international law. They are proprietary     *
 * code from Harm Smits and shall not be obtained, used or distributed without explicit permission from Harm Smits.   *
 * I grant you a non-commercial license via github when you download the product. Commercial licenses can be obtained *
 * by contacting me. For any legal inquiries, please contact me at <harmsmitsdev@gmail.com>                           *
 **********************************************************************************************************************/

namespace BestBrands\KiyohClient\Models;

use DateTime;

/**
 * Class Review
 * @package BestBrands\KiyohClient\Models
 *
 * @method string getReviewAuthor()
 * @method self setReviewAuthor(string $reviewAuthor)
 * @method string getCity()
 * @method self setCity(string $city)
 * @method int getRating()
 * @method self setRating(int $rating)
 * @method ReviewContentItem[] getReviewContent()
 * @method string getReviewComments()
 * @method self setReviewComments(string $reviewComments)
 * @method DateTime|null getDateSince()
 * @method DateTime|null getUpdatedSince()
 * @method string getReviewLanguage()
 * @method self setReviewLanguage(string $reviewLanguage)
 */
class Review extends ReducedReview
{
    protected string $reviewAuthor = '';

    protected string $city = '';

    protected int $rating = 0;

    /** @var ReviewContentItem[] */
    protected array $reviewContent = [];

    protected string $reviewComments = '';

    protected ?DateTime $dateSince = null;

    protected string $reviewLanguage = '';

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

    /**
     * @param array $reviewContent
     *
     * @return $this
     */
    public function setReviewContent(array $reviewContent): self
    {
        $this->_checkIfPureArray($reviewContent, ReviewContentItem::class);
        $this->reviewContent = $reviewContent;

        return $this;
    }
}