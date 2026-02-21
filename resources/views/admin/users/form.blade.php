@extends('admin.layout')
@section('title', isset($user) ? 'Edit User' : 'New User')

@section('content')
    <form action="{{ isset($user) ? route('admin.users.update', $user) : route('admin.users.store') }}" method="POST"
        class="form-container">
        @csrf
        @if(isset($user)) @method('PUT') @endif

        <div class="panel">
            <div class="panel-header">
                <span class="mi material-icons-round">person</span>
                <h3>Account Information</h3>
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label>Full Name <span class="req">*</span></label>
                    <input type="text" name="name" class="fi" value="{{ old('name', $user->name ?? '') }}" required
                        placeholder="e.g. John Doe">
                    @error('name') <span class="err">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label>Phone Number <span class="req">*</span></label>
                    <input type="text" name="phone" class="fi" value="{{ old('phone', $user->phone ?? '') }}" required
                        placeholder="e.g. +923001234567">
                    @error('phone') <span class="err">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label>Email Address (Optional)</label>
                    <input type="email" name="email" class="fi" value="{{ old('email', $user->email ?? '') }}"
                        placeholder="e.g. john@example.com">
                    @error('email') <span class="err">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label>Password {{ isset($user) ? '(Leave blank to keep current)' : '*' }}</label>
                    <input type="password" name="password" class="fi" {{ isset($user) ? '' : 'required' }}
                        placeholder="Min 8 characters">
                    @error('password') <span class="err">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label>City</label>
                    <select name="city_id" class="fi">
                        <option value="">Select City</option>
                        @foreach($cities as $city)
                            <option value="{{ $city->id }}" {{ old('city_id', $user->city_id ?? '') == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                        @endforeach
                    </select>
                    @error('city_id') <span class="err">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label>Account Type <span class="req">*</span></label>
                    <select name="account_type" class="fi" required>
                        <option value="user" {{ old('account_type', $user->account_type ?? 'user') === 'user' ? 'selected' : '' }}>Regular User</option>
                        <option value="vendor" {{ old('account_type', $user->account_type ?? '') === 'vendor' ? 'selected' : '' }}>Vendor</option>
                        <option value="admin" {{ old('account_type', $user->account_type ?? '') === 'admin' ? 'selected' : '' }}>Administrator</option>
                    </select>
                    @error('account_type') <span class="err">{{ $message }}</span> @enderror
                </div>
            </div>

            <div style="margin-top:20px">
                <label class="toggle">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $user->is_active ?? true) ? 'checked' : '' }}>
                    <span class="slider"></span>
                    <span class="label">Account Status (Active / Inactive)</span>
                </label>
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('admin.users.index') }}" class="btn btn-ghost">Cancel</a>
            <button type="submit" class="btn btn-pri btn-lg">
                <span class="mi material-icons-round">save</span>
                {{ isset($user) ? 'Update User' : 'Create User' }}
            </button>
        </div>
    </form>
@endsection

@section('styles')
    <style>
        .form-container {
            max-width: 800px;
            margin: 0 auto;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-top: 15px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .form-group label {
            font-size: 13px;
            font-weight: 600;
            color: var(--t2);
        }

        .req {
            color: var(--red);
        }

        .fi {
            height: 42px;
            padding: 0 14px;
            border-radius: 10px;
            border: 1.5px solid var(--border);
            background: #fbfbfb;
            transition: all 0.2s;
            font-size: 14px;
        }

        .fi:focus {
            border-color: var(--pri);
            background: #fff;
            box-shadow: 0 0 0 3px var(--pri-l);
            outline: none;
        }

        .err {
            font-size: 11px;
            color: var(--red);
            margin-top: 4px;
        }

        .panel {
            background: #fff;
            border-radius: 16px;
            border: 1px solid var(--border);
            padding: 24px;
            margin-bottom: 24px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
        }

        .panel-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--border);
        }

        .panel-header h3 {
            font-size: 16px;
            font-weight: 700;
            margin: 0;
        }

        .panel-header .mi {
            color: var(--rose);
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 20px;
        }

        .toggle {
            display: inline-flex;
            align-items: center;
            cursor: pointer;
            gap: 10px;
        }

        .toggle input {
            display: none;
        }

        .toggle .slider {
            width: 40px;
            height: 20px;
            background: #ddd;
            border-radius: 20px;
            position: relative;
            transition: .3s;
        }

        .toggle .slider:before {
            content: "";
            position: absolute;
            width: 14px;
            height: 14px;
            left: 3px;
            top: 3px;
            background: #fff;
            border-radius: 50%;
            transition: .3s;
        }

        .toggle input:checked+.slider {
            background: var(--pri);
        }

        .toggle input:checked+.slider:before {
            transform: translateX(20px);
        }

        .toggle .label {
            font-size: 13px;
            font-weight: 500;
            color: var(--t3);
        }

        @media (max-width: 600px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endsection