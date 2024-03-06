<!DOCTYPE html>
<html lang="en">
    @include('components.frontend.head')
<body>
    @if(session('showAlert'))
    @php
    $msg = session('message');
    @endphp
    <script>
        window.onload = function () {
            alert('{{ $msg }}');
        }
    </script>
    @endif
    <!--============= ScrollToTop Section Starts Here =============-->
    <div class="overlayer" id="overlayer">
        <div class="loader">
            <div class="loader-inner"></div>
        </div>
    </div>
    <a href="#0" class="scrollToTop"><i class="fas fa-angle-up"></i></a>
    <div class="overlay"></div>
    <!--============= ScrollToTop Section Ends Here =============-->
    @if(session('showAlert'))
    @php
    $msg = session('message');
    @endphp
    <script>
        window.onload = function () {
            alert('{{ $msg }}');
        }
    </script>
    @endif
    <!--============= Header Section Starts Here =============-->
    @include('components.frontend.header')
    <!--============= Header Section Ends Here =============-->

    <!--============= Cart Section Starts Here =============-->
    @include('components.frontend.cart')
    <!--============= Cart Section Ends Here =============-->
    @yield('web_contend')
    <!--============= Footer Section Starts Here =============-->
    @include('components.frontend.footer')
    <!--============= Footer Section Ends Here =============-->

    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="{{ asset('assets/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/modernizr-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/js/wow.min.js') }}"></script>
    <script src="{{ asset('assets/js/waypoints.js') }}"></script>
    <script src="{{ asset('assets/js/nice-select.js') }}"></script>
    <script src="{{ asset('assets/js/counterup.min.js') }}"></script>
    <script src="{{ asset('assets/js/owl.min.js') }}"></script>
    <script src="{{ asset('assets/js/magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets/js/yscountdown.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
</body>

</html>
