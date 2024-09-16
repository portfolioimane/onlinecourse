@extends('backend.layouts.admin')

@section('content')
<div class="container mt-4">
    <h1>Lessons</h1>
    <a href="{{ route('admin.lessons.create') }}" class="btn btn-primary mb-3">Create Lesson</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Course</th>
                <th>Title</th>
                <th>Content</th>
                <th>Video</th>
                <th>Additional Files</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lessons as $lesson)
                <tr>
                    <td>{{ $lesson->course->title ?? 'N/A' }}</td>
                    <td>{{ $lesson->title }}</td>
                    <td>{{ Str::limit(strip_tags($lesson->content), 100) }}</td>

                    <!-- Combined Video Column -->
                    <td>
                        @if ($lesson->video_url)
                            <a href="{{ $lesson->video_url }}" target="_blank">Watch Video</a>
                        @elseif ($lesson->video_file)
                            <a href="{{ Storage::url($lesson->video_file) }}" target="_blank">View Video</a>
                        @else
                            None
                        @endif
                    </td>

                    <td>
                        @if ($lesson->additional_files)
                            @php $files = json_decode($lesson->additional_files, true); @endphp
                            @foreach ($files as $file)
                                <a href="{{ Storage::url($file) }}" target="_blank">{{ basename($file) }}</a><br>
                            @endforeach
                        @else
                            None
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.lessons.edit', $lesson->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('admin.lessons.destroy', $lesson->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $lessons->links() }}
</div>
@endsection
