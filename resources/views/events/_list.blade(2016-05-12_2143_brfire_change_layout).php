@extends('layouts.document')
@section('page_title', 'Events List')
@section('content')

<div class="social-wrapper">
  <div class="social-element" data-pages="social">
    <div class="container-fluid container-fixed-lg sm-p-l-10 sm-p-r-10">
      <div class="m-b-5">&nbsp;</div>

      @if($events->count() < 1)
      <div class="p-l-0 col-md-12 promotion-empty text-master">ยังไม่มีโปรโมชั่น ในขณะนี้...</div>
      @endif
      <div class="feed">
        <!-- START DAY -->
        <div class="day" data-social="day">
          <!-- START ITEM -->
          <div class="card col2-element col-centered" data-social="item">
            <div class="gallery-item" data-width="2" data-height="2">
              <div class="live-tile slide" data-speed="750" data-delay="4000" data-mode="carousel">
                <div class="slide-front">
                  <img src="/images/events/2016-03-30/gallery/43/20160330-141855-Promotion-Reebok-Grand-Sale-2016-Sale-up-to-70-Off.png" class="img-responsive" />
               </div>
               <div class="slide-back">
                  <img src="/images/events/2016-03-30/20160330-120609-Promotion-Crocs-End-Of-Season-Sale-up-to-50-Mar.2016.jpg" class="img-responsive" />
               </div>
              </div>
              <div class="overlayer bottom-left full-width">
                <div class="overlayer-wrapper item-info more-content">
                  <div class="gradient-grey p-l-20 p-r-20 p-t-50 p-b-5">
                    <div class="">
                      <h3 class="pull-left bold text-white no-margin">โปรโมชั่น Sports Revolution Warehouse Sale ครั้งที่4 Nike, Under Armour, ASICS, Crocs Sale ลดสูงสุด 80%</h3>
                      <div class="clearfix"></div>
                    </div>
                    <div class="m-t-20">
                      <div class="thumbnail-wrapper d32 circular m-t-5">
                        <img width="40" height="40" src="/assets/img/profiles/avatar.jpg" data-src="/assets/img/profiles/avatar.jpg" data-src-retina="/assets/img/profiles/avatar2x.jpg" alt="">
                      </div>
                      <div class="inline m-l-10">
                        <p class="no-margin text-white fs-12 text-master"><strong class="text-master">Super Sport</strong></p>
						            <p class="rating text-master">หมวดหมู่แบรนด์</p>
                      </div>
                      <div class="clearfix"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- END ITEM -->

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
                      <strong class="text-master">{{ $event->brand->name }}</strong>
                    </p>
                    @if(!empty($event->brand->category_first->name))
                        <p class="no-margin hint-text text-master"><a class="category-brand-url" href="{{ URL::to('brand/category', $event->brand->category_first->category) }}" title="{{ $event->brand->category_first->name }}">{{ $event->brand->category_first->name }}</a></p>
                    @else
                        <p class="no-margin hint-text text-master"><a class="category-brand-url" href="{{ URL::to('brand/category', 'unknow') }}" title="Unknow">ไม่ระบุ หมวดหมู่</a></p>
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
              <div class="padding-15">
                <strong class="text-master"><a href="{{ URL::to('events', $event->url_slug) }}" title="{{ $event->title }}" class="card_title">{{ $event->title }}</a></strong>
                <p>{{ $event->brief }}</p>
                @if(!empty($event->category->first()->name))
                  <div class="hint-text small-text text-master">via <a href="{{ URL::to('category', $event->category->first()->category) }}" title="{{ $event->category->first()->name }}" class="">{{ $event->category->first()->name }}</a></div>
                @else
                  <div class="hint-text small-text text-master">via <a href="{{ URL::to('category', 'unknow') }}" title="ไม่ระบุหมวดหมู่" class="">ไม่ระบุหมวดหมู่</a></div>
                @endif
              </div>
              <div class="padding-15 card_footer">
                <div class="pull-left">ถึงวันที่ : {{ $event->end_date_thai }}</div>
                <ul class="list-inline pull-right no-margin hint-text">
                  <li><a class="text-info-link" href="#"><span>5,345</span> <i class="fa fa-comment"></i></a>
                  </li>
                  <li><a class="text-info-link heart" href="#"><span>23K</span> <i class="fa fa-heart"></i></a>
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
