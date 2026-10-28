@extends('admin.layout.' . $layout)

@section('subhead')
<title>Create Event | TRACESCI Admin</title>
<meta name="description" content="Create and Upload a New Event in TRACESCI.">
<meta name="robots" content="noindex, nofollow">
<meta property="og:title" content="Events | TRACESCI Admin">
<meta property="og:description" content="Create and Upload a new Event on TRACESCI.">
<meta property="og:type" content="website">
<link rel="canonical" href="{{ url('/admin/Events/create') }}">

<style>
    /* === Card & Layout Enhancements === */
    .event-form-card {
        border-radius: 12px;
        box-shadow: 0 4px 24px rgba(0, 0, 0, 0.07);
        overflow: hidden;
    }

    .event-form-header h2 {
        color: #fff;
        font-size: 1rem;
        font-weight: 600;
        margin: 0;
        letter-spacing: 0.01em;
    }

    .event-form-header .header-icon {
        width: 36px;
        height: 36px;
        background: rgba(255, 255, 255, 0.18);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .event-form-header .header-icon svg {
        width: 18px;
        height: 18px;
        stroke: #fff;
    }

    /* === Field Groups === */
    .field-group-label {
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: #6b7280;
        padding: 18px 8px 6px;
        border-bottom: 1px dashed #e5e7eb;
        margin-bottom: 4px;
        grid-column: span 12;
    }

    .dark .field-group-label {
        color: #9ca3af;
        border-color: #374151;
    }

    /* === Input Enhancements === */
    .form__input {
        border-radius: 8px !important;
        transition: border-color 0.2s, box-shadow 0.2s !important;
        font-size: 0.875rem !important;
    }

    .form__input:focus {
        box-shadow: 0 0 0 3px rgba(26, 86, 219, 0.12) !important;
        border-color: #1a56db !important;
    }

    .form-label {
        font-size: 0.8rem !important;
        font-weight: 600 !important;
        color: #374151 !important;
        margin-bottom: 5px !important;
    }

    .dark .form-label {
        color: #d1d5db !important;
    }

    /* === Character hint === */
    .input-hint {
        font-size: 0.72rem;
        color: #9ca3af;
        margin-top: 3px;
    }

    /* === Submit Button === */
    #btn-add {
        border-radius: 8px !important;
        font-weight: 600 !important;
        letter-spacing: 0.02em !important;
        padding: 10px 28px !important;
        transition: transform 0.15s, box-shadow 0.15s !important;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    #btn-add:not([disabled]):hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 14px rgba(26, 86, 219, 0.35) !important;
    }

    #btn-add:not([disabled]):active {
        transform: translateY(0);
    }

    /* === Cancel Button === */
    #btn-cancel {
        border-radius: 8px !important;
        font-weight: 500 !important;
        padding: 10px 22px !important;
    }

    /* === Error states === */
    .login__input-error {
        font-size: 0.75rem !important;
        margin-top: 4px !important;
    }

    /* === Page header === */
    .page-header-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 6px;
    }

    .breadcrumb-nav {
        font-size: 0.78rem;
        color: #9ca3af;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .breadcrumb-nav a {
        color: #1a56db;
        text-decoration: none;
        font-weight: 500;
    }

    .breadcrumb-nav a:hover {
        text-decoration: underline;
    }

    .breadcrumb-nav svg {
        width: 12px;
        height: 12px;
        stroke: #d1d5db;
    }

    /* === Required asterisk === */
    .required-mark {
        color: #ef4444;
        margin-left: 2px;
    }

    /* === Status badge preview === */
    .status-preview {
        display: inline-block;
        margin-left: 10px;
        font-size: 0.7rem;
        padding: 2px 8px;
        border-radius: 999px;
        font-weight: 600;
        vertical-align: middle;
        transition: all 0.2s;
    }

    .status-preview.active {
        background: #d1fae5;
        color: #065f46;
    }

    .status-preview.inactive {
        background: #fee2e2;
        color: #991b1b;
    }
</style>
@endsection

@section('subcontent')

