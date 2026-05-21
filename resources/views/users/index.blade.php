{{-- resources/views/users/index.blade.php --}}
@extends('layouts.app')
@section('title', 'User Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-700 mb-1">User Management</h5>
        <p class="text-muted mb-0 small">Manage system users and their roles</p>
    </div>
    <a href="{{ route('users.create') }}" class="btn btn-primary">
        <i class="bi bi-person-plus me-2"></i>Add User
    </a>
</div>

<div class="card">
    <div class="card-header">System Users ({{ $users->total() }})</div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr><th>Name</th><th>Email</th><th>Phone</th><th>Role</th><th>Status</th><th>Created</th><th>Actions</th></tr>
            </thead>
            <tbody>
            @forelse($users as $user)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div style="width:32px;height:32px;background:#e0e7ff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;color:#3730a3;font-size:.8rem;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <span class="fw-600">{{ $user->name }}</span>
                            @if($user->id === auth()->id()) <span class="badge bg-secondary">You</span> @endif
                        </div>
                    </td>
                    <td class="small">{{ $user->email }}</td>
                    <td class="small">{{ $user->phone ?? '—' }}</td>
                    <td>
                        <span class="badge {{ $user->role === 'admin' ? 'bg-danger' : ($user->role === 'registrar' ? 'bg-primary' : 'bg-secondary') }}">
                            {{ $user->role_label }}
                        </span>
                    </td>
                    <td><span class="badge {{ $user->is_active ? 'bg-success' : 'bg-secondary' }}">{{ $user->is_active ? 'Active' : 'Inactive' }}</span></td>
                    <td class="small text-muted">{{ $user->created_at->format('d M Y') }}</td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('users.edit', $user) }}" class="btn btn-xs btn-outline-primary" style="padding:2px 7px;font-size:.75rem;"><i class="bi bi-pencil"></i></a>
                            @if($user->id !== auth()->id())
                                <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('Delete this user?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-xs btn-outline-danger" style="padding:2px 7px;font-size:.75rem;"><i class="bi bi-trash"></i></button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center text-muted py-4">No users found.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
    <div class="card-footer">{{ $users->links() }}</div>
    @endif
</div>
@endsection
