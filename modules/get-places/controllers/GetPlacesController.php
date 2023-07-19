<?php

// this is to used for our search term

namespace modules\controllers;

use Craft;
use craft\web\Controller;
use craft\helpers\App;

class GetPlacesController extends Controller
{

    // Protected Properties
    // =========================================================================

    protected $allowAnonymous = [
        'get-places',
        'get-place-detail',
    ];

    // Public Methods
    // =========================================================================

    /**
     * @return Response
     */
    // get the cur­rent CSRF token to val­i­date POST request submissions
    public function actionGetPlaces() {

        $this->requirePostRequest();

        $base_url = 'https://maps.googleapis.com/maps/api/place/autocomplete/json';

        $key = App::env('GOOGLE_API_KEY');
        $input = Craft::$app->getRequest()->getBodyParam('input');
        // $components = Craft::$app->getRequest()->getBodyParam('components');

        $headers = [
            'query' => [
                'key' => $key,
                'input' => $input,
                'components' => $components,
            ]
        ];

        $client = new \GuzzleHttp\Client();

        try {

            $response = $client->request('GET', $base_url, $headers);
            $data = $response->getBody();

            // return $response->getBody();
            return $this->renderTemplate('../templates/index.twig', ['placesData' => $data]);
        
        } catch (\Exception $e) {

            return $this->asJson([
                'error' => true,
                'reason' => $e->getMessage()
            ]);

        }

    }

    public function actionGetPlaceDetail() {

        $this->requirePostRequest();

        $base_url = 'https://maps.googleapis.com/maps/api/place/details/json';
        
        $key = App::env('GOOGLE_API_KEY');
        $placeId = Craft::$app->getRequest()->getBodyParam('place_id');

        $headers = [
            'query' => [
                'key' => $key,
                'place_id' => $placeId,
            ]
        ];

        $client = new \GuzzleHttp\Client();

        try {

            $response = $client->request('GET', $base_url, $headers);

            return $response->getBody();
        
        } catch (\Exception $e) {

            return $this->asJson([
                'error' => true,
                'reason' => $e->getMessage()
            ]);

        }

    }

}