<!-- BEGIN VENDOR JS -->
<script type="text/javascript" src="{{ URL::asset('assets/pace/pace.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/jquery/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/modernizr.custom.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/jquery-metrojs/MetroJs.min.js') }}"></script>

<script type="text/javascript" src="{{ URL::asset('pages/js/pages.min.js') }}"></script>

{{--
{{ Html::script('assets/pace/pace.min.js') }}
{{ Html::script('assets/jquery/jquery.min.js') }}
{{ Html::script('assets/modernizr.custom.js') }}
{{ Html::script('assets/bootstrap/js/bootstrap.min.js') }}

{{ Html::script('assets/jquery-scrollbar/jquery.scrollbar.min.js') }}
{{ Html::script('assets/jquery-metrojs/MetroJs.min.js') }}
--}}

{{-- Html::script('assets/jquery-ui/jquery-ui.min.js') --}}

{{--
{{ Html::script('assets/jquery/jquery-easy.js') }}
{{ Html::script('assets/jquery-unveil/jquery.unveil.min.js') }}
{{ Html::script('assets/jquery-bez/jquery.bez.min.js') }}
{{ Html::script('assets/jquery-ios-list/jquery.ioslist.min.js') }}
{{ Html::script('assets/jquery-actual/jquery.actual.min.js') }}

{{ Html::script('assets/bootstrap-select2/select2.min.js') }}
{{ Html::script('assets/classie/classie.js') }}
{{ Html::script('assets/switchery/js/switchery.min.js') }}
{{ Html::script('assets/nvd3/lib/d3.v3.js') }}
{{ Html::script('assets/nvd3/nv.d3.min.js') }}
{{ Html::script('assets/nvd3/src/utils.js') }}
{{ Html::script('assets/nvd3/src/tooltip.js') }}
{{ Html::script('assets/nvd3/src/interactiveLayer.js') }}
{{ Html::script('assets/nvd3/src/models/axis.js') }}
{{ Html::script('assets/nvd3/src/models/line.js') }}
{{ Html::script('assets/nvd3/src/models/lineWithFocusChart.js') }}
{{ Html::script('assets/mapplic/js/hammer.js') }}
{{ Html::script('assets/mapplic/js/jquery.mousewheel.js') }}
{{ Html::script('assets/mapplic/js/mapplic.js') }}
{{ Html::script('assets/rickshaw/rickshaw.min.js') }}

{{ Html::script('assets/jquery-sparkline/jquery.sparkline.min.js') }}
{{ Html::script('assets/skycons/skycons.js') }}
{{ Html::script('assets/bootstrap-datepicker/js/bootstrap-datepicker.js') }}
--}}

<!-- END VENDOR JS -->
<!-- BEGIN CORE TEMPLATE JS -->
{{-- Html::script('pages/js/pages.min.js') --}}
<!-- END CORE TEMPLATE JS -->
<!-- BEGIN PAGE LEVEL JS -->
{{-- Html::script('assets/js/dashboard.js') --}}
{{-- Html::script('assets/js/scripts.js') --}}
<!-- END PAGE LEVEL JS -->

<script type="text/javascript">
(function($) {
  'use strict';
  $(document).ready(function() {
      $(".widget-3 .metro").liveTile();
      $(".widget-7 .metro").liveTile();
  });
})(window.jQuery);
</script>

<script type="text/javascript">
    $(document).ready(function(){
        $('#article').submit(function(e){
            {{--
            var formData = $(this).serialize(); // form data as string
            var formAction = $(this).attr('action'); // form handler url
            var formMethod = $(this).attr('method'); // GET, POST
            --}}

            var article, token, url, data;
            token = $('input[name=_token]').val();
            {{-- article = $('#article').serialize(); --}} // form data as string
            //article = new FormData($(this)[0]);
            article = new FormData(this);

            alert(article + '<=== article');
            {{-- article.append('image', input.images[0]); --}}
            {{-- var fd = new FormData(); --}}
            {{-- fd.append( 'file', input.files[0] ); --}}
            {{-- url = '{{route('articles')}}'; --}}
            {{-- data = {article: article}; --}}
            {{-- $('#subramos').empty(); --}}
            $.ajax({
                url: '/articles',
                headers: {'X-CSRF-TOKEN': token},
                data: article,
                type: 'POST',
                datatype: 'JSON',
                processData: false,
                contentType: false,
                success: function (resp) {
                  console.log('resp => ' + resp);
                    /*$.each(resp.subramos, function (key, value) {
                        $('#subramos').append('<option>'+ value.nombre_subramo +'</option>');
                    });*/
                },
                error: function(jqXHR, textStatus, errorThrown)
                {
                    // Handle errors here
                    console.log('ERRORS: ' + jqXHR + ' ,textStatus => ' + textStatus + ' ,errorThrown => ' + errorThrown);
                    //var resJson = JSON.stringify(jqXHR);
                    console.log(JSON.stringify(jqXHR.responseJSON));
                    // STOP LOADING SPINNER
                }
            });

            e.preventDefault();
        });
    });
</script>
