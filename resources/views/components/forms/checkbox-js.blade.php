<div class="form-check" x-data="{ open: false }">
  <!-- Nothing worth having comes easy. - Theodore Roosevelt -->

  <input type="checkbox" x-on:click="open = ! open" class="form-check-input" id="test">

  <label for="test" class="form-check-label mb-2">
    {{ trans('app.customers.add_customer') }}
  </label>

  <div x-show="open" x-transition>

    <x-buttons.add route="add-customer" trans="{{ trans('app.customers.add_customer') }}" />

    <table class="table table-striped mt-3">
      <tr>
        <th>No</th>
        <th>Customer ID</th>
        <th>Customer Name</th>
      </tr>
      <tr>
        <td>1</td>
        <td>1001</td>
        <td>Vin</td>
      </tr>
      <tr>
        <td>2</td>
        <td>1002</td>
        <td>test dua</td>
      </tr>
    </table>
    
  </div>

</div>
