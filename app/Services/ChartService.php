<?php

namespace App\Services;

use App\Entity\Group;
use App\Entity\Statistics;
use App\Utilities\ChartUtility;
use Illuminate\Database\Eloquent\Collection;

class ChartService
{
    public function getChart(Group $group, $chartType = 'line')
    {
        if (!$chartType) {
            $chartType = $this->determineChartType($group->statistics[0]);
        }

        $chartData = [
            'type' => $chartType,
            'data' => $this->generateChartData($group->statistics, $chartType),
            'options' => ChartUtility::getChartOptions($chartType, $group->name),
        ];

        return $chartData;
    }

    private function determineChartType(Statistics $statistics)
    {
        $type = null;
        $subGroup = ChartUtility::hasSubGroup($statistics);
        $multipleData = ChartUtility::hasMultipleData($statistics);
        if ($this->lineOrBarType($subGroup, $multipleData)) {
            $type = 'line';
        } elseif ($this->stackedBarType($subGroup, $multipleData)) {
            $type = 'stacked_bar';
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

        if ('line' == $type || 'bar' == $type) {
            $chart = $this->generateLineChart($statistics);
        } elseif ('stacked_bar' == $type) {
            $chart = null;
        }

        return $chart;
    }

    private function generateLineChart(Collection $statistics)
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
        $chartData['datasets'] = $this->getLineDataSet($tempData);

        return $chartData;
    }

    private function getLineDataSet($dataSet)
    {
        $chartData = [];
        foreach ($dataSet as $key => $data) {
            $chartData[] = [
                'fill' => false,
                'label' => $key,
                'borderColor' => ChartUtility::getColor($key),
                'backgroundColor' => ChartUtility::getColor($key),
                'data' => $data,
            ];
        }

        return $chartData;
    }
}
