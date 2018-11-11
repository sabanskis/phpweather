<?php

namespace Weather;

use Weather\Api\DataProvider;
use Weather\Api\DbRepository;
use Weather\Model\Weather;
use Weather\Api\GoogleApi;

class Manager
{
    /**
     * @var DataProvider
     */
    private $transporter;

    function __construct($transporter)
    {
        $this->transporter = $transporter;
    }

    public function getTodayInfo(): Weather
    {
        return $this->getTransporter()->selectByDate(new \DateTime());
    }

    public function getWeekInfo(): array
    {
        return $this->getTransporter()->selectByRange(new \DateTime(), new \DateTime('+7 days'));
    }

    private function getTransporter()
    {
        switch ($this->transporter) {
            case 'google-api':
                return $this->transporter = new GoogleApi();
                break;
            case 'json-db':
                return $this->transporter = new DbRepository('Weather');
                break;
        }
    }
}


