<?php

namespace App\Http\Controllers;

//use Storage;
//use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\EventRequest;

use Auth;
use App\Brand;
use App\Event;
use App\Category;
use App\Tag;
use App\Branch;
use App\Gallery;
use App\Location;

//use Request;
use Request as Response;
//use Illuminate\Http\Request;

class EventsController extends Controller
{
  public function __construct()
  {
    //$this->middleware('auth', ['only' => ['create', 'store']]);
    $this->middleware('auth', ['except' => ['index', 'show', 'desc_upload', 'locations', 'branch']]);
  }

  function string_friendly($string)
  {
    $string = preg_replace("`\[.*\]`U","",$string);
    $string = preg_replace('`&(amp;)?#?[a-z0-9]+;`i','-',$string);
    $string = str_replace('%', '-percent', $string);
    $string = htmlentities($string, ENT_COMPAT, 'utf-8');
    $string = preg_replace("`&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);`i","\\1", $string);
    $string = strtolower(preg_replace(array("`[^a-z0-9ก-๙เ-า]`i","`[-]+`"), "-", $string));
    return $string;
    //echo strtolower(trim($string, '-')).'.html';
  }

  /**
  * Display a list of the event.
  *
  *@return Response
  */
  public function index()
  {
    $events = Event::published()->active()->eventBrand()->orderBy('events.created_at', 'desc')->paginate(15);
    //$events = Event::published()->active()->orderBy('events.created_at', 'desc')->paginate(15);

    //echo '<pre>';
    //print_r($events);
    //exit;

    //$tag = 'โปรโมชั่น watsons ภาษาไทย';
    //$tag = $this->string_friendly($tag);
    //echo $tag;
    //exit;

    return view('events.list', compact('events'));
  }

  /**
  * Show the form for creating a new resource.
  *
  *@return Response
  */
  public function create()
  {
      $category = Category::select('name', 'id')->where('category_type', 'event')->get();
      $brand = Brand::select('id', 'name')->get();
      //$branch = $brand->first()->branch_list; //default null
      $branch = array();

      //echo '<pre>';
      //print_r($category);
      //exit;

      return view('events.create', compact('brand', 'branch', 'category'));
  }

