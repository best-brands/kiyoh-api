<?php
/**********************************************************************************************************************
 * Any components or design related choices are copyright protected under international law. They are proprietary     *
 * code from Harm Smits and shall not be obtained, used or distributed without explicit permission from Harm Smits.   *
 * I grant you a non-commercial license via github when you download the product. Commercial licenses can be obtained *
 * by contacting me. For any legal inquiries, please contact me at <harmsmitsdev@gmail.com>                           *
 **********************************************************************************************************************/

namespace BestBrands\KiyohClient\Models;

/**
 * Class Response
 * @package BestBrands\KiyohClient\Models
 *
 * @method string getCode()
 * @method self setCode(string $code)
 * @method string getMessage()
 * @method self setMessage(string $message)
 */
class Response extends AModel
{
    protected string $code = '';

    protected string $message = '';
}