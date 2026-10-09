@php $content = $content ?? null; @endphp

<div class="admin-form-group">
    <label for="page_url">Page URL</label>
    <input type="text" id="page_url" name="page_url" class="admin-form-control"
           value="{{ old('page_url', $content->page_url ?? '') }}" placeholder="/services/auto-transport" required>
    <small class="text-muted">The internal path where this content should appear, e.g. <code>/services/auto-transport</code>. Leading slash is added automatically.</small>
</div>

<div class="admin-form-group">
    <label for="title">Title (optional)</label>
    <input type="text" id="title" name="title" class="admin-form-control" maxlength="255"
           value="{{ old('title', $content->title ?? '') }}">
</div>

<div class="admin-form-group">
    <label for="status">Status</label>
    <select id="status" name="status" class="admin-form-control">
        <option value="1" @selected(old('status', $content->status ?? true) == 1)>Active</option>
        <option value="0" @selected(old('status', $content->status ?? true) == 0)>Inactive</option>
    </select>
</div>

<div class="admin-form-group">
    <label for="editor_content">Content</label>
    <textarea id="editor_content" name="content" class="admin-form-control" rows="10">{{ old('content', $content->content ?? '') }}</textarea>
</div>

<button type="submit" class="admin-btn admin-btn-primary">Save Additional Content</button>
<a href="{{ route('admin.additional-contents.index') }}" class="admin-btn admin-btn-outline">Cancel</a>

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
        if (!window.__additionalContentEditorLoaded) {
            window.__additionalContentEditorLoaded = true;

            import(/* webpackIgnore: true */ 'ckeditor5').then((CKEDITOR) => {
                const {
                    ClassicEditor, Essentials, Paragraph, Heading, Bold, Italic, Underline, Strikethrough,
                    RemoveFormat, Alignment, List, Link, BlockQuote, Table, TableToolbar, TableProperties,
                    TableCellProperties, Image, ImageToolbar, ImageCaption, ImageStyle, ImageResize,
                    ImageUpload, SimpleUploadAdapter, PasteFromOffice, SourceEditing,
                } = CKEDITOR;

                const textarea = document.getElementById('editor_content');
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
                        uploadUrl: '{{ route('admin.additional-contents.content-image') }}',
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
