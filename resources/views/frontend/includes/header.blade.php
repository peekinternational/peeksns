<?php 
$headerWeb = json_decode(file_get_contents(public_path('website/web-setting.info')),true);
$headerWebLogo = url('website/logo.png');
if(file_exists('../website/'.$headerWeb['webLogo'])){
    $headerWebLogo = url('../website/'.$headerWeb['webLogo']);
}
$cPage = Request::segment(2);


?>
<nav class="nav navbar-inverse navbar-fixed-top" >
 @if(Session::has('jcmUser'))
                 <div class="container">
                @else
                    <div class="container">
                @endif
    
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
               <span class="icon-bar"></span>
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" style="padding:0px" href="{{ url('') }}"><h3 style="line-height: 0.5;color: white;">SNS Logo</h3></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
       
            <ul class="nav navbar-nav navbar-right">
                <!--Show on Large and Medium screen-->
                @if(Session::has('jcmUser'))
                    <li class="hidden-md"><a href="{{ url('account/manage') }}"><i class="fa fa-gear"></i> @lang('home.manage')</a> </li>
                    <li class="hidden-md"><a href="{{ url('account/logout') }}"><i class="fa fa-sign-out"></i> @lang('home.logout')</a></li>
                @else
                    <li class="hidden-md"><a href="{{ url('/') }}"><i class="fa fa-user"></i> @lang('home.login')</a></li>
                @endif

                <!---->
                @if(Session::has('jcmUser'))
                    <li class="hidden-lg hidden-sm hidden-xs"><a href="{{ url('account/manage') }}"><i class="fa fa-gear"></i></a> </li>
                <li class="hidden-lg hidden-sm hidden-xs"><a href="{{ url('account/logout') }}"><i class="fa fa-sign-out"></i></a></li>
                @else
                    <li class="hidden-lg hidden-sm hidden-xs"><a href="{{ url('login') }}"><i class="fa fa-user"></i></a></li>
                @endif
				<li>		<div class="dropdown">
  <button class="language btn btn-primary dropdown-toggle" style="background:transparent" type="button" data-toggle="dropdown">Language
  <span class="caret"></span></button>
  <ul class="dropdown-menu">
    <li><a href="{{ url('locale/en') }}">English</a></li>
    <li><a href="{{ url('locale/kr') }}">Korean</a></li>
  
  </ul>
</div></li>
            </ul>
	
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
<div id="feedback-Form"></div>