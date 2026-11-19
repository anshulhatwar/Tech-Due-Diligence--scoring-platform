<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Evaluator Workspace — Credence</title>

  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>

<body>

<header class="navbar">
  <button id="sidebar-toggle" class="hamburger-btn">
    <span class="bar bar1"></span>
    <span class="bar bar2"></span>
    <span class="bar bar3"></span>
  </button>

  <a href="#" class="brand-logo">
    <img src="<?= base_url('images/logo.png') ?>" alt="Credence" style="height:34px;">
    <div>
      <div class="brand-title">Tech Due-Diligence & Trust Score</div>
      <span class="brand-sub">Verification & Assessment Platform</span>
    </div>
  </a>

  <div class="nav-controls">
    <div class="nav-user-info">
      <div class="nav-user-avatar"><?= esc($userInitials ?? 'EV') ?></div>
      <span><?= esc($userName ?? 'Evaluator') ?></span>
    </div>

    <button class="nav-logout-btn" id="btn-logout">Logout</button>
  </div>
</header>

<div class="app-container">

  <aside class="sidebar">
    <div class="role-nav">
      <div class="sidebar-title">Evaluator Workspace</div>

      <a class="nav-link active" href="<?= base_url('eval') ?>">
        <svg width="17" height="17" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
          </path>
        </svg>
        Assigned Queue
      </a>
    </div>
  </aside>

  <main class="main-content">

    <div class="page-header">
      <h1 class="page-title">Evaluator Workspace</h1>
      <p class="page-desc">
        Review assigned applications, perform technology due-diligence, and enter parameter scores.
      </p>
    </div>

    <div class="card">

      <div class="card-header">
        <h3 class="card-title">Assigned Applications Queue</h3>
      </div>

      <div id="queue-message" style="padding:15px;">
        Loading assigned applications...
      </div>

      <div class="table-responsive">
        <table class="custom-table">

          <thead>
            <tr>
              <th>Application No.</th>
              <th>Company</th>
              <th>Assessment Type</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>

          <tbody id="applications-list">
          </tbody>

        </table>
      </div>

    </div>

  </main>
</div>


<!-- Evaluation Modal -->

<div class="modal-backdrop" id="eval-modal">

  <div class="modal-box" style="max-width:700px; max-height:90vh; overflow-y:auto;">

    <div class="modal-header">
      <h3 class="card-title">
        Evaluate: <span id="eval-company"></span>
      </h3>

      <button class="modal-close" onclick="closeEval()">&times;</button>
    </div>

    <div id="eval-loading" style="padding:15px;">
      Loading evaluation parameters...
    </div>

    <div id="eval-sliders"></div>

    <div class="form-group" style="margin-top:1rem;">
      <label class="form-label">Final Remarks</label>

      <textarea
        id="eval-remarks"
        class="form-control"
        placeholder="Evaluator observations..."
      ></textarea>
    </div>

    <div style="display:flex; justify-content:space-between; align-items:center; margin-top:1rem; gap:10px;">

      <div>
        Live Score:
        <strong id="eval-score" style="color:var(--primary);">0</strong>
        / 100
      </div>

      <button
        class="btn btn-primary"
        id="submit-evaluation"
        onclick="submitEval()"
        disabled
      >
        Submit Final Evaluation
      </button>

    </div>

  </div>
</div>


<script>

const APPLICATIONS_API = <?= json_encode(base_url('api/evaluator/applications')) ?>;
const PARAMETERS_API = <?= json_encode(base_url('api/evaluator/parameters/')) ?>;
const SUBMIT_API = <?= json_encode(base_url('api/evaluator/submit')) ?>;
const LOGOUT_API = <?= json_encode(base_url('api/logout')) ?>;
const LOGIN_PAGE = <?= json_encode(base_url('login')) ?>;

let currentApplicationId = null;
let evalParams = [];
let submitting = false;


// HTML escape

function escapeHTML(value) {
  return String(value ?? '').replace(/[&<>"']/g, function(char) {
    return {
      '&': '&amp;',
      '<': '&lt;',
      '>': '&gt;',
      '"': '&quot;',
      "'": '&#039;'
    }[char];
  });
}


// API request helper

async function apiRequest(url, options = {}) {

  const response = await fetch(url, {
    credentials: 'same-origin',
    ...options,
    headers: {
      'Accept': 'application/json',
      ...(options.headers || {})
    }
  });

  const data = await response.json();

  if (!response.ok || data.status === false) {
    throw new Error(data.message || 'Something went wrong.');
  }

  return data;
}


// Load assigned applications

