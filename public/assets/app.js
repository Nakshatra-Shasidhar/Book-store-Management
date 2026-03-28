async function apiGet(path, params = {}) {
  const url = new URL(path, window.location.origin);
  Object.keys(params).forEach(k => url.searchParams.set(k, params[k]));
  const res = await fetch(url);
  return res.json();
}

async function apiPost(path, data = {}) {
  const form = new URLSearchParams();
  Object.keys(data).forEach(k => form.append(k, data[k]));
  const res = await fetch(path, { method: 'POST', body: form });
  return res.json();
}

function renderTable(targetId, rows) {
  const table = document.getElementById(targetId);
  if (!table) return;
  if (!rows || rows.length === 0) {
    table.innerHTML = '<tr><td class="muted">No records found</td></tr>';
    return;
  }
  const headers = Object.keys(rows[0]);
  const thead = '<thead><tr>' + headers.map(h => `<th>${h}</th>`).join('') + '</tr></thead>';
  const tbody = '<tbody>' + rows.map(r => '<tr>' + headers.map(h => `<td>${r[h]}</td>`).join('') + '</tr>').join('') + '</tbody>';
  table.innerHTML = thead + tbody;
}

function formToObject(form) {
  const data = {};
  new FormData(form).forEach((value, key) => data[key] = value);
  return data;
}
