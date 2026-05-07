<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #f4f4f4; padding: 15px; margin-bottom: 20px; border-radius: 5px; }
        .content { margin-bottom: 20px; }
        .important { background-color: #fee; padding: 15px; border-left: 4px solid #c33; margin-bottom: 20px; }
        .important strong { color: #c33; }
        .footer { border-top: 1px solid #ddd; padding-top: 15px; margin-top: 20px; font-size: 12px; color: #666; }
        .button { background-color: #3490dc; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block; }
    </style>
</head>
<body>
    <div class="container">
        <h2>New Announcement: {{ $announcement->title }}</h2>

        <div class="header">
            @if($announcement->category)
                <p><strong>Category:</strong> {{ $announcement->category->name }}</p>
            @endif
            @if($announcement->creator)
                <p><strong>From:</strong> {{ $announcement->creator->name }}</p>
            @endif
        </div>

        @if($announcement->status === 'important')
            <div class="important">
                <strong>⚠️ IMPORTANT</strong>
            </div>
        @endif

        <div class="content">
            {!! nl2br(e($announcement->content)) !!}
        </div>

        <p>
            <a href="{{ route('feed') }}" class="button">View Full Announcement</a>
        </p>

        <div class="footer">
            <p>{{ config('app.name') }}</p>
        </div>
    </div>
</body>
</html>