<header class="intro-y mt-8">
    <div class="page-header-bar">
        <div>
            <h1 class="text-lg font-medium" style="font-size:1.2rem;">Create New Event</h1>
            <nav class="breadcrumb-nav" aria-label="Breadcrumb">
                <a href="{{ url('/admin') }}">Dashboard</a>
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
                <a href="{{ url('/admin/Events') }}">Events</a>
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
                <span>Create New</span>
            </nav>
        </div>
        <a href="{{ url('/admin/Events') }}" class="btn btn-outline-secondary btn-sm" style="border-radius:8px;font-size:0.8rem;">
            ← Back to Events
        </a>
    </div>
</header>

<main class="grid grid-cols-12 gap-6 mt-5" id="main-content" aria-label="Create New Event Form">
    <div class="intro-y col-span-12 lg:col-span-12">
        <form id="add-form" enctype="multipart/form-data" novalidate aria-label="Create event form">
            @csrf

            <article class="intro-y box event-form-card">

                <div class="p-5 pb-7">
                    <div class="grid grid-cols-12">
                        <span class="input-hint ml-2" aria-hidden="true"><span class="required-mark">*</span> Required fields</span>

                        {{-- Section: Basic Info --}}
                        <div class="field-group-label" role="heading" aria-level="3">Basic Information</div>

                        {{-- Event Name --}}
                        <div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-1">
                            <label for="event_name" class="form-label">
                                Event Name <span class="required-mark" aria-hidden="true">*</span>
                            </label>
                            <input
                                id="event_name"
                                type="text"
                                name="event_name"
                                class="form-control form__input"
                                placeholder="Please enter Event Name"
                                autocomplete="off"
                                aria-required="true"
                                aria-describedby="error-event_name hint-event_name">
                            <p id="hint-event_name" class="input-hint">A clear, descriptive Name for the Event.</p>
                            <div id="error-event_name" class="login__input-error w-5/6 text-theme-6" role="alert" aria-live="polite"></div>
                        </div>

                        {{-- Start Date --}}
                        <div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-1">
                            <label for="start_date" class="form-label">
                                Start Date <span class="required-mark" aria-hidden="true">*</span>
                            </label>
                            <input
                                id="start_date"
                                type="date"
                                name="start_date"
                                class="form-control form__input"
                                aria-required="true"
                                aria-describedby="error-start_date hint-start_date">
                            <p id="hint-start_date" class="input-hint">Date for Starting of the Event.</p>
                            <div id="error-start_date" class="login__input-error w-5/6 text-theme-6" role="alert" aria-live="polite"></div>
                        </div>
                        {{-- End Date --}}
                        <div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-1">
                            <label for="end_date" class="form-label">
                                End Date <span class="required-mark" aria-hidden="true">*</span>
                            </label>
                            <input
                                id="end_date"
                                type="date"
                                name="end_date"
                                class="form-control form__input"
                                aria-required="true"
                                aria-describedby="error-end_date hint-end_date">
                            <p id="hint-end_date" class="input-hint">Date for Ending of the Event.</p>
                            <div id="error-end_date" class="login__input-error w-5/6 text-theme-6" role="alert" aria-live="polite"></div>
                        </div>

                        {{-- Address --}}
                        <div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-1">
                            <label for="address" class="form-label">
                                Address of Event <span class="required-mark" aria-hidden="true">*</span>
                            </label>
                            <textarea
                                id="address"
                                type="text"
                                name="address"
                                class="form-control form__input"
                                placeholder="Please provide Venue and Address Details"
                                aria-required="true"
                                aria-describedby="error-address hint-address"></textarea>
                            <p id="hint-address" class="input-hint">Event Venue and Address Details for the Event.</p>
                            <div id="error-address" class="login__input-error w-5/6 text-theme-6" role="alert" aria-live="polite"></div>
                        </div>
                        {{-- City --}}
                        <div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-1">
                            <label for="city" class="form-label">
                                Event City <span class="required-mark" aria-hidden="true">*</span>
                            </label>
                            <input
                                id="city"
                                type="text"
                                name="city"
                                class="form-control form__input"
                                placeholder="Please enter Event City"
                                autocomplete="off"
                                aria-required="true"
                                aria-describedby="error-event_name hint-city">
                            <p id="hint-city" class="input-hint">City of the Event / Location of the Event.</p>
                            <div id="error-city" class="login__input-error w-5/6 text-theme-6" role="alert" aria-live="polite"></div>
                        </div>

                        {{-- Event Image --}}
                        <div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-1">
                            <label for="event_img" class="form-label">
                                Event Cover Image<span class="required-mark" aria-hidden="true">*</span>
                            </label>
                            <input
                                id="event_img"
                                type="file"
                                name="event_img"
                                accept="image/png, image/jpeg, image/jpg"
                                class="form-control form__input"
                                aria-required="true"
                                aria-describedby="error-event_img hint-event_img">
                            <p id="hint-event_img" class="input-hint">
                                Upload an associated image (JPG, PNG, JPEG). Max size: 2MB.
                                <strong style="color:red;">Image dimensions must be exactly (455px × 215px)</strong>, otherwise the image will not be displayed properly on the homepage.
                            </p>
                            <div id="error-event_img" class="login__input-error w-5/6 text-theme-6" role="alert" aria-live="polite"></div>
                        </div>

                        {{-- Section: Authorization --}}
                        <div class="field-group-label" role="heading" aria-level="3">Authorization</div>

                        {{-- Visibility --}}
                        <div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-1">
                            <label for="allowed" class="form-label">
                                Visibility
                            </label>
                            <div class="form-check form-switch mt-2">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    id="allowed"
                                    name="allowed"
                                    value="1">
                                <label class="form-check-label" for="allowed">
                                    Display on Homepage
                                </label>
                            </div>
                            <p id="hint-allowed" class="input-hint">Mark the Checkbox for Displaying Event on the Homepage.</p>
                            <div id="error-allowed" class="login__input-error w-5/6 text-theme-6" role="alert" aria-live="polite"></div>
                        </div>

                        {{-- Status --}}
                        <div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-1">
                            <label for="status" class="form-label">
                                Status <span class="required-mark" aria-hidden="true">*</span>
                                <span id="status-badge" class="status-preview inactive" aria-live="polite">InActive</span>
                            </label>
                            <select
                                id="status"
                                name="status"
                                class="form-select form__input"
                                aria-describedby="hint-status">
                                <option value="0">Inactive</option>
                                <option value="1">Active</option>
                            </select>
                            <p id="hint-status" class="input-hint">Inactive events won't be visible on the Homepage.</p>
                        </div>

                        {{-- Description --}}
                        <div class="input-form col-span-12 lg:col-span-12 px-2 py-1 mt-2">
                            <label for="description" class="form-label">
                                Event Description
                            </label>
                            <textarea
                                id="description"
                                rows="5"
                                name="description"
                                class="form-control form__input tinymce"
                                placeholder="Add a short description covering the event’s purpose, key highlights, and overall experience."
                                minlength="2"
                                aria-describedby="error-description hint-description"></textarea>
                            <p id="hint-description" class="input-hint"></p>
                            <div id="error-description" class="login__input-error w-5/6 text-theme-6" role="alert" aria-live="polite"></div>
                        </div>

                        {{-- Actions --}}
                        <div class="input-form col-span-12 lg:col-span-12 px-2 py-1 mt-5 flex flex-wrap gap-3 items-center">
                            <button type="submit" id="btn-add" class="btn btn-primary" aria-label="Save new event">
                                Add Event
                            </button>
                            <a href="{{ url('/admin/Events') }}" id="btn-cancel" class="btn btn-outline-secondary" aria-label="Cancel and return to events list">
                                Cancel
                            </a>
                        </div>

                    </div>
                </div>
            </article>
        </form>
    </div>
    <x-notification></x-notification>
