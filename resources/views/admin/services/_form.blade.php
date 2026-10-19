@php $service = $service ?? null; @endphp

<div class="admin-form-group">
    <label for="name">Service Name</label>
    <input type="text" id="name" name="name" class="admin-form-control" maxlength="255"
           value="{{ old('name', $service->name ?? '') }}" required>
</div>

<div class="admin-form-group">
    <label for="headline">Page Headline (H1)</label>
    <input type="text" id="headline" name="headline" class="admin-form-control" maxlength="255"
           value="{{ old('headline', $service->headline ?? '') }}" placeholder="e.g. SEO Services Company That Turns Search Traffic Into Sales">
    <small class="text-muted">The main heading on the service page. Leave empty to use the service name.</small>
</div>

<div class="admin-form-group">
    <label for="slug">URL Slug</label>
    <input type="text" id="slug" name="slug" class="admin-form-control"
           value="{{ old('slug', $service->slug ?? '') }}" placeholder="auto-generated-from-name">
    <small class="text-muted">Leave empty to auto-generate. Page URL: {{ url('/services') }}/<span id="slugPreview">{{ old('slug', $service->slug ?? 'your-slug') }}</span></small>
</div>

<div class="admin-form-group">
    <label for="short_description">Short Description</label>
    <textarea id="short_description" name="short_description" class="admin-form-control" rows="2" maxlength="500">{{ old('short_description', $service->short_description ?? '') }}</textarea>
    <small class="text-muted">Shown on the services listing card and used as a fallback meta description.</small>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="admin-form-group">
            <label for="banner_image">Banner Image {{ isset($service) && $service->banner_image ? '(leave empty to keep current)' : '' }}</label>
            <input type="file" id="banner_image" name="banner_image" class="admin-form-control" accept="image/*">
            @if (isset($service) && $service->banner_image)
                <img src="{{ $service->banner_image }}" alt="Current banner" style="max-width:200px; margin-top:8px; border-radius:6px;">
            @endif
        </div>
    </div>
    <div class="col-md-3">
        <div class="admin-form-group">
            <label for="status">Status</label>
            <select id="status" name="status" class="admin-form-control">
                <option value="1" @selected(old('status', $service->status ?? true) == 1)>Active</option>
                <option value="0" @selected(old('status', $service->status ?? true) == 0)>Inactive</option>
            </select>
        </div>
    </div>
    <div class="col-md-3">
        <div class="admin-form-group">
            <label for="sort_order">Display Order</label>
            <input type="number" id="sort_order" name="sort_order" class="admin-form-control" min="0"
                   value="{{ old('sort_order', $service->sort_order ?? 0) }}">
        </div>
    </div>
</div>

<div class="admin-form-group">
    <label for="editor_description">Full Description</label>
    <textarea id="editor_description" name="description" class="admin-form-control" rows="12">{{ old('description', $service->description ?? '') }}</textarea>
    <small class="text-muted">Use headings (H2/H3) to structure Benefits, Features, Process, Why Choose Us, and Use Cases sections.</small>
</div>

<hr>
<h5>Frequently Asked Questions</h5>
<div id="faqRows">
    @foreach (old('faqs', $service->faqs ?? []) as $i => $faq)
        <div class="row faq-row mb-2">
            <div class="col-md-5">
                <input type="text" name="faqs[{{ $i }}][question]" class="admin-form-control" placeholder="Question" value="{{ $faq['question'] ?? '' }}">
            </div>
            <div class="col-md-6">
                <input type="text" name="faqs[{{ $i }}][answer]" class="admin-form-control" placeholder="Answer" value="{{ $faq['answer'] ?? '' }}">
            </div>
            <div class="col-md-1">
                <button type="button" class="admin-btn admin-btn-outline removeFaqRow" style="padding:9px 12px;">&times;</button>
            </div>
        </div>
    @endforeach
</div>
<button type="button" class="admin-btn admin-btn-outline mb-3" id="addFaqRow">+ Add FAQ</button>

<hr>
<h5>SEO</h5>
<div class="row">
    <div class="col-md-6">
        <div class="admin-form-group">
            <label for="seo_title">SEO Title</label>
            <input type="text" id="seo_title" name="seo_title" class="admin-form-control" maxlength="255"
                   value="{{ old('seo_title', $service->seo_title ?? '') }}" placeholder="Falls back to service name">
        </div>
    </div>
    <div class="col-md-6">
        <div class="admin-form-group">
            <label for="keywords">Keywords</label>
            <input type="text" id="keywords" name="keywords" class="admin-form-control"
                   value="{{ old('keywords', $service->keywords ?? '') }}" placeholder="comma, separated, keywords">
        </div>
    </div>
</div>
<div class="admin-form-group">
    <label for="seo_description">SEO Description</label>
    <textarea id="seo_description" name="seo_description" class="admin-form-control" rows="2" maxlength="500" placeholder="Falls back to short description">{{ old('seo_description', $service->seo_description ?? '') }}</textarea>