  /**
  * Store a newly created resource in storage.
  *
  *@return Response
  */
  public function store(EventRequest $request)
  {
    $event = new Event($request->all());

    //echo '<pre>';
    //print_r($request->input('branch'));

    //echo '<pre>';
    //print_r($event);
    //exit;

    //image
    if($request->hasFile('image')){
      $image_filename = $request->file('image')->getClientOriginalName();
      $file_name = pathinfo($image_filename, PATHINFO_FILENAME); // name
      $extension = pathinfo($image_filename, PATHINFO_EXTENSION); // extension
      $image_name = date('Ymd-His-').str_slug($file_name) . '.' . $extension;
      $public_path = 'images/events/' . date('Y-m-d') . '/';
      $destination = base_path() . '/public/' . $public_path;
      $request->file('image')->move($destination, $image_name); //move file to destination
      $event->image = $public_path . $image_name; //set article image name
    }

    //published
    if($request->input('published_now')){
      $event->published_at = $request->input('published_now');
    }

    //url slug
    $url_slug = str_slug($request->input('url_slug'));
    $base_slug = $url_slug;

    $i=1; $dup=1;
    do {
      $slug = Event::firstOrNew(array('url_slug' => $base_slug));
      if($slug->exists){
        $base_slug = $url_slug . '-' . $i++;
      } else {
        $dup=0;
      }
    } while($dup==1);
    $event->url_slug = $base_slug;

    //brand
    $event->brand_id = $request->input('brand'); //event brand

    $event_id = Auth::user()->events()->save($event)->id; //user id

    //category
    $categoryId = $request->input('category');
    if(!empty($categoryId)){
       $event->category()->sync($categoryId);
    }

    //branch
    $branchId = $request->input('branch');
    if(!empty($branchId)){
       $event->branch()->sync($branchId);
    }

    //tags
    $tagsId = $request->input('tag_list');
    if(!empty($tagsId)){
       $tag_list = explode(',', $tagsId);
       //$tags = Event::InsertTag($tagsId);
       $tags = array();
       foreach($tag_list as $name)
       {
         //$tag = preg_replace('/[^a-zA-Z0-9]+/', '-', strtolower(trim($name)));
         //$tag = str_slug($name); //helper url
         $tag = $this->string_friendly($name);
         $tags[] = Tag::firstOrCreate(array('name' => $name, 'tag' => $tag))->id;
       }
       $event->tags()->sync($tags);
    }

    //gallery
    $gallery = $request->file('gallery');
    $success = 0;
    $error = 0;
    $file_index = 0;
    if($gallery){
      $images = array();
      foreach($gallery as $file){
         $image_filename = $file->getClientOriginalName();
         $file_name = pathinfo($image_filename, PATHINFO_FILENAME); // name
         $extension = pathinfo($image_filename, PATHINFO_EXTENSION); // extension
         $image_name = date('Ymd-His-').str_slug($file_name) . '.' . $extension;
         $public_path = 'images/events/'. date('Y-m-d') .'/gallery/'. $event_id . '/';
         $destination = base_path() . '/public/' . $public_path;
         $upload_success = $file->move($destination, $image_name); //move file to destination
         if( $upload_success ) {
            $success++;
            $image = $destination;
            //$images[] = Gallery::firstOrCreate(array('name' => $name, 'tag' => $tag))->id;
            $images[] = Gallery::firstOrCreate(array('name' => $image_name, 'image' => $public_path . $image_name))->id;
          } else {
            $error++;
            //echo $upload_success . '<br />';
          }
          $file_index++;
      }
      $event->gallery()->sync($images);
    }

    //location
    $location_name = $request->input('location_name');
    $location_lat = $request->input('location_lat');
    $location_lon = $request->input('location_lon');
    $location_zoom = $request->input('location_zoom');

    if($location_name != '' && $location_lat != '' && $location_lon != ''){
      $location = array();
      $location[] = Location::firstOrCreate(array('name' => $location_name, 'lat' => $location_lat, 'lon' => $location_lon, 'zoom' => $location_zoom))->id;
      $event->location()->sync($location);
    }

    echo '-- exit --';
    exit;
  }

  /**
  * Display the speified resource.
  *
  *@param int $id
  *@return Response
  */
  public function show($slug)
  {
      if(is_numeric($slug)) {
          $event = Event::findOrFail($slug);
          return redirect()->action('EventsController@show', ['slug' => $event->url_slug]);
      }

      //$event = Event::with('user', 'category')->where('slug', $slug)->first();
      //$event = Event::where('url_slug', $slug)->eventBrand()->first();
      $event = Event::where('url_slug', $slug)->first();
      $branchs = array();
      $tags = array();
      //$locations = array();
      foreach($event->branch->all() as $index => $branch){
        //$branchs[]= link_to('brand/'.$event->brand_id . '/' . $branch, $branch, array('alt' => $branch));
        //$branchs[]= link_to('#' . $branch, $branch, array('alt' => $branch));
        $branchs[] = '<span><i class="pg-map hint-text-9" aria-hidden="true"></i> </span>' . link_to('#' . $branch->name, $branch->name, array('alt' => $branch->name, 'data-index' => $index, 'class' => 'place'));
        //$locations[] = array('name' => $branch->name, 'lat' => $branch->lat, 'lon' => $branch->lon);
      }

      foreach($event->tags->all() as $index => $tag){
        //$tags[] = '<i class="fa fa-check-circle hint-text m-t-10"></i> ' . link_to('/tag/' . $tag->tag, $tag->name, array('title' => $tag->name, 'data-index' => $index, 'class' => 'tag'));
        $tags[] = '<span><i class="fa fa-tag fa-flip-horizontal hint-text-8 m-t-10" aria-hidden="true"></i> </span>' . link_to('/tag/' . $tag->tag, $tag->name, array('title' => $tag->name, 'data-index' => $index, 'class' => 'tag'));
      }

      //if(!empty($locations)){
        //$locations = json_encode($locations);
      //}

      //echo '<pre>';
      //print_r($branchs_location);
      //foreach($event->brand->all() as $brand){
        //echo ($brand->name) . '<br />';
      //}
      //echo $branchs_location;
      //exit;

      //echo '<pre>';
      //print_r($branchs);
      //echo implode(', ', $branchs);
      //exit;

      //echo $event->category_first->name;
      //exit;

      //echo '<pre>';
      //print_r($event->category_first->name);
      //exit;

      //echo '<pre>';
      //print_r($event->tags->all());
      //exit;

      return view('events.show', compact('event', 'branchs', 'locations', 'tags'));
  }

