<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Event;
use App\Location;

class MapsController extends Controller
{
  /**
  * Display a list of the event.
  *
  *@return Response
  */
  public function index()
  {
    return view('maps.index');
  }

  public function locations($id=0)
  {
    if($id > 0){
      $location = Location::find($id);
      echo '<pre>';
      print_r($location);
    } else {
        $events = Event::noExpire()->active()->eventBrand()->get();
        $event_locations = array();
        foreach($events as $id => $event){

          $cate_name = isset($event->category->first()->name)?$event->category->first()->name:'ไม่ระบุ หมวดหมู่';
          //echo $event->title . ', end => ' . $event->end_date .  '<br />';
          //echo 'count => ' . $event->branch->count() . '<br />';

          if($event->branch->count() > 0){
            $event_count = 0;
            foreach($event->branch->all() as $branch){
              //echo $branch->name . ', lat =>' .$branch->lat . '<br />';
              if(!array_key_exists($branch->lat .','. $branch->lon . ',' . $branch->name, $event_locations)){
                $event_locations[$branch->lat .','. $branch->lon .','. $branch->name] = array(array('title' => $event->title, 'slug' => $event->url_slug, 'brand' => $event->brand_name, 'image' => $event->image, 'category' => $cate_name));
              } else {
                //echo 'in array => ' . $branch->lat .','. $branch->lon;
                array_push($event_locations[$branch->lat .','. $branch->lon .','. $branch->name], array('title' => $event->title, 'slug' => $event->url_slug, 'brand' => $event->brand_name, 'image' => $event->image, 'category' => $cate_name));
              }
            }
          } else {
            //event location first
          }
          //echo '</p>';
        }

        //echo '<pre>';
        //print_r($event_locations);
        //exit;

        echo json_encode($event_locations);
    }
  }
}
