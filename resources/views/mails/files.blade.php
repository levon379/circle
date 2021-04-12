<!DOCTYPE html>
<html>
<head>
    <title>{{$data['sent']}}</title>
</head>
<body>

<p>Description: {{ $data['message'] }}</p>
<p>Files: </p>
@if(isset($message))
        @foreach($message as $key => $value)
            <img src={{$value}}>
            @if($key->mime == 'pdf')
                <a href="{{$value}}" class="btn btn-info" style="color:white;" download> {{$key->as}}</a>
            @endif
            @if($key->mime == 'jpg' or $key->mime == 'jpeg' or $key->mime == 'png' or $key->mime == 'bmp' or $key->mime == 'tiff')
                <a href="{{$value}}"  class="btn" style="color:white;">
                    <img src="{{$value}}"
                         class="card img-responsive m-l-15 img-thumbnail"
                         style="display: inline-block; width: 200px; height: 200px;"/>
                </a>
            @endif
        @endforeach
@endif

</body>
</html>
