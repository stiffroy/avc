<?php

namespace App\Services;

use App\Entity\Statistics;
use App\Utilities\ChartUtility;
use Illuminate\Database\Eloquent\Collection;

class ChartService
{
    public function getChart(Collection $statistics, $chartType)
    {
        if ($chartType == 'false') {
            $chartType = $this->determineChartType($statistics->first());
        }

        $chartData = [
            'chart_type' => $chartType,
            'type' => ChartUtility::getChartType($chartType),
            'data' => $this->generateChartData($statistics, $chartType),
            'options' => ChartUtility::getChartOptions($chartType, $statistics->first()->group_identifier),
            'defaults' => [
                'global' => [
                    'maintainAspectRatio' => false,
                ],
            ],
        ];

        return $chartData;
    }

    private function determineChartType(Statistics $statistics)
    {
        $type = null;
        $subGroup = ChartUtility::hasSubGroup($statistics);
        $multipleData = ChartUtility::hasMultipleData($statistics);

        if ($this->lineOrBarType($subGroup, $multipleData)) {
            $type = ChartUtility::LINE;
        } elseif ($this->stackedBarType($subGroup, $multipleData)) {
            $type = ChartUtility::STACKED_BAR;
        }

        return $type;
    }

    private function lineOrBarType($subGroup, $multipleData)
    {
        return ($subGroup && !$multipleData) || (!$subGroup && $multipleData) || (!$subGroup && !$multipleData);
    }

    private function stackedBarType($subGroup, $multipleData)
    {
        return $subGroup && $multipleData;
    }

    private function generateChartData(Collection $statistics, $type)
    {
        $chart = null;

        if (ChartUtility::LINE == $type || ChartUtility::BAR == $type) {
            $chart = $this->generateLineChart($statistics);
        } elseif (ChartUtility::STACKED_BAR == $type) {
            $chart = $this->generateStackedBarChart($statistics);
        }

        return $chart;
    }

    private function generateLineChart(Collection $statistics)
    {
        return ChartUtility::hasMultipleData($statistics->first()) ?
            $this->generateLineChartWithMultipleData($statistics) :
            $this->generateLineChartWithSingleData($statistics);
    }

    private function generateLineChartWithMultipleData(Collection $statistics)
    {
        $chartData = [];
        $tempData = [];
        foreach ($statistics as $statistic) {
            $data = json_decode($statistic->data, true);
            $chartData['labels'][] = $statistic->created_at->format('d-m-Y');
            foreach ($data as $key => $item) {
                $tempData[$key][] = $item;
            }
        }
        $chartData['labels'] = array_values(array_unique($chartData['labels']));
        $chartData['datasets'] = ChartUtility::getLineDataSet($tempData);

        return $chartData;
    }

    private function generateLineChartWithSingleData(Collection $statistics)
    {
        $chartData = [];
        $tempData = [];
        foreach ($statistics as $statistic) {
            $data = json_decode($statistic->data, true);
            $key = $statistic->subgroup_identifier ?: key($data);
            $chartData['labels'][] = $statistic->created_at->format('d-m-Y');
            $tempData[$key][] = [
                'x' => $statistic->created_at->format('d-m-Y'),
                'y' => $data[key($data)],
            ];
        }
        $chartData['labels'] = array_values(array_unique($chartData['labels']));
        $chartData['datasets'] = ChartUtility::getLineDataSetWithSubGroup($tempData);
        $chartData['canvas']['parentNode']['style']['height'] = '480px';

        return $chartData;
    }

    private function generateStackedBarChart(Collection $statistics)
    {
        $chartData = [];
        $tempData = [];
        foreach ($statistics as $statistic) {
            $data = json_decode($statistic->data, true);
            $chartData['labels'][] = $statistic->created_at->format('d-m-Y');
            foreach ($data as $key => $item) {
                $tempData[$statistic->subgroup_identifier . '-and-' . $key][] = [
                    'x' => $statistic->created_at->format('d-m-Y'),
                    'y' => $item,
                ];
            }
        }
        $chartData['labels'] = array_values(array_unique($chartData['labels']));
        $chartData['datasets'] = ChartUtility::getStackedBarDataSet($tempData);

        return $chartData;
    }
}
