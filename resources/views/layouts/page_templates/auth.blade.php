<div class="wrapper ">
  @include('layouts.navbars.sidebar')
  <div class="main-panel" style="background-image: url('{{ asset('material') }}/img/backgroud.jpg'); background-size: cover; background-position: top center;align-items: center;">
    @include('layouts.navbars.navs.auth')
    @yield('content')
    @include('layouts.footers.auth')
  </div>
</div>