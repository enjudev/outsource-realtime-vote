<div class="form-group col-md-12">
    <label for="">Config_title</label>
    <input type="text" name="configure_title" value="" class="form-control" placeholder="">
</div>
<div class="form-group col-md-12">
    <label for="">configure_name</label>
    <input type="text" name="configure_name" value="" class="form-control" placeholder="">
</div>
<div class="form-group col-md-12">
    <label class="configure_type">configure_type</label>
    <select class="form-control" style="width: 100%;" name="configure_type">
        <option class="text-black font-medium" value="image">image</option>
        <option class="text-black font-medium" value="switch">switch</option>
        <option class="text-black font-medium" value="textarea">textarea</option>
        <option class="text-black font-medium" value="text">text</option>
        <option class="text-black font-medium" value="date">date</option>
    </select>
</div>
@php $i=10; @endphp
<div class="form-group col-md-12">
    <label for="">configure_ordering</label>
    <input type="text" name="configure_ordering" value="{{$i++}}" class="form-control" placeholder="">
</div>