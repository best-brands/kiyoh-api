<?php
/**********************************************************************************************************************
 * Any components or design related choices are copyright protected under international law. They are proprietary     *
 * code from Harm Smits and shall not be obtained, used or distributed without explicit permission from Harm Smits.   *
 * I grant you a non-commercial license via github when you download the product. Commercial licenses can be obtained *
 * by contacting me. For any legal inquiries, please contact me at <harmsmitsdev@gmail.com>                           *
 **********************************************************************************************************************/

namespace BestBrands\KiyohClient\Models;

use BestBrands\KiyohClient\Exceptions\InvalidArgumentException;

/**
 * Class ReviewContentItem
 * @package BestBrands\KiyohClient\Models
 * @method string getQuestionGroup()
 * @method string getQuestionType()
 * @method string getRating()
 * @method self setRating(string $rating)
 * @method int getOrder()
 * @method self setOrder(int $order)
 * @method string getQuestionTranslation()
 * @method self setQuestionTranslation(string $questionTranslation)
 */
class ReviewContentItem extends AModel
{
    const QUESTION_GROUP_DEFAULT_OVERALL = 'DEFAULT_OVERALL';
    const QUESTION_GROUP_DEFAULT_OPINION = 'DEFAULT_OPINION';
    const QUESTION_GROUP_DEFAULT_ONELINER = 'DEFAULT_ONELINER';
    const QUESTION_GROUP_DEFAULT_RECOMMEND = 'DEFAULT_RECOMMEND';
    const QUESTION_GROUP_DEFAULT_CATEGORY = 'CATEGORY';
    const QUESTION_GROUP_CUSTOM = 'CUSTOM';

    const QUESTION_GROUPS = [
        self::QUESTION_GROUP_DEFAULT_OVERALL,
        self::QUESTION_GROUP_DEFAULT_OPINION,
        self::QUESTION_GROUP_DEFAULT_ONELINER,
        self::QUESTION_GROUP_DEFAULT_RECOMMEND,
        self::QUESTION_GROUP_DEFAULT_CATEGORY,
        self::QUESTION_GROUP_CUSTOM,
    ];

    const QUESTION_TYPE_INT = 'INT';
    const QUESTION_TYPE_TEXT = 'TEXT';
    const QUESTION_TYPE_BOOLEAN = 'BOOLEAN';
    const QUESTION_TYPE_SELECT = 'SELECT';

    const QUESTION_TYPES = [
        self::QUESTION_TYPE_INT,
        self::QUESTION_TYPE_TEXT,
        self::QUESTION_TYPE_BOOLEAN,
        self::QUESTION_TYPE_SELECT,
    ];

    protected string $questionGroup = 'DEFAULT_OVERALL';

    protected string $questionType = '';

    protected string $rating = '';

    protected int $order = 0;

    protected string $questionTranslation = '';

    public function setQuestionType(string $questionType): self
    {
        if (!in_array($questionType, self::QUESTION_TYPES))
            throw new InvalidArgumentException("Undefined question type");

        $this->questionType = $questionType;

        return $this;
    }

    public function setQuestionGroup(string $questionGroup): self
    {
        if (!in_array($questionGroup, self::QUESTION_GROUPS))
            throw new InvalidArgumentException("Undefined question group");

        $this->questionGroup = $questionGroup;

        return $this;
    }
}