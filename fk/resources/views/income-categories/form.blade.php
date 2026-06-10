<form class="form-panel form-grid" method="POST" action="{{ $action }}">
  @csrf
  @if ($method !== 'POST')
    @method($method)
  @endif

  <div class="field">
    <label for="name">Name</label>
    <input id="name" name="name" type="text" value="{{ old('name', $category->name) }}" required>
    @error('name') <small>{{ $message }}</small> @enderror
  </div>

  <div class="form-actions">
    <button class="button" type="submit">{{ $button }}</button>
    <a class="button button-secondary" href="{{ route('income-categories.index') }}">Cancel</a>
  </div>
</form>
