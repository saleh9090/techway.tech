<form class="form-panel form-grid" method="POST" action="{{ $action }}">
  @csrf
  @if ($method !== 'POST')
    @method($method)
  @endif

  <div class="field">
    <label for="expense_category_id">Expense Category</label>
    <select id="expense_category_id" name="expense_category_id" required>
      <option value="">Select category</option>
      @foreach ($categories as $category)
        <option value="{{ $category->id }}" @selected((int) old('expense_category_id', $item->expense_category_id) === $category->id)>{{ $category->name }}</option>
      @endforeach
    </select>
    @error('expense_category_id') <small>{{ $message }}</small> @enderror
  </div>

  <div class="field">
    <label for="name">Name</label>
    <input id="name" name="name" type="text" value="{{ old('name', $item->name) }}" required>
    @error('name') <small>{{ $message }}</small> @enderror
  </div>

  <div class="form-actions">
    <button class="button" type="submit">{{ $button }}</button>
    <a class="button button-secondary" href="{{ route('expense-items.index') }}">Cancel</a>
  </div>
</form>
