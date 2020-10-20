<?php

use BestBrands\KiyohClient\Client;
use BestBrands\KiyohClient\Exceptions\KiyohException;
use BestBrands\KiyohClient\Models\Invitee;

require "vendor/autoload.php";

$client = new Client(...);
$location_id = ...;
/**
 * Send an invite to a client
 */
try {
    if ($client->invite((new Invitee())
        ->setInviteEmail('harm@bestbrands.eu')
        ->setDelay(1)
        ->setFirstName('Harm')
        ->setLastName('Smits')
        ->setLocationId($location_id)
        ->setRefCode(...)
    )->getCode() === 'A') {
        echo 'Invite is scheduled';
    } else {
        echo 'Invite is not scheduled';
    }
} catch (KiyohException $exception) {
    echo 'Invite is not scheduled';
}

/**
 * Iterate over the reviews
 */
($date = new DateTime())->setDate(2020, 01, 01);
foreach ($client->getReviews($location_id, $date)->getReviews() as $review)
    echo "Review written by: " . $review->getReviewAuthor() . "\n";

/**
 * Get location statistics
 */
$stats = $client->getLocationStatistics($location_id);
echo "Average rating of last 12 months: " . $stats->getLast12MonthAverageRating() . "\n";
