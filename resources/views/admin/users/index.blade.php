@extends('admin.layout')
@section('title', 'Users')

@section('content')
    <!-- Filters -->
    <form class="filters" method="GET">
        <input type="text" name="search" class="fi" placeholder="Search users (name, phone, email)..."
            value="{{ request('search') }}" style="max-width:300px">
        <select name="type" class="fi" style="max-width:150px">
            <option value="">All Account Types</option>
            <option value="user" {{ request('type') === 'user' ? 'selected' : '' }}>User</option>
            <option value="vendor" {{ request('type') === 'vendor' ? 'selected' : '' }}>Vendor</option>
            <option value="admin" {{ request('type') === 'admin' ? 'selected' : '' }}>Admin</option>
        </select>
        <button type="submit" class="btn btn-pri"><span class="mi material-icons-round">filter_list</span> Filter</button>
        @if(request()->hasAny(['search', 'type']))
            <a href="{{ route('admin.users.index') }}" class="btn btn-ghost"><span class="mi material-icons-round">close</span>
                Clear</a>
        @endif
        <div style="flex:1"></div>
        <a href="{{ route('admin.users.create') }}" class="btn btn-rose"><span
                class="mi material-icons-round">person_add</span> New User</a>
    </form>

    <!-- Table -->
    <div class="panel">
        <table class="tbl">
            <thead>
                <tr>
                    <th style="width:24px"><input type="checkbox" id="selectAll" style="accent-color:var(--pri-d)"></th>
                    <th>User</th>
                    <th>Phone / Email</th>
                    <th>City</th>
                    <th>Account Type</th>
                    <th>Status</th>
                    <th>Join Date</th>
                    <th style="text-align:right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td><input type="checkbox" class="row-check" value="{{ $user->id }}" style="accent-color:var(--pri-d)">
                        </td>
                        <td>
                            <div style="display:flex; align-items:center; gap:10px">
                                <div
                                    style="width:32px; height:32px; border-radius:8px; background:var(--bg-d); display:flex; align-items:center; justify-content:center; overflow:hidden">
                                    @if($user->avatar)
                                        <img src="{{ filter_var($user->avatar, FILTER_VALIDATE_URL) ? $user->avatar : url('uploads/' . $user->avatar) }}"
                                            style="width:100%; height:100%; object-fit:cover">
                                    @else
                                        <span class="mi material-icons-round" style="font-size:18px; color:var(--t4)">person</span>
                                    @endif
                                </div>
                                <div>
                                    <span class="name">{{ $user->name }}</span>
                                    <span class="sub">#{{ $user->id }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="name">{{ $user->phone }}</span>
                            <span class="sub">{{ $user->email ?? 'no email' }}</span>
                        </td>
                        <td>{{ $user->city->name ?? '—' }}</td>
                        <td>
                            <span
                                class="b b-{{ $user->account_type === 'admin' ? 'rose' : ($user->account_type === 'vendor' ? 'indigo' : 'gray') }}">
                                {{ ucfirst($user->account_type) }}
                            </span>
                        </td>
                        <td>
                            <span class="b-dot {{ $user->is_active ? 'on' : 'off' }}"></span>
                            <span class="sub" style="margin-left:5px">{{ $user->is_active ? 'Active' : 'Inactive' }}</span>
                        </td>
                        <td class="mono" style="font-size:11px">{{ $user->created_at->format('M d, Y') }}</td>
                        <td>
                            <div class="act-group" style="justify-content:flex-end">
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-ghost btn-xs" title="Edit"><span
                                        class="mi material-icons-round">edit</span></a>
                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                                    onsubmit="return confirm('Delete {{ $user->name }}?')" style="display:inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-ghost btn-xs" title="Delete" style="color:var(--red)"><span
                                            class="mi material-icons-round">delete_outline</span></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <span class="mi material-icons-round">people</span>
                                <h3>No users found</h3>
                                <p>Try adjusting your search or add a new user</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($users->hasPages())
            <div class="pag">
                <span>Showing {{ $users->firstItem() }}–{{ $users->lastItem() }} of {{ $users->total() }}</span>
                <div class="pag-btns">
                    @if($users->onFirstPage())
                        <span class="dis">‹</span>
                    @else
                        <a href="{{ $users->previousPageUrl() }}">‹</a>
                    @endif

                    @foreach($users->getUrlRange(max(1, $users->currentPage() - 2), min($users->lastPage(), $users->currentPage() + 2)) as $page => $url)
                        @if($page == $users->currentPage())
                            <span class="cur">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}">{{ $page }}</a>
                        @endif
                    @endforeach

                    @if($users->hasMorePages())
                        <a href="{{ $users->nextPageUrl() }}">›</a>
                    @else
                        <span class="dis">›</span>
                    @endif
                </div>
            </div>
        @endif
    </div>
@endsection

@section('js')
    <script>
        document.getElementById('selectAll')?.addEventListener('change', function () {
            document.querySelectorAll('.row-check').forEach(c => c.checked = this.checked);
        });
    </script>
@endsection