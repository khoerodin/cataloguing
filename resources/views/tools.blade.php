@extends('layouts.app')

@section('styles')
<link href="{{ asset('css/fuelux.min.css') }}" rel="stylesheet">
@endsection

@section('scripts')
<script type="text/javascript" src="{{asset('vendor/upload/jquery.form.js')}}"></script>
<script type="text/javascript" src="{{asset('js/bootstrap-filestyle.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/fuelux.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/tools.js')}}"></script>
@endsection

@section('top_menu')
<li class="dropdown">
    <a href="{{ url('dictionary') }}">DICTIONARY</a>
</li>
<li class="dropdown">
    <a href="{{ url('settings') }}" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">SETTINGS <span class="caret"></span></a>
    <ul class="dropdown-menu">
      <li><a href="{{ url('characteristics-settings') }}">CHARACTERISTICS SETTINGS</a></li>
      <li><a href="{{ url('settings') }}">BASE SETTINGS</a></li>
    </ul>
</li>
<li class="dropdown active">
    <a href="{{ url('tools') }}">TOOLS</a>
</li>
@endsection

@section('content')
<div class="container2">
  <div class="page-header">
    <h2>TOOLS <small>IMPORT & EXPORT</small></h2>
  </div>

  <ul class="nav nav-tabs" id="toolsTab">
    <li class="active"><a href="#import">IMPORT</a></li>
    <li><a href="#export" id="#">EXPORT</a></li>
  </ul>

  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active row" id="import">
      <div class="col-xs-12">
        
        <form action="{{url('tools/upload')}}" class="form-horizontal" method="post" enctype="multipart/form-data">
          <div class="form-group">
            <div class="col-sm-4">
              <input type="file" class="filestyle" data-buttonBefore="true" name="document" data-icon="false" data-buttonText="SELECT FILE" data-buttonName="btn-primary btn-sm" id="file_upload">
            </div>
            <div class="col-sm-6" id="save-btn"></div>
          </div>
        </form>

        <div class="progress">
          <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
            <div class="percent">0%</div >
          </div>
        </div>
        
        <span id="status"></span>
        <span id="display_uploaded_table"></span>

      </div>
    </div>

    <div role="tabpanel" class="tab-pane row" id="export">      
      <div class="col-xs-3">
        <select id="#" class="form-control">
          <option value="" selected disabled>Select a table before EXPORT</option>
          <option value="1">Item 1</option>
          <option value="2">Item 2</option>
        </select>
      </div>
    </div>

    
  </div>
</div>
@endsection