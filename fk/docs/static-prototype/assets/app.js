const STORAGE_KEYS = {
  expenses: "fk.expenses",
  categories: "fk.expenseCategories",
};

const currencyFormatter = new Intl.NumberFormat("en-OM", {
  minimumFractionDigits: 2,
  maximumFractionDigits: 2,
});

function readRecords(key) {
  try {
    return JSON.parse(localStorage.getItem(key) || "[]");
  } catch {
    return [];
  }
}

function writeRecords(key, records) {
  localStorage.setItem(key, JSON.stringify(records));
}

function nextId(records) {
  return records.reduce((max, record) => Math.max(max, Number(record.id) || 0), 0) + 1;
}

function money(value) {
  return currencyFormatter.format(Number(value) || 0);
}

function getQueryParam(name) {
  return new URLSearchParams(window.location.search).get(name);
}

function redirectTo(path) {
  window.location.href = path;
}

function showNotice() {
  const message = getQueryParam("message");
  const notice = document.querySelector("[data-notice]");

  if (message && notice) {
    notice.textContent = message;
    notice.classList.add("is-visible");
  }
}

function requireRecord(records, id) {
  return records.find((record) => String(record.id) === String(id));
}

function renderExpenseRows() {
  const tableBody = document.querySelector("[data-expenses-body]");
  const emptyState = document.querySelector("[data-expenses-empty]");

  if (!tableBody) return;

  const expenses = readRecords(STORAGE_KEYS.expenses);
  tableBody.innerHTML = "";

  if (!expenses.length) {
    if (emptyState) emptyState.style.display = "block";
    return;
  }

  if (emptyState) emptyState.style.display = "none";

  expenses
    .slice()
    .sort((a, b) => String(b.date).localeCompare(String(a.date)) || Number(b.id) - Number(a.id))
    .forEach((expense) => {
      const row = document.createElement("tr");
      row.innerHTML = `
        <td>${expense.id}</td>
        <td>${expense.date || ""}</td>
        <td>${escapeHtml(expense.expense || "")}</td>
        <td>${money(expense.amount)}</td>
        <td>${escapeHtml(expense.details || "")}</td>
        <td>
          <div class="actions">
            <a class="button button-secondary" href="edit.html?id=${expense.id}">Edit</a>
            <button class="button button-danger" type="button" data-delete-expense="${expense.id}">Delete</button>
          </div>
        </td>
      `;
      tableBody.appendChild(row);
    });
}

function renderCategoryRows() {
  const tableBody = document.querySelector("[data-categories-body]");
  const emptyState = document.querySelector("[data-categories-empty]");

  if (!tableBody) return;

  const categories = readRecords(STORAGE_KEYS.categories);
  tableBody.innerHTML = "";

  if (!categories.length) {
    if (emptyState) emptyState.style.display = "block";
    return;
  }

  if (emptyState) emptyState.style.display = "none";

  categories
    .slice()
    .sort((a, b) => Number(a.id) - Number(b.id))
    .forEach((category) => {
      const row = document.createElement("tr");
      row.innerHTML = `
        <td>${category.id}</td>
        <td>${escapeHtml(category.name || "")}</td>
        <td>
          <div class="actions">
            <a class="button button-secondary" href="edit.html?id=${category.id}">Edit</a>
            <button class="button button-danger" type="button" data-delete-category="${category.id}">Delete</button>
          </div>
        </td>
      `;
      tableBody.appendChild(row);
    });
}

