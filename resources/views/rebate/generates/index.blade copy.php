@extends('layout.default')

@section('title', __('app.generates.pages.index'))

@section('styles')

<script src="//unpkg.com/alpinejs" defer></script>

<!-- Livewire Style -->
@livewireStyles()

@endsection

@section('content')

<!-- Alert Success -->
<x-alerts.alert condition="success" />

<!-- Warning alert -->
<x-alerts.alert condition="warning" />

<ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home">
      <span class="nav-icon">
        <i class="flaticon2-chat-1"></i>
      </span>
      <span class="nav-text">Golden Program</span>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" aria-controls="profile">
      <span class="nav-icon">
        <i class="flaticon2-layers-1"></i>
      </span>
      <span class="nav-text">Sessional Program</span>
    </a>
  </li>
</ul>

<hr>

<div class="tab-content" id="myTabContent">
  <!-- Golden Program -->
  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

    <div class="card card-custom mb-3">
      <div class="card-body">
        <form action="{{ route('generates.import') }}" id="formAction" method="post" enctype="multipart/form-data">
          @csrf

          <!-- Livewire dynamic select -->
          <livewire:dynamic-select />

          <!-- nav -->
          <ul class="nav nav-tabs nav-justified mb-5" id="myTab" role="tablist">
            <!-- Import nav -->
            <li class="nav-item">
              <a class="nav-link active" id="import-tab" data-toggle="tab" href="#import">
                <span class="nav-icon">
                  <i class="flaticon2-chat-1"></i>
                </span>
                <span class="nav-text">{{ __('app.generates.texts.import') }}</span>
              </a>
            </li>
            <!-- Export nav -->
            <li class="nav-item">
              <a class="nav-link" id="export-tab" data-toggle="tab" href="#export" aria-controls="export">
                <span class="nav-icon">
                  <i class="flaticon2-layers-1"></i>
                </span>
                <span class="nav-text">{{ __('app.generates.texts.export') }}</span>
              </a>
            </li>
            <!-- Generate nav -->
            <li class="nav-item">
              <a class="nav-link" id="generate-tab" data-toggle="tab" href="#generate" aria-controls="generate">
                <span class="nav-icon">
                  <i class="flaticon2-layers-1"></i>
                </span>
                <span class="nav-text">{{ __('app.generates.pages.index') }}</span>
              </a>
            </li>
          </ul>
          <!-- // -->
          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="import" role="tabpanel" aria-labelledby="import-tab">
              <!-- Import File -->
              <div class="form-group" x-data="{ fileName: '' }">
                <div class="input-group shadow">
                  <span class="input-group-text px-3 text-muted">
                    <i class="fas fa-file fa-lg"></i>
                  </span>
                  <input type="file" name="generateFile" x-ref="file" @change="fileName = $refs.file.files[0].name"
                    class="d-none">
                  <input type="text" class="form-control @error('generateFile') is-invalid @enderror"
                    placeholder="Upload File Here" x-model="fileName">
                  <button class="browse btn btn-primary px-4" type="button" x-on:click.prevent="$refs.file.click()">
                    <i class="fas fa-file"></i> {{ __('app.button.browse') }}
                  </button>
                </div>

                @error('generateFile')
                <div class="text-danger mt-2">
                  {{ $message }}
                </div>
                @enderror
              </div>
            </div>
            <div class="tab-pane fade" id="export" role="tabpanel" aria-labelledby="export-tab">
              <!-- Select Key -->
              <div class="form-group">
                <label for="">
                  {{ __('app.generates.key_id') }}
                  <span class="text-danger">*</span>
                </label>

                <select name="key_id" id=""
                  class="form-control kt_select2 @error('key_id') is-invalid @enderror" style="width: 100%;">
                  <option selected disabled value=""> {{ __('app.generates.placeholder.key_id') }} </option>
                  @foreach ($keys as $key)
                  <option value="{{ $key->id }}">
                    {{ $key->name }}
                  </option>
                  @endforeach
                </select>

                @error('key_id')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
                @enderror
              </div>
            </div>
            <div class="tab-pane fade" id="generate" role="tabpanel" aria-labelledby="generate-tab">
              <div class="form-group">
                <div class="alert alert-custom alert-default" role="alert">
                  <div class="alert-icon"><i class="flaticon-warning text-primary"></i></div>
                  <div class="alert-text">
                    The example form below demonstrates common HTML form elements that receive updated styles from
                    Bootstrap
                    with
                    additional classes.
                  </div>
                </div>
              </div>
            </div>
          </div>

          <button type="submit" class="btn btn-primary">
            {{ __('app.button.submit') }}
          </button>
        </form>
      </div>
    </div>
  </div>

  <!-- Sessional Program -->
  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
    OK
  </div>
</div>

@endsection

@section('scripts')

<script src="{{ asset('js/pages/crud/forms/widgets/select2.js') }}"></script>

<!-- <script>
  $('#import-tab').click(function () {
    $('#formAction').attr('action', '{{ route('generates.import') }}');
    console.log($('#formAction').attr('action'));
  });

  $('#export-tab').click(function () {
    $('#formAction').attr('action', '{{ route('generates.export') }}');
    console.log($('#formAction').attr('action'));
  });

  $('#generate-tab').click(function () {
    $('#formAction').attr('action', '{{ route('generates.generate') }}');
    console.log($('#formAction').attr('action'));
  });

</script> -->

<!-- Select 2 -->
<script>
  // Class definition
  var KTSelect2 = function () {
    // Private functions
    var demos = function () {
      // basic
      $('.kt_select2').select2();

      // hiding the search box
      $('.kt_select2_hiding').select2({
        placeholder: "Select an option",
        minimumResultsForSearch: Infinity
      });
    }

    // Public functions
    return {
      init: function () {
        demos();
      }
    };
  }();

  // Initialization
  jQuery(document).ready(function () {
    KTSelect2.init();
  });

</script>

<!-- Livewire Scripts -->
@livewireScripts()

@endsection
