<?php

namespace App\Utilities;

use App\Entity\ColorCode;
use App\Entity\Statistics;

class ChartUtility
{
    const COLOR_LIST = [
        'queueCount' => '#00a65a',
        'messageCount' => '#36A2EB',
        'unprocessedCount' => '#FF6384',
    ];

    const LINE_CHART_OPTIONS = [
        'responsive' => true,
        'title' => [
            'display' => true,
            'text' => '',
        ],
        'tooltips' => [
            'mode' => 'index',
            'intersect' => false,
        ],
        'hover' => [
            'mode' => 'nearest',
            'intersect' => true,
        ],
        'animation' => [
            'duration' => 0,
        ],
        'responsiveAnimationDuration' => 0,
        'scales' => [
            'xAxes' => [[
                'display' => true,
                'scaleLabel' => [
                    'display' => true,
                    'labelString' => 'Days',
                ],
            ]],
            'yAxis' => [[
                'display' => true,
                'scaleLabel' => [
                    'display' => true,
                    'labelString' => 'Value',
                ],
            ]],
        ],
    ];

    public static function getColor($index = null)
    {
        $color = $index ? ColorCode::where(['type' => $index])->firstOrFail() : null;

        return $color ? $color->color_code : self::generateRandomColor();
    }

    public static function getChartOptions($type, $title)
    {
        $options = self::getLineChartOptions();
        if ('bar' == $type) {
            $options = null;
        } elseif ('stacked_bar' == $type) {
            $options = null;
        }

        $options['title']['text'] = $type . ' chart for ' . $title;
//        $options['legend']['display'] = false;
//        $options['legend']['position'] = 'right';

        return $options;
    }

    public static function getLineChartOptions()
    {
        return self::LINE_CHART_OPTIONS;
    }

    public static function generateRandomColor()
    {
        return '#' . substr(md5(rand()), 0, 6);
    }

    public static function hasSubGroup($statistics)
    {
        return !!($statistics->subgroup_identifier);
    }

    public static function hasMultipleData(Statistics $statistics)
    {
        $data = json_decode($statistics->data, true);
        return count($data) > 1;
    }

    public static function getLineDataSet($dataSet)
    {
        $chartData = [];
        foreach ($dataSet as $key => $data) {
            $color = ChartUtility::getColor($key);
            $chartData[] = [
                'fill' => false,
                'label' => $key,
                'borderColor' => $color,
                'backgroundColor' => $color,
                'data' => $data,
            ];
        }

        return $chartData;
    }

    public static function getLineDataSetWithSubGroup($dataSet)
    {
        $chartData = [];
        foreach ($dataSet as $key => $data) {
            $color = ChartUtility::getColor();
            $chartData[] = [
                'fill' => false,
                'label' => $key,
                'borderColor' => $color,
                'backgroundColor' => $color,
                'data' => $data,
                'hidden' => count($chartData) >= 10 ? true : false,
            ];
        }

        return $chartData;
    }
}
