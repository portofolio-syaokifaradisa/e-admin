<?php

namespace App\Charts;

use App\Models\Survey;
use Illuminate\Support\Facades\DB;
use ArielMejiaDev\LarapexCharts\BarChart;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class SurveyChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): BarChart
    {
        $years = DB::table('surveys')
                    ->select([DB::raw('EXTRACT(YEAR FROM surveys.tanggal) as year')])
                    ->groupBy('year')
                    ->pluck('year');

        $ikm_values = [];
        $years_label = [];
        foreach($years as $year){
            $records = Survey::whereYear('tanggal', $year)->get();
            $evaluation = ["u1" => [],"u2" => [],"u3" => [],"u4" => [],"u5" => [],"u6" => [],"u7" => [],"u8" => [],"u9" => []];
            foreach($records as $record){
                for($i = 1; $i < 10; $i++){
                    array_push($evaluation["u".$i], $record['u'.$i]);
                }
            }

            $score = 0;
            for($i = 1; $i < 10; $i++){
                $sum = Array_sum($evaluation["u".$i]);
                $mean = $sum/count($evaluation["u".$i]);
                $score = $score + ($mean * 0.111);
            }
            $finalScore = $score * 25;

            $ikm_values[] = $finalScore;
            $years_label[] = $year . " (" . round($finalScore, 3) . ")";
        }

        return $this->chart->barChart()
            ->addData('IKM', $ikm_values)
            ->setLabels($ikm_values)
            ->setXAxis($years_label);
    }
}
