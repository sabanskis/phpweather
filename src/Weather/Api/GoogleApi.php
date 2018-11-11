<?php

namespace Weather\Api;

use Weather\Model\NullWeather;
use Weather\Model\Weather;

class GoogleApi implements DataProvider
{

    public function selectByDate(\DateTime $date)
    {
        $day = $this->load(new NullWeather(), $date->format('Y-m-d'));
        return $day;
    }
    public function selectByRange(\DateTime $from, \DateTime $to): array
    {
        $i = $from;
        $i->modify('+1 day');
        $result = [];
        while($i < $to)
        {
            $result[] = $this->load(new NullWeather(), $i->format('Y-m-d'));
            $i->modify('+1 day');
        }
        return $result;
    }
    /**
     * @return Weather
     * @throws \Exception
     */
    public function getToday()
    {
        $today = $this->load(new NullWeather());
        $today->setDate(new \DateTime());

        return $today;
    }

    /**
     * @param Weather $before
     * @return Weather
     * @throws \Exception
     */
    private function load(Weather $before)
    {
        $now = new Weather();
        $base = $before->getDayTemp();
        $now->setDayTemp(random_int(5 - $base, 5 + $base));

        $base = $before->getNightTemp();
        $now->setNightTemp(random_int(-5 - abs($base), -5 + abs($base)));

        $now->setSky(random_int(1, 3));

        return $now;
    }
}
