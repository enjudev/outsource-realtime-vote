@php
    if(isset($configure)) {
    $network = json_decode($configure->configure_social,true);
    };
@endphp
@if (isset($configure))
    <div class="">
        <div id="imgArrList" style="display: flex; align-items:center; gap:20px; flex-wrap:wrap;">
            @foreach ($network as $key => $list)
                <div class="network" style="display:flex; align-items:center;gap:10px;">
                    <input type="hidden" name="configure_social[{{ $key }}][thumbnail]" value="{{ $list['thumbnail'] }}" />
                    <div class="wrap_img" style="width:10%;">
                        <img id="img_arr_prev" src="{{ url($list['thumbnail']) }}"  style=" width: 100%;border-radius:10px; height: 100%; overflow: hidden; margin-bottom: 20px;" alt="" />
                    </div>
                    <div class="form-group " style="display:flex;flex-direction:column;margin-left:10px;">
                        <label for="input">Link</label>
                        <input  type="text" class="form-control"  name="configure_social[{{ $key }}][link]" id="link" value="{{ $list['link'] }}" style="border-radius: 0; box-shadow: none; border-color: #d2d6de; outline:none;">
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="mt-5 " style="display:flex; align-items:center; gap:6px;">
        <button id="array_add" type="button"
            class="array_add cursor-pointer  ">
            Add
        </button>
        <button id="resetArrImage" type="button"
            class="array_add cursor-pointer  ">
            Remove
        </button>
    </div>
@else
<div class="">
    <div  class="container">
      <div class="row" id="imgArrList">

      </div>
    </div>
    <div class="mt-5" style="display:flex; align-items:center; gap:6px;">
        <button id="array_add" type="button"
            class="array_add cursor-pointer  ">
            Add
        </button>
        <button id="resetArrImage" type="button"
            class="array_add cursor-pointer  ">
            Remove
        </button>
    </div>
</div>
@endif
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    var array_add = document.getElementById("array_add");
    array_add.onclick = function() {
        selectFileArrayWithCKFinder("ckfinder-input-array");
    };

    function selectFileArrayWithCKFinder(elementId) {
        CKFinder.modal({
            language: "vi",
            chooseFiles: true,
            width: 800,
            height: 600,
            onInit: function(finder) {
                finder.on("files:choose", function(evt) {
                    var arr_file = evt.data.files.first();
                    var key = $('.network').length;
                    var img_arr = arr_file.getUrl();
                    var url = window.location.origin;
                    var fullUrl = url+ '/' + img_arr;
                    $('#imgArrList').append(`
                        <div class="network" style="display:flex; align-items:center;gap:10px;">
                            <input type="hidden" name="configure_social[${key}][thumbnail]" value="${img_arr}" />
                            <div class="wrap-img" style="width:10%;">
                                <img id="img_arr_prev" src="${fullUrl}"  style=" width: 100%;border-radius:10px; height: 100%; overflow: hidden;margin-bottom: 20px;" alt="" />
                            </div>
                            <div class="form-group" style="display:flex;flex-direction:column;">
                                <label for="input">Link</label>
                                <input type="text" name="configure_social[${key}][link]" id="link" style="border-radius: 0; box-shadow: none; border-color: #d2d6de; outline:none;" >
                            </div>
                        </div>`
                    );
                });

                finder.on("file:choose:resizedImage", function(evt) {
                    var output = document.getElementById(elementId);
                    output.value = evt.data.resizedUrl;
                });
            },
        });
    }
    $('#resetArrImage').on('click',function(){
        $('.network:last').remove();
    });
</script>
