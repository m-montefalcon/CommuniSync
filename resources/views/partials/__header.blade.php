<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CommuniSync</title>
    <link rel="icon" href="{{ asset('Assets/web-icon.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    
    <!-- Include toastr script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- Include Pusher script -->
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>

    <!-- Include your custom script -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    @auth
    <!-- Include Pusher script with dynamic app key and cluster -->
<!-- Include Pusher script with dynamic app key and cluster -->
<script>
    // Check if the script has already been executed
    if (typeof window.pusherScriptExecuted === 'undefined' || !window.pusherScriptExecuted) {
        Pusher.logToConsole = true;

        var pusher = new Pusher('{{ env("PUSHER_APP_KEY") }}', {
            cluster: '{{ env("PUSHER_APP_CLUSTER") }}',
            encrypted: true
        });

        var channel = pusher.subscribe('new-caf-channel');

        // Handle page unload or user logout
        window.addEventListener('beforeunload', function() {
            channel.unsubscribe();
        });

        channel.bind('App\\Events\\NewCAFEvent', function(data) {
            console.log('New CAF Event:', data);

            // Show a Toastr notification
            toastr.success('New Access Control Request Received!', 'Notification');
        });

        // Set a flag indicating that the script has been executed
        window.pusherScriptExecuted = true;
    }
</script>

@endauth

</head>
<!-- ... rest of your HTML ... -->
