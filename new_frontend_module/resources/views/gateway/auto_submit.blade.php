<form action="" method="{{ $action['method'] }}" id="autoSubmit">
    @foreach($data as $key => $value)
        <input type="hidden" name="{{$key}}" value="{{$value}}">
    @endforeach
</form>
<script>
    document.getElementById("autoSubmit").submit();
</script>
