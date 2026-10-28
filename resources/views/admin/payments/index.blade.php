@extends('layouts.admin')

@section('header', 'Midtrans Payments')

@section('content')
<div class="bg-dark-card border border-gray-800 rounded-2xl shadow-xl overflow-hidden">
    <div class="p-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h2 class="text-2xl font-bold text-white mb-2">Transaction History</h2>
                <p class="text-secondary">Monitor and inspect all Midtrans payment transactions.</p>
            </div>
            <a href="{{ route('admin.payments.test') }}" class="bg-primary hover:bg-primary-light text-dark font-bold py-2 px-6 rounded-xl transition-all duration-300 flex items-center justify-center gap-2">
                <i class="fas fa-credit-card"></i>
                Test Payment Gateway
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b border-gray-800">
                        <th class="px-4 py-4 text-secondary text-xs font-bold uppercase tracking-wider">Order ID</th>
                        <th class="px-4 py-4 text-secondary text-xs font-bold uppercase tracking-wider">Type</th>
                        <th class="px-4 py-4 text-secondary text-xs font-bold uppercase tracking-wider">User</th>
                        <th class="px-4 py-4 text-secondary text-xs font-bold uppercase tracking-wider">Amount</th>
                        <th class="px-4 py-4 text-secondary text-xs font-bold uppercase tracking-wider">Status</th>
                        <th class="px-4 py-4 text-secondary text-xs font-bold uppercase tracking-wider">Date</th>
                        <th class="px-4 py-4 text-secondary text-xs font-bold uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    @forelse($payments as $payment)
                    <tr class="hover:bg-dark-lighter/50 transition-colors duration-200">
                        <td class="px-4 py-4 font-mono text-sm text-white">{{ $payment->order_id }}</td>
                        <td class="px-4 py-4">
                            <span class="px-2 py-1 rounded text-xs font-bold uppercase {{ $payment->payment_type === 'donation' ? 'bg-blue-500/10 text-blue-500' : 'bg-purple-500/10 text-purple-500' }}">
                                {{ $payment->payment_type }}
                            </span>
                        </td>
                        <td class="px-4 py-4 text-secondary">
                            {{ $payment->user ? $payment->user->name : 'Guest' }}
                        </td>
                        <td class="px-4 py-4 font-bold text-white">
                            Rp {{ number_format($payment->gross_amount, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-4">
                            @php
                                $statusClasses = [
                                    'settlement' => 'bg-green-500/10 text-green-500',
                                    'capture' => 'bg-green-500/10 text-green-500',
                                    'pending' => 'bg-yellow-500/10 text-yellow-500',
                                    'deny' => 'bg-red-500/10 text-red-500',
                                    'cancel' => 'bg-gray-500/10 text-gray-500',
                                    'expire' => 'bg-gray-500/10 text-gray-500',
                                ];
                                $class = $statusClasses[$payment->status] ?? 'bg-blue-500/10 text-blue-500';
                            @endphp
                            <span class="px-2 py-1 rounded text-xs font-bold uppercase {{ $class }}">
                                {{ $payment->status }}
                            </span>
                        </td>
                        <td class="px-4 py-4 text-secondary text-sm">
                            {{ $payment->created_at->format('M d, Y H:i') }}
                        </td>
                        <td class="px-4 py-4">
                            <a href="{{ route('admin.payments.show', $payment) }}" class="text-primary hover:text-primary-light transition-colors">
                                <i class="fas fa-eye mr-1"></i> Inspect
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-12 text-center text-secondary">
                            No transactions found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-8">
            {{ $payments->links() }}
        </div>
    </div>
</div>
@endsection

