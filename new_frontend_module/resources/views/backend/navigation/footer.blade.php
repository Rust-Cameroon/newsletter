@extends('backend.navigation.index')
@section('navigation_content')
    <div class="col-xl-12">
        <div class="site-card">
            <div class="site-card-header">
                <h3 class="title">{{ __('Footer Navigation') }}</h3>
            </div>
            <form action="{{ route('admin.navigation.position.update') }}" method="post">
                @csrf
                <input type="hidden" name="type" value="footer">
                <div class="site-card-body">
                    <p class="paragraph"><i data-lucide="alert-triangle"></i>All the <strong>Menu Items are
                            Dragable.</strong> Once you drag then click <strong>Save Changes</strong></p>
                    <div class="site-table table-responsive mb-0">
                        <table class="table mb-0" id="sortable">
                            <thead>
                            <tr>
                                <th scope="col">{{ __('Menu Item') }}</th>
                                <th scope="col">{{ __('Menu URL') }}</th>
                                <th scope="col">{{ __('Page') }}</th>
                                <th scope="col">{{ __('Action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($navigations as $navigation)

                                <tr>
                                    <input type="hidden" name="{{ $loop->index }}" value="{{ $navigation->id }}">
                                    <td>
                                        <strong>{{ $navigation->name }}</strong>
                                    </td>
                                    <td>{{ $navigation->url }}</td>
                                    <td><strong
                                            class="site-badge primary"> {{ $navigation?->page->title ?? 'Custom Url' }}</strong>
                                    </td>
                                    <td>
                                      <span type="button" data-bs-toggle="modal" data-bs-target="#removeMenuItem">
                                        <a href="{{ route('admin.navigation.menu.type.delete',[$navigation->id,'footer']) }}"
                                           class="round-icon-btn red-btn" data-bs-toggle="tooltip" title=""
                                           data-bs-original-title="Remove Item">
                                          <i data-lucide="x"></i>
                                        </a>
                                      </span>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="site-card-footer">
                    <button type="submit" class="site-btn-sm primary-btn">{{ __('Save Changes') }}</button>
                </div>
            </form>

        </div>
    </div>
@endsection
@section('script')
    <script>
        $(function () {
            'use strict';
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
        });
    </script>
@endsection
