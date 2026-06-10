@extends('layouts.app', ['title' => 'Dashboard | Fateer Wa Khameer Accounting'])

@section('content')
  @php
    $monthlyTotals = collect(range(11, 0))->map(function (int $monthsAgo) {
        $start = now()->startOfMonth()->subMonths($monthsAgo);
        $end = $start->copy()->endOfMonth();
        $income = (float) \App\Models\Income::query()
            ->whereBetween('date', [$start->toDateString(), $end->toDateString()])
            ->sum('amount');
        $expenses = (float) \App\Models\Expense::query()
            ->whereBetween('date', [$start->toDateString(), $end->toDateString()])
            ->sum('amount');

        return [
            'label' => $start->format('M Y'),
            'income' => $income,
            'expenses' => $expenses,
        ];
    });

    $maxAmount = max(1, $monthlyTotals->max(fn (array $month) => max($month['income'], $month['expenses'])));
  @endphp

  <header class="page-header">
    <div>
      <h1 class="page-title">Dashboard</h1>
      <p class="page-subtitle">12-month income and expenses overview for Fateer Wa Khameer.</p>
    </div>
  </header>

  <section class="chart-panel" aria-label="Income and expenses chart">
    <div class="chart-header">
      <div>
        <h2>Income vs Expenses</h2>
        <p>Last 12 months</p>
      </div>
      <div class="chart-legend" aria-label="Chart legend">
        <span class="legend-item legend-income">Income</span>
        <span class="legend-item legend-expenses">Expenses</span>
      </div>
    </div>

    <div class="chart-scroll">
      <div class="monthly-chart">
        @foreach ($monthlyTotals as $month)
          @php
            $incomeHeight = $month['income'] > 0 ? max(4, round(($month['income'] / $maxAmount) * 100)) : 0;
            $expensesHeight = $month['expenses'] > 0 ? max(4, round(($month['expenses'] / $maxAmount) * 100)) : 0;
          @endphp
          <div class="chart-month">
            <div class="chart-bars">
              <div
                class="chart-bar chart-bar-income"
                style="height: {{ $incomeHeight }}%;"
                title="Income {{ $month['label'] }}: {{ number_format($month['income'], 2) }}"
              ></div>
              <div
                class="chart-bar chart-bar-expenses"
                style="height: {{ $expensesHeight }}%;"
                title="Expenses {{ $month['label'] }}: {{ number_format($month['expenses'], 2) }}"
              ></div>
            </div>
            <span class="chart-month-label">{{ $month['label'] }}</span>
            <span class="chart-value chart-value-income">{{ number_format($month['income'], 0) }}</span>
            <span class="chart-value chart-value-expenses">{{ number_format($month['expenses'], 0) }}</span>
          </div>
        @endforeach
      </div>
    </div>
  </section>
@endsection
