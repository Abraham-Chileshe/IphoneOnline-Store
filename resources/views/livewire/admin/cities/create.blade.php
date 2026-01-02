@section('title', __('Add City'))

<div>
    <div style="background: var(--admin-card); border: 1px solid var(--admin-border); border-radius: 20px; padding: 40px; max-width: 700px; margin: 0 auto; box-shadow: 0 10px 40px rgba(0,0,0,0.2);">
        <form wire:submit.prevent="save">
            
            <div class="form-group">
                <label class="form-label">{{ __('City Name (English)') }}</label>
                <input type="text" wire:model.live="name_en" class="admin-input" placeholder="e.g. Moscow">
                @error('name_en') <span style="color: #ff3b30; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">{{ __('City Name (Russian)') }}</label>
                <input type="text" wire:model="name_ru" class="admin-input" placeholder="e.g. Москва">
                @error('name_ru') <span style="color: #ff3b30; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">{{ __('Slug') }}</label>
                <input type="text" wire:model="slug" class="admin-input" placeholder="e.g. Moscow">
                <small style="color: var(--text-muted); font-size: 11px; margin-top: 4px; display: block;">{{ __('This is used for filtering products and routing.') }}</small>
                @error('slug') <span style="color: #ff3b30; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">{{ __('Status') }}</label>
                <div style="display: flex; align-items: center; gap: 12px; background: rgba(255,255,255,0.03); border: 1px solid var(--admin-border); padding: 10px 16px; border-radius: 10px; height: 44px; box-sizing: border-box; width: fit-content;">
                    <input type="checkbox" wire:model="is_active" id="is_active" style="width: 20px; height: 20px; cursor: pointer; accent-color: var(--admin-accent);">
                    <label for="is_active" style="color: white; font-size: 14px; cursor: pointer; font-weight: 500;">{{ $is_active ? __('Active') : __('Inactive') }}</label>
                </div>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 16px; padding-top: 32px; border-top: 1px solid var(--admin-border); margin-top: 20px;">
                <a href="{{ route('admin.cities.index') }}" class="btn-secondary" style="text-decoration: none; padding: 12px 24px; border-radius: 10px; font-size: 14px; font-weight: 600; color: var(--text-muted); background: rgba(255,255,255,0.05); transition: all 0.2s;">{{ __('Cancel') }}</a>
                <button type="submit" class="btn-primary" style="padding: 12px 32px; border-radius: 10px; font-size: 14px; font-weight: 700; background: var(--admin-accent); color: white; border: none; cursor: pointer; box-shadow: 0 4px 15px rgba(203, 17, 171, 0.3); transition: all 0.2s;">
                    <span wire:loading.remove>{{ __('Create City') }}</span>
                    <span wire:loading>{{ __('Saving...') }}</span>
                </button>
            </div>
        </form>
    </div>
</div>
