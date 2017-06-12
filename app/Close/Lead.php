<?php

namespace App\Close;

class Lead
{
    const DEFAULT_STATUS_ID = 'stat_yE4J4QxxowV6IKNI931O7RrbtTn3iQtYwS9u52l4D2P';

    private $data;
    private $isNew;

    /**
     * Make new lead with default data.
     *
     * @param $email
     */
    public function new($email)
    {
        $this->data = [
            'name'          => 'Example Lead',
            'url'           => 'www.tepilo.com',
            'description'   => '',
            'status_id'     => self::DEFAULT_STATUS_ID,
            'contacts'      => [
                [
                    'name' => 'Example',
                    'emails' => [
                        [
                            'type' => 'office',
                            'email' => $email,
                        ]
                    ],
                    'phones' => [
                        [
                            'type' => 'office',
                            'phone' => '012345123123',
                        ]
                    ],
                ],
            ],
        ];
    }

    /**
     * Set data from an array.
     *
     * @param $data
     * @param $isNew
     */
    public function fromArray($data, $isNew)
    {
        $this->data = $data;
        $this->isNew = $isNew;
    }


    /**
     * @return mixed
     */
    public function toArray()
    {
        return $this->data;
    }

    /**
     * Get Id if set.
     *
     * @return null
     */
    public function getId()
    {
        // Check id is set first.
        if(empty($this->data['id'])){
            return null;
        }

        return $this->data['id'];
    }

    /**
     * Check if new lead.
     *
     * @return mixed
     */
    public function isNew()
    {
        return $this->isNew;
    }

}
