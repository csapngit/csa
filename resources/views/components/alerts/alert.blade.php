  <!-- Live as if you were to die tomorrow. Learn as if you were to live forever. - Mahatma Gandhi -->

  @if (session($condition))
  <div class="alert alert-{{ $condition }} alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {{ session($condition) }}
  </div>
  @endif
