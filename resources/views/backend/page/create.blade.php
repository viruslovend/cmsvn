@extends('layouts.backend.main')

@section('title', 'Add new page | Vnkings CMS')

@section('content')

    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Page
          <small>Add new page</small>
        </h1>
        <ol class="breadcrumb">
          <li>
              <a href="{{ url('/admincms') }}"><i class="fa fa-dashboard"></i> Dashboard</a>
          </li>
          <li><a href="{{ route('backend.page.index') }}">Page</a></li>
          <li class="active">Add new</li>
        </ol>
      </section>

      <!-- Main content -->
      <section class="content">
          <div class="row">
              {!! Form::model($page, [
                  'method' => 'POST',
                  'route'  => 'backend.page.store',
                  'files'  => TRUE,
                  'id' => 'post-form'
              ]) !!}

              @include('backend.page.form')

            {!! Form::close() !!}
          </div>
        <!-- ./row -->
      </section>
      <!-- /.content -->
    </div>

@endsection

@include('backend.page.script')
