<?php

namespace App\Close;

use GuzzleHttp\Client;

class CloseIO
{
    const API_URL = 'https://app.close.io/api/v1/';

    private $client;
    private $organizationId;
    private $errors;

    public function __construct($apiKey, $organizationId) {
        $this->organizationId = $organizationId;
        $this->client = new Client([
            'base_uri' => self::API_URL,
            'auth' => [$apiKey, ''],
            'headers'  => [
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    /**
     * Look up lead by email address.
     *
     * @param $query
     * @return Lead|null
     */
    public function findLead($query)
    {
        try {
            $response = $this->client->get('lead/', [
                'query' => [
                    'organization_id' => config('closeio.organization_id'),
                    'limit' => 1,
                    'query' => $query
                ]
            ]);

            $leadResults = json_decode($response->getBody()->getContents());
        } catch (\Exception $e) {
            $this->addError('Error trying to find lead.');
            return null;
        }

        // Check we have results.
        if ($leadResults->total_results == 0) {
            return null;
        }

        $lead = new Lead;
        $lead->fromArray($leadResults->data[0], false);
        return $lead;
    }

    /**
     * Add lead.
     *
     * @param $email
     * @return Lead|null
     */
    public function addLead($email)
    {
        $lead = new Lead();
        $lead->new($email);

        try {
            $response = $this->client->post('lead/', [
                'json' => $lead->toArray()
            ]);

            $leadResult = json_decode($response->getBody()->getContents());
        } catch(\Exception $e) {
            $this->addError('Unable to add new Lead.');
            return null;
        }

        if (empty($leadResult->id)) {
            return null;
        }

        $lead->fromArray($leadResult, true);

        return $lead;
    }

    /**
     * Add new lead if one does not exist.
     *
     * @param $email
     * @return Lead|null
     */
    public function findOrUpdateLead($email)
    {
        $lead = $this->findLead($email);

        if (! $lead) {
            $lead = $this->addLead($email);
        }

        return $lead;
    }

    /**
     * Has errors.
     *
     * @return bool
     */
    public function hasErrors()
    {
        return ! empty($this->errors);
    }

    /**
     * return list of errors.
     *
     * @return mixed
     */
    public function errors()
    {
        return $this->errors;
    }

    /**
     * Add an error message.
     *
     * @param $error
     */
    private function addError($error)
    {
        $this->errors[] = $error;
    }

}
