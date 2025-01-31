@extends('backend.navigation.index')
@section('title')
    {{ __('User Navigation Management') }}
@endsection
@section('navigation_content')
<div class="container-fluid">
    <div class="row">

        <div class="col-xl-12">
            <div class="row">
                <div class="col-xl-12">
                    <div class="site-card">
                        <div class="site-card-body">
                            <p class="paragraph"><i data-lucide="alert-triangle"></i>{{ __('All the') }}
                                <strong>{{ __('Menu Items are Draggable.') }}</strong> {{ __('Once you drag then click') }}
                                <strong>{{ __('Save Changes') }}</strong>
                            </p>
                            <form action="{{ route('admin.user.navigation.position.update') }}" method="post">
                                @csrf
                                <div class="site-table table-responsive mb-0">
                                    <table class="table mb-0 centered" id="sortable">
                                        <thead>
                                        <tr>
                                            <th scope="col">{{ __('#') }}</th>
                                            <th scope="col">{{ __('Menu Name') }}</th>
                                            <th scope="col">{{ __('Action') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($navigations as $navigation)
                                            <tr>
                                                <input type="hidden" name="{{ $loop->index }}" value="{{ $navigation->id }}">
                                                <td>
                                                    {{ $loop->iteration }}
                                                </td>
                                                <td>
                                                    <strong>{{ $navigation->name }}</strong>
                                                </td>
                                                <td>
                                                    {{-- <a class="round-icon-btn blue-btn" href="{{ route('admin.navigation.translate',$navigation->id) }}">
                                                        <i data-lucide="languages"></i>
                                                    </a> --}}
                                                    <button class="round-icon-btn primary-btn editNavMenu"
                                                            data-id="{{ $navigation->id }}"
                                                            data-type="{{ $navigation->type }}"
                                                            data-name="{{ $navigation->name }}"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#editNav"
                                                            type="button">
                                                        <i data-lucide="edit-3"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                        <td colspan="6" class="text-center">{{ __('No Data Found!') }}</td>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <div class="site-card-footer">
                                    <button type="submit" class="site-btn-sm primary-btn">{{ __('Save Changes') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Edit Nav Menu -->
@include('backend.user_navigations.include.__edit')
<!-- Modal for Edit Nav Menu-->
@endsection

@section('script')
<script>
    "use strict";

    $(document).on('click','.editNavMenu',function(e){
        e.preventDefault();

        let id = $(this).data('id');
        let type = $(this).data('type');
        let name = $(this).data('name');
        let url = "{{ route('admin.user.navigation.update',':id') }}";
        url = url.replace(':id',id);

        $('input[name=type]').val(type);
        $('input[name=name]').val(name);
        $('#edit-form').attr('action',url);

    });

    $("#sortable tbody").sortable({
        cursor: "move",
        placeholder: "sortable-placeholder",
        helper: function (e, tr) {
            var $originals = tr.children();
            var $helper = tr.clone();
            $helper.children().each(function (index) {
                // Set helper cell sizes to match the original sizes
                $(this).width($originals.eq(index).width());
            });
            return $helper;
        }
    }).disableSelection();

</script>
@endsection
