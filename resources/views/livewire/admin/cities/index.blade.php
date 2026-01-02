@section('title', __('Cities'))

<div>
    @if (session()->has('success'))
        <div style="background: rgba(52, 199, 89, 0.1); color: #34c759; padding: 12px 16px; border-radius: 8px; margin-bottom: 24px;">
            {{ session('success') }}
        </div>
    @endif

    <div style="display: flex; justify-content: flex-end; margin-bottom: 24px;">
        <a href="{{ route('admin.cities.create') }}" class="btn-primary" style="text-decoration: none; padding: 10px 20px; border-radius: 8px; font-size: 14px;">+ {{ __('Add City') }}</a>
    </div>

    <div class="data-table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>{{ __('Name (EN)') }}</th>
                    <th>{{ __('Name (RU)') }}</th>
                    <th>{{ __('Slug') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th>{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cities as $city)
                <tr>
                    <td>#{{ $city->id }}</td>
                    <td style="font-weight: 500;">{{ $city->name_en }}</td>
                    <td>{{ $city->name_ru }}</td>
                    <td><code style="background: rgba(255,255,255,0.05); padding: 2px 6px; border-radius: 4px; font-size: 12px;">{{ $city->slug }}</code></td>
                    <td>
                        <button wire:click="toggleStatus({{ $city->id }})" class="status-badge {{ $city->is_active ? 'status-success' : 'status-danger' }}" style="border: none; cursor: pointer; font-family: inherit;">
                            {{ $city->is_active ? __('Active') : __('Inactive') }}
                        </button>
                    </td>
                    <td>
                        <div style="display: flex; gap: 8px;">
                            <a href="{{ route('admin.cities.edit', $city->id) }}" class="action-btn">{{ __('Edit') }}</a>
                            <button wire:confirm="{{ __('Are you sure? This may affect products assigned to this city.') }}" wire:click="delete({{ $city->id }})" class="action-btn" style="background: rgba(255, 59, 48, 0.1); color: #ff3b30;">{{ __('Delete') }}</button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div style="margin-top: 24px;">
        {{ $cities->links() }}
    </div>
</div>
