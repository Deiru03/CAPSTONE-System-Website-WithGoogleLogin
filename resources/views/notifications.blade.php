@extends('layouts.admin')

@section('content')
<div class="notifications">
    @foreach($notifications as $notification)
        <div class="notification" data-id="{{ $notification->id }}">
            {{ $notification->message }}
            <button onclick="markNotificationAsRead({{ $notification->id }})">Mark as Read</button>
        </div>
    @endforeach
</div>

<script>
    function markNotificationAsRead(notificationId) {
        fetch(`/notifications/${notificationId}/mark-as-read`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update the UI to reflect the notification as read
                document.querySelector(`.notification[data-id="${notificationId}"]`).classList.add('read');
            }
        })
        .catch(error => console.error('Error:', error));
    }
</script>
@endsection 