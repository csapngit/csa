<!-- An unexamined life is not worth living. - Socrates -->
<form action="{{ $route }}" method="POST" class="d-inline">
  @csrf
  @method('DELETE')
  <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are You Sure ?')">
    {{ $text }}
  </button>
</form>
