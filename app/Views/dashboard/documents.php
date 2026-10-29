
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Manager — Credence</title>
    <meta name="description" content="Credence Tech Due-Diligence & Trust Score Platform — Document Manager">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>

<body>

<div class="app-wrapper active" id="app-wrapper">

    <!-- Header -->
    <header class="navbar">

        <button id="sidebar-toggle" class="hamburger-btn" type="button">
            <span class="bar bar1"></span>
            <span class="bar bar2"></span>
            <span class="bar bar3"></span>
        </button>

        <a href="<?= base_url('dashboard') ?>" class="brand-logo">
            <img src="<?= base_url('images/logo.png') ?>" alt="Credence" style="height:34px;">

            <div>
                <div class="brand-title">Tech Due-Diligence & Trust Score</div>
                <span class="brand-sub">Verification & Assessment Platform</span>
            </div>
        </a>

        <div class="nav-controls">
            <div class="nav-user-info">
                <div class="nav-user-avatar" id="nav-user-avatar">CR</div>
                <span id="nav-user-name">Credence User</span>
            </div>

            <button class="nav-logout-btn" id="btn-logout" type="button">
                Logout
            </button>
        </div>

    </header>

    <div class="app-container">

        <!-- Sidebar -->
        <aside class="sidebar">

            <div class="role-nav role-startup">

                <div class="sidebar-title">Startup Portal</div>

                <a class="nav-link" href="<?= base_url('dashboard') ?>">
                    <svg width="17" height="17" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Dashboard & Status
                </a>

                <a class="nav-link" id="nav-link-profile" href="<?= base_url('profile') ?>">
                    <svg width="17" height="17" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Company Profile
                </a>

                <a class="nav-link active" id="nav-link-docs" href="<?= base_url('documents') ?>">
                    <svg width="17" height="17" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Document Manager
                </a>

                <a class="nav-link" id="nav-link-apply" href="<?= base_url('apply') ?>">
                    <svg width="17" height="17" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Assessment Application
                </a>

            </div>

            <div style="margin-top:auto;padding-top:1.5rem;border-top:1px solid var(--light-border);">
                <button class="btn btn-secondary btn-sm" style="width:100%;" id="btn-reset-data" type="button">
                    Reset All Data
                </button>
            </div>

        </aside>

        <!-- Main Content -->
        <main class="main-content">

            <section id="startup-docs" class="view-section active">

                <div class="page-header">
                    <h1 class="page-title">Document Manager</h1>
                    <p class="page-desc">
                        Upload required verification documents for Credence assessment
                    </p>
                </div>

                <!-- Success Banner -->
                <div class="step-complete-banner" id="docs-complete-banner" style="display:none;">
                    <div class="icon">✅</div>

                    <div>
                        <div class="text">Documents Uploaded!</div>
                        <div class="sub">
                            Minimum 3 documents uploaded. You can now Apply for Assessment (Step 4).
                        </div>
                    </div>
                </div>

                <!-- Upload Form -->
                <div class="card" id="docs-upload-card">

                    <div class="card-header">
                        <h3 class="card-title">Upload New Supporting Document</h3>
                    </div>

                    <form
                        id="doc-upload-form"
                        method="post"
                        action="<?= base_url('api/documents') ?>"
                        enctype="multipart/form-data"
                    >

                        <?= csrf_field() ?>

                        <div class="form-row">

                            <div class="form-group">
                                <label class="form-label" for="doc-name-input">
                                    Document Title <span class="req">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="document_name"
                                    id="doc-name-input"
                                    class="form-control"
                                    placeholder="e.g. Audit Report FY25, Patent Spec"
                                    required
                                >
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="doc-type-select">
                                    Document Category <span class="req">*</span>
                                </label>

                                <select
                                    name="document_type"
                                    id="doc-type-select"
                                    class="form-select"
                                    required
                                >
                                    <option value="incorporation">Certificate of Incorporation</option>
                                    <option value="tax">PAN / GST Certificate</option>
                                    <option value="dpiit">DPIIT Certificate</option>
                                    <option value="pitch">Pitch Deck</option>
                                    <option value="financials">Financial Statements</option>
                                    <option value="patent">Patent / IP Document</option>
                                    <option value="tech-arch">Technology Architecture Doc</option>
                                    <option value="team">Team Resume / CVs</option>
                                    <option value="compliance">Compliance Certificate</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="doc-file-input">
                                    Select File <span class="req">*</span>
                                </label>

                                <input
                                    type="file"
                                    name="document"
                                    id="doc-file-input"
                                    class="form-control"
                                    accept=".pdf,.jpg,.jpeg,.png"
                                    required
                                >

                                <small>Allowed: PDF, JPG, JPEG, PNG. Maximum size: 5 MB.</small>
                            </div>

                        </div>

                        <button type="submit" class="btn btn-primary" id="btn-upload-document">
                            Upload Document
                        </button>

                        <p id="upload-message" role="status" style="margin-top:12px;"></p>

                    </form>

                    <div style="display:flex;justify-content:flex-end;margin-top:1rem;">
                        <button type="button" id="btn-docs-next" class="btn btn-primary">
                            Save & Next →
                        </button>
                    </div>

                </div>

                <!-- Uploaded Documents -->
                <div class="card">

                    <div class="card-header">
                        <h3 class="card-title">
                            Uploaded Documents (<span id="docs-count">0</span>)
                        </h3>
                    </div>

                    <div id="docs-list-container"></div>

                    <div class="empty-state" id="docs-empty-state">
                        <div class="empty-state-icon">📁</div>
                        <h3>No Documents Yet</h3>
                        <p>Upload at least 3 documents to proceed to Assessment Application.</p>
                    </div>

                </div>

            </section>

        </main>

    </div>
