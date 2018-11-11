<?php

namespace Weather\Controller;

use Weather\Manager;
use Weather\Model\NullWeather;

class StartPage
{
    public function getTodayWeather($db): array
    {
        try {
            $service = new Manager($db);
            $weather = $service->getTodayInfo();
        } catch (\Exception $exp) {
            $weather = new NullWeather();
        }

        return ['template' => 'today-weather.twig', 'context' => ['weather' => $weather]];
    }

    public function getWeekWeather($db): array
    {
        try {
            $service = new Manager($db);
            $weathers = $service->getWeekInfo();
        } catch (\Exception $exp) {
            $weathers = [];
        }

        return ['template' => 'range-weather.twig', 'context' => ['weathers' => $weathers]];
    }
}