</div>

<button type="submit" class="admin-btn admin-btn-primary">Save Service</button>
<a href="{{ route('admin.services.index') }}" class="admin-btn admin-btn-outline">Cancel</a>

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/ckeditor5/ckeditor5.css') }}">
@endpush

@push('scripts')
    <script>
        (function () {
            const nameInput = document.getElementById('name');
            const slugInput = document.getElementById('slug');
            const slugPreview = document.getElementById('slugPreview');

            function slugify(value) {
                return value.toLowerCase().trim()
                    .replace(/[^a-z0-9]+/g, '-')
                    .replace(/^-+|-+$/g, '') || 'your-slug';
            }

            function updatePreview() {
                slugPreview.textContent = slugInput.value.trim() ? slugify(slugInput.value) : slugify(nameInput.value);
            }

            nameInput?.addEventListener('input', updatePreview);
            slugInput?.addEventListener('input', updatePreview);
        })();

        (function () {
            let faqIndex = document.querySelectorAll('#faqRows .faq-row').length;
            const faqRows = document.getElementById('faqRows');

            document.getElementById('addFaqRow').addEventListener('click', () => {
                const row = document.createElement('div');
                row.className = 'row faq-row mb-2';
                row.innerHTML = `
                    <div class="col-md-5">
                        <input type="text" name="faqs[${faqIndex}][question]" class="admin-form-control" placeholder="Question">
                    </div>
                    <div class="col-md-6">
                        <input type="text" name="faqs[${faqIndex}][answer]" class="admin-form-control" placeholder="Answer">
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="admin-btn admin-btn-outline removeFaqRow" style="padding:9px 12px;">&times;</button>
                    </div>`;
                faqRows.appendChild(row);
                faqIndex++;
            });

            faqRows.addEventListener('click', (e) => {
                if (e.target.classList.contains('removeFaqRow')) {
                    e.target.closest('.faq-row').remove();
                }
            });
        })();
    </script>
    <script type="importmap">
        {
            "imports": {
                "ckeditor5": "{{ asset('assets/vendor/ckeditor5/ckeditor5.js') }}"
            }
        }
    </script>
    <script type="module">
        if (!window.__serviceDescriptionEditorLoaded) {
            window.__serviceDescriptionEditorLoaded = true;

            import(/* webpackIgnore: true */ 'ckeditor5').then((CKEDITOR) => {
                const {
                    ClassicEditor, Essentials, Paragraph, Heading, Bold, Italic, Underline, Strikethrough,
                    RemoveFormat, Alignment, List, Link, BlockQuote, Table, TableToolbar, TableProperties,
                    TableCellProperties, Image, ImageToolbar, ImageCaption, ImageStyle, ImageResize,
                    ImageUpload, SimpleUploadAdapter, PasteFromOffice, SourceEditing,
                } = CKEDITOR;

                const textarea = document.getElementById('editor_description');
                if (!textarea) {
                    return;
                }

                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

                ClassicEditor.create(textarea, {
                    licenseKey: 'GPL',
                    plugins: [
                        Essentials, Paragraph, Heading, Bold, Italic, Underline, Strikethrough,
                        RemoveFormat, Alignment, List, Link, BlockQuote, Table, TableToolbar, TableProperties,
                        TableCellProperties, Image, ImageToolbar, ImageCaption, ImageStyle, ImageResize,
                        ImageUpload, SimpleUploadAdapter, PasteFromOffice, SourceEditing,
                    ],
                    toolbar: [
                        'heading', '|',
                        'bold', 'italic', 'underline', 'strikethrough', 'removeFormat', '|',
                        'alignment', '|',
                        'bulletedList', 'numberedList', '|',
                        'link', 'blockQuote', 'insertTable', 'uploadImage', '|',
                        'undo', 'redo', '|',
                        'sourceEditing',
                    ],
                    image: {
                        toolbar: [
                            'imageStyle:alignLeft', 'imageStyle:alignCenter', 'imageStyle:alignRight', '|',
                            'toggleImageCaption', 'imageTextAlternative', '|',
                            'resizeImage',
                        ],
                    },
                    table: {
                        contentToolbar: [
                            'tableColumn', 'tableRow', 'mergeTableCells',
                            'tableProperties', 'tableCellProperties',
                        ],
                    },
                    link: {
                        addTargetToExternalLinks: true,
                        defaultProtocol: 'https://',
                    },
                    simpleUpload: {
                        uploadUrl: '{{ route('admin.services.content-image') }}',
                        headers: csrfToken ? { 'X-CSRF-TOKEN': csrfToken } : {},
                    },
                }).then((editor) => {
                    textarea.closest('form')?.addEventListener('submit', () => {
                        editor.updateSourceElement();
                    });
                }).catch((error) => {
                    console.error('CKEditor failed to initialize:', error);
                });
            });
        }
    </script>
@endpush
