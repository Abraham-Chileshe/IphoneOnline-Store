@section('title', __('Store Settings'))

<div>
    @if (session()->has('success'))
        <div style="background: rgba(52, 199, 89, 0.1); color: #34c759; padding: 12px 16px; border-radius: 12px; margin-bottom: 24px; border: 1px solid rgba(52, 199, 89, 0.2); display: flex; align-items: center; gap: 10px;">
            <img src="https://img.icons8.com/material-rounded/24/34c759/checkmark.png" style="width: 18px;">
            {{ session('success') }}
        </div>
    @endif

    <div style="background: var(--admin-card); border: 1px solid var(--admin-border); border-radius: 20px; padding: 40px; width: 100%; box-sizing: border-box; box-shadow: 0 10px 40px rgba(0,0,0,0.2);">
        <div style="margin-bottom: 30px; border-bottom: 1px solid var(--admin-border); padding-bottom: 20px;">
            <h2 style="font-size: 20px; font-weight: 700; color: white; margin-bottom: 8px;">{{ __('General Settings') }}</h2>
            <p style="color: var(--text-muted); font-size: 14px;">{{ __("Manage your store's basic identity and location.") }}</p>
        </div>

        <form wire:submit.prevent="save">
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" style="display: flex; align-items: center; gap: 8px;">
                        <i class="fa-solid fa-location-dot"></i>
                        {{ __('Store Location') }}
                    </label>
                    <div style="position: relative;">
                        <input type="text" wire:model="store_location" class="admin-input" placeholder="{{ __('e.g. Lusaka') }}">
                    </div>
                    @error('store_location') <span style="color: #ff3b30; font-size: 12px; margin-top: 8px; display: block;">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" style="display: flex; align-items: center; gap: 8px;">
                        <i class="fa-solid fa-language"></i>
                        {{ __('Default Language') }}
                    </label>
                    <div style="position: relative;">
                        <select wire:model="default_locale" class="admin-select">
                            <option value="en">English (EN)</option>
                            <option value="ru">Русский (RU)</option>
                        </select>
                    </div>
                    @error('default_locale') <span style="color: #ff3b30; font-size: 12px; margin-top: 8px; display: block;">{{ $message }}</span> @enderror
                </div>
            </div>

            <div style="margin-bottom: 30px; border-bottom: 1px solid var(--admin-border); padding-bottom: 20px; margin-top: 20px;">
                <h2 style="font-size: 20px; font-weight: 700; color: white; margin-bottom: 8px;">{{ __('Contact Settings') }}</h2>
                <p style="color: var(--text-muted); font-size: 14px;">{{ __("Manage contact information shown to guest users.") }}</p>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" style="display: flex; align-items: center; gap: 8px;">
                        <i class="fa-solid fa-envelope"></i>
                        {{ __('Admin Email') }}
                    </label>
                    <div style="position: relative;">
                        <input type="email" wire:model="admin_email" class="admin-input" placeholder="{{ __('e.g. admin@example.com') }}">
                    </div>
                    @error('admin_email') <span style="color: #ff3b30; font-size: 12px; margin-top: 8px; display: block;">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" style="display: flex; align-items: center; gap: 8px;">
                        <i class="fa-solid fa-phone"></i>
                        {{ __('Admin Phone') }}
                    </label>
                    <div style="position: relative;">
                        <input type="text" wire:model="admin_phone" class="admin-input" placeholder="{{ __('e.g. +260 977 123456') }}">
                    </div>
                    @error('admin_phone') <span style="color: #ff3b30; font-size: 12px; margin-top: 8px; display: block;">{{ $message }}</span> @enderror
                </div>
            </div>

            <div style="margin-bottom: 30px; border-bottom: 1px solid var(--admin-border); padding-bottom: 20px; margin-top: 20px;">
                <h2 style="font-size: 20px; font-weight: 700; color: white; margin-bottom: 8px;">{{ __('Currency Settings') }}</h2>
                <p style="color: var(--text-muted); font-size: 14px;">{{ __("Manage your store's default exchange rates for localized pricing.") }}</p>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" style="display: flex; align-items: center; gap: 8px;">
                        <i class="fa-solid fa-money-bill-transfer" style="color: #34c759;"></i>
                        {{ __('USD to RUB Exchange Rate') }}
                    </label>
                    <div style="position: relative;">
                        <span style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: var(--text-muted); font-weight: 600;">1 USD =</span>
                        <input type="number" wire:model="usd_to_rub_rate" step="0.01" class="admin-input" style="padding-left: 75px; font-weight: 700; font-size: 16px; color: var(--admin-accent);">
                        <span style="position: absolute; right: 16px; top: 50%; transform: translateY(-50%); color: var(--text-muted); font-weight: 600;">RUB</span>
                    </div>
                    @error('usd_to_rub_rate') <span style="color: #ff3b30; font-size: 12px; margin-top: 8px; display: block;">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" style="display: flex; align-items: center; gap: 8px;">
                        <i class="fa-solid fa-money-bill-trend-up" style="color: #ff9500;"></i>
                        {{ __('USD to AED Exchange Rate') }}
                    </label>
                    <div style="position: relative;">
                        <span style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: var(--text-muted); font-weight: 600;">1 USD =</span>
                        <input type="number" wire:model="usd_to_aed_rate" step="0.01" class="admin-input" style="padding-left: 75px; font-weight: 700; font-size: 16px; color: var(--admin-accent);">
                        <span style="position: absolute; right: 16px; top: 50%; transform: translateY(-50%); color: var(--text-muted); font-weight: 600;">AED</span>
                    </div>
                    @error('usd_to_aed_rate') <span style="color: #ff3b30; font-size: 12px; margin-top: 8px; display: block;">{{ $message }}</span> @enderror
                </div>
            </div>

            <div style="background: rgba(203, 17, 171, 0.05); border: 1px dashed var(--admin-accent); border-radius: 12px; padding: 20px; margin-top: 24px;">
                <div style="display: flex; gap: 12px;">
                    <i class="fa-solid fa-circle-info" style="color: var(--admin-accent); font-size: 24px;"></i>
                    <div>
                        <h4 style="color: white; font-size: 14px; font-weight: 600; margin-bottom: 4px;">{{ __('Pro Tip') }}</h4>
                        <p style="color: var(--text-muted); font-size: 13px; line-height: 1.5;">
                            {{ __('Exchange rates will automatically calculate prices across your entire store. For example, if a product is $1,000 and the rate is 90, it will display as 90,000 RUB.') }}
                        </p>
                    </div>
                </div>
            </div>

            <div style="margin-top: 40px; display: flex; justify-content: flex-end;">
                <button type="submit" class="btn-primary" style="padding: 12px 32px; border-radius: 12px; font-size: 14px; font-weight: 700; background: var(--admin-accent); color: white; border: none; cursor: pointer; box-shadow: 0 4px 15px rgba(203, 17, 171, 0.3); transition: all 0.2s; width: 100%;">
                    <span wire:loading.remove>{{ __('Save Settings') }}</span>
                    <span wire:loading>{{ __('Saving...') }}</span>
                </button>
            </div>
        </form>
    </div>
</div>
