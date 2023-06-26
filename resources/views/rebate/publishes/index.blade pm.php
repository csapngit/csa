@extends('layout.default')

@section('title', __('app.publishes.pages.index'))

@section('styles')

<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">

@endsection

@section('content')

<div class="card">
  <div class="card-header">
    <div class="card-title">
      <h3>{{ __('app.publishes.pages.index') }}</h3>
    </div>
  </div>

  <div class="card-body" id="">
    <form action="{{ route('publishes.store') }}" method="POST" enctype="multipart/form-data">
      @csrf

      <!-- Select Date -->
      <div class="row mb-3">
        <div class="col">
          <div class="form-group">
            <label for="">
              {{ __('app.publishes.start_date') }}
            </label>
            <input type="date" name="start_date" id="start_date"
              class="form-control @error('start_date') is-invalid @enderror">

            @error('start_date')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
          </div>
        </div>
        <div class="col">
          <div class="form-group">
            <label for="">
              {{ __('app.publishes.end_date') }}
            </label>
            <input type="date" name="end_date" id="end_date"
              class="form-control @error('end_date') is-invalid @enderror">
            @error('end_date')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
          </div>
        </div>
      </div>

      <!-- Select Area -->
      <div class="row">
        <div class="col-md">
          <div class="form-group">
            <select name="area" id="area" class="form-control kt_select2_hiding">
              <option selected disabled value="">{{ __('app.programs.placeholder.area') }}</option>
              @foreach ($areas as $area)
              <option value="{{ $area }}">{{ $area }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="col-md">
          <button type="button" id="btn_area" class="btn btn-primary mb-3">{{ __('app.button.refresh') }}</button>
        </div>
      </div>

      <!-- Table -->
      <table id="myTable" class="table table-striped table-bordered">
        <thead>
          <tr>
            <th style="width: 5%">
              <input type="checkbox" name="" id="" class="checked_all">
            </th>
            <th>{{ __('app.customers.customer_id') }}</th>
            <th>{{ __('app.tables.name') }}</th>
            <th>{{ __('app.customers.target') }}</th>
            <th>{{ __('app.customers.offtakes') }}</th>
          </tr>
        </thead>
        <tbody id="line">
          {{--
          @foreach ($generates as $generate)
          <tr>
            <td>
              <input type="checkbox" name="customer_id[{{ $generate->customer_id }}]" class="check_customer_id">
          </td>
          <td>{{ $generate->customer_id }}</td>
          <td>{{ $generate->customer_name }}</td>
          <td>{{ $generate->target }}</td>
          <td>{{ $generate->offtakes }}</td>
          </tr>
          @endforeach
          --}}
        </tbody>
      </table>

      <!-- Submit Button -->
      <button type="submit" name="action" value="submit" class="btn btn-primary">Submit</button>

      <!-- Publish All Button -->
      <button type="submit" name="action" value="publish_all" class="btn btn-primary">Publish All</button>
    </form>
  </div>
</div>

@endsection

@section('scripts')

<script src="{{ asset('js/rebate/voucher/voucher_publish.js') }}"></script>

<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

<script>
  $(document).ready(function () {
    $('#myTable').DataTable();
  });

</script>

<script>
  $('.checked_all').on('change', function (e) {
    e.preventDefault()
    $('.check_customer_id').prop('checked', this.checked)
  })

</script>

<!-- Select 2 -->
<script>
  var KTSelect2 = function () {
    var demos = function () {
      // basic
      $('.kt_select2').select2();

      // hiding the search box
      $('.kt_select2_hiding').select2({
        minimumResultsForSearch: Infinity
      });
    }

    return {
      init: function () {
        demos();
      }
    };
  }();

  jQuery(document).ready(function () {
    KTSelect2.init();
  });

</script>

@endsection