async function loadApplications() {

  const tbody = document.getElementById('applications-list');
  const message = document.getElementById('queue-message');

  tbody.innerHTML = '';

  try {

    const data = await apiRequest(APPLICATIONS_API);

    const applications = data.applications || [];

    if (applications.length === 0) {
      message.textContent = 'No applications assigned to you yet.';
      return;
    }

    message.textContent = `${data.total} assigned application(s) found.`;

    tbody.innerHTML = applications.map(app => {

      const status = app.assignment_status || 'Pending';

      return `
        <tr>
          <td>${escapeHTML(app.application_number)}</td>

          <td>${escapeHTML(app.company_name || 'N/A')}</td>

          <td>${escapeHTML(app.assessment_type || 'N/A')}</td>

          <td>
            <span class="badge badge-new">
              ${escapeHTML(status)}
            </span>
          </td>

          <td>
            <button
              class="btn btn-primary btn-sm"
              onclick="openEval(${Number(app.application_id)}, '${escapeHTML(app.company_name || 'Company')}')"
            >
              Evaluate
            </button>
          </td>
        </tr>
      `;

    }).join('');

  } catch (error) {

    message.textContent = error.message;

    if (error.message.toLowerCase().includes('login')) {
      setTimeout(() => {
        window.location.href = LOGIN_PAGE;
      }, 1500);
    }

  }
}


// Load evaluation parameters

async function openEval(applicationId, company) {

  currentApplicationId = applicationId;
  evalParams = [];

  document.getElementById('eval-company').textContent = company;
  document.getElementById('eval-sliders').innerHTML = '';
  document.getElementById('eval-remarks').value = '';
  document.getElementById('eval-score').textContent = '0';

  document.getElementById('eval-loading').textContent =
    'Loading evaluation parameters...';

  document.getElementById('submit-evaluation').disabled = true;

  document.getElementById('eval-modal').classList.add('active');

  try {

    const data = await apiRequest(PARAMETERS_API + applicationId);

    evalParams = data.parameters || [];

    if (evalParams.length === 0) {
      throw new Error('No active evaluation parameters found.');
    }

    renderParameters();

    document.getElementById('eval-loading').textContent = '';

    document.getElementById('submit-evaluation').disabled = false;

  } catch (error) {

    document.getElementById('eval-loading').textContent = error.message;

  }

}


// Render database parameters

function renderParameters() {

  const box = document.getElementById('eval-sliders');

  box.innerHTML = evalParams.map((parameter, index) => {

    const name = parameter.name || parameter.parameter_name || parameter.title || 'Parameter';
    const weight = Number(parameter.weight || 0);

    return `
      <div class="form-group" style="margin-bottom:18px;">

        <label class="form-label">
          ${escapeHTML(name)}
          (Weight: ${weight}%):
          <strong id="val-${index}">5</strong> / 10
        </label>

        <input
          type="range"
          min="0"
          max="10"
          step="1"
          value="5"
          class="eval-slider"
          data-idx="${index}"
          style="width:100%;"
        >

      </div>
    `;

  }).join('');

  box.querySelectorAll('.eval-slider').forEach(slider => {
    slider.addEventListener('input', updateScore);
  });

  updateScore();

}


// Calculate live weighted score

function updateScore() {

  let total = 0;

  document.querySelectorAll('.eval-slider').forEach(slider => {

    const index = Number(slider.dataset.idx);
    const score = Number(slider.value);
    const weight = Number(evalParams[index].weight || 0);

    document.getElementById('val-' + index).textContent = score;

    total += (score / 10) * weight;

  });

  document.getElementById('eval-score').textContent = total.toFixed(2);

}


// Submit evaluation

async function submitEval() {

  if (submitting || !currentApplicationId || evalParams.length === 0) {
    return;
  }

  const remarks = document.getElementById('eval-remarks').value.trim();

  const scores = [];

  document.querySelectorAll('.eval-slider').forEach(slider => {

    const index = Number(slider.dataset.idx);

    scores.push({
      parameter_id: Number(evalParams[index].id),
      score: Number(slider.value)
    });

  });

  if (scores.length !== evalParams.length) {
    alert('Please provide scores for all evaluation parameters.');
    return;
  }

  const confirmed = confirm('Are you sure you want to submit this evaluation?');

  if (!confirmed) {
    return;
  }

  const button = document.getElementById('submit-evaluation');

  submitting = true;
  button.disabled = true;
  button.textContent = 'Submitting...';

  try {

    const result = await apiRequest(SUBMIT_API, {

      method: 'POST',

      headers: {
        'Content-Type': 'application/json'
      },

      body: JSON.stringify({
        application_id: currentApplicationId,
        scores: scores,
        comments: remarks
      })

    });

    alert(result.message || 'Evaluation submitted successfully.');

    closeEval();

    loadApplications();

  } catch (error) {

    alert(error.message);

  } finally {

    submitting = false;
    button.disabled = false;
    button.textContent = 'Submit Final Evaluation';

  }

}


// Close modal

function closeEval() {

  document.getElementById('eval-modal').classList.remove('active');

  currentApplicationId = null;
  evalParams = [];

}


// Sidebar

document.getElementById('sidebar-toggle')?.addEventListener('click', function() {

  document.querySelector('.sidebar').classList.toggle('collapsed');

  this.classList.toggle('active');

});


// Logout

document.getElementById('btn-logout')?.addEventListener('click', async function() {

  try {
    await fetch(LOGOUT_API, {
      method: 'POST',
      credentials: 'same-origin'
    });
  } finally {
    window.location.href = LOGIN_PAGE;
  }

});


// Initial load

document.addEventListener('DOMContentLoaded', loadApplications);

</script>

</body>
</html>