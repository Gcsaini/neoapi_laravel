<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class backendController extends Controller
{
    public function index(){
        return view('index');
    }

    public function submit(Request $req){
        $validatedData = $req->validate([
            'startdate' => 'required',
            'enddate' => 'required',
            
        ]);
        $sdate = $req->post('startdate');
        $edate = $req->post('enddate');
        $stimestamp = strtotime($sdate);
        $new_sdate = date("Y-m-d", $stimestamp);
        $etimestamp = strtotime($edate);
        $new_edate = date("Y-m-d", $etimestamp);
     
        $e_date =  strtotime($new_edate);
        $s_date = strtotime($new_sdate);
        $datediff =  $e_date-$s_date;
        $numday =round($datediff / (60 * 60 * 24)); // total days in the range of given date
        
        if($numday>8){ // retunr if number of days is greater than 8 
            $rangeerror = "date range can not be more than 8 days";
            return back()
            ->with('rangeerror',$rangeerror);

        }else{

            $api = "zAF5bqvN7y79gqvhQv7sC5rhV9tl1BEcPEfjtc66";
            $base = "https://api.nasa.gov/neo/rest/v1/feed?start_date=".$new_sdate."&end_date=".$new_edate."&api_key=".$api;
            $curl = curl_init(); // initializing curl
            curl_setopt_array($curl, array(
                CURLOPT_URL =>$base,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_TIMEOUT => 30000,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            
            ));

            $result = curl_exec($curl);
            curl_close($curl);
            $response = json_decode($result, true); // getting the response from curl
            $totala = $response['element_count']; // total astroid beetween given date
           
            if($response!=0){

                $temparr = array();
                $max=0;
                $min=999999.007878;
                $avg=0;
                for($i=0; $i<=$numday; $i++){
                    $repeat = strtotime("$i day",strtotime($sdate));
                    $newdate = date('Y-m-d',$repeat);
                    $count = count($response['near_earth_objects'][$newdate]); // total astroid on every day
                    $temparr[$i] = ["label"=>$newdate,"y"=>$count]; // array , will be use to plot graph
                   
                 
                    for($j=0;$j<$count;$j++){
                        $vel = $response['near_earth_objects'][$newdate][$j]['close_approach_data'][0]['relative_velocity']['kilometers_per_second'];
                        $near = $response['near_earth_objects'][$newdate][$j]['close_approach_data'][0]['miss_distance']['astronomical'];
                        $avg+=$response['near_earth_objects'][$newdate][$j]['estimated_diameter']['kilometers']['estimated_diameter_max'];
                        $avg = $avg/$totala; // average diameter of astroids
                      
                        if($vel>$max){
                            $faid = $response['near_earth_objects'][$newdate][$j]['id']; // id of fastest astroid
                            $max=$vel; // fastest astroid among all
                            
                        }
                        if($near<$min){
                            $min = $near; // nearest astroid among all
                            $nearid = $response['near_earth_objects'][$newdate][$j]['id']; // id of nearest astroid
                        }
                        
                    }
                }

                $resultarr  = array('sdate'=>$sdate,'edate'=>$edate,'max'=>$max,'min'=>$min,'avg'=>$avg,'arr'=>$temparr,'total'=>$totala);
                return view('index',$resultarr);

            }else{
                $rangeerror = "Something went wrong please try again";
                return back()
                ->with('rangeerror',$rangeerror);
            }

            
        }

    }
    
}
