const BASE_PATH = window.location.pathname.includes('/bookstore/') ? '/bookstore' : '';
const API_BASE = `${window.location.origin}${BASE_PATH}/api`;

function apiPath(path) {
  if (path.startsWith('/')) path = path.slice(1);
  if (path.startsWith('api/')) return `${API_BASE}/${path.slice(4)}`;
  return path;
}

async function apiGet(path, params = {}) {
  const url = new URL(apiPath(path), window.location.href);
  Object.keys(params).forEach(k => url.searchParams.set(k, params[k]));
  const res = await fetch(url);
  const txt = await res.text();
  const clean = txt.replace(/^﻿/, '').trim();
  return clean ? JSON.parse(clean) : [];
}

async function apiPost(path, data = {}) {
  const form = new URLSearchParams();
  Object.keys(data).forEach(k => form.append(k, data[k]));
  const res = await fetch(apiPath(path), { method: 'POST', body: form });
  const txt = await res.text();
  const clean = txt.replace(/^﻿/, '').trim();
  return clean ? JSON.parse(clean) : [];
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
