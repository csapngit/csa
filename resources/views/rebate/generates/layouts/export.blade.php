<div class="card card-custom mb-3" style="height: 450px">
  <div class="card-header">
    <div class="card-title">
      <h3 class="mb-2">
        {{ __('app.generates.texts.export') }}
      </h3>
    </div>
  </div>

  <div class="card-body">
    <form action="{{ route('generates.export') }}" method="POST" enctype="multipart/form-data">
      @csrf

      <!-- Livewire dynamic select -->
      <livewire:dynamic-select />

      <!-- select key -->
      {{-- <x-forms.select :items="$keys" name="key_id" trans="generates" :required="true" /> --}}

      <!-- Generate Button -->
      <button type="submit" class="btn btn-primary">
        {{ __('app.button.export') }}
      </button>
    </form>
  </div>
</div>
