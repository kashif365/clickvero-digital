<div class="admin-form-group">
    <label for="title">Title</label>
    <input type="text" id="title" name="title" class="admin-form-control" value="{{ old('title', $blog->title ?? '') }}" required>
</div>

<div class="admin-form-group">
    <label for="slug">URL Slug</label>
    <input type="text" id="slug" name="slug" class="admin-form-control" value="{{ old('slug', $blog->slug ?? '') }}" placeholder="auto-generated-from-title">
    <small class="text-muted">Leave empty to auto-generate from the title.</small>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="admin-form-group">
            <label for="category">Category / Tag</label>
            <input type="text" id="category" name="category" class="admin-form-control" value="{{ old('category', $blog->category ?? '') }}">
        </div>
    </div>
    <div class="col-md-6">
        <div class="admin-form-group">
            <label for="author">Author</label>
            <input type="text" id="author" name="author" class="admin-form-control" value="{{ old('author', $blog->author ?? '') }}">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="admin-form-group">
            <label for="published_at">Published Date</label>
            <input type="date" id="published_at" name="published_at" class="admin-form-control" value="{{ old('published_at', isset($blog) ? $blog->published_at->format('Y-m-d') : now()->format('Y-m-d')) }}" required>
        </div>
    </div>
    <div class="col-md-6">
        <div class="admin-form-group">
            <label for="image">Featured Image {{ isset($blog) ? '(leave empty to keep current)' : '' }}</label>
            <input type="file" id="image" name="image" class="admin-form-control" accept="image/*">
        </div>
    </div>
</div>

<div class="admin-form-group">
    <label for="excerpt">Excerpt</label>
    <textarea id="excerpt" name="excerpt" class="admin-form-control" rows="2">{{ old('excerpt', $blog->excerpt ?? '') }}</textarea>
</div>

<div class="admin-form-group">
    <label for="content">Content</label>
    {{-- "required" is intentionally omitted: CKEditor hides this textarea (display:none), and a hidden
         required field blocks native HTML5 form submission with an unfocusable validation error.
         Emptiness is enforced server-side instead (see BlogController::validated()). --}}
    <textarea id="content" name="content" class="admin-form-control" rows="10">{{ old('content', $blog->content ?? '') }}</textarea>
</div>

<button type="submit" class="admin-btn admin-btn-primary">Save Blog Post</button>
<a href="{{ route('admin.blogs.index') }}" class="admin-btn admin-btn-outline">Cancel</a>

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/ckeditor5/ckeditor5.css') }}">
@endpush

@push('scripts')
    <script type="importmap">
        {
            "imports": {
                "ckeditor5": "{{ asset('assets/vendor/ckeditor5/ckeditor5.js') }}"
            }
        }
    </script>
    <script type="module">
        if (!window.__blogContentEditorLoaded) {
            window.__blogContentEditorLoaded = true;

            import(/* webpackIgnore: true */ 'ckeditor5').then((CKEDITOR) => {
                const {
                    ClassicEditor, Essentials, Paragraph, Heading, Bold, Italic, Underline, Strikethrough,
                    RemoveFormat, Alignment, List, Link, BlockQuote, Table, TableToolbar, TableProperties,
                    TableCellProperties, Image, ImageToolbar, ImageCaption, ImageStyle, ImageResize,
                    ImageUpload, SimpleUploadAdapter, PasteFromOffice, SourceEditing,
                } = CKEDITOR;

                const textarea = document.getElementById('content');
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
                        uploadUrl: '{{ route('admin.blogs.content-image') }}',
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
    <script>
        (function () {
            const titleInput = document.getElementById('title');
            const slugInput = document.getElementById('slug');
            const slugPreview = document.getElementById('slugPreview');

            function slugify(value) {
                return value.toLowerCase().trim()
                    .replace(/[^a-z0-9]+/g, '-')
                    .replace(/^-+|-+$/g, '') || 'your-slug';
            }

            function updatePreview() {
                slugPreview.textContent = slugInput.value.trim() ? slugify(slugInput.value) : slugify(titleInput.value);
            }

            titleInput?.addEventListener('input', updatePreview);
            slugInput?.addEventListener('input', updatePreview);
        })();
    </script>
@endpush
