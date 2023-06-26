@extends('layout.default')

@section('styles')
@endsection
@section('content')
    <div class="card card-custom">
        <div class="card-header">
            <h3 class="card-title">
                Change Password
            </h3>
        </div>
        {!! Form::open(['route' => ['password-change', isset($edit) ? 'method=update&id=' . $edit->id : 'method=save'], 'id' => 'myForm', 'files' => true]) !!}
            <div class="card-body">
                <div class="form-group row">
                    {!! Form::label('password1','Password Baru', ['class' => 'col-2 col-form-label']) !!}
                    <div class="col-4">
                        {!! Form::input('password','password1', null, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="form-group row">
                    {!! Form::label('password2','Ulangi Password', ['class' => 'col-2 col-form-label']) !!}
                    <div class="col-4">
                        {!! Form::input('password', 'password2', null, ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-2">
                    </div>
                    <div class="col-10">
                        <button type="submit" class="btn btn-success mr-2">Submit</button>
                        <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </div>
            </div>

        {!! Form::hidden('userArea', isset($edit) ? $edit->area : null, ['id' => 'userArea']) !!}
        {!! Form::hidden('userRole', isset($edit) ? $edit->role : null, ['id' => 'userRole']) !!}
        {!! Form::close() !!}
    </div>
@endsection

@section('scripts')
<script src="{{ asset('js/csapps/admin/user.js') }}"></script>
@endsection
