@extends('admin.layout.' . $layout)

@section('subhead')
<title>Edit Blog | TRACESCI Admin</title>
<meta name="description" content="Edit and Update a Blog in TRACESCI.">
<meta name="robots" content="noindex, nofollow">
<meta property="og:title" content="Edit Blog | TRACESCI Admin">
<meta property="og:description" content="Edit and Update a Blog on TRACESCI.">
<meta property="og:type" content="website">
<link rel="canonical" href="{{ url('/admin/Blog/' . $blog->id . '/edit') }}">

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
    #btn-update {
        border-radius: 8px !important;
        font-weight: 600 !important;
        letter-spacing: 0.02em !important;
        padding: 10px 28px !important;
        transition: transform 0.15s, box-shadow 0.15s !important;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    #btn-update:not([disabled]):hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 14px rgba(26, 86, 219, 0.35) !important;
    }

    #btn-update:not([disabled]):active {
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

    /* === Current Image Preview === */
    .current-image-preview {
        margin-top: 8px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .current-image-preview img {
        width: 64px;
        height: 64px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
    }

    .current-image-label {
        font-size: 0.72rem;
        color: #6b7280;
    }

    .current-image-label a {
        color: #1a56db;
        font-weight: 500;
        text-decoration: none;
    }

    .current-image-label a:hover {
        text-decoration: underline;
    }
</style>
@endsection

@section('subcontent')

{{-- SEO: Structured page heading with breadcrumb --}}
<header class="intro-y mt-8">
    <div class="page-header-bar">
        <div>
            <h1 class="text-lg font-medium" style="font-size:1.2rem;">Edit Blog</h1>
            <nav class="breadcrumb-nav" aria-label="Breadcrumb">
                <a href="{{ url('/admin') }}">Dashboard</a>
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
                <a href="{{ url('/admin/Blog') }}">Blogs</a>
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
                <span>Edit: {{ $blog->title }}</span>
            </nav>
        </div>
        <a href="{{ url('/admin/Blog') }}" class="btn btn-outline-secondary btn-sm" style="border-radius:8px;font-size:0.8rem;">
            ← Back to Blogs
        </a>
    </div>
</header>

<main class="grid grid-cols-12 gap-6 mt-5" id="main-content" aria-label="Edit Blog Form">
    <div class="intro-y col-span-12 lg:col-span-12">
        <form id="edit-form" enctype="multipart/form-data" novalidate aria-label="Edit blog form">
            @csrf
            @method('PUT')

            <article class="intro-y box blog-form-card">

                <div class="p-5 pb-7">
                    <div class="grid grid-cols-12">
                        <span class="input-hint ml-2" aria-hidden="true"><span class="required-mark">*</span> Required fields</span>

                        {{-- Section: Basic Info --}}
                        <div class="field-group-label" role="heading" aria-level="3">Basic Information</div>

                        {{-- Blog Title --}}
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
                                value="{{ old('title', $blog->title) }}"
                                autocomplete="off"
                                aria-required="true"
                                aria-describedby="error-title hint-title">
                            <p id="hint-title" class="input-hint">A clear, descriptive name for the blog.</p>
                            <div id="error-title" class="login__input-error w-5/6 text-theme-6" role="alert" aria-live="polite"></div>
                        </div>

                        {{-- Published Date --}}
                        <div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-1">
                            <label for="publish_date" class="form-label">
                                Published Date <span class="required-mark" aria-hidden="true">*</span>
                            </label>
                            <input
                                id="publish_date"
                                type="date"
                                name="publish_date"
                                class="form-control form__input"
                                value="{{ old('publish_date', \Carbon\Carbon::parse($blog->publish_date)->format('Y-m-d')) }}"
                                aria-required="true"
                                aria-describedby="error-publish_date hint-publish_date">
                            <p id="hint-publish_date" class="input-hint">Date for Publishing/releasing of the Blog Provided.</p>
                            <div id="error-publish_date" class="login__input-error w-5/6 text-theme-6" role="alert" aria-live="polite"></div>
                        </div>

                        {{-- Published By --}}
                        <div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-1">
                            <label for="publish_by" class="form-label">
                                Published By <span class="required-mark" aria-hidden="true">*</span>
                            </label>
                            <input
                                id="publish_by"
                                type="text"
                                name="publish_by"
                                class="form-control form__input"
                                placeholder="Please provide Publisher Name"
                                value="{{ old('publish_by', $blog->publish_by) }}"
                                aria-required="true"
                                aria-describedby="error-publish_by hint-publish_by">
                            <p id="hint-publish_by" class="input-hint">Name of the Publisher for this Blog.</p>
                            <div id="error-publish_by" class="login__input-error w-5/6 text-theme-6" role="alert" aria-live="polite"></div>
                        </div>

                        {{-- Blog Image --}}
                        <div class="input-form col-span-12 lg:col-span-6 px-2 py-1 mt-1">
                            <label for="blog_img" class="form-label">
                                Blog Image
                            </label>
                            <input
                                id="blog_img"
                                type="file"
                                name="blog_img"
                                accept="image/png, image/jpeg, image/jpg"
                                class="form-control form__input"
                                aria-describedby="error-blog_img hint-blog_img">
                            <p id="hint-blog_img" class="input-hint">Upload a new image to replace the current one (JPG, PNG, JPEG). Max size: 2MB. Leave blank to keep existing.</p>

                            @if ($blog->image_path)
                            <div class="input-form col-span-12 lg:col-span-6 px-2 py-1">
                            </div>
                            <div class="input-form col-span-12 lg:col-span-3 px-2 py-1 mt-3">
                                <div class="h-60 flex items-center justify-start bg-white-100 rounded overflow-hidden">
                                    <img class="rounded-md" alt="Product Image" src="{{ asset('storage/' . $blog->image_path) }}">
                                </div>
                            </div>
                            @endif
                            {{-- Current Image Preview --}}
                            @if($blog->image_path)
                            <div class="current-image-preview">
                                <img
                                    src="{{ asset('storage/' . $blog->image_path) }}"
                                    alt="Current blog image"
                                    id="current-img-thumb">
                                <div class="current-image-label">
                                    Current image &mdash;
                                    <a href="{{ asset('storage/' . $blog->image_path) }}" target="_blank" rel="noopener noreferrer">View full size</a>
                                </div>
                            </div>
                            @endif

                            <div id="error-blog_img" class="login__input-error w-5/6 text-theme-6" role="alert" aria-live="polite"></div>
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
                                    value="1"
                                    {{ old('allowed', $blog->allowed) ? 'checked' : '' }}>
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
                                <span
                                    id="status-badge"
                                    class="status-preview {{ old('status', $blog->status) == 1 ? 'active' : 'inactive' }}"
                                    aria-live="polite">
                                    {{ old('status', $blog->status) == 1 ? 'Active' : 'InActive' }}
                                </span>
                            </label>
                            <select
                                id="status"
                                name="status"
                                class="form-select form__input"
                                aria-describedby="hint-status">
                                <option value="0" {{ old('status', $blog->status) == 0 ? 'selected' : '' }}>Inactive</option>
                                <option value="1" {{ old('status', $blog->status) == 1 ? 'selected' : '' }}>Active</option>
                            </select>
                            <p id="hint-status" class="input-hint">Inactive blogs won't be visible on the Homepage.</p>
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
                                aria-describedby="error-description hint-description">{{ old('description', $blog->description) }}</textarea>
                            <p id="hint-description" class="input-hint">This description will be Blog's Content along with the Image.</p>
                            <div id="error-description" class="login__input-error w-5/6 text-theme-6" role="alert" aria-live="polite"></div>
                        </div>

                        {{-- Actions --}}
                        <div class="input-form col-span-12 lg:col-span-12 px-2 py-1 mt-5 flex flex-wrap gap-3 items-center">
                            <button type="submit" id="btn-update" class="btn btn-primary" aria-label="Save blog changes">
                                Update Blog
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

        // Live image preview on new file selection
        cash('#blog_img').on('change', function() {
            var file = this.files[0];
            if (!file) return;

            var thumb = document.getElementById('current-img-thumb');
            if (thumb) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    thumb.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });

        async function update() {

            // Reset all errors
            cash('#edit-form').find('input, select, textarea').removeClass('border-theme-6');
            cash('#edit-form').find('.login__input-error').html('');

            // Reset TinyMCE border
            if (typeof tinymce !== "undefined" && tinymce.get('description')) {
                tinymce.get('description').getContainer().style.border = '';
            }

            var formData = new FormData(document.querySelector('#edit-form'));

            // Spoof PUT method for Laravel
            formData.append('_method', 'PUT');

            cash('#btn-update')
                .html('<i data-loading-icon="oval" data-color="white" class="w-4 h-4 mr-2"></i> Saving…')
                .svgLoader();

            cash('#btn-update').attr('disabled', 'true');

            axios.post("{{ url('/admin/Blog/' . $blog->id) }}", formData)
                .then(res => {
                    showNotification('success', 'Success!', res.data.message);

                    setTimeout(() => {
                        window.location.href = "{{ url('/admin/Blog') }}";
                    }, 1000);
                })
                .catch(err => {

                    showNotification('error', 'Error!', err.response.data.message);

                    cash('#btn-update').html(
                        '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> Update Blog'
                    );

                    cash('#btn-update').removeAttr('disabled');

                    if (err.response.data.errors) {

                        for (const [key, val] of Object.entries(err.response.data.errors)) {

                            let field = cash(`#${key}`);

                            if (key === 'description') {
                                field = cash('#description');

                                if (typeof tinymce !== "undefined" && tinymce.get('description')) {
                                    tinymce.get('description').getContainer().style.border = '1px solid #ef4444';
                                }
                            }

                            if (key === 'blog_img') {
                                field = cash('#blog_img');
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
        cash('#edit-form').on('submit', function(e) {
            e.preventDefault();
            update();
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