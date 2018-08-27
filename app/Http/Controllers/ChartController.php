<?php

namespace App\Http\Controllers;

use File;
use App\Model\Profit;
use App\Model\Ticker;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class ChartController extends Controller
{

    public $dateRange;

    public function __construct()  
    {
        ini_set('max_execution_time', 600);
        $this->dateRange = array();
    }

    public function index() 
    {
    }

    /**
     * Does something interesting
     *
     * @param Place   $where  Where something interesting takes place
     * @param integer $repeat How many times something interesting should happen
     * 
     * @author Jack
     * @return Status
     */

    public function coins() 
    {
        $coins_data = array();
        $coins = Ticker::select('ticker', 'quotes', 'colour', 'midColour', 'midLight', 'lightColour')
                        ->orderBy('index', 'ASC')
                        // ->limit(10)
                        ->get();
        foreach($coins as $key => $coin) 
        {
            $data = array(
                'ticker' => $coin->ticker,
                'json'   => $this->makeJson($coin->ticker, $coin->quotes, [0,4,5]),
                //'colour' => $this->getColours($coin->ticker)
                'colour' => json_encode(array(
                    'colour'      => $coin->colour,
                    'midColour'   => $coin->midColour,
                    'midLight'    => $coin->midLight,
                    'lightColour' => $coin->lightColour,
                ))
            );

            array_push($coins_data, $data);
        }
        
        return View('pages.toolbar.coins')
               ->withCoins($coins_data);
    }
    
    /**
     * table    : public.ticker
     * field    : quotes
     * dataType : json
     * return    : jsondata
     * if $indexArray is [0,4,5],       will get data (timestamp, close, smacd)
     * if $indexArray is [0,1,2,3,4,5], will get all data
     */
    public function makeJson($ticker, $coindata, $indexArray) 
    {
        $dateRange = array();

        $coindata = str_replace("\"", "", $coindata);
        // $data = str_replace("[[", "[", $data);
        // $data = str_replace("]]", "", $data);
        $explode = explode("],", $coindata);
        $coindata_array = array();
        $flag = false;

        $explode_count = count($explode);

        foreach($explode as $mainKey => $data) 
        {
            // if($flag)
            //     break;
            $data = str_replace("[", "", $data);
            $data = str_replace("]", "", $data);
            $group_str = explode(",", $data);
            $array = array();
            foreach($group_str as $key => $value) {
                if(in_array($key, $indexArray)) {
                    if($key == 0) {
                        $date = intval($value);

                        /* Get First Date of Range */
                        if($mainKey == 0)
                            array_push($dateRange, $date);
                        /* Get Last Date of Range */
                        if($mainKey == $explode_count-1)
                            array_push($dateRange, $date);
                        // if($mainKey == 0)
                        //     $firstDate = $date;
                        // if($date - $firstDate > 2592000) {
                        //     $flag = true;
                        //     break;
                        // } else {
                            array_push($array, $date);
                        // }
                    } else if($key == 5) {
                        array_push($array, round(floatval($value), 8) + 1);
                    } else {
                        array_push($array, round(floatval($value), 8));
                    }
                }
            }
            array_push($coindata_array, $array);
        }
        $this->dateRange[$ticker] =  $dateRange;
        return json_encode($coindata_array);
    }

    /**
     * table    : public.coin
     * field    : colour, midColour, midLight, lightColour
     * dataType : json
     * return    : jsondata
     */
    public function getColours($ticker) 
    {
        $coin = Ticker::select('colour', 'midColour', 'midLight', 'lightColour')
                        ->whereTicker($ticker)
                        ->first();
        $colour = array(
            'colour'      => $coin->colour,
            'midColour'   => $coin->midColour,
            'midLight'    => $coin->midLight,
            'lightColour' => $coin->lightColour,
        ); 
        return json_encode($colour);
    }


    /**
     * table    : public.profit
     * field    : ticker, dateOpen, priceOpen, dateClose, priceClose, profit, sold_amount
     * dataType : json
     * return    : jsondata
     */
    public function makeProfitJson($ticker) 
    {
        /* when chart is zoomed get first date */
        // $dateRange = $this->getDateRange($ticker);
        // $start = $dateRange[0];
        // $end = $dateRange[1];
        $start = 1523617800;
        $end = 1527394500;
        
        $profit_datas = Profit::select('dateOpen', 'priceOpen', 'dateClose', 'priceClose', 'profit', 'sold_amount')->where('ticker', $ticker)->orderBy('dateOpen', 'asc')->get();
        $profits = array();
 
        foreach($profit_datas as $key => $data) {
            // $json = array();
            // $dateOpen = strtotime($data->dateOpen);
            // $dateClose = strtotime($data->dateClose);
            // if(($dateClose <= $start) || ($end <= $dateOpen))
            //     continue;
            // if(($dateOpen < $start) && ($start <= $dateClose))
            //     $dateOpen = $start;
            // if(($dateOpen < $end) && ($end <= $dateClose))ta) {
            $json = array();
            $dateOpen = intval($data->dateOpen);
            $dateClose = intval($data->dateClose);
            if(($dateClose <= $start) || ($end <= $dateOpen))
                continue;
            if(($dateOpen < $start) && ($start <= $dateClose))
                $dateOpen = $start;
            if(($dateOpen < $end) && ($end <= $dateClose))
                $dateClose = $end;
            array_push($json, $dateOpen);
            array_push($json, $dateClose);
            array_push($json, round(floatval($data->priceOpen), 8) + 1);
            array_push($json, round(floatval($data->priceClose), 8) + 1);
            array_push($json, round(floatval($data->profit), 8) + 1);
            array_push($json, round(floatval($data->sold_amount), 8) + 1);
            // $json = array(  $data->$dateOpen, 
            //                 $data->$dateClose, 
            //                 round(floatval($data->priceOpen), 8) + 1,
            //                 round(floatval($data->priceClose), 8) + 1, 
            //                 round(floatval($data->profit), 8) + 1, 
            //                 round(floatval($data->sold_amount), 8) + 1);
            array_push($profits, $json);

        }
        return json_encode($profits);
    }
    /**
     * table    : public.ticker
     * field    : quotes
     * dataType : json
     * return   : jsondata
     */
    public function getCoindata(Request $request) 
    {
        $ticker   = $request->ticker;
        $coin   = Ticker::select('quotes')
                                ->whereTicker($ticker)
                                ->first();
    
        $coin_data = array(
            'json'   => $this->makeJson($ticker, $coin->quotes, [0,1,2,3,4,5]),
            'colour' => $this->getColours($ticker),
            'profit' => $this->makeProfitJson($ticker)
        );


        return json_encode($coin_data);
    }

    /**
     * Get Range of date, when the chart is zoomed.
     */
    public function getDateRange($ticker) 
    {
        return $this->dateRange[$ticker];
    }
    
    public function show() 
    {

    }
    
    public function getProgress() 
    {
        return Response::json(array(Session::get('progress')));
    }

    /**
     * Does something interesting
     *
     * @param Place   $where  Where something interesting takes place
     * @param integer $repeat How many times something interesting should happen
     * 
     * @author Jack
     * @return Status
     */
    
    public function profits() 
    {
        
        $coins = Ticker::join('profit', 'ticker.ticker', '=', 'profit.ticker')
                            ->select('ticker.ticker', 'ticker.equity','ticker.colour')
                            ->groupBy('ticker.ticker')
                            ->orderByRaw('SUM(profit.profit) DESC')
                            ->get();
        /*
            
        $coins = array();
        foreach($profits as $key => $profit) {
            $coin = array(
                'ticker' => $profit->ticker,
                'equity' => $profit->equity,
                'colour' => $profit->colour,
            );
            array_push($coins, $coin);
        }
        */
        return View('pages.toolbar.profits')
                ->withCoins($coins);
    }

    public function writePNG(Request $request) {
        $filenames = $request->filenames;
        $imgdata = $request->imagedata;
        foreach($filenames as $key => $filename) {
            $img = $imgdata[$key];
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $fileData = base64_decode($img);
            
            file_put_contents($filename, $fileData);
        }
        return 'suc';
    }
}