</div>

<script>
(() => {
    'use strict';

    const uploadForm = document.getElementById('doc-upload-form');
    const uploadButton = document.getElementById('btn-upload-document');
    const uploadMessage = document.getElementById('upload-message');
    const docsContainer = document.getElementById('docs-list-container');
    const docsCount = document.getElementById('docs-count');
    const emptyState = document.getElementById('docs-empty-state');
    const completeBanner = document.getElementById('docs-complete-banner');
    const nextButton = document.getElementById('btn-docs-next');

    const documentsUrl = '<?= base_url('api/documents') ?>';
    const nextUrl = '<?= base_url('apply') ?>';
    const saveUrl = '<?= base_url('documents/save') ?>';
    const loginUrl = '<?= base_url('login') ?>';

    // Sidebar toggle
    document.getElementById('sidebar-toggle')?.addEventListener('click', function () {
        document.querySelector('.sidebar')?.classList.toggle('collapsed');
        this.classList.toggle('active');
        this.style.transform = 'scale(0.85)';
        setTimeout(() => {
            this.style.transform = 'scale(1)';
        }, 150);
    });

    // Logout
    document.getElementById('btn-logout')?.addEventListener('click', async function () {
        if (!confirm('Are you sure you want to logout?')) {
            return;
        }

        try {
            const response = await fetch('<?= base_url('api/logout') ?>', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (response.ok) {
                window.location.href = loginUrl;
            } else {
                alert('Logout failed. Please try again.');
            }
        } catch (error) {
            alert('Unable to connect to the server.');
        }
    });

    // Render documents safely
    function renderDocuments(documents) {
        docsContainer.replaceChildren();

        docsCount.textContent = documents.length;
        emptyState.style.display = documents.length === 0 ? 'block' : 'none';
        completeBanner.style.display = documents.length >= 3 ? 'flex' : 'none';

        documents.forEach((doc) => {
            const card = document.createElement('div');
            card.className = 'document-item card';
            card.style.marginBottom = '12px';

            const title = document.createElement('h4');
            title.textContent = doc.document_name || 'Untitled Document';

            const category = document.createElement('p');
            category.textContent = 'Category: ' + (doc.document_type || 'Other');

            const status = document.createElement('p');
            status.textContent = 'Status: ' + (doc.status || 'Pending');

            card.append(title, category, status);
            docsContainer.appendChild(card);
        });
    }

    // Load documents from backend
    async function loadDocuments() {
        try {
            const response = await fetch(documentsUrl, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const result = await response.json();

            if (!response.ok || result.status === false) {
                if (response.status === 401 || response.status === 403) {
                    uploadMessage.textContent = 'Please log in before managing documents.';
                } else {
                    uploadMessage.textContent = result.message || 'Could not load documents.';
                }
                return;
            }

            // Supports either {documents: [...]} or {data: [...]}
            const documents = Array.isArray(result)
                ? result
                : (result.documents || result.data || []);

            renderDocuments(documents);

        } catch (error) {
            console.error('Load documents error:', error);
            uploadMessage.textContent = 'Could not connect to the server while loading documents.';
        }
    }

    // Upload document
    uploadForm.addEventListener('submit', async function (event) {
        event.preventDefault();

        if (!uploadForm.reportValidity()) {
            return;
        }

        const formData = new FormData(uploadForm);

        uploadButton.disabled = true;
        uploadButton.textContent = 'Uploading...';
        uploadMessage.textContent = '';

        try {
            const response = await fetch(documentsUrl, {
                method: 'POST',
                body: formData,
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const result = await response.json();

            if (!response.ok || result.status === false) {
                uploadMessage.textContent = result.message || 'Document upload failed.';
                return;
            }

            uploadMessage.textContent = result.message || 'Document uploaded successfully!';

            uploadForm.reset();

            await loadDocuments();

        } catch (error) {
            console.error('Upload error:', error);
            uploadMessage.textContent = 'Unable to connect to the server. Please try again.';
        } finally {
            uploadButton.disabled = false;
            uploadButton.textContent = 'Upload Document';
        }
    });

    // Save & Next
    nextButton.addEventListener('click', async function () {
        const count = parseInt(docsCount.textContent, 10) || 0;

        if (count < 3) {
            alert('At least 3 documents are required. Currently uploaded: ' + count);
            return;
        }

        nextButton.disabled = true;
        nextButton.textContent = 'Saving...';

        try {
            const response = await fetch(saveUrl, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const result = await response.json();

            if (!response.ok || result.status === false) {
                alert(result.message || 'Could not save document progress.');
                return;
            }

            window.location.href = nextUrl;

        } catch (error) {
            console.error('Save progress error:', error);
            alert('Unable to connect to the server. Please try again.');
        } finally {
            nextButton.disabled = false;
            nextButton.textContent = 'Save & Next →';
        }
    });

    // Reset button
    document.getElementById('btn-reset-data')?.addEventListener('click', function () {
        alert('Reset is disabled here to protect your saved company and document records.');
    });

    // Initial load
    loadDocuments();

})();
</script>

</body>
</html>
```
