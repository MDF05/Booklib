@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto bg-white shadow-md rounded-lg p-8">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">My Profile</h2>
    @if(session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative flex items-center" role="alert">
            <i class="fas fa-check-circle mr-2"></i>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    <div class="mb-4">
        <label class="block text-gray-700 font-semibold mb-1">Name</label>
        <div class="text-gray-900">{{ $user->name }}</div>
    </div>
    <div class="mb-4">
        <label class="block text-gray-700 font-semibold mb-1">Email</label>
        <div class="text-gray-900">{{ $user->email }}</div>
    </div>
    <div class="mb-4">
        <label class="block text-gray-700 font-semibold mb-1">Address</label>
        <div class="text-gray-900">{{ $user->address ?? '-' }}</div>
    </div>
    <div class="mb-4">
        <label class="block text-gray-700 font-semibold mb-1">Phone</label>
        <div class="text-gray-900">{{ $user->phone ?? '-' }}</div>
    </div>
    <a href="{{ route('profile.edit') }}" class="inline-block mt-4 px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 font-semibold">
        <i class="fas fa-edit mr-2"></i>Edit Profile
    </a>
</div>
@endsection 