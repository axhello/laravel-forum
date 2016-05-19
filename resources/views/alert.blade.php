@if ( Session::has('email_confirm') )
    <script>
        window.onload = function () {
            swal("Good job!", "{{ Session::get('email_confirm') }}", "success");
        };
    </script>
@endif

@if ( Session::has('if_confirmed') )
    <script>
        window.onload = function () {
            swal("Oops!!", "{{ Session::get('if_confirmed') }}", "error");
        };
    </script>
@endif

@if ( Session::has('register_success') )
    <script>
        window.onload = function () {
            swal("Good job!", "{{ Session::get('register_success') }}", "success");
        };
    </script>
@endif

@if ( Session::has('login_success') )
    <script>
        window.onload = function () {
            swal("Good job!", "{{ Session::get('login_successfully') }}", "success");
        };
    </script>
@endif

@if ( Session::has('success_change') )
    <script>
        window.onload = function () {
            swal("Good job!", "{{ Session::get('success_change') }}", "success");
        };
    </script>
@endif