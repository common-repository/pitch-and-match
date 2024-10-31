<?php

use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;

class PitchAndMatchApi {

    const SERVER = "https://www.pitchandmatch.com";

    const API = "/api/v1";

    const GRANT_TYPE = "http://www.pitchandmatch.com/grants/api_key";

    const CLIENT_ID = "1_4pq2fas7zgu8ggwwowook08wg8gsww484808gw8c0s004s88cw";

    const CLIENT_SECRET = "2cvbld7v9j0g80sw044gks8w8kkowcw8k0ko80c8sso4ko0ggg";

    const TOKEN = "/oauth/v2/token";

    const EVENTS = "events";

    const ATTENDEES = "attendees";

    const COMPANIES = "companies";

    const COUNTRIES = "countries";

    private $apiKey;

    private $client;

    private $token;

    /**
     * PitchAndMatchApi constructor.
     */
    public function __construct($apiKey) {

        $this->apiKey = $apiKey;

        $this->client = new Client([
            'base_uri' => self::SERVER,
            'timeout' => 10.0,
        ]);

        $this->token = $this->getToken();
    }

    /** Attendee by id
     * @param $id
     * @return object|null
     */
    public function getAttendee($id)
    {
        $result = $this->getArray(self::ATTENDEES, $id);
        return $result;
    }

    /** List the attendees of all your events
     * @return array
     */
    public function getAttendees()
    {
        return $this->getArray(self::ATTENDEES);
    }

    /** Company by id
     * @param $id
     * @return object|null
     */
    public function getCompany($id)
    {
        $result = $this->getArray(self::COMPANIES, $id);
        return $result;
    }

    /** List the companies of all your events
     * @return array
     */
    public function getCompanies()
    {
        return $this->getArray(self::COMPANIES);
    }

    /** Event by id
     * @param $id
     * @return object|null
     */
    public function getEvent($id)
    {
        $result = $this->getArray(self::EVENTS, $id);
        return $result;
    }

    /** List of all your events
     * @return array
     */
    public function getEvents()
    {
        return $this->getArray(self::EVENTS);
    }

    /** List all attendees of one of your events
     * @param $id (event id)
     * @return array
     */
    public function getEventAttendees($id)
    {
        return $this->getArray(self::EVENTS, $id, self::ATTENDEES);
    }

    /** List all companies of one of your events
     * @param $id (event id)
     * @return array
     */
    public function getEventCompanies($id)
    {
        return $this->getArray(self::EVENTS, $id, self::COMPANIES);
    }

    /** Returns json with OAuth session data
     * @return mixed
     */
    private function getToken()
    {
        $result = null;

        $jsonResponse = $this->getJson(self::TOKEN, array(
            'grant_type' => self::GRANT_TYPE,
            'client_id' => self::CLIENT_ID,
            'client_secret' => self::CLIENT_SECRET,
            'api_key' => $this->apiKey,
        ));

        if ($jsonResponse !== null) {

            $result = $jsonResponse->access_token;
        }

        return $result;
    }

    /** List of entities extracted from json response
     * @param $endpoint
     * @param null $params
     * @return array|object
     */
    private function getArray($primaryEntity, $id = null, $secondaryEntity = null) {

        $result = array();
        $endpoint = '/' . $primaryEntity;

        if ($id !== null) {
            $endpoint .= '/' . $id;

            if ($secondaryEntity !== null) {
                $endpoint .= '/' . $secondaryEntity;
            }
        }

        $jsonResponse = $this->getJson($endpoint);

        if ($jsonResponse !== null && $secondaryEntity !== null) {

            $result = $jsonResponse->{$secondaryEntity};
        }
        elseif ($jsonResponse !== null && $secondaryEntity === null) {
            $result = $jsonResponse->{$primaryEntity};
        }

        return $result;
    }

    /** Json structure retrieved from endpoint call
     * @param $endpoint
     * @param null $params
     * @return object
     */
    private function getJson($endpoint, $params = null) {

        $jsonResponse = null;
        $requestParams = array();

        if (isset($this->token) && $this->token !== null) {

            $endpoint = self::API . $endpoint;

            $requestParams['headers'] = [
                'Authorization' => 'Bearer ' . $this->token,
            ];
        }

        if ($params !== null) {

            $requestParams['query'] = $params;
        }

        try {

            $response = $this->client->get($endpoint, $requestParams);

            $jsonResponse = json_decode($response->getBody()->getContents());

        } catch (RequestException $e) {

            echo "<!-- PHPLOG RequestException: " . Psr7\str($e->getRequest()) . "-->";

            if ($e->hasResponse()) {

                echo "<!-- PHPLOG RequestException: " . Psr7\str($e->getResponse()) . "-->";
            }

            echo "<!-- PHPLOG Message: " . $e->getMessage() . "-->";
        }

        return $jsonResponse;
    }
}