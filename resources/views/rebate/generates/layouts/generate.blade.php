<div class="card card-custom mb-3">
  <div class="card-header">
    <div class="card-title">
      <h3 class="mb-2">
        {{ __('app.generates.pages.index') }}
      </h3>
    </div>
  </div>

  <div class="card-body">
    {{-- <div class="form-group mb-8">
      <div class="alert alert-custom alert-default" role="alert">
        <div class="alert-icon"><i class="flaticon-warning text-primary"></i></div>
        <div class="alert-text">
          The example form below demonstrates common HTML form elements that receive updated styles from Bootstrap
          with
          additional classes.
        </div>
      </div>
    </div> --}}

    <form action="{{ route('generates.generate') }}" method="POST" enctype="multipart/form-data">
      @csrf

      <!-- Select program -->
      <livewire:dynamic-select />

      <!-- Generate Button -->
      <button type="submit" class="btn btn-success"
        onclick="return confirm('{{ __('message.generate.calculate') }}')">
        {{ __('app.button.generate') }}
      </button>
    </form>
  </div>
</div>
