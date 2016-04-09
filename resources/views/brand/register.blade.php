@extends('layouts.document')
@section('page_title', 'Events Create')
@section('content')
  <!-- START CONTAINER FLUID -->
  <form class="brand-form" id="brand-form" role="form" action="/brand" enctype="multipart/form-data" method="POST">
  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  {{-- Form::token() --}}
  <div class="container-fluid container-fixed-lg">
    <div class="row">
      <div class="col-md-12">
        <h3 class='page-title'>เพิ่มแบรนด์</h3>
        <span class="error-reponse">
          @include('errors.list')
        </span>
      </div>
      <div class="col-md-8">
        <!-- START PANEL -->
        <div class="panel panel-default">
          <div class="panel-body sm-p-t-20">
              <button class="btn btn-complete fb_login" type="button" id="FBLogin"><i class="fa fa-facebook"></i>&nbsp;Facebook Login</button>
              </p>

              <div class="form-group form-group-default required">
                <label>หัวข้อข่าว</label>
                <input type="text" name="title" class="form-control" placeholder="โปรโมชั่น" oninvalid="this.setCustomValidity('Please Enter valid title')" required />
              </div>
              <div class="form-group form-group-default required">
                <label>URL SLUG (ภาษาอังกฤษเท่านั้น / สูงสุด 60 ตัวอักษร)</label>
                <input type="text" name="url_slug" class="form-control" placeholder="ex: promotion-my-brand-my-name-date-year" required />
              </div>
              <div class="form-group form-group-default required">
                <label>Category</label>
                <select id="category" name="category[]" class="full-width category-select2" multiple>
                  @if($category)
                    @foreach($category as $id => $cate)
                      <option value="{{ $cate->id }}">{{ $cate->name }}</option>
                    @endforeach
                  @endif
                </select>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group form-group-default input-group col-sm-12">
                    <label>วันที่เริ่ม</label>
                    <input type="text" name="start_date" class="form-control" placeholder="Pick a date" id="datepicker-component">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group form-group-default input-group col-sm-12">
                    <label>วันสิ้นสุด</label>
                    <input type="text" name="end_date" class="form-control" placeholder="Pick a date" id="datepicker-component2">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                  </div>
                </div>
              </div>
              <div class="form-group form-group-default input-group">
                <label>รูปภาพหลัก</label>
                <input type="text" class="form-control" />
                <span class="input-group-addon btn-file">
                    <input type="file" name="image" class="form-control form-control-image" id="image" placeholder="รูปภาพ" readonly />
                    <i class="fa fa-picture-o icon-picture"></i>
                </span>
              </div>

              <div class="form-group form-group-default required">
                <label>Keyword (สูงสุด 20 คำ)</label>
                <input class="tagsinput custom-tag-input validate" id="tag_list" name="tag_list" type="text" value="" />
              </div>
              <div class="form-group form-group-default form-group-area required">
                <label>รายละเอียดแบบย่อ</label>
                <textarea class="form-control" name="brief" rows="3" required></textarea>
              </div>
              <div class="form-group">
                <label>รายละเอียด</label>
                <div class="tools">
                  <a class="collapse" href="javascript:;"></a>
                  <a class="config" data-toggle="modal" href="#grid-config"></a>
                  <a class="reload" href="javascript:;"></a>
                  <a class="remove" href="javascript:;"></a>
                </div>
                <div class="no-scroll">
                  <div class="summernote-wrapper">
                    <textarea class="input-block-level note-placeholder" id="summernote" name="description" class="summernote" rows="10"><div><br></div></textarea>
                  </div>
                </div>
              </div>

              <div class="form-group social-post-title">
                <h5><i class="fa fa-share-square-o fa-lg"></i> Post ไปยัง Social Network <input type="checkbox" name="social_post_switchery" class="js-check-change" data-init-plugin="switchery" data-size="small" data-color="primary" checked="checked" /></h5>
                <input name="social_post_status" class="js-check-change-field" type="hidden" value="true" />
              </div>

              <div class="social_group">
                <div class="form-group">
                  <label class="social-facebook-title">Facebook</label>
                  <span class="checkbox-inline">
                    <div class="checkbox check-warning">
                      <input type="checkbox" checked="checked" value="1" name="fb1" id="checkbox2" />
                      <label class="label-master" for="checkbox2">Channel 2</label>
                    </div>
                  </span>
                  <span class="checkbox-inline">
                    <div class="checkbox check-warning">
                      <input type="checkbox" checked="checked" value="1" name="fb2" id="checkbox3">
                      <label class="label-master" for="checkbox3">One</label>
                    </div>
                  </span>
                  <textarea class="form-control" name="fb_message" rows="3"></textarea>
                </div>

                <div class="form-group">
                  <label class="social-twitter-title">Twitter</label>
                  <span class="checkbox-inline">
                    <div class="checkbox check-warning">
                      <input type="checkbox" checked="checked" value="1" name="tw1" id="checkbox4">
                      <label class="label-master" for="checkbox4">Ch8</label>
                    </div>
                  </span>
                  <span class="checkbox-inline">
                    <div class="checkbox check-warning">
                      <input type="checkbox" checked="checked" value="1" name="tw2" id="checkbox5">
                      <label class="label-master" for="checkbox5">Sabaidee</label>
                    </div>
                  </span>
                  <textarea class="form-control" name="tw_message" rows="3"></textarea>
                </div>
              </div>
          </div>
        </div>
        <!-- END PANEL -->
      </div>
      <div class="col-md-4">
        <!-- START PANEL -->
        <div class="panel panel-default">
          <div class="panel-heading">
            <div class="panel-title">
              สาขาที่
            </div>
          </div>
          <div class="panel-body">
            <div class="wizard-footer padding-5 bg-master-lightest master-checkbox-all">
              <div class="checkbox check-success">
                <input type="checkbox" checked="checked" name="branch_all" value="1" class="branch_all" id="branch_all">
                <label class="label-master" for="branch_all">ทุกสาขา</label>
              </div>
              <div class="clearfix"></div>
            </div>

            <div class="wizard-footer padding-5 branch_child">
              <div class="list">
                {{--
                @if($branch)
                  @foreach($branch as $id => $name)
                  <div class="checkbox check-warning">
                    <input type="checkbox" checked="checked" name="branch[]" class="branch" value="{{ $id }}" id="branch_{{ $id }}">
                    <label for="branch_{{ $id }}">{{ $name }}</label>
                  </div>
                  @endforeach
                  <div class="clearfix"></div>
                @endif
                --}}
              </div>

              <div class="form-group">
                  <span class="new-branch"><i class="fs-14 pg-plus"></i>เพิ่มสาขาใหม่</span>
              </div>

            </div>
          </div>
        </div>
        <!-- END PANEL -->
        <!-- START PANEL -->
        <div class="panel panel-default master-checkbox-all">
          <div class="panel-heading">
            <div class="panel-title">
              <div class="checkbox check-danger">
                <input type="checkbox" checked="checked" class="published_check" name="published_now" value="{{ date('Y-m-d') }}" id="published_check">
                <label class="label-master" for="published_check">ขึ้นแสดงผลทันที</label>
              </div>
            </div>
          </div>
          <div class="panel-body published_set_time" style="display: none">
            <div class="form-group form-group-default input-group col-sm-12">
              <label>ตั้งเวลาขึ้นแสดง</label>
              <input type="text" name="published_at" class="form-control" placeholder="Pick a date" id="datepicker-component3">
              <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
            </div>
          </div>
        </div>
        <!-- END PANEL -->

        <div class="row">
          <button class="btn btn-success" type="submit" id="submit_event">Submit</button>
          <button class="btn btn-default" type="reset"><i class="pg-close"></i> Clear</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="fbPostModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
  	<div class="modal-content">
  	  <div class="modal-header">
  		<div class="close" data-dismiss="modal" aria-label="Close"></div>
  		<span class="modal-title" id="myModalLabel">
  			<img class="img-responsive" width="316" src="/assets/img/text_header_popup.png" />
  		</span>
  	  </div>

  		<div class="modal-body">
  			<textarea name="message" class="box-mind form-control" rows="2" placeholder="What's on your mind?"></textarea>
  			<img src="/assets/img/sabaideetv_pr6years_407-132.png" width="405" class="img-responsive" />
  			<input type="hidden" name="access_token" id="tokenId" value=""/>
  			<input type="hidden" name="fb_id" id="fbId" value=""/>
  			<input type="hidden" name="first_name" id="firstName" value=""/>
  			<input type="hidden" name="last_name" id="lastName" value=""/>
  			<input type="hidden" name="gender" id="gender" value=""/>
  			<input type="hidden" name="email" id="email" value=""/>
  		</div>
  		<div class="modal-footer">
  			<div class="loading"><img src="/assets/img/barloader.gif" width="220" class="img-responsive" /></div>
  			<div class="notification">&nbsp;</div>
  			<button id="subscribe-email-submit" type="submit" class="btn_share" />
  		</div>

  	</div>
    </div>
  </div>

  </form>
  <!-- END CONTAINER FLUID -->
@stop