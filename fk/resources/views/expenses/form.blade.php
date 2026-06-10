@php($selectedCategoryId = (int) old('expense_category_id', $expense->expense_category_id))
@php($selectedItemId = (int) old('expense_item_id', $expense->expense_item_id))

<form class="form-panel form-grid" method="POST" action="{{ $action }}">
  @csrf
  @if ($method !== 'POST')
    @method($method)
  @endif

  <div class="field">
    <label for="date">Date</label>
    <input id="date" name="date" type="date" value="{{ old('date', optional($expense->date)->format('Y-m-d') ?? $expense->date) }}" required>
    @error('date') <small>{{ $message }}</small> @enderror
  </div>

  <div class="field">
    <label for="expense_category_id">Expense Category</label>
    <select id="expense_category_id" name="expense_category_id" required>
      <option value="">Select category</option>
      @foreach ($categories as $category)
        <option value="{{ $category->id }}" @selected($selectedCategoryId === $category->id)>{{ $category->name }}</option>
      @endforeach
    </select>
    @error('expense_category_id') <small>{{ $message }}</small> @enderror
  </div>

  <div class="field">
    <label for="expense_item_id">Sub Expense</label>
    <select id="expense_item_id" name="expense_item_id" required>
      <option value="">Select sub expense</option>
      @foreach ($items as $item)
        <option value="{{ $item->id }}" data-category-id="{{ $item->expense_category_id }}" @selected($selectedItemId === $item->id)>{{ $item->name }}</option>
      @endforeach
    </select>
    @error('expense_item_id') <small>{{ $message }}</small> @enderror
  </div>

  <div class="field">
    <label for="expense">Expense</label>
    <input id="expense" name="expense" type="text" value="{{ old('expense', $expense->expense) }}" required>
    @error('expense') <small>{{ $message }}</small> @enderror
  </div>

  <div class="field">
    <label for="amount">Amount</label>
    <input id="amount" name="amount" type="number" min="0" step="0.01" value="{{ old('amount', number_format((float) ($expense->amount ?? 0), 2, '.', '')) }}" required>
    @error('amount') <small>{{ $message }}</small> @enderror
  </div>

  <div class="field">
    <label for="details">Details</label>
    <textarea id="details" name="details">{{ old('details', $expense->details) }}</textarea>
    @error('details') <small>{{ $message }}</small> @enderror
  </div>

  <div class="field field-full">
    <label for="note">Note</label>
    <textarea id="note" name="note">{{ old('note', $expense->note) }}</textarea>
    @error('note') <small>{{ $message }}</small> @enderror
  </div>

  <div class="form-actions">
    <button class="button" type="submit">{{ $button }}</button>
    <a class="button button-secondary" href="{{ route('expenses.index') }}">Cancel</a>
  </div>
</form>

<script>
  (() => {
    const category = document.getElementById('expense_category_id');
    const item = document.getElementById('expense_item_id');

    if (!category || !item) {
      return;
    }

    const filterItems = () => {
      const categoryId = category.value;
      let selectedStillVisible = false;

      [...item.options].forEach((option) => {
        if (!option.value) {
          option.hidden = false;
          option.disabled = false;
          return;
        }

        const matches = option.dataset.categoryId === categoryId;
        option.hidden = !matches;
        option.disabled = !matches;

        if (matches && option.selected) {
          selectedStillVisible = true;
        }
      });

      if (!selectedStillVisible) {
        item.value = '';
      }
    };

    category.addEventListener('change', filterItems);
    filterItems();
  })();
</script>
