@php
    $currentUser = auth()->user();
    $isAdmin = $currentUser && $currentUser->role === 'admin';
@endphp

@if($isAdmin)
    @include('profile.edit-admin')
@else
    @include('profile.edit-default')
@endif