  /**
  * Show the form for editing the specified resource.
  *
  *@param int $id
  *@return Response
  */
  public function edit($id)
  {
    $event = Event::find($id);
    //$tag_list = Tag::lists('name', 'id');

    $category = Category::select('name', 'id')->where('category_type', 'event')->get();
    $brand = Brand::select('id', 'name')->get();
    $brand_active = Brand::find($event->brand_id);
    $branch = $brand_active->branch_list; //default null
    //$branch = array();

    /*if(in_array(1, $event->category_list)){
      echo 'in array >>';
    }*/

    //echo $event->branch_list;
    $obj = array();
    $result = array();
    foreach($event->gallery_list as $file){
      $fileinfo = base_path() .'/public/'. $file;
      $filename = pathinfo($fileinfo)['basename'];
      $filesize = filesize($fileinfo);

      //echo '<pre>';
      //print_r($filename);
      //exit;

      $obj['name'] = $filename; //get the filename in array
      $obj['size'] = $filesize; //get the flesize in array
      $obj['fileinfo'] = $fileinfo; //get the fileinfo in array
      $result[] = $obj; // copy it to another array
    }

    //echo '<pre>';
    //print_r($result);
    //exit;

    //$gallery = Response::json('success', $result);

    $gallery =  json_encode($result);

    //echo 'gallery => ' . $gallery;
    //exit;

    //echo '<pre>';
    //print_r($gallery);
    //exit;

    $string_tag = implode(',', $event->tag_list);
    //echo $string_tag;
    //exit;

    if(empty($event))
      abort(404);
    return  view('events.edit', compact('event', 'category', 'brand', 'branch', 'string_tag', 'gallery'));
  }

  public function locations($event)
  {
    $event = Event::findOrFail($event);
    echo json_encode($event->branch->all());
  }


  /*
  public function show($id)
  {
    //echo '=> ' . $id;

    $event = Event::find($id);
    if(empty($event))
      abort(404);

    return view('events.show', compact('event'));
  }
  */

  public function desc_upload()
  {
      if(Request::ajax() && Request::hasFile('file_upload')){
        $image_filename = Request::file('file_upload')->getClientOriginalName();
        $file_name = pathinfo($image_filename, PATHINFO_FILENAME); // name
        $extension = pathinfo($image_filename, PATHINFO_EXTENSION); // extension
        $image_name = date('Ymd-His-').str_slug($file_name) . '.' . $extension;
        $public_path = 'images/events/'. date('Y-m-d') .'/description/';
        $destination = base_path() . '/public/' . $public_path;
        $upload_success = Request::file('file_upload')->move($destination, $image_name); //move file to destination
        if( $upload_success ) {
          return '/'. $public_path . $image_name;
        } else {
          return false;
        }
      }

      return Response::json('success', 200);
  }

  /**
  * Display the speified resource.
  *
  *@param int $id
  *@return Response
  */
  public function _branch(Request $request)
  {
    $id = $request->input('id');
    $brand = Brand::find($id);
    echo json_encode($brand->branch_list);
  }

  public function branch($id)
  {
    $brand = Brand::findOrFail($id);
    echo json_encode($brand->branch_list);
  }

}
