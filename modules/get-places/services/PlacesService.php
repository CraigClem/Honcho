<?php
// used for our id from crafts cp 

namespace modules\getplaces\services;

use craft\base\Component;
use craft\helpers\App;
use craft\helpers\Json;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Subscriber\Oauth\Oauth1;
use modules\getplaces\Module;
use yii\base\Exception;

class PlacesService extends Component
{
    // Public Methods
    // =========================================================================

    /**
     * @param int $amount
     * @param mixed|null $fields
     * @param string $parameters
     * @return array
     * @throws Exception
     * @throws GuzzleException
     */

    //set arguments to accept as per honcho code challenge

// https://maps.googleapis.com/maps/api/place/details/json
// ?place_id=ChIJrTLr-GyuEmsRBfy61i59si0
//  &fields=address_components
//  &key=YOUR_API_KEY
//
    public function getPlaces(int $amount = 100, mixed $fields = null, string $parameters = ''): array
    {
        try {
            //https://developer.twitter.com/en/docs/twitter-api/data-dictionary/object-model/tweet
            // update end point
            $client = new Client([
                'base_uri' => 'https://api.twitter.com/2/',
                'handler' => $stack,
                'auth' => 'oauth',
            ]);

            $response = $client->get("users/{$userId}/tweets?max_results={$amount}&tweet.fields=entities{$fields}{$parameters}");

            return Json::decodeIfJson($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            \Craft::error($e->getMessage());
            return [];
        }
    }
}