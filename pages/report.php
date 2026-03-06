<?php require_once __DIR__ . '/../includes/config.php'; ?>
<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Report a maintenance issue — describe the problem, upload photos, and submit in 5 easy steps.">
    <title>Report an Issue — HouseAidPro</title>
    <link rel="stylesheet" href="../css/variables.css">
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/components.css">
    <link rel="stylesheet" href="../css/layout.css">
    <link rel="stylesheet" href="../css/animations.css">
    <link rel="stylesheet" href="../css/wizard.css">
</head>

<body>

    <!-- Header -->
    <header class="site-header">
        <div class="header-inner">
            <a href="../index.php" class="logo">
                <div class="logo__icon"><svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" />
                    </svg></div>
                <div class="logo__text"><span>HouseAidPro</span></div>
            </a>
            <nav class="nav" id="main-nav">
                <a href="../index.php" class="nav__link">Home</a>
                <a href="report.php" class="nav__link active">Report Issue</a>
                <a href="faq.php" class="nav__link">Help & FAQ</a>
                <a href="track.php" class="nav__link">Track Issue</a>
                <div class="nav__actions">
                    <button class="theme-toggle" id="theme-toggle" aria-label="Toggle dark mode">
                        <svg class="icon-moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z" />
                        </svg>
                        <svg class="icon-sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="5" />
                            <line x1="12" y1="1" x2="12" y2="3" />
                            <line x1="12" y1="21" x2="12" y2="23" />
                            <line x1="4.22" y1="4.22" x2="5.64" y2="5.64" />
                            <line x1="18.36" y1="18.36" x2="19.78" y2="19.78" />
                            <line x1="1" y1="12" x2="3" y2="12" />
                            <line x1="21" y1="12" x2="23" y2="12" />
                            <line x1="4.22" y1="19.78" x2="5.64" y2="18.36" />
                            <line x1="18.36" y1="5.64" x2="19.78" y2="4.22" />
                        </svg>
                    </button>
                    <a href="login.php" class="btn btn--outline btn--sm">Log In</a>
                </div>
            </nav>
            <button class="hamburger" id="hamburger" aria-label="Open menu"><svg viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2">
                    <line x1="3" y1="6" x2="21" y2="6" />
                    <line x1="3" y1="12" x2="21" y2="12" />
                    <line x1="3" y1="18" x2="21" y2="18" />
                </svg></button>
        </div>
    </header>

    <main class="main-content page-enter">
        <div class="container container--lg">

            <h1 style="text-align:center;margin-bottom:var(--space-2);">Report a Maintenance Issue</h1>
            <p style="text-align:center;max-width:500px;margin:0 auto var(--space-6);">Complete the steps below. It only
                takes a few minutes.</p>

            <!-- ══ Progress Stepper ══════════════════════════ -->
            <div class="wizard-progress" id="wizard-progress">
                <div class="wizard-step-indicator active" data-step="1">
                    <div class="wizard-step-circle">1</div>
                    <div class="wizard-step-label">Describe</div>
                </div>
                <div class="wizard-step-line" data-line="1"></div>
                <div class="wizard-step-indicator" data-step="2">
                    <div class="wizard-step-circle">2</div>
                    <div class="wizard-step-label">Upload</div>
                </div>
                <div class="wizard-step-line" data-line="2"></div>
                <div class="wizard-step-indicator" data-step="3">
                    <div class="wizard-step-circle">3</div>
                    <div class="wizard-step-label">Address</div>
                </div>
                <div class="wizard-step-line" data-line="3"></div>
                <div class="wizard-step-indicator" data-step="4">
                    <div class="wizard-step-circle">4</div>
                    <div class="wizard-step-label">Contact</div>
                </div>
                <div class="wizard-step-line" data-line="4"></div>
                <div class="wizard-step-indicator" data-step="5">
                    <div class="wizard-step-circle">5</div>
                    <div class="wizard-step-label">Confirm</div>
                </div>
            </div>

            <div class="wizard-panels" id="wizard-panels">

                <!-- ══ STEP 1: Describe ═════════════════════════ -->
                <div class="wizard-panel active" id="step-1">
                    <div class="card">
                        <h3 style="margin-bottom:var(--space-4)">What's the problem?</h3>

                        <div class="form-group">
                            <label class="form-label" for="issue-title">Short title<span
                                    class="required">*</span></label>
                            <input type="text" class="form-input" id="issue-title"
                                placeholder="e.g. Leaking kitchen tap" maxlength="200" aria-required="true">
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="issue-description">Describe the issue<span
                                    class="required">*</span></label>
                            <textarea class="form-textarea" id="issue-description" rows="4"
                                placeholder="Give us as much detail as possible..." aria-required="true"></textarea>
                        </div>

                        <label class="form-label">Select a category<span class="required">*</span></label>
                        <div class="category-grid stagger" id="category-grid">
                            <div class="category-card" data-category="plumbing" tabindex="0" role="button"
                                aria-label="Plumbing">
                                <div class="category-card__icon"><svg viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <path d="M6 12h6m-3-3v6m6.5-1.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z" />
                                        <path d="M19.5 10.5L21 12l-1.5 1.5" />
                                    </svg></div>
                                <span class="category-card__label">Plumbing</span>
                            </div>
                            <div class="category-card" data-category="electrical" tabindex="0" role="button"
                                aria-label="Electrical">
                                <div class="category-card__icon"><svg viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z" />
                                    </svg></div>
                                <span class="category-card__label">Electrical</span>
                            </div>
                            <div class="category-card" data-category="appliances" tabindex="0" role="button"
                                aria-label="Appliances">
                                <div class="category-card__icon"><svg viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <rect x="4" y="2" width="16" height="20" rx="2" />
                                        <line x1="8" y1="6" x2="16" y2="6" />
                                        <circle cx="12" cy="14" r="3" />
                                    </svg></div>
                                <span class="category-card__label">Appliances</span>
                            </div>
                            <div class="category-card" data-category="heating" tabindex="0" role="button"
                                aria-label="Heating">
                                <div class="category-card__icon"><svg viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <path d="M12 2a5 5 0 0 1 5 5c0 4-5 6-5 9a5 5 0 0 1-5-5c0-4 5-6 5-9z" />
                                        <path d="M12 18v4" />
                                    </svg></div>
                                <span class="category-card__label">Heating</span>
                            </div>
                            <div class="category-card" data-category="leaks" tabindex="0" role="button"
                                aria-label="Leaks">
                                <div class="category-card__icon"><svg viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <path d="M12 2C8 7 4 10 4 14a8 8 0 1 0 16 0c0-4-4-7-8-12z" />
                                    </svg></div>
                                <span class="category-card__label">Leaks</span>
                            </div>
                            <div class="category-card" data-category="fencing" tabindex="0" role="button"
                                aria-label="Fencing & Gates">
                                <div class="category-card__icon"><svg viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <rect x="3" y="8" width="4" height="14" />
                                        <rect x="10" y="8" width="4" height="14" />
                                        <rect x="17" y="8" width="4" height="14" />
                                        <line x1="1" y1="14" x2="23" y2="14" />
                                        <path d="M5 8L5 2M12 8L12 2M19 8L19 2" />
                                    </svg></div>
                                <span class="category-card__label">Fencing</span>
                            </div>
                            <div class="category-card" data-category="doors-windows" tabindex="0" role="button"
                                aria-label="Doors & Windows">
                                <div class="category-card__icon"><svg viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <rect x="3" y="3" width="18" height="18" rx="2" />
                                        <line x1="12" y1="3" x2="12" y2="21" />
                                        <line x1="3" y1="12" x2="12" y2="12" />
                                        <circle cx="10" cy="15" r="0.5" fill="currentColor" />
                                    </svg></div>
                                <span class="category-card__label">Doors &amp; Windows</span>
                            </div>
                            <div class="category-card" data-category="roofing" tabindex="0" role="button"
                                aria-label="Roofing">
                                <div class="category-card__icon"><svg viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <path d="M3 21h18l-3-9H6l-3 9z" />
                                        <path d="M6 12L12 3l6 9" />
                                    </svg></div>
                                <span class="category-card__label">Roofing</span>
                            </div>
                            <div class="category-card" data-category="damp-mould" tabindex="0" role="button"
                                aria-label="Damp & Mould">
                                <div class="category-card__icon"><svg viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="9" />
                                        <path d="M8 12c0-2 1.5-3 4-3s4 1 4 3-1.5 3-4 3-4-1-4-3z" />
                                    </svg></div>
                                <span class="category-card__label">Damp &amp; Mould</span>
                            </div>
                            <div class="category-card" data-category="pest-control" tabindex="0" role="button"
                                aria-label="Pest Control">
                                <div class="category-card__icon"><svg viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="8" r="3" />
                                        <path d="M5 21c0-4 3-7 7-7s7 3 7 7" />
                                        <path d="M9 5L6 2M15 5l3-3" />
                                    </svg></div>
                                <span class="category-card__label">Pest Control</span>
                            </div>
                            <div class="category-card" data-category="locks-security" tabindex="0" role="button"
                                aria-label="Locks & Security">
                                <div class="category-card__icon"><svg viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <rect x="3" y="11" width="18" height="11" rx="2" />
                                        <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                                        <circle cx="12" cy="16" r="1" />
                                    </svg></div>
                                <span class="category-card__label">Locks &amp; Security</span>
                            </div>
                            <div class="category-card" data-category="other" tabindex="0" role="button"
                                aria-label="Other">
                                <div class="category-card__icon"><svg viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10" />
                                        <line x1="12" y1="8" x2="12" y2="12" />
                                        <line x1="12" y1="16" x2="12.01" y2="16" />
                                    </svg></div>
                                <span class="category-card__label">Other</span>
                            </div>
                        </div>
                        <input type="hidden" id="selected-category" value="">

                        <!-- Area toggle -->
                        <div class="form-group" style="margin-top:var(--space-6)">
                            <label class="form-label">Is this in a private or communal area?</label>
                            <div class="area-toggle" id="area-toggle">
                                <button type="button" class="area-toggle__btn active" data-area="private">🏠
                                    Private</button>
                                <button type="button" class="area-toggle__btn" data-area="communal">🏢 Communal</button>
                            </div>
                            <input type="hidden" id="selected-area" value="private">
                        </div>

                        <!-- Conditional: Appliance fields -->
                        <div class="conditional-fields hidden" id="appliance-fields">
                            <div class="conditional-fields__title">Appliance Details</div>
                            <div class="grid-2">
                                <div class="form-group"><label class="form-label"
                                        for="appliance-make">Make</label><input type="text" class="form-input"
                                        id="appliance-make" placeholder="e.g. Bosch"></div>
                                <div class="form-group"><label class="form-label"
                                        for="appliance-model">Model</label><input type="text" class="form-input"
                                        id="appliance-model" placeholder="e.g. Series 4"></div>
                            </div>
                            <div class="grid-2">
                                <div class="form-group"><label class="form-label" for="appliance-serial">Serial
                                        Number</label><input type="text" class="form-input" id="appliance-serial"
                                        placeholder="Found on back/side"></div>
                                <div class="form-group"><label class="form-label" for="flights-stairs">Flights of
                                        Stairs</label><input type="number" class="form-input" id="flights-stairs"
                                        min="0" max="50" value="0"></div>
                            </div>
                        </div>

                        <!-- Conditional: Leak fields -->
                        <div class="conditional-fields hidden" id="leak-fields">
                            <div class="conditional-fields__title">Leak Details</div>
                            <div class="grid-2">
                                <div class="form-group">
                                    <label class="form-label" for="leak-container">Container size being used</label>
                                    <select class="form-select" id="leak-container">
                                        <option value="">Select...</option>
                                        <option value="cup">Cup / Mug</option>
                                        <option value="bowl">Bowl</option>
                                        <option value="bucket">Bucket</option>
                                        <option value="large-container">Large Container</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="leak-frequency">How often do you empty it?</label>
                                    <select class="form-select" id="leak-frequency">
                                        <option value="">Select...</option>
                                        <option value="hourly">Every hour</option>
                                        <option value="few-hours">Every few hours</option>
                                        <option value="daily">Daily</option>
                                        <option value="weekly">Weekly</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-check">
                                    <input type="checkbox" id="leak-constant">
                                    <span class="form-check__label">The leak is constant (doesn't stop)</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="wizard-nav">
                        <div></div>
                        <button type="button" class="btn btn--primary" id="btn-next-1">Next: Upload Files →</button>
                    </div>
                </div>

                <!-- ══ STEP 2: Upload ══════════════════════════ -->
                <div class="wizard-panel" id="step-2">
                    <div class="card">
                        <h3 style="margin-bottom:var(--space-2)">Upload Photos & Evidence</h3>
                        <p class="text-sm">Help us understand the issue better. You can upload up to 10 files (images,
                            videos, or audio).</p>

                        <div class="upload-zone" id="upload-zone" role="button"
                            aria-label="Click or drag files to upload" tabindex="0">
                            <div class="upload-zone__icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                    <polyline points="17 8 12 3 7 8" />
                                    <line x1="12" y1="3" x2="12" y2="15" />
                                </svg>
                            </div>
                            <p class="upload-zone__text"><strong>Click to upload</strong> or drag and drop</p>
                            <p class="upload-zone__hint">JPG, PNG, GIF, WEBP, MP4, WEBM, MP3, WAV — max 10MB each</p>
                        </div>
                        <input type="file" id="upload-input" multiple accept="image/*,video/*,audio/*" class="hidden">
                        <div class="upload-previews" id="upload-previews"></div>
                        <p class="upload-count" id="upload-count">0 of 10 files selected</p>
                    </div>

                    <div class="wizard-nav">
                        <button type="button" class="btn btn--secondary" id="btn-prev-2">← Back</button>
                        <button type="button" class="btn btn--primary" id="btn-next-2">Next: Address →</button>
                    </div>
                </div>

                <!-- ══ STEP 3: Address ═════════════════════════ -->
                <div class="wizard-panel" id="step-3">
                    <div class="card">
                        <h3 style="margin-bottom:var(--space-2)">Property Address</h3>
                        <p class="text-sm">Where is the issue located?</p>

                        <div class="postcode-lookup" style="margin-top:var(--space-5)">
                            <div class="form-group">
                                <label class="form-label" for="postcode-input">Postcode<span
                                        class="required">*</span></label>
                                <input type="text" class="form-input" id="postcode-input" placeholder="e.g. SW1A 1AA"
                                    aria-required="true">
                            </div>
                            <button type="button" class="btn btn--accent" id="postcode-lookup-btn"
                                style="margin-bottom:var(--space-5)">Look Up</button>
                        </div>

                        <div id="address-manual-fields">
                            <div class="form-group">
                                <label class="form-label" for="address-line1">Address Line 1<span
                                        class="required">*</span></label>
                                <input type="text" class="form-input" id="address-line1"
                                    placeholder="House number and street" aria-required="true">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="address-line2">Address Line 2</label>
                                <input type="text" class="form-input" id="address-line2"
                                    placeholder="Flat, floor, building (optional)">
                            </div>
                            <div class="grid-2">
                                <div class="form-group">
                                    <label class="form-label" for="address-town">Town / City<span
                                            class="required">*</span></label>
                                    <input type="text" class="form-input" id="address-town" aria-required="true">
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="address-county">County</label>
                                    <input type="text" class="form-input" id="address-county">
                                </div>
                            </div>
                            <div class="grid-2">
                                <div class="form-group">
                                    <label class="form-label" for="address-postcode-confirm">Postcode</label>
                                    <input type="text" class="form-input" id="address-postcode-confirm" readonly>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="address-country">Country</label>
                                    <input type="text" class="form-input" id="address-country" value="United Kingdom">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="wizard-nav">
                        <button type="button" class="btn btn--secondary" id="btn-prev-3">← Back</button>
                        <button type="button" class="btn btn--primary" id="btn-next-3">Next: Contact Details →</button>
                    </div>
                </div>

                <!-- ══ STEP 4: Contact Details ══════════════════ -->
                <div class="wizard-panel" id="step-4">
                    <div class="card">
                        <h3 style="margin-bottom:var(--space-2)">Your Contact Details</h3>
                        <p class="text-sm">How should we reach you about this issue?</p>

                        <div style="margin-top:var(--space-5)">
                            <!-- Guest / Account toggle -->
                            <div class="area-toggle" id="account-toggle" style="margin-bottom:var(--space-6)">
                                <button type="button" class="area-toggle__btn active" data-mode="guest">Submit as
                                    Guest</button>
                                <button type="button" class="area-toggle__btn" data-mode="account">Create
                                    Account</button>
                            </div>

                            <div class="grid-2" style="grid-template-columns: 100px 1fr;">
                                <div class="form-group">
                                    <label class="form-label" for="contact-title">Title</label>
                                    <select class="form-select" id="contact-title">
                                        <option value="">—</option>
                                        <option value="Mr">Mr</option>
                                        <option value="Mrs">Mrs</option>
                                        <option value="Ms">Ms</option>
                                        <option value="Miss">Miss</option>
                                        <option value="Dr">Dr</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="contact-firstname">First Name<span
                                            class="required">*</span></label>
                                    <input type="text" class="form-input" id="contact-firstname" aria-required="true">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="contact-surname">Surname<span
                                        class="required">*</span></label>
                                <input type="text" class="form-input" id="contact-surname" aria-required="true">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="contact-email">Email Address<span
                                        class="required">*</span></label>
                                <input type="email" class="form-input" id="contact-email" aria-required="true">
                                <span class="form-hint">We'll send confirmation and updates to this address.</span>
                            </div>
                            <div class="grid-2">
                                <div class="form-group">
                                    <label class="form-label" for="contact-phone">Phone Number<span
                                            class="required">*</span></label>
                                    <input type="tel" class="form-input" id="contact-phone" aria-required="true">
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="contact-altphone">Alternative Phone</label>
                                    <input type="tel" class="form-input" id="contact-altphone">
                                </div>
                            </div>

                            <!-- Account-only fields -->
                            <div class="hidden" id="account-fields">
                                <div class="form-group">
                                    <label class="form-label" for="contact-password">Create Password<span
                                            class="required">*</span></label>
                                    <input type="password" class="form-input" id="contact-password" minlength="8"
                                        placeholder="Minimum 8 characters">
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="contact-password-confirm">Confirm Password<span
                                            class="required">*</span></label>
                                    <input type="password" class="form-input" id="contact-password-confirm">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="wizard-nav">
                        <button type="button" class="btn btn--secondary" id="btn-prev-4">← Back</button>
                        <button type="button" class="btn btn--primary" id="btn-next-4">Next: Confirm & Send →</button>
                    </div>
                </div>

                <!-- ══ STEP 5: Confirm ═════════════════════════ -->
                <div class="wizard-panel" id="step-5">
                    <div class="card">
                        <h3 style="margin-bottom:var(--space-4)">Review & Submit</h3>

                        <div class="summary-card" id="summary-issue">
                            <div class="summary-card__title">📋 Issue Details</div>
                            <div id="summary-issue-rows"></div>
                        </div>

                        <div class="summary-card" id="summary-address">
                            <div class="summary-card__title">📍 Address</div>
                            <div id="summary-address-rows"></div>
                        </div>

                        <div class="summary-card" id="summary-contact">
                            <div class="summary-card__title">👤 Contact</div>
                            <div id="summary-contact-rows"></div>
                        </div>

                        <div class="summary-card" id="summary-files">
                            <div class="summary-card__title">📎 Uploaded Files</div>
                            <div id="summary-files-info"></div>
                        </div>

                        <hr>

                        <!-- Notes -->
                        <div class="form-group">
                            <label class="form-label" for="notes">Additional Notes</label>
                            <textarea class="form-textarea" id="notes" rows="3"
                                placeholder="Parking restrictions, pets, alarms, special access needs..."></textarea>
                        </div>

                        <div class="grid-2" style="margin-bottom:var(--space-4);">
                            <label class="form-check"><input type="checkbox" id="check-parking"><span
                                    class="form-check__label">There are parking restrictions</span></label>
                            <label class="form-check"><input type="checkbox" id="check-pets"><span
                                    class="form-check__label">There are pets on the property</span></label>
                            <label class="form-check"><input type="checkbox" id="check-alarm"><span
                                    class="form-check__label">There is a burglar alarm</span></label>
                            <label class="form-check"><input type="checkbox" id="check-vulnerable"><span
                                    class="form-check__label">Vulnerable occupier present</span></label>
                        </div>

                        <!-- Schedule -->
                        <div class="form-group">
                            <label class="form-label">Preferred Repair Date / Time (optional)</label>
                            <div class="schedule-section">
                                <div class="form-group" style="margin-bottom:0"><input type="date" class="form-input"
                                        id="preferred-date"></div>
                                <div class="form-group" style="margin-bottom:0">
                                    <select class="form-select" id="preferred-time">
                                        <option value="">Any time</option>
                                        <option value="morning">Morning (8am–12pm)</option>
                                        <option value="afternoon">Afternoon (12pm–5pm)</option>
                                        <option value="evening">Evening (5pm–8pm)</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="terms-section">
                            <label class="form-check"><input type="checkbox" id="check-access"><span
                                    class="form-check__label">I authorise access to the property without my presence if
                                    required</span></label>
                            <label class="form-check"><input type="checkbox" id="check-terms" aria-required="true"><span
                                    class="form-check__label">I accept the <a href="#"
                                        style="text-decoration:underline">Terms & Conditions</a> <span
                                        class="required">*</span></span></label>
                            <label class="form-check"><input type="checkbox" id="check-remember"><span
                                    class="form-check__label">Remember my details for next time</span></label>
                        </div>
                    </div>

                    <div class="wizard-nav">
                        <button type="button" class="btn btn--secondary" id="btn-prev-5">← Back</button>
                        <button type="button" class="btn btn--accent btn--lg" id="btn-submit">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M22 2L11 13" />
                                <path d="M22 2l-7 20-4-9-9-4 20-7z" />
                            </svg>
                            Submit Report
                        </button>
                    </div>
                </div>

            </div><!-- /wizard-panels -->

            <!-- Success overlay (hidden by default) -->
            <div class="modal-overlay" id="success-overlay">
                <div class="modal" style="text-align:center">
                    <div style="font-size:64px;margin-bottom:var(--space-4)">✅</div>
                    <h2>Report Submitted!</h2>
                    <p style="margin-top:var(--space-3)">Your reference number is:</p>
                    <p style="font-size:var(--text-2xl);font-weight:var(--weight-bold);color:var(--color-primary);font-family:var(--font-mono);margin:var(--space-3) 0"
                        id="success-ref">HAP-20260305-XXXX</p>
                    <p class="text-sm">You'll receive a confirmation email shortly. You can track progress on the <a
                            href="track.php">Track Issue</a> page.</p>
                    <a href="../index.php" class="btn btn--primary btn--lg" style="margin-top:var(--space-6)">Back to
                        Home</a>
                </div>
            </div>

        </div>
    </main>

    <script src="../js/validation.js"></script>
    <script src="../js/upload.js"></script>
    <script src="../js/postcode.js"></script>
    <script src="../js/wizard.js"></script>
    <script src="../js/app.js"></script>
</body>

</html>