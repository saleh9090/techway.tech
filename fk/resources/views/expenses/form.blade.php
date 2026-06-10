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

  <div class="form-actions">
    <button class="button" type="submit">{{ $button }}</button>
    <a class="button button-secondary" href="{{ route('expenses.index') }}">Cancel</a>
  </div>
</form>
