<?php

namespace App\Utilities;

use App\Entity\ColorCode;

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

    public static function getColor($index)
    {
        $color = ColorCode::where(['type' => $index])->firstOrFail();
        return $color->color_code ?: self::generateRandomColor();
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
}
