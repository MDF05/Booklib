@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-lg rounded-xl p-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-900 flex items-center">
                    <i class="fas fa-book-reader text-indigo-600 mr-2"></i> Loan Details
                </h1>
                <a href="{{ route('admin.loans') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200">
                    <i class="fas fa-arrow-left mr-2"></i> Back to Loans
                </a>
            </div>

            <div class="bg-gray-50 rounded-lg p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Loan Information</h2>
                        <dl class="space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Loan ID</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $bookLoan->id }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Status</dt>
                                <dd class="mt-1">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $bookLoan->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : ($bookLoan->status === 'approved' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                                        {{ ucfirst($bookLoan->status) }}
                                    </span>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Loan Date</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    @if($bookLoan->loan_date)
                                        {{ $bookLoan->loan_date->format('M d, Y') }}
                                    @else
                                        -
                                    @endif
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Return Date</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    @if($bookLoan->return_date)
                                        {{ $bookLoan->return_date->format('M d, Y') }}
                                    @else
                                        -
                                    @endif
                                </dd>
                            </div>
                        </dl>
                    </div>

                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">User & Book Information</h2>
                        <dl class="space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">User</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $bookLoan->user->name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Book</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $bookLoan->book->title }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Author</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $bookLoan->book->author }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                @if($bookLoan->status === 'pending')
                    <div class="mt-8 flex space-x-4">
                        <form action="{{ route('admin.book-loans.approve', $bookLoan) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                                <i class="fas fa-check mr-2"></i> Approve
                            </button>
                        </form>
                        <form action="{{ route('admin.book-loans.reject', $bookLoan) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700">
                                <i class="fas fa-times mr-2"></i> Reject
                            </button>
                        </form>
                    </div>
                @endif

                @if($bookLoan->status === 'return_pending')
                    <div class="mt-8 flex space-x-4">
                        <form action="{{ route('admin.book-loans.approve-return', $bookLoan) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                                <i class="fas fa-check mr-2"></i> Approve Return
                            </button>
                        </form>
                        <form action="{{ route('admin.book-loans.reject-return', $bookLoan) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700">
                                <i class="fas fa-times mr-2"></i> Reject Return
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 