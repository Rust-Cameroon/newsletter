<script>
    (function ($) {
        'use strict';
        var targetCode =  $("input[name='section_code']").val();
        var token = '{{ csrf_token() }}';
        var route = "{{ route('admin.page.section.section.update') }}";
        imageRemoveWithRoute(targetCode,route,token)

    })(jQuery);
</script>
