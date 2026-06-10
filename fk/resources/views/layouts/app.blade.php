<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Fateer Wa Khameer Accounting' }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  </head>
  <body>
    <div class="app-shell">
      <aside class="sidebar">
        <a class="brand" href="{{ route('dashboard') }}">
          <strong>Fateer Wa Khameer</strong>
          <span>Accounting System</span>
        </a>

        <a class="nav-link {{ request()->routeIs('dashboard') ? 'is-active' : '' }}" href="{{ route('dashboard') }}">Dashboard</a>

        <div class="nav-group-label">Expenses</div>
        <a class="nav-link {{ request()->routeIs('expenses.*') ? 'is-active' : '' }}" href="{{ route('expenses.index') }}">Expenses</a>
        <a class="nav-link {{ request()->routeIs('expense-items.*') ? 'is-active' : '' }}" href="{{ route('expense-items.index') }}">Sub Expenses</a>
        <a class="nav-link {{ request()->routeIs('expense-categories.*') ? 'is-active' : '' }}" href="{{ route('expense-categories.index') }}">Expenses Categories</a>

        <div class="nav-group-label">Income</div>
        <a class="nav-link {{ request()->routeIs('income.*') ? 'is-active' : '' }}" href="{{ route('income.index') }}">Income</a>
        <a class="nav-link {{ request()->routeIs('income-items.*') ? 'is-active' : '' }}" href="{{ route('income-items.index') }}">Sub Income</a>
        <a class="nav-link {{ request()->routeIs('income-categories.*') ? 'is-active' : '' }}" href="{{ route('income-categories.index') }}">Income Categories</a>
      </aside>

      <main class="main">
        @if (session('status'))
          <div class="notice">{{ session('status') }}</div>
        @endif

        @if ($errors->any())
          <div class="notice notice-error">
            <strong>Please fix the highlighted fields.</strong>
          </div>
        @endif

        @yield('content')
      </main>
    </div>
  </body>
</html>