</main>
@endsection

@section('script')


<script>
    cash(function() {
        var REQUIRED_W = 455;
        var REQUIRED_H = 215;
        var MAX_FILE_SIZE = 2 * 1024 * 1024;
        var isSubmitting = false;

        var form = document.getElementById('add-form');
        var button = document.getElementById('btn-add');

        var originalButtonHtml = button ? button.innerHTML : '';
        var originalThumb = document.getElementById('current-img-thumb');
        var originalThumbSrc = originalThumb ? originalThumb.src : null;

        // Status badge preview
        cash('#status').on('change', function() {
            var badge = document.getElementById('status-badge');
            if (!badge) return;

            if (this.value === '1') {
                badge.textContent = 'Active';
                badge.className = 'status-preview active';
            } else {
                badge.textContent = 'Inactive';
                badge.className = 'status-preview inactive';
            }
        });

        function showError(id, message) {
            var field = document.getElementById(id);
            var error = document.getElementById('error-' + id);

            if (field) {
                field.classList.add('border-theme-6');
                field.setAttribute('aria-invalid', 'true');
            }

            if (error) {
                error.textContent = message;
            }

            if (id === 'description' &&
                typeof tinymce !== 'undefined' &&
                tinymce.get('description')) {
                tinymce.get('description').getContainer().style.border =
                    '1px solid #ef4444';
            }
        }

        function clearError(id) {
            var field = document.getElementById(id);
            var error = document.getElementById('error-' + id);

            if (field) {
                field.classList.remove('border-theme-6');
                field.removeAttribute('aria-invalid');
            }

            if (error) {
                error.textContent = '';
            }

            if (id === 'description' &&
                typeof tinymce !== 'undefined' &&
                tinymce.get('description')) {
                tinymce.get('description').getContainer().style.border = '';
            }
        }

        function getDescription() {
            if (typeof tinymce !== 'undefined' &&
                tinymce.get('description')) {
                return tinymce.get('description')
                    .getContent({
                        format: 'text'
                    }).trim();
            }

            var field = document.getElementById('description');
            return field ? field.value.trim() : '';
        }

        // Validate text, date, status and any other required fields
        function validateFields() {
            var valid = true;

            // Clear previous field errors
            form.querySelectorAll('.login__input-error').forEach(function(el) {
                el.textContent = '';
            });

            form.querySelectorAll('[aria-invalid="true"]').forEach(function(el) {
                el.removeAttribute('aria-invalid');
                el.classList.remove('border-theme-6');
            });

            if (typeof tinymce !== 'undefined' &&
                tinymce.get('description')) {
                tinymce.get('description').getContainer().style.border = '';
            }

            // Title
            var title = document.getElementById('title');

            if (title && !title.value.trim()) {
                showError('title', 'Please enter the event title.');
                valid = false;
            }

            // Date: supports common event form field IDs
            var dateField = document.getElementById('event_date') ||
                document.getElementById('publish_date') ||
                document.getElementById('date');

            if (dateField) {
                var value = dateField.value;
                var parsed = value ? new Date(value) : null;

                if (!value || !parsed || isNaN(parsed.getTime())) {
                    showError(dateField.id, 'Please select a valid date.');
                    valid = false;
                }
            }

            // Publisher, if this field exists
            var publisher = document.getElementById('publish_by');

            if (publisher && !publisher.value.trim()) {
                showError('publish_by', 'Please enter the publisher name.');
                valid = false;
            }

            // Status
            var status = document.getElementById('status');

            if (status && !['0', '1'].includes(status.value)) {
                showError('status', 'Please select a valid status.');
                valid = false;
            }

            // Description: optional, but if supplied must contain 2+ characters
            var description = getDescription();

            if (description.length === 1) {
                showError(
                    'description',
                    'Description must contain at least 2 characters.'
                );
                valid = false;
            }

            // Validate all other controls marked required in HTML.
            form.querySelectorAll('input[required], select[required], textarea[required]')
                .forEach(function(field) {
                    if (field.type === 'file') return;
                    if (field.type === 'checkbox' && !field.checked) {
                        showError(field.id, 'This field is required.');
                        valid = false;
                        return;
                    }

                    if (field.type !== 'checkbox' && !field.value.trim()) {
                        showError(field.id, 'This field is required.');
                        valid = false;
                    }
                });

            return valid;
        }

        // Validate event image type, size and exact dimensions
        function validateImage(file) {
            return new Promise(function(resolve) {
                if (!file) {
                    showError('event_img', 'Please select an event image.');
                    resolve(false);
                    return;
                }

                if (!['image/jpeg', 'image/png'].includes(file.type)) {
                    showError(
                        'event_img',
                        'Only JPG, JPEG, and PNG images are allowed.'
                    );
                    resolve(false);
                    return;
                }

                if (file.size > MAX_FILE_SIZE) {
                    showError('event_img', 'Image size must not exceed 2 MB.');
                    resolve(false);
                    return;
                }

                var objectUrl = URL.createObjectURL(file);
                var img = new Image();

                img.onload = function() {
                    var width = img.naturalWidth;
                    var height = img.naturalHeight;

                    URL.revokeObjectURL(objectUrl);

                    if (width !== REQUIRED_W || height !== REQUIRED_H) {
                        showError(
                            'event_img',
                            'Image must be exactly 455 × 215 pixels. ' +
                            'Selected image: ' + width + ' × ' + height + ' pixels.'
                        );

                        resolve(false);
                        return;
                    }

                    clearError('event_img');

                    var thumb = document.getElementById('current-img-thumb');

                    if (thumb) {
                        var reader = new FileReader();

                        reader.onload = function(e) {
                            thumb.src = e.target.result;
                        };

                        reader.readAsDataURL(file);
                    }

                    resolve(true);
                };

                img.onerror = function() {
                    URL.revokeObjectURL(objectUrl);

                    showError(
                        'event_img',
                        'Could not read the image. Please select a valid JPG or PNG.'
                    );

                    resolve(false);
                };

                img.src = objectUrl;
            });
        }

        // Validate immediately when the image is selected
        cash('#event_img').on('change', async function() {
            var input = this;
            var file = input.files[0];

            clearError('event_img');

            if (!file) return;

            var valid = await validateImage(file);

            if (!valid) {
                input.value = '';

                if (originalThumb && originalThumbSrc) {
                    originalThumb.src = originalThumbSrc;
                }
            }
        });

        // Clear a field's error when the user corrects it
        cash('#add-form input, #add-form select, #add-form textarea')
            .on('input change', function() {
                clearError(this.id);
            });

        async function add() {
            if (isSubmitting) return;

            if (!validateFields()) {
                var firstError = form.querySelector('[aria-invalid="true"]');

                if (firstError) {
                    firstError.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                    firstError.focus();
                }

                return;
            }

            isSubmitting = true;

            if (button) {
                button.disabled = true;
                button.innerHTML = 'Validating…';
            }

            try {
                var imageInput = document.getElementById('event_img');
                var imageValid = await validateImage(
                    imageInput ? imageInput.files[0] : null
                );

                if (!imageValid) {
                    if (imageInput) {
                        imageInput.value = '';
                        imageInput.focus();
                    }

                    if (originalThumb && originalThumbSrc) {
                        originalThumb.src = originalThumbSrc;
                    }

                    return;
                }

                // Sync TinyMCE content before constructing FormData
                if (typeof tinymce !== 'undefined') {
                    tinymce.triggerSave();
                }

                // Recheck fields before submitting
                if (!validateFields()) {
                    var invalid = form.querySelector('[aria-invalid="true"]');

                    if (invalid) {
                        invalid.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                        invalid.focus();
                    }

                    return;
                }

                var formData = new FormData(form);

                button.innerHTML =
                    '<i data-loading-icon="oval" data-color="white" class="w-4 h-4 mr-2"></i> Saving…';

                cash('#btn-add').svgLoader();

                var res = await axios.post(
                    "{{ url('/admin/Events/store') }}",
                    formData
                );

                showNotification('success', 'Success!', res.data.message);

                setTimeout(function() {
                    window.location.href = "{{ url('/admin/Events') }}";
                }, 1000);

            } catch (err) {
                var response = err.response;
                var data = response && response.data ? response.data : {};

                showNotification(
                    'error',
                    'Error!',
                    data.message || 'Unable to save the event. Please try again.'
                );

                if (data.errors) {
                    Object.entries(data.errors).forEach(function([key, messages]) {
                        var message = Array.isArray(messages) ?
                            messages.join(' ') :
                            messages;

                        showError(key, message);
                    });

                    var firstError = form.querySelector('[aria-invalid="true"]');

                    if (firstError) {
                        firstError.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                        firstError.focus();
                    }
                }

            } finally {
                isSubmitting = false;

                if (button) {
                    button.disabled = false;
                    button.innerHTML = originalButtonHtml;
                }
            }
        }

        // AJAX submit
        cash('#add-form').on('submit', function(e) {
            e.preventDefault();
            add();
        });
    });
</script>


@endsection