function bindExpenseForm() {
  const form = document.querySelector("[data-expense-form]");
  if (!form) return;

  const expenses = readRecords(STORAGE_KEYS.expenses);
  const id = getQueryParam("id");
  const existing = id ? requireRecord(expenses, id) : null;

  if (id && !existing) {
    redirectTo("index.html?message=Expense not found");
    return;
  }

  if (existing) {
    form.elements.id.value = existing.id;
    form.elements.date.value = existing.date || "";
    form.elements.expense.value = existing.expense || "";
    form.elements.amount.value = Number(existing.amount || 0).toFixed(2);
    form.elements.details.value = existing.details || "";
  }

  form.addEventListener("submit", (event) => {
    event.preventDefault();

    const record = {
      id: existing ? existing.id : nextId(expenses),
      date: form.elements.date.value,
      expense: form.elements.expense.value.trim(),
      amount: Number(form.elements.amount.value || 0).toFixed(2),
      details: form.elements.details.value.trim(),
    };

    if (existing) {
      const nextRecords = expenses.map((expense) => (expense.id === existing.id ? record : expense));
      writeRecords(STORAGE_KEYS.expenses, nextRecords);
      redirectTo("index.html?message=Expense updated");
      return;
    }

    writeRecords(STORAGE_KEYS.expenses, [...expenses, record]);
    redirectTo("index.html?message=Expense added");
  });
}

function bindCategoryForm() {
  const form = document.querySelector("[data-category-form]");
  if (!form) return;

  const categories = readRecords(STORAGE_KEYS.categories);
  const id = getQueryParam("id");
  const existing = id ? requireRecord(categories, id) : null;

  if (id && !existing) {
    redirectTo("index.html?message=Category not found");
    return;
  }

  if (existing) {
    form.elements.id.value = existing.id;
    form.elements.name.value = existing.name || "";
  }

  form.addEventListener("submit", (event) => {
    event.preventDefault();

    const record = {
      id: existing ? existing.id : nextId(categories),
      name: form.elements.name.value.trim(),
    };

    if (existing) {
      const nextRecords = categories.map((category) => (category.id === existing.id ? record : category));
      writeRecords(STORAGE_KEYS.categories, nextRecords);
      redirectTo("index.html?message=Category updated");
      return;
    }

    writeRecords(STORAGE_KEYS.categories, [...categories, record]);
    redirectTo("index.html?message=Category added");
  });
}

function bindDeletes() {
  document.addEventListener("click", (event) => {
    const expenseButton = event.target.closest("[data-delete-expense]");
    const categoryButton = event.target.closest("[data-delete-category]");

    if (expenseButton) {
      const id = expenseButton.getAttribute("data-delete-expense");
      const records = readRecords(STORAGE_KEYS.expenses).filter((expense) => String(expense.id) !== String(id));
      writeRecords(STORAGE_KEYS.expenses, records);
      renderExpenseRows();
    }

    if (categoryButton) {
      const id = categoryButton.getAttribute("data-delete-category");
      const records = readRecords(STORAGE_KEYS.categories).filter((category) => String(category.id) !== String(id));
      writeRecords(STORAGE_KEYS.categories, records);
      renderCategoryRows();
    }
  });
}

function renderDashboard() {
  const totalExpenses = document.querySelector("[data-total-expenses]");
  const totalAmount = document.querySelector("[data-total-amount]");
  const totalCategories = document.querySelector("[data-total-categories]");
  const latestExpense = document.querySelector("[data-latest-expense]");

  if (!totalExpenses) return;

  const expenses = readRecords(STORAGE_KEYS.expenses);
  const categories = readRecords(STORAGE_KEYS.categories);
  const amount = expenses.reduce((sum, expense) => sum + Number(expense.amount || 0), 0);
  const latest = expenses.slice().sort((a, b) => String(b.date).localeCompare(String(a.date)))[0];

  totalExpenses.textContent = expenses.length;
  totalAmount.textContent = money(amount);
  totalCategories.textContent = categories.length;
  latestExpense.textContent = latest ? `${latest.date} - ${latest.expense}` : "No expenses yet";
}

function escapeHtml(value) {
  const element = document.createElement("span");
  element.textContent = value;
  return element.innerHTML;
}

showNotice();
renderDashboard();
renderExpenseRows();
renderCategoryRows();
bindExpenseForm();
bindCategoryForm();
bindDeletes();
