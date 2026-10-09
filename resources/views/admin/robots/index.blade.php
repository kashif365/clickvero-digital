@extends('admin.layouts.admin')

@section('title', 'Robots.txt')

@section('content')
    <div class="row g-3">
        <div class="col-lg-7">
            <div class="admin-card">
                <h2>Rules</h2>
                <div style="overflow-x:auto;">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>User-agent</th>
                                <th>Disallow</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($rules as $rule)
                                <tr>
                                    <td>{{ $rule->user_agent }}</td>
                                    <td>{{ $rule->disallow }}</td>
                                    <td>
                                        <form action="{{ route('admin.robots.destroy', $rule) }}" method="POST" onsubmit="return confirm('Delete this rule?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="admin-btn admin-btn-danger" style="padding:6px 12px;">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="3">No rules yet — robots.txt will be empty.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <form action="{{ route('admin.robots.store') }}" method="POST" class="mt-4">
                    @csrf
                    <div class="row">
                        <div class="col-md-5">
                            <div class="admin-form-group">
                                <label for="user_agent">User-agent</label>
                                <input type="text" id="user_agent" name="user_agent" class="admin-form-control" value="{{ old('user_agent', '*') }}" required>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="admin-form-group">
                                <label for="disallow">Disallow path</label>
                                <input type="text" id="disallow" name="disallow" class="admin-form-control" placeholder="/admin" value="{{ old('disallow') }}" required>
                            </div>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="admin-btn admin-btn-accent mb-3" style="width:100%;">Add</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="admin-card">
                <h2>Live Preview <a href="{{ route('admin.robots.download') }}" class="admin-btn admin-btn-outline" style="float:right; padding:6px 12px;"><i class="fa-solid fa-download"></i> Download</a></h2>
                @if ($uploadExists)
                    <p class="admin-alert admin-alert-success" style="margin-bottom:14px;">An uploaded robots.txt file is active and being served instead of the rules above.</p>
                @endif
                <pre style="background:var(--admin-bg); padding:16px; border-radius:8px; font-size:13px; white-space:pre-wrap;">{{ $uploadExists ? $uploadContent : $preview }}</pre>
            </div>

            <div class="admin-card">
                <h2>Upload a .txt File</h2>
                <p class="admin-form-group" style="color:var(--admin-text); font-size:13.5px;">Upload a raw <code>robots.txt</code> file to serve as-is, overriding the rules above. Remove it to go back to the rule-based version.</p>

                @if ($uploadExists)
                    <div class="admin-form-group">
                        <label>Current file</label>
                        <div>robots.txt — updated {{ \Carbon\Carbon::createFromTimestamp($uploadUpdatedAt)->diffForHumans() }}</div>
                    </div>
                    <a href="{{ route('admin.robots.upload.download') }}" class="admin-btn admin-btn-outline"><i class="fa-solid fa-download"></i> Download</a>
                    <form action="{{ route('admin.robots.upload.destroy') }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Remove the uploaded file?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="admin-btn admin-btn-danger"><i class="fa-solid fa-trash"></i> Delete</button>
                    </form>
                    <hr class="my-4">
                @endif

                <form action="{{ route('admin.robots.upload') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="admin-form-group">
                        <label for="robots_file">Upload robots.txt {{ $uploadExists ? '(replaces the current file)' : '' }}</label>
                        <input type="file" id="robots_file" name="robots_file" class="admin-form-control" accept=".txt" required>
                    </div>
                    <button type="submit" class="admin-btn admin-btn-primary">Upload</button>
                </form>
            </div>
        </div>
    </div>
@endsection
