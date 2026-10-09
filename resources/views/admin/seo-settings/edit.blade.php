@extends('admin.layouts.admin')

@section('title', 'SEO Settings')

@section('content')
    <div class="admin-card">
        <form action="{{ route('admin.seo-settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <h5>Site Defaults</h5>
            <div class="row">
                <div class="col-md-6">
                    <div class="admin-form-group">
                        <label for="site_name">Site Name</label>
                        <input type="text" id="site_name" name="site_name" class="admin-form-control" value="{{ old('site_name', $settings->site_name) }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="admin-form-group">
                        <label for="title_suffix">Title Suffix</label>
                        <input type="text" id="title_suffix" name="title_suffix" class="admin-form-control" value="{{ old('title_suffix', $settings->title_suffix) }}" placeholder="e.g. | Clickvora Digital">
                    </div>
                </div>
            </div>
            <div class="admin-form-group">
                <label for="default_title">Default SEO Title</label>
                <input type="text" id="default_title" name="default_title" class="admin-form-control" value="{{ old('default_title', $settings->default_title) }}">
            </div>
            <div class="admin-form-group">
                <label for="default_description">Default Meta Description</label>
                <textarea id="default_description" name="default_description" class="admin-form-control" rows="2">{{ old('default_description', $settings->default_description) }}</textarea>
            </div>
            <div class="admin-form-group">
                <label for="default_keywords">Default Keywords</label>
                <input type="text" id="default_keywords" name="default_keywords" class="admin-form-control" value="{{ old('default_keywords', implode(', ', $settings->default_keywords ?? [])) }}" placeholder="comma, separated, keywords">
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="admin-form-group">
                        <label for="default_og_image_file">Default Open Graph Image {{ $settings->default_og_image ? '(leave empty to keep current)' : '' }}</label>
                        <input type="file" id="default_og_image_file" name="default_og_image_file" class="admin-form-control" accept="image/*">
                        @if ($settings->default_og_image)
                            <img src="{{ $settings->default_og_image }}" alt="Default OG image" style="max-width:160px; margin-top:8px; border-radius:6px;">
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="admin-form-group">
                        <label for="canonical_base_url">Canonical Base URL</label>
                        <input type="text" id="canonical_base_url" name="canonical_base_url" class="admin-form-control" value="{{ old('canonical_base_url', $settings->canonical_base_url) }}" placeholder="https://example.com">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="admin-form-group">
                        <label for="default_robots_index">Default Indexing</label>
                        <select id="default_robots_index" name="default_robots_index" class="admin-form-control">
                            <option value="1" @selected(old('default_robots_index', $settings->default_robots_index) == 1)>Index</option>
                            <option value="0" @selected(old('default_robots_index', $settings->default_robots_index) == 0)>Noindex</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="admin-form-group">
                        <label for="default_robots_follow">Default Link Following</label>
                        <select id="default_robots_follow" name="default_robots_follow" class="admin-form-control">
                            <option value="1" @selected(old('default_robots_follow', $settings->default_robots_follow) == 1)>Follow</option>
                            <option value="0" @selected(old('default_robots_follow', $settings->default_robots_follow) == 0)>Nofollow</option>
                        </select>
                    </div>
                </div>
            </div>

            <hr>
            <h5>Organization</h5>
            <div class="row">
                <div class="col-md-6">
                    <div class="admin-form-group">
                        <label for="organization_name">Organization Name</label>
                        <input type="text" id="organization_name" name="organization_name" class="admin-form-control" value="{{ old('organization_name', $settings->organization_name) }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="admin-form-group">
                        <label for="organization_logo_file">Organization Logo {{ $settings->organization_logo ? '(leave empty to keep current)' : '' }}</label>
                        <input type="file" id="organization_logo_file" name="organization_logo_file" class="admin-form-control" accept="image/*">
                        @if ($settings->organization_logo)
                            <img src="{{ $settings->organization_logo }}" alt="Organization logo" style="max-width:120px; margin-top:8px; border-radius:6px;">
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="admin-form-group">
                        <label for="contact_email">Contact Email</label>
                        <input type="email" id="contact_email" name="contact_email" class="admin-form-control" value="{{ old('contact_email', $settings->contact_email) }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="admin-form-group">
                        <label for="contact_phone">Contact Phone</label>
                        <input type="text" id="contact_phone" name="contact_phone" class="admin-form-control" value="{{ old('contact_phone', $settings->contact_phone) }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="admin-form-group">
                        <label for="contact_address">Contact Address</label>
                        <input type="text" id="contact_address" name="contact_address" class="admin-form-control" value="{{ old('contact_address', $settings->contact_address) }}">
                    </div>
                </div>
            </div>

            <hr>
            <h5>Social Profiles</h5>
            @php $social = $settings->social_links ?? []; @endphp
            <div class="row">
                <div class="col-md-4">
                    <div class="admin-form-group">
                        <label for="facebook">Facebook</label>
                        <input type="text" id="facebook" name="facebook" class="admin-form-control" value="{{ old('facebook', $social['facebook'] ?? '') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="admin-form-group">
                        <label for="twitter">Twitter / X</label>
                        <input type="text" id="twitter" name="twitter" class="admin-form-control" value="{{ old('twitter', $social['twitter'] ?? '') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="admin-form-group">
                        <label for="instagram">Instagram</label>
                        <input type="text" id="instagram" name="instagram" class="admin-form-control" value="{{ old('instagram', $social['instagram'] ?? '') }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="admin-form-group">
                        <label for="linkedin">LinkedIn</label>
                        <input type="text" id="linkedin" name="linkedin" class="admin-form-control" value="{{ old('linkedin', $social['linkedin'] ?? '') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="admin-form-group">
                        <label for="youtube">YouTube</label>
                        <input type="text" id="youtube" name="youtube" class="admin-form-control" value="{{ old('youtube', $social['youtube'] ?? '') }}">
                    </div>
                </div>
            </div>

            <button type="submit" class="admin-btn admin-btn-primary">Save Settings</button>
        </form>
    </div>
@endsection
