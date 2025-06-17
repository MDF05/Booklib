@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-50 to-purple-50 py-10">
    <div class="w-full max-w-lg">
        <div class="bg-white rounded-3xl shadow-2xl px-8 py-10 flex flex-col items-center">
            <div class="mb-6">
                <div class="h-28 w-28 rounded-full bg-indigo-200 flex items-center justify-center text-indigo-700 text-5xl font-extrabold shadow-lg border-4 border-white">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
            </div>
            <div class="text-center mb-8">
                <div class="text-2xl font-bold text-gray-900 mb-1">{{ $user->name }}</div>
                <div class="text-base text-gray-500 mb-2">{{ $user->email }}</div>
            </div>
            <div class="w-full grid grid-cols-1 gap-4 mb-8">
                <div class="flex items-center bg-gray-50 rounded-xl px-4 py-3">
                    <i class="fas fa-map-marker-alt text-indigo-400 text-lg mr-3"></i>
                    <span class="text-gray-700">{{ $user->address ? $user->address : 'Not provided' }}</span>
                </div>
                <div class="flex items-center bg-gray-50 rounded-xl px-4 py-3">
                    <i class="fas fa-phone-alt text-indigo-400 text-lg mr-3"></i>
                    <span class="text-gray-700">{{ $user->phone ? $user->phone : 'Not provided' }}</span>
                </div>
                <div class="flex items-center bg-gray-50 rounded-xl px-4 py-3">
                    <i class="fas fa-book-reader text-indigo-400 text-lg mr-3"></i>
                    <span class="text-gray-700">Books Borrowed: <span class="font-semibold text-indigo-700">{{ $user->bookLoans()->where('status', 'approved')->count() }}</span></span>
                </div>
                <div class="flex items-center bg-gray-50 rounded-xl px-4 py-3">
                    <i class="fas fa-calendar-alt text-indigo-400 text-lg mr-3"></i>
                    <span class="text-gray-700">Member since {{ $user->created_at->format('M Y') }}</span>
                </div>
            </div>
            <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white rounded-xl shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition font-semibold">
                <i class="fas fa-edit mr-2"></i>
                Edit Profile
            </a>
        </div>
    </div>
</div>
@endsection 