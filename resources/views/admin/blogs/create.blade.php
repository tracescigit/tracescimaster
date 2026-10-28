@extends('admin.layout.' . $layout)

@section('subhead')
<title>Create Blog| TRACESCI Admin</title>
<meta name="description" content="Create and Upload a New Blog in TRACESCI.">
<meta name="robots" content="noindex, nofollow">
<meta property="og:title" content="Blogs | TRACESCI Admin">
<meta property="og:description" content="Create and Upload a new Blog on TRACESCI.">
<meta property="og:type" content="website">
<link rel="canonical" href="{{ url('/admin/Blog/create') }}">

<style>
    /* === Card & Layout Enhancements === */
    .blog-form-card {
        border-radius: 12px;
        box-shadow: 0 4px 24px rgba(0, 0, 0, 0.07);
        overflow: hidden;
    }



    .blog-form-header h2 {
        color: #fff;
        font-size: 1rem;
        font-weight: 600;
        margin: 0;
        letter-spacing: 0.01em;
    }

    .blog-form-header .header-icon {
        width: 36px;
        height: 36px;
        background: rgba(255, 255, 255, 0.18);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .blog-form-header .header-icon svg {
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

    /* === Input with icon prefix === */
    .input-with-prefix {
        position: relative;
    }

    .input-prefix {
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f3f4f6;
        border: 1px solid #d1d5db;
        border-right: none;
        border-radius: 8px 0 0 8px;
        font-size: 0.8rem;
        font-weight: 600;
        color: #6b7280;
        pointer-events: none;
    }

    .dark .input-prefix {
        background: #374151;
        border-color: #4b5563;
        color: #9ca3af;
    }

    .input-with-prefix .form__input {
        padding-left: 46px !important;
        border-radius: 0 8px 8px 0 !important;
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

{{-- SEO: Structured page heading with breadcrumb --}}
<header class="intro-y mt-8">
    <div class="page-header-bar">
        <div>
            <h1 class="text-lg font-medium" style="font-size:1.2rem;">Create New blog</h1>
            <nav class="breadcrumb-nav" aria-label="Breadcrumb">
                <a href="{{ url('/admin') }}">Dashboard</a>
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
                <a href="{{ url('/admin/Blog') }}">Blogs</a>
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
                <span>Create New</span>
            </nav>
        </div>
        <a href="{{ url('/admin/Blog') }}" class="btn btn-outline-secondary btn-sm" style="border-radius:8px;font-size:0.8rem;">
            ← Back to Blogs
        </a>
    </div>
</header>

<main class="grid grid-cols-12 gap-6 mt-5" id="main-content" aria-label="create New blog Form">
    <div class="intro-y col-span-12 lg:col-span-12">
        <form id="add-form" enctype="multipart/form-data" novalidate aria-label="Create blog form">
            @csrf

            <article class="intro-y box blog-form-card">

                {{-- Card Header --}}


                <div class="p-5 pb-7">
                    <div class="grid grid-cols-12">
                        <span class="input-hint ml-2" aria-hidden="true"><span class="required-mark">*</span> Required fields</span>
                        {{-- Section: Basic Info --}}
                        <div class="field-group-label" role="heading" aria-level="3">Basic Information</div>

                        {{-- blog Title --}}
                        <div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-1">
                            <label for="title" class="form-label">
                                Blog Title <span class="required-mark" aria-hidden="true">*</span>
                            </label>
                            <input
                                id="title"
                                type="text"
                                name="title"
                                class="form-control form__input"
                                placeholder="Please enter title"
                                autocomplete="off"
                                aria-required="true"
                                aria-describedby="error-title hint-title">
                            <p id="hint-title" class="input-hint">A clear, descriptive name for the blog.</p>
                            <div id="error-title" class="login__input-error w-5/6 text-theme-6" role="alert" aria-live="polite"></div>
                        </div>

                        {{-- date --}}
                        <div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-1">
                            <label for="Publish_date" class="form-label">
                                Published Date <span class="required-mark" aria-hidden="true">*</span>
                            </label>
                            <input
                                id="publish_date"
                                type="date"
                                name="publish_date"
                                class="form-control form__input"
                                placeholder="Please provide Publishing date"
                                aria-required="true"
                                aria-describedby="error-credits hint-credits">
                            <p id="hint-publish_date" class="input-hint">Date for Publishing/releasing of the Blog Provided.</p>
                            <div id="error-credits" class="login__input-error w-5/6 text-theme-6" role="alert" aria-live="polite"></div>
                        </div>


                        {{-- Published by--}}
                        <div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-1">
                            <label for="publish_by" class="form-label">
                                Published By<span class="required-mark" aria-hidden="true">*</span>
                            </label>
                            <input
                                id="publish_by"
                                type="text"
                                name="publish_by"
                                class="form-control form__input"
                                placeholder="Please provide Publisher Name"
                                aria-required="true"
                                aria-describedby="error-allowed_products hint-allowed_products">
                            <p id="hint-allowed_products" class="input-hint">Name of the Publisher for this Blog.</p>
                            <div id="error-" class="login__input-error w-5/6 text-theme-6" role="alert" aria-live="polite"></div>
                        </div>

                        {{-- Image --}}
                        <div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-1">
                            <label for="blog_img" class="form-label">
                                Blog Image <span class="required-mark" aria-hidden="true">*</span>
                            </label>

                            <input
                                id="blog_img"
                                type="file"
                                name="blog_img"
                                accept="image/png, image/jpeg, image/jpg"
                                class="form-control form__input"
                                aria-required="true"
                                aria-describedby="hint-blog_img error-blog_img">

                            <p id="hint-blog_img" class="input-hint">
                                Upload an associated image in JPG, JPEG, or PNG format.
                                Maximum file size: 2MB.
                                <strong style="color:red;">Required dimensions: 325 × 325 pixels.</strong>
                                Images with different dimensions may not display properly.
                            </p>

                            <div id="error-blog_img"
                                class="login__input-error w-5/6 text-theme-6"
                                role="alert"
                                aria-live="polite"></div>
                        </div>

                        {{-- Section: Permissions --}}
                        <div class="field-group-label" role="heading" aria-level="3">Authorization</div>

                        {{-- Is allowed --}}
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



                            <p id="hint-allowed" class="input-hint">Mark the Checkbox for Displaying Blog.</p>
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
                            <p id="hint-status" class="input-hint">Inactive blogs won't be visible in Homepage.</p>
                        </div>

                        {{-- Description --}}
                        <div class="input-form col-span-12 lg:col-span-12 px-2 py-1 mt-2">
                            <label for="description" class="form-label">
                                Blog Description
                            </label>
                            <textarea
                                id="description"
                                rows="5"
                                name="description"
                                class="form-control form__input tinymce"
                                placeholder="Describe what's included in this blog, key features, and any limitations…"
                                minlength="2"
                                aria-describedby="error-description hint-description"></textarea>
                            <p id="hint-description" class="input-hint">This description will be Blog's Content along with the Image.</p>
                            <div id="error-description" class="login__input-error w-5/6 text-theme-6" role="alert" aria-live="polite"></div>
                        </div>

                        {{-- Actions --}}
                        <div class="input-form col-span-12 lg:col-span-12 px-2 py-1 mt-5 flex flex-wrap gap-3 items-center">
                            <button type="submit" id="btn-add" class="btn btn-primary" aria-label="Save new blog">
                                Add blog
                            </button>
                            <a href="{{ url('/admin/Blog') }}" id="btn-cancel" class="btn btn-outline-secondary" aria-label="Cancel and return to blogs list">
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
        var REQUIRED_W = 325;
        var REQUIRED_H = 325;
        var MAX_FILE_SIZE = 2 * 1024 * 1024;
        var isSubmitting = false;

        var form = document.getElementById('add-form');
        var originalThumb = document.getElementById('current-img-thumb');
        var originalThumbSrc = originalThumb ? originalThumb.src : null;

        // Status badge preview
        cash('#status').on('change', function() {
            var badge = document.getElementById('status-badge');
            if (!badge) return;

            if (cash(this).val() === '1') {
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

        function clearAllErrors() {
            form.querySelectorAll('.border-theme-6').forEach(function(field) {
                field.classList.remove('border-theme-6');
                field.removeAttribute('aria-invalid');
            });

            form.querySelectorAll('.login__input-error').forEach(function(error) {
                error.textContent = '';
            });

            if (typeof tinymce !== 'undefined' &&
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

            return document.getElementById('description').value.trim();
        }

        // Validate all non-image fields
        function validateFields() {
            var valid = true;
            var title = document.getElementById('title');
            var date = document.getElementById('publish_date');
            var publisher = document.getElementById('publish_by');
            var status = document.getElementById('status');
            var description = getDescription();

            clearError('title');
            clearError('publish_date');
            clearError('publish_by');
            clearError('status');
            clearError('description');

            if (!title.value.trim()) {
                showError('title', 'Please enter the blog title.');
                valid = false;
            }

            var dateValue = date.value;
            var parsedDate = dateValue ?
                new Date(dateValue + 'T00:00:00Z') :
                null;

            if (!dateValue ||
                !parsedDate ||
                isNaN(parsedDate.getTime()) ||
                parsedDate.toISOString().slice(0, 10) !== dateValue) {
                showError('publish_date', 'Please select a valid published date.');
                valid = false;
            }

            if (!publisher.value.trim()) {
                showError('publish_by', 'Please enter the publisher name.');
                valid = false;
            }

            if (!['0', '1'].includes(status.value)) {
                showError('status', 'Please select a valid status.');
                valid = false;
            }

            // Description is optional, but if entered must contain 2+ characters.
            if (description.length === 1) {
                showError(
                    'description',
                    'Description must contain at least 2 characters.'
                );
                valid = false;
            }

            return valid;
        }

        // Validate the selected image and dimensions
        function validateImage(file) {
            return new Promise(function(resolve) {
                if (!file) {
                    showError('blog_img', 'Please select a blog image.');
                    resolve(false);
                    return;
                }

                if (!['image/jpeg', 'image/png'].includes(file.type)) {
                    showError(
                        'blog_img',
                        'Only JPG, JPEG, and PNG images are allowed.'
                    );
                    resolve(false);
                    return;
                }

                if (file.size > MAX_FILE_SIZE) {
                    showError('blog_img', 'Image size must not exceed 2MB.');
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
                            'blog_img',
                            'Image must be exactly 325 × 325 pixels. ' +
                            'Selected image: ' + width + ' × ' + height + ' pixels.'
                        );
                        resolve(false);
                        return;
                    }

                    clearError('blog_img');
                    resolve(true);
                };

                img.onerror = function() {
                    URL.revokeObjectURL(objectUrl);
                    showError(
                        'blog_img',
                        'Could not read this image. Please select a valid JPG or PNG.'
                    );
                    resolve(false);
                };

                img.src = objectUrl;
            });
        }

        // Immediate image validation and preview on selection
        cash('#blog_img').on('change', async function() {
            var input = this;
            var file = input.files[0];

            clearError('blog_img');

            if (!file) return;

            var valid = await validateImage(file);

            if (!valid) {
                input.value = '';

                if (originalThumb && originalThumbSrc) {
                    originalThumb.src = originalThumbSrc;
                }

                return;
            }

            var thumb = document.getElementById('current-img-thumb');

            if (thumb) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    thumb.src = e.target.result;
                };

                reader.readAsDataURL(file);
            }
        });

        async function add() {
            if (isSubmitting) return;

            clearAllErrors();

            if (!validateFields()) {
                var firstInvalid = form.querySelector('[aria-invalid="true"]');

                if (firstInvalid) {
                    firstInvalid.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                    firstInvalid.focus();
                }

                return;
            }

            isSubmitting = true;

            var button = document.getElementById('btn-add');
            var originalButtonHtml = button.innerHTML;

            button.disabled = true;
            button.innerHTML = 'Validating image…';

            try {
                var file = document.getElementById('blog_img').files[0];
                var imageValid = await validateImage(file);

                if (!imageValid) {
                    document.getElementById('blog_img').value = '';

                    if (originalThumb && originalThumbSrc) {
                        originalThumb.src = originalThumbSrc;
                    }

                    document.getElementById('blog_img').focus();
                    return;
                }

                // Sync TinyMCE content to its textarea before creating FormData.
                if (typeof tinymce !== 'undefined') {
                    tinymce.triggerSave();
                }

                // Revalidate fields in case values changed during image validation.
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

                button.innerHTML = 'Saving…';

                var res = await axios.post(
                    "{{ url('/admin/Blog/store') }}",
                    formData
                );

                showNotification('success', 'Success!', res.data.message);

                setTimeout(function() {
                    window.location.href = "{{ url('/admin/Blog') }}";
                }, 1000);

            } catch (err) {
                var response = err.response;
                var data = response && response.data ? response.data : {};

                showNotification(
                    'error',
                    'Error!',
                    data.message || 'Unable to save the blog. Please try again.'
                );

                if (data.errors) {
                    Object.entries(data.errors).forEach(function([key, messages]) {
                        var message = Array.isArray(messages) ?
                            messages[0] :
                            messages;

                        if (document.getElementById(key)) {
                            showError(key, message);
                        } else {
                            var errorBox = document.getElementById('error-' + key);

                            if (errorBox) {
                                errorBox.textContent = message;
                            }
                        }
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
                button.disabled = false;
                button.innerHTML = originalButtonHtml;
            }
        }

        // Clear an individual field's error as the user corrects it.
        cash('#add-form input, #add-form select, #add-form textarea')
            .on('input change', function() {
                clearError(this.id);
            });

        // AJAX submission
        cash('#add-form').on('submit', function(e) {
            e.preventDefault();
            add();
        });
    });
</script>

@endsection