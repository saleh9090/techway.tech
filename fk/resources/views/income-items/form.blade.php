<form class="form-panel form-grid" method="POST" action="{{ $action }}">
  @csrf
  @if ($method !== 'POST')
    @method($method)
  @endif

  <div class="field">
    <label for="income_category_id">Income Category</label>
    <select id="income_category_id" name="income_category_id" required>
      <option value="">Select category</option>
      @foreach ($categories as $category)
        <option value="{{ $category->id }}" @selected((int) old('income_category_id', $item->income_category_id) === $category->id)>{{ $category->name }}</option>
      @endforeach
    </select>
    @error('income_category_id') <small>{{ $message }}</small> @enderror
  </div>

  <div class="field">
    <label for="name">Name</label>
    <input id="name" name="name" type="text" value="{{ old('name', $item->name) }}" required>
    @error('name') <small>{{ $message }}</small> @enderror
  </div>

  <div class="form-actions">
    <button class="button" type="submit">{{ $button }}</button>
    <a class="button button-secondary" href="{{ route('income-items.index') }}">Cancel</a>
  </div>
</form>
