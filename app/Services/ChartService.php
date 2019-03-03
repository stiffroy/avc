<?php

namespace App\Services;

use App\Entity\Group;
use App\Entity\Statistics;
use App\Utilities\ChartUtility;
use Illuminate\Database\Eloquent\Collection;

class ChartService
{
    const LINE = 'line';
    const BAR = 'bar';
    const STACKED_BAR = 'stacked_bar';

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
        $multipleData = ChartUtility::hasMultipleData($statistics[0]);
        if ($this->lineOrBarType($subGroup, $multipleData)) {
            $type = self::LINE;
        } elseif ($this->stackedBarType($subGroup, $multipleData)) {
            $type = self::STACKED_BAR;
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

        if (self::LINE == $type || self::BAR == $type) {
            $chart = $this->generateLineChart($statistics);
        } elseif (self::STACKED_BAR == $type) {
            $chart = $this->generateStackedBarChart($statistics);
        }

        return $chart;
    }

    private function generateLineChart(Collection $statistics)
    {
        return ChartUtility::hasMultipleData($statistics[0]) ?
            $this->generateLineChartWithMultipleData($statistics) :
            $this->generateLineChartWithSubGroup($statistics);
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

    private function generateLineChartWithSubGroup(Collection $statistics)
    {
        $chartData = [];
        $tempData = [];
        foreach ($statistics as $statistic) {
            $data = json_decode($statistic->data, true);
            $chartData['labels'][] = $statistic->created_at->format('d-m-Y');
            $tempData[$statistic->subgroup_identifier][] = [
                'x' => $statistic->created_at->format('d-m-Y'),
                'y' => $data['count'],
            ];
        }
        $chartData['labels'] = array_values(array_unique($chartData['labels']));
        $chartData['datasets'] = ChartUtility::getLineDataSetWithSubGroup($tempData);

        return $chartData;
    }

    private function generateStackedBarChart(Collection $statistics)
    {
        return true;
    }
}
