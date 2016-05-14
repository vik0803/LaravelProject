@extends('layouts.document')
@section('page_title', $category_name . ' - โปรโมชั่นทั้งหมด')
@section('content')

<!-- START JUMBOTRON -->
<div class="jumbotron m-b-30" data-pages="parallax">
  <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">
    <div class="inner">
      <!-- START BREADCRUMB -->
      <ul class="breadcrumb">
        <li>
          <a href="/" title="หน้าแรก">หน้าแรก</a>
        </li>
        <li>
          @if($events->first()->category->count() > 0)
            <span class="p-l-5 m-l-5 fs-12">{{ $events->first()->category->first()->name }}</span>
          @else
            <span class="p-l-5 m-l-5 fs-12">ไม่ระบุ หมวดหมู่</span>
          @endif
        </li>
      </ul>
      <!-- END BREADCRUMB -->
    </div>
  </div>
</div>
<!-- END JUMBOTRON -->

<div class="social-wrapper">
  <div class="social-element" data-pages="social">
    <div class="container-fluid container-fixed-lg sm-p-l-10 sm-p-r-10">
      @if($events->count() < 1)
      <div class="p-l-0 col-md-12 promotion-empty text-master">ยังไม่มีโปรโมชั่น ในหมวดหมู่นี้...</div>
      @endif
      <div class="feed">
        <!-- START DAY -->
        <div class="day" data-social="day">
          @forelse($events as $event)
          <!-- START ITEM -->
          <div class="card col1-element col-centered" data-social="item" data-col="column">
            <div class="panel no-border  no-margin">
              <div class="padding-10">
                <div class="item-header clearfix">
                  <div class="thumbnail-wrapper d32 circular">
                    <img width="40" height="40" src="{{ file_exists($event->brand->logo_image) ? URL::asset($event->brand->logo_image) : URL::asset('assets/img/profiles/e.jpg') }}" data-src="" data-src-retina="" alt="{{ $event->brand->name }}" />
                  </div>
                  <div class="inline m-l-10">
                    <p class="no-margin">
                      <strong class="text-master"><a class="brand-event-url" title="{{ $event->brand->name }}" href="{{ URL::to('brand', $event->brand->url_slug) }}">{{ $event->brand->name }}</a></strong>
                    </p>
                    @if(!empty($event->category->first()->name))
                      <div class="hint-text small-text text-master"><a href="{{ URL::to('category', $event->category->first()->category) }}" title="{{ $event->category->first()->name }}" class="">{{ $event->category->first()->name }}</a></div>
                    @else
                      <div class="hint-text small-text text-master"><a href="{{ URL::to('category', 'unknow') }}" title="ไม่ระบุหมวดหมู่" class="">ไม่ระบุหมวดหมู่</a></div>
                    @endif
                  </div>
                  <div class="pull-top pull-right list-inline">
                    <i class="pg-map"></i>
                  </div>
                </div>
              </div>
              <hr class="no-margin">
              <div class="relative">
                <div class="no-overflow">
                  <a href="{{ URL::to('events', $event->url_slug) }}" title="{{ $event->title }}"><img src="{{ URL::asset($event->image) }}" class="block center-margin relative img-responsive" alt="{{ $event->title }}" /></a>
                </div>
              </div>
              <div class="p-t-15 p-l-15 p-r-15 p-b-5">
                <strong class="text-master"><a href="{{ URL::to('events', $event->url_slug) }}" title="{{ $event->title }}" class="card_title">{{ $event->title }}</a></strong>
                <p>{{ $event->brief }}</p>
              </div>
              <div class="p-t-10 p-l-15 p-r-15 p-b-5 card_footer">
                <div class="pull-left text-master hint-text fs-12 color-body">ถึงวันที่ : {{ $event->end_date_thai }}</div>
                <ul class="list-inline pull-right no-margin hint-text">
                  <li><a class="text-info-link" href="#fb comment"><span>5,345</span> <i class="fs-12 pg-comment"></i></a>
                  </li>
                  <li><a class="text-info-link heart" href="#"><span>23K</span> <i class="fa fa-heart-o"></i></a>
                  </li>
                </ul>
                <div class="clearfix"></div>
              </div>
            </div>
          </div>
          <!-- END ITEM -->
          @empty
          @endforelse
          <div class="clearfix">&nbsp;</div>
        </div>
        <!-- END DAY -->
      </div>
      <!-- END FEED -->
    </div>
    <!-- END CONTAINER FLUID -->
  </div>
  <!-- /container -->
</div>
@stop
