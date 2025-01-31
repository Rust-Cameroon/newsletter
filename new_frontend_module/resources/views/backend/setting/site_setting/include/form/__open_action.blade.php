<form action="{{ route('admin.settings.update') }}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="section" value="{{$section}}">
