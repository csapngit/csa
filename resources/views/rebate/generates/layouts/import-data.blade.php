<div class="card card-custom mb-3" style="height: 450px">
  <div class="card-header">
    <div class="card-title">
      <h3 class="mb-2">
        {{ __('app.generates.texts.import') }}
      </h3>
    </div>
  </div>

  <div class="card-body">

    <x-forms.form :action="route('generates.import')">

      <!-- Livewire dynamic select -->
      <livewire:dynamic-select />

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

          <button class="browse btn btn-primary px-4" type="button" x-on:click.prevent="$refs.file.click()"><i
              class="fas fa-file"></i> {{ __('app.button.browse') }}</button>

        </div>

        @error('generateFile')
        <div class="text-danger mt-2">
          {{ $message }}
        </div>
        @enderror

      </div>

    </x-forms.form>
  </div>
</div>
