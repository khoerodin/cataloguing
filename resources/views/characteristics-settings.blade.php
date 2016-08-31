@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/jquery-ui.css') }}" rel="stylesheet"/>
@endsection

@section('scripts')
<script src="{{ asset('js/jquery-ui.js') }}"></script>
<script src="{{ asset('assets/js/char-settings.js') }}"></script>
<script src="{{ asset('js/BootstrapMenu.min.js') }}"></script>
@endsection

@section('top_menu')
<li class="dropdown">
    <a href="{{ url('dictionary') }}">DICTIONARY</a>
</li>
<li class="dropdown active">
    <a href="{{ url('settings') }}" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">SETTINGS <span class="caret"></span></a>
    <ul class="dropdown-menu">
      <li class="active"><a href="{{ url('characteristics-settings') }}">CHARACTERISTICS SETTINGS</a></li>
      <li><a href="{{ url('settings') }}">BASE SETTINGS</a></li>
    </ul>
</li>
<li class="dropdown">
    <a href="{{ url('tools') }}">TOOLS</a>
</li>
@endsection

@section('content')

<div class="container2">
  <div class="page-header">
    <h2>CHARACTERISTICS SETTINGS <small> CHARACTERISTICS</small></h2>
  </div>
  
  <ul class="nav nav-tabs" id="setingsTab">
      <li class="active"><a href="#char_settings">CHARACTERISTICS</a></li>
      <li><a href="#short_settings">SHORT DESCRIPTION</a></li>
  </ul>

  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active row" id="char_settings">
      
      <div class="col-xs-12" style="margin-bottom:10px;">

        <div class="row">
          <div class="col-xs-6" id="select_inc">
            <select id="inc" class="inc with-ajax" data-live-search="true" data-width="100%"></select>
          </div>
        </div>

      </div>

      <div class="col-xs-12" style="margin-bottom:10px;">

        <div class="row">
          <div class="col-xs-3">
            <select id="holding" class="holding with-ajax" data-live-search="true" data-width="100%"></select>
          </div>
          <div class="col-xs-3" id="select_company">
          </div>
        </div>

      </div>      
      
      <div id="char-area">
        <div class="col-xs-6">
          <b>CHARACTERISICS</b>
          <div style="height:300px;margin-top:10px;background-color:#F1F4F8;"></div>
        </div>
      </div>
      
      <div id="val-area">
        <div class="col-xs-6">
          <b>VALUES</b>
          <div style="height:300px;margin-top:10px;background-color:#F1F4F8;"></div>
        </div>
      </div>

    </div>

    <div role="tabpanel" class="tab-pane row" id="short_settings">

      <div class="col-xs-6">
        WAL HAMDULILLAH
      </div>

    </div>
  </div>
</div>
@endsection