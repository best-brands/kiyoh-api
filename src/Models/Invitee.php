<?php

namespace BestBrands\KiyohClient\Models;

/**
 * Class Invitee
 * @package BestBrands\KiyohClient\Models
 *
 * @method string getInviteEmail()
 * @method self setInviteEmail(string $inviteEmail)
 * @method string getLocationId()
 * @method self setLocationId(string $locationId)
 * @method int getDelay()
 * @method self setDelay(int $delay)
 * @method string getFirstName()
 * @method self setFirstName(string $firstName)
 * @method string getLastName()
 * @method self setLastName(string $lastName)
 * @method string getRefCode()
 * @method self setRefCode(string $refCode)
 * @method string getLanguage()
 * @method self setLanguage(string $language)
 */
class Invitee extends AModel
{
    protected string $inviteEmail = '';

    protected string $locationId = '';

    protected int $delay = 0;

    protected string $firstName = '';

    protected string $lastName = '';

    protected string $refCode = '';

    protected string $language = '';

    public function __toArray()
    {
        return [
            'location_id'  => $this->getLocationId(),
            'invite_email' => $this->getInviteEmail(),
            'delay'        => $this->getDelay(),
            'first_name'   => $this->getFirstName(),
            'last_name'    => $this->getLastName(),
            'language'     => $this->getLanguage(),
            'ref_code'     => $this->getRefCode(),
        ];
    }
}