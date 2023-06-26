<!-- Well begun is half done. - Aristotle -->
<form action="{{ $action }}" method="POST" enctype="multipart/form-data">
  @csrf

  @if ($notPostMethod)
  @method('PUT')
  @endif

  {{ $slot }}

  <x-buttons.submit />

  @if ($backRouteName)
  <x-buttons.back :route-name="$backRouteName" />
  @endif

</form>
