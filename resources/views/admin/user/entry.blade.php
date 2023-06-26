@extends('layout.default')

@section('styles')
@endsection
@section('content')
<div class="card card-custom">
  <div class="card-header">
    <h3 class="card-title">
      Add New User
    </h3>
  </div>
  {!! Form::open([
  'route' => ['user', isset($edit) ? 'method=update&id=' . $edit->id : 'method=save'],
  'id' => 'myForm',
  'files' => true,
  ]) !!}
  <div class="card-body">
    <div class="form-group row">
      {!! Form::label('username', 'Username', ['class' => 'col-2 col-form-label']) !!}
      <div class="col-4">
        {!! Form::text('username', isset($edit) ? $edit->username : old('username'), [
        'id' => 'username',
        'class' => 'form-control',
        ]) !!}
      </div>
    </div>
    <div class="form-group row">
      {!! Form::label('name', 'Full Name', ['class' => 'col-2 col-form-label']) !!}
      <div class="col-4">
        {!! Form::text('name', isset($edit) ? $edit->name : old('name'), ['id' => 'name', 'class' => 'form-control'])
        !!}
      </div>
    </div>
    <div class="form-group row">
      {!! Form::label('email', 'Email', ['class' => 'col-2 col-form-label']) !!}
      <div class="col-4">
        {!! Form::text('email', isset($edit) ? $edit->email : old('email'), [
        'id' => 'email',
        'class' => 'form-control',
        ]) !!}
      </div>
    </div>
    <div class="form-group row">
      {!! Form::label('password', 'Password', ['class' => 'col-2 col-form-label']) !!}
      <div class="col-4">
        <div class="input-group">
          {!! Form::input('password', 'password', isset($edit) ? $edit->password : old('password'), [
          'class' => 'form-control',
          ]) !!}
          <div class="input-group-append">
            <button class="btn btn-info" type="button" onmousedown="mDown()" onmouseup="mUp()">Show</button>
          </div>
        </div>
      </div>
    </div>
    <div class="form-group row">
      {!! Form::label('area', 'Area', ['class' => 'col-2 col-form-label']) !!}
      <div class="col-4">
        <select class="form-control" id="area" name="area">
          <option value="1">CSA Jakarta</option>
          <option value="2">CSA Sumatera</option>
        </select>
      </div>
    </div>
    <div class="form-group row">
      {!! Form::label('branch', 'Branch', ['class' => 'col-2 col-form-label']) !!}
      <div class="col-4">
        <select class="form-control select2" name="branch" id="branch">
          <option label="Label"></option>
        </select>
      </div>
    </div>
    <div class="form-group row">
      {!! Form::label('userrole', 'Role', ['class' => 'col-2 col-form-label']) !!}
      <div class="col-4">
        <select class="form-control select2" name="userrole" id="userrole">
          <option label="Label"></option>
        </select>
      </div>
    </div>
    <div class="form-group row">
      {!! Form::label('avatar', 'Avatar', ['class' => 'col-2 col-form-label']) !!}
      <div class="col-10">
        <div class="image-input image-input-outline" id="kt_user_add_avatar">
          @isset($edit)
          <div class="image-input-wrapper"
            style="background-image: url('{{ asset('storage/avatar/' . $edit->avatar) }}')"></div>
          @else
          <div class="image-input-wrapper" style="background-image: url('{{ asset('storage/avatar/default.jpg') }}')">
          </div>
          @endisset

          <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change"
            data-toggle="tooltip" title="" data-original-title="Change avatar">
            <i class="fa fa-pen icon-sm text-muted"></i>
            <input type="file" name="profile_avatar" accept=".png, .jpg, .jpeg" />
            <input type="hidden" name="profile_avatar_remove" />
          </label>

          <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel"
            data-toggle="tooltip" title="Cancel avatar">
            <i class="ki ki-bold-close icon-xs text-muted"></i>
          </span>
        </div>
      </div>
    </div>
    <div class="form-group row">
      {!! Form::label('status', 'Status', ['class' => 'col-2 col-form-label']) !!}
      <div class="col-10 col-form-label">
        <div class="radio-inline">
          <label class="radio radio-success">
            <input type="radio" name="status" value="1" @if (isset($edit)) @if ($edit->status == 1)
            checked @endif
            @endif
            />
            <span></span>
            Aktif
          </label>
          <label class="radio radio-danger">
            <input type="radio" name="status" value="0" @if (isset($edit)) @if ($edit->status == 0)
            checked @endif
            @endif
            />
            <span></span>
            Tidak Aktif
          </label>
        </div>
      </div>
    </div>
  </div>
  <div class="card-footer text-right">
    <div class="row">
      <div class="col-12">
        <button type="submit" class="btn btn-success mr-2">Simpan</button>
        <a href="{{ url()->previous() }}" class="btn btn-danger">Batal</a>
      </div>
    </div>
  </div>

  {!! Form::hidden('userArea', isset($edit) ? $edit->area : null, ['id' => 'userArea']) !!}
  {!! Form::hidden('userBranch', isset($edit) ? $edit->branch : null, ['id' => 'userBranch']) !!}
  {!! Form::hidden('userRole', isset($edit) ? $edit->role : null, ['id' => 'userRole']) !!}
  {!! Form::close() !!}
</div>
@endsection

@section('scripts')
<script>
  const password = document.getElementById('password');

  function mDown() {
    password.setAttribute('type', 'text');
  }

  function mUp() {
    password.setAttribute('type', 'password');
  }

</script>
<script src="{{ asset('js/admin/user/entry.js') }}"></script>
@endsection
