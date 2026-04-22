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
                            <p id="hint-event_img" class="input-hint">Upload an Associated Image (JPG, PNG, JPEG). Max size: 2MB.</p>
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

        // Status badge live preview
        cash('#status').on('change', function() {
            var val = cash(this).val();
            var badge = document.getElementById('status-badge');
            if (val === '1') {
                badge.textContent = 'Active';
                badge.className = 'status-preview active';
            } else {
                badge.textContent = 'Inactive';
                badge.className = 'status-preview inactive';
            }
        });

        async function add() {

            // Reset all errors
            cash('#add-form').find('input, select, textarea').removeClass('border-theme-6');
            cash('#add-form').find('.login__input-error').html('');

            // Reset TinyMCE border
            if (typeof tinymce !== "undefined" && tinymce.get('description')) {
                tinymce.get('description').getContainer().style.border = '';
            }

            var formData = new FormData(document.querySelector('#add-form'));

            cash('#btn-add')
                .html('<i data-loading-icon="oval" data-color="white" class="w-4 h-4 mr-2"></i> Saving…')
                .svgLoader();

            cash('#btn-add').attr('disabled', 'true');

            axios.post("{{ url('/admin/Events/store') }}", formData)
                .then(res => {
                    showNotification('success', 'Success!', res.data.message);

                    setTimeout(() => {
                        window.location.href = "{{ url('/admin/Events') }}";
                    }, 1000);
                })
                .catch(err => {

                    showNotification('error', 'Error!', err.response.data.message);

                    cash('#btn-add').html(
                        '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> Add Event'
                    );

                    cash('#btn-add').removeAttr('disabled');

                    if (err.response.data.errors) {

                        for (const [key, val] of Object.entries(err.response.data.errors)) {

                            let field = cash(`#${key}`);

                            if (key === 'description') {
                                field = cash('#description');

                                if (typeof tinymce !== "undefined" && tinymce.get('description')) {
                                    tinymce.get('description').getContainer().style.border = '1px solid #ef4444';
                                }
                            }

                            if (key === 'event_img') {
                                field = cash('#event_img');
                            }

                            // Add error class
                            field.addClass('border-theme-6');

                            // Show error message
                            cash(`#error-${key}`).html(val);
                        }

                        // Scroll to first error
                        var firstError = document.querySelector('.border-theme-6');
                        if (firstError) {
                            firstError.scrollIntoView({
                                behavior: 'smooth',
                                block: 'center'
                            });
                        }
                    }
                });
        }

        // Submit handler
        cash('#add-form').on('submit', function(e) {
            e.preventDefault();
            add();
        });

        // Remove error on input change
        cash('input, select, textarea').on('input change', function() {
            cash(this).removeClass('border-theme-6');

            let id = cash(this).attr('id');
            if (id) {
                cash(`#error-${id}`).html('');
            }
        });

    });
</script>
@endsection