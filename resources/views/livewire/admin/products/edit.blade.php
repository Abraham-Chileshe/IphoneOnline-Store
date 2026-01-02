@section('title', __('Edit Product'))

<div>
    <div style="background: var(--admin-card); border: 1px solid var(--admin-border); border-radius: 20px; padding: 40px; max-width: 900px; margin: 0 auto; box-shadow: 0 10px 40px rgba(0,0,0,0.2);">
        <form wire:submit.prevent="update">
            
            <!-- Name & Status -->
            <div class="form-row" style="grid-template-columns: 2fr 1fr;">
                <div class="form-group">
                    <label class="form-label">{{ __('Product Name') }}</label>
                    <input type="text" wire:model="name" class="admin-input" placeholder="{{ __('iPhone 15 Pro Max') }}">
                    @error('name') <span style="color: #ff3b30; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">{{ __('Product Status') }}</label>
                    <div style="display: flex; align-items: center; gap: 12px; background: rgba(255,255,255,0.03); border: 1px solid var(--admin-border); padding: 10px 16px; border-radius: 10px; height: 44px; box-sizing: border-box;">
                        <input type="checkbox" wire:model="is_active" id="is_active" style="width: 20px; height: 20px; cursor: pointer; accent-color: var(--admin-accent);">
                        <label for="is_active" style="color: white; font-size: 14px; cursor: pointer; font-weight: 500;">{{ $is_active ? __('Active') : __('Inactive') }}</label>
                    </div>
                </div>
            </div>

            <!-- Brand & Category -->
            <div class="form-row">
                <div class="form-group">
                     <label class="form-label" for="brand">{{ __('Brand') }}</label>
                     <input type="text" id="brand" class="admin-input" wire:model="brand" placeholder="{{ __('e.g. Apple') }}">
                     @error('brand') <span style="color: #ff3b30; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span> @enderror
                </div>
                 <div class="form-group">
                     <label class="form-label" for="category">{{ __('Category') }}</label>
                     <select id="category" class="admin-select" wire:model="category">
                         <option value="">{{ __('Select Category') }}</option>
                         <option value="Smartphones">{{ __('Smartphones') }}</option>
                         <option value="Macbook">{{ __('Macbook') }}</option>
                         <option value="iPad">{{ __('iPad') }}</option>
                         <option value="Apple Watch">{{ __('Apple Watch') }}</option>
                         <option value="AirPods">{{ __('AirPods') }}</option>
                         <option value="Accessories">{{ __('Accessories') }}</option>
                     </select>
                     @error('category') <span style="color: #ff3b30; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                     <label class="form-label" for="city">{{ __('City') }}</label>
                     <select id="city" class="admin-select" wire:model="city">
                         <option value="">{{ __('Select City') }}</option>
                         <option value="Moscow">{{ __('Moscow') }}</option>
                         <option value="Saint Petersburg">{{ __('Saint Petersburg') }}</option>
                         <option value="Novokuznetsk">{{ __('Novokuznetsk') }}</option>
                     </select>
                     @error('city') <span style="color: #ff3b30; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Price & Stock -->
            <div class="form-row" style="grid-template-columns: 1fr 1fr 1fr;">
                <div class="form-group">
                    <label class="form-label" for="price">{{ __('Price') }} ($)</label>
                    <input type="number" id="price" class="admin-input" wire:model="price" placeholder="0.00" step="0.01">
                    @error('price') <span style="color: #ff3b30; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label" for="old_price">{{ __('Old Price') }} ($)</label>
                    <input type="number" id="old_price" class="admin-input" wire:model="old_price" placeholder="{{ __('Optional') }}" step="0.01">
                    @error('old_price') <span style="color: #ff3b30; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span> @enderror
                </div>
                 <div class="form-group">
                    <label class="form-label" for="stock">{{ __('Stock') }}</label>
                    <input type="number" id="stock" class="admin-input" wire:model="stock" placeholder="{{ __('Qty') }}">
                    @error('stock') <span style="color: #ff3b30; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span> @enderror
                </div>
            </div>

             <!-- Description -->
             <div class="form-group">
                <label class="form-label">{{ __('Description') }}</label>
                <textarea wire:model="description" rows="5" class="admin-textarea" style="resize: none;" placeholder="{{ __('Tell customers about this product...') }}"></textarea>
                 @error('description') <span style="color: #ff3b30; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span> @enderror
            </div>

            <!-- Badge Settings -->
            <div class="form-row" style="grid-template-columns: 2fr 1fr;">
                <div class="form-group">
                    <label class="form-label">{{ __('Badge Text (Optional)') }}</label>
                    <input type="text" wire:model="badge_text" class="admin-input" placeholder="{{ __('e.g. GOOD PRICE, NEW, SALE') }}">
                    <small style="color: var(--text-muted); font-size: 11px; margin-top: 4px; display: block;">{{ __('Leave empty for no badge') }}</small>
                    @error('badge_text') <span style="color: #ff3b30; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">{{ __('Badge Style') }}</label>
                    <select wire:model="badge_type" class="admin-select">
                        <option value="price">{{ __('Price') }} ({{ __('Green') }})</option>
                        <option value="discount">{{ __('Discount') }} ({{ __('Red') }})</option>
                        <option value="new">{{ __('New') }} ({{ __('Blue') }})</option>
                        <option value="sale">{{ __('Sale') }} ({{ __('Orange') }})</option>
                        <option value="hot">{{ __('Hot') }} ({{ __('Pink') }})</option>
                    </select>
                    @error('badge_type') <span style="color: #ff3b30; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Image Upload Section -->
            <div class="form-group">
                <label class="form-label" style="margin-bottom: 16px;">{{ __('Product Images') }}</label>
                
                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px;">
                    
                    <!-- Main Image -->
                    <div style="border: 2px dashed var(--admin-border); border-radius: 16px; padding: 20px; text-align: center; background: rgba(255,255,255,0.02); transition: all 0.3s ease;">
                        <div style="margin-bottom: 12px; font-size: 12px; color: var(--text-muted); font-weight: 600;">{{ __('Main Image') }}</div>
                        @if ($new_image)
                            <div style="position: relative;">
                                <img src="{{ $new_image->temporaryUrl() }}" style="width: 100%; height: 110px; object-fit: contain; border-radius: 10px; margin-bottom: 12px;">
                                <span style="position: absolute; top: -8px; right: -8px; background: var(--admin-accent); color: white; font-size: 10px; padding: 4px 8px; border-radius: 20px; font-weight: 700; box-shadow: 0 4px 10px rgba(203, 17, 171, 0.4);">{{ __('New') }}</span>
                            </div>
                        @elseif ($image)
                            <img src="{{ $image }}" style="width: 100%; height: 110px; object-fit: contain; border-radius: 10px; margin-bottom: 12px; opacity: 0.8;">
                        @else
                            <div style="width: 100%; height: 110px; display: flex; align-items: center; justify-content: center; background: #222; border-radius: 10px; margin-bottom: 12px; color: #555;">
                                <img src="https://img.icons8.com/ios/50/444444/image.png" style="width: 32px; opacity: 0.5;">
                            </div>
                        @endif
                        
                        <input type="file" wire:model="new_image" id="file-upload-1" style="display: none;">
                        <label for="file-upload-1" style="display: inline-block; background: var(--admin-accent); color: white; padding: 6px 16px; border-radius: 20px; font-size: 12px; font-weight: 600; cursor: pointer; transition: transform 0.2s;">{{ $image ? __('Change') : __('Upload') }}</label>
                         @error('new_image') <span style="color: #ff3b30; font-size: 11px; display: block; margin-top: 8px;">{{ $message }}</span> @enderror
                    </div>

                    <!-- Additional Images -->
                    @foreach(['2', '3', '4'] as $idx)
                    <div style="border: 2px dashed var(--admin-border); border-radius: 16px; padding: 20px; text-align: center; background: rgba(255,255,255,0.02);">
                        <div style="margin-bottom: 12px; font-size: 12px; color: var(--text-muted); font-weight: 600;">{{ __('Image') }} {{ $idx }}</div>
                        @php 
                            $newImgProp = "new_image_$idx";
                            $oldImgProp = "image_$idx";
                            $newImgVal = $$newImgProp;
                            $oldImgVal = $$oldImgProp;
                        @endphp
                        @if ($newImgVal)
                            <div style="position: relative;">
                                <img src="{{ $newImgVal->temporaryUrl() }}" style="width: 100%; height: 110px; object-fit: contain; border-radius: 10px; margin-bottom: 12px;">
                                <span style="position: absolute; top: -8px; right: -8px; background: var(--admin-accent); color: white; font-size: 10px; padding: 4px 8px; border-radius: 20px; font-weight: 700; box-shadow: 0 4px 10px rgba(203, 17, 171, 0.4);">{{ __('New') }}</span>
                            </div>
                        @elseif ($oldImgVal)
                            <img src="{{ $oldImgVal }}" style="width: 100%; height: 110px; object-fit: contain; border-radius: 10px; margin-bottom: 12px; opacity: 0.8;">
                        @else
                            <div style="width: 100%; height: 110px; display: flex; align-items: center; justify-content: center; background: #222; border-radius: 10px; margin-bottom: 12px; color: #555;">
                                <img src="https://img.icons8.com/ios/50/444444/image.png" style="width: 32px; opacity: 0.5;">
                            </div>
                        @endif
                        
                        <input type="file" wire:model="{{ $newImgProp }}" id="file-upload-{{ $idx }}" style="display: none;">
                        <label for="file-upload-{{ $idx }}" style="display: inline-block; background: rgba(255,255,255,0.05); color: white; padding: 6px 16px; border-radius: 20px; font-size: 12px; font-weight: 600; cursor: pointer; border: 1px solid var(--admin-border);">{{ $oldImgVal ? __('Change') : __('Upload') }}</label>
                         @error($newImgProp) <span style="color: #ff3b30; font-size: 11px; display: block; margin-top: 8px;">{{ $message }}</span> @enderror
                    </div>
                    @endforeach
                </div>
                 <div wire:loading wire:target="new_image, new_image_2, new_image_3, new_image_4" style="margin-top: 15px; font-size: 12px; color: var(--admin-accent); font-weight: 600; display: flex; align-items: center; gap: 8px;">
                    <span class="spinner"></span> {{ __('Uploading image...') }}
                 </div>
            </div>

            <!-- Actions -->
            <div style="display: flex; justify-content: flex-end; gap: 16px; padding-top: 32px; border-top: 1px solid var(--admin-border); margin-top: 20px;">
                <a href="{{ route('admin.products.index') }}" class="btn-secondary" style="text-decoration: none; padding: 12px 24px; border-radius: 10px; font-size: 14px; font-weight: 600; color: var(--text-muted); background: rgba(255,255,255,0.05); transition: all 0.2s;">{{ __('Cancel') }}</a>
                <button type="submit" class="btn-primary" style="padding: 12px 32px; border-radius: 10px; font-size: 14px; font-weight: 700; background: var(--admin-accent); color: white; border: none; cursor: pointer; box-shadow: 0 4px 15px rgba(203, 17, 171, 0.3); transition: all 0.2s;">
                    <span wire:loading.remove>{{ __('Update Product') }}</span>
                    <span wire:loading>{{ __('Updating...') }}</span>
                </button>
            </div>
        </form>
    </div>
</div>
