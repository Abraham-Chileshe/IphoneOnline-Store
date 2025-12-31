@section('title', 'Edit Product')

<div>
    <div style="background: var(--admin-card); border: 1px solid var(--admin-border); border-radius: 16px; padding: 32px; max-width: 800px;">
        <form wire:submit.prevent="update">
            
            <!-- Name -->
            <div style="margin-bottom: 24px;">
                <label class="form-label" style="display: block; color: var(--text-muted); font-size: 13px; margin-bottom: 8px;">Product Name</label>
                <input type="text" wire:model="name" style="width: 100%; background: rgba(255,255,255,0.05); border: 1px solid var(--admin-border); color: white; padding: 10px 12px; border-radius: 8px;" placeholder="iPhone 15 Pro Max">
                @error('name') <span style="color: #ff3b30; font-size: 12px;">{{ $message }}</span> @enderror
            </div>

            <!-- Brand & Category -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 24px;">
                <!-- Brand -->
                <div>
                     <label class="form-label" style="display: block; color: var(--text-muted); font-size: 13px; margin-bottom: 8px;" for="brand">Brand</label>
                     <input type="text" id="brand" style="width: 100%; background: rgba(255,255,255,0.05); border: 1px solid var(--admin-border); color: white; padding: 10px 12px; border-radius: 8px;" wire:model="brand" placeholder="e.g. Apple">
                     @error('brand') <span style="color: #ff3b30; font-size: 12px;">{{ $message }}</span> @enderror
                </div>
                 <!-- Category -->
                 <div>
                     <label class="form-label" style="display: block; color: var(--text-muted); font-size: 13px; margin-bottom: 8px;" for="category">Category</label>
                     <input type="text" id="category" style="width: 100%; background: rgba(255,255,255,0.05); border: 1px solid var(--admin-border); color: white; padding: 10px 12px; border-radius: 8px;" wire:model="category" placeholder="e.g. Smartphones">
                     @error('category') <span style="color: #ff3b30; font-size: 12px;">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Price & Stock -->
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; margin-bottom: 24px;">
                <!-- Price -->
                <div>
                    <label class="form-label" style="display: block; color: var(--text-muted); font-size: 13px; margin-bottom: 8px;" for="price">Price ($)</label>
                    <input type="number" id="price" style="width: 100%; background: rgba(255,255,255,0.05); border: 1px solid var(--admin-border); color: white; padding: 10px 12px; border-radius: 8px;" wire:model="price" placeholder="0.00" step="0.01">
                    @error('price') <span style="color: #ff3b30; font-size: 12px;">{{ $message }}</span> @enderror
                </div>
                <!-- Old Price -->
                <div>
                    <label class="form-label" style="display: block; color: var(--text-muted); font-size: 13px; margin-bottom: 8px;" for="old_price">Old Price ($)</label>
                    <input type="number" id="old_price" style="width: 100%; background: rgba(255,255,255,0.05); border: 1px solid var(--admin-border); color: white; padding: 10px 12px; border-radius: 8px;" wire:model="old_price" placeholder="Optional" step="0.01">
                    @error('old_price') <span style="color: #ff3b30; font-size: 12px;">{{ $message }}</span> @enderror
                </div>
                 <!-- Stock -->
                 <div>
                    <label class="form-label" style="display: block; color: var(--text-muted); font-size: 13px; margin-bottom: 8px;" for="stock">Stock</label>
                    <input type="number" id="stock" style="width: 100%; background: rgba(255,255,255,0.05); border: 1px solid var(--admin-border); color: white; padding: 10px 12px; border-radius: 8px;" wire:model="stock" placeholder="Qty">
                    @error('stock') <span style="color: #ff3b30; font-size: 12px;">{{ $message }}</span> @enderror
                </div>
            </div>

             <!-- Description -->
             <div style="margin-bottom: 24px;">
                <label class="form-label" style="display: block; color: var(--text-muted); font-size: 13px; margin-bottom: 8px;">Description</label>
                <textarea wire:model="description" rows="4" style="width: 100%; background: rgba(255,255,255,0.05); border: 1px solid var(--admin-border); color: white; padding: 10px 12px; border-radius: 8px; resize: vertical;"></textarea>
                 @error('description') <span style="color: #ff3b30; font-size: 12px;">{{ $message }}</span> @enderror
            </div>

            <!-- Image Upload Section -->
            <div style="margin-bottom: 32px;">
                <label class="form-label" style="display: block; color: var(--text-muted); font-size: 13px; margin-bottom: 16px;">Product Images</label>
                
                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px;">
                    
                    <!-- Main Image -->
                    <div style="border: 2px dashed var(--admin-border); border-radius: 12px; padding: 16px; text-align: center; background: rgba(255,255,255,0.02);">
                        <div style="margin-bottom: 8px; font-size: 12px; color: var(--text-muted);">Main Image</div>
                        @if ($new_image)
                            <div style="position: relative;">
                                <img src="{{ $new_image->temporaryUrl() }}" style="width: 100%; height: 100px; object-fit: contain; border-radius: 8px; margin-bottom: 8px;">
                                <span style="position: absolute; top: 0; right: 0; background: var(--admin-accent); color: white; font-size: 10px; padding: 2px 6px; border-radius: 4px;">New</span>
                            </div>
                        @elseif ($image)
                            <img src="{{ $image }}" style="width: 100%; height: 100px; object-fit: contain; border-radius: 8px; margin-bottom: 8px; opacity: 0.8;">
                        @else
                            <div style="width: 100%; height: 100px; display: flex; align-items: center; justify-content: center; background: #222; border-radius: 8px; margin-bottom: 8px; color: #555;">No Image</div>
                        @endif
                        
                        <input type="file" wire:model="new_image" id="file-upload-1" style="display: none;">
                        <label for="file-upload-1" style="color: var(--admin-accent); cursor: pointer; font-size: 13px;">{{ $image ? 'Change' : 'Upload' }}</label>
                         @error('new_image') <span style="color: #ff3b30; font-size: 11px; display: block;">{{ $message }}</span> @enderror
                    </div>

                    <!-- Image 2 -->
                    <div style="border: 2px dashed var(--admin-border); border-radius: 12px; padding: 16px; text-align: center; background: rgba(255,255,255,0.02);">
                        <div style="margin-bottom: 8px; font-size: 12px; color: var(--text-muted);">Image 2</div>
                        @if ($new_image_2)
                            <div style="position: relative;">
                                <img src="{{ $new_image_2->temporaryUrl() }}" style="width: 100%; height: 100px; object-fit: contain; border-radius: 8px; margin-bottom: 8px;">
                                <span style="position: absolute; top: 0; right: 0; background: var(--admin-accent); color: white; font-size: 10px; padding: 2px 6px; border-radius: 4px;">New</span>
                            </div>
                        @elseif ($image_2)
                            <img src="{{ $image_2 }}" style="width: 100%; height: 100px; object-fit: contain; border-radius: 8px; margin-bottom: 8px; opacity: 0.8;">
                        @else
                            <div style="width: 100%; height: 100px; display: flex; align-items: center; justify-content: center; background: #222; border-radius: 8px; margin-bottom: 8px; color: #555;">No Image</div>
                        @endif
                        
                        <input type="file" wire:model="new_image_2" id="file-upload-2" style="display: none;">
                        <label for="file-upload-2" style="color: var(--admin-accent); cursor: pointer; font-size: 13px;">{{ $image_2 ? 'Change' : 'Upload' }}</label>
                         @error('new_image_2') <span style="color: #ff3b30; font-size: 11px; display: block;">{{ $message }}</span> @enderror
                    </div>

                    <!-- Image 3 -->
                    <div style="border: 2px dashed var(--admin-border); border-radius: 12px; padding: 16px; text-align: center; background: rgba(255,255,255,0.02);">
                        <div style="margin-bottom: 8px; font-size: 12px; color: var(--text-muted);">Image 3</div>
                        @if ($new_image_3)
                            <div style="position: relative;">
                                <img src="{{ $new_image_3->temporaryUrl() }}" style="width: 100%; height: 100px; object-fit: contain; border-radius: 8px; margin-bottom: 8px;">
                                <span style="position: absolute; top: 0; right: 0; background: var(--admin-accent); color: white; font-size: 10px; padding: 2px 6px; border-radius: 4px;">New</span>
                            </div>
                        @elseif ($image_3)
                            <img src="{{ $image_3 }}" style="width: 100%; height: 100px; object-fit: contain; border-radius: 8px; margin-bottom: 8px; opacity: 0.8;">
                        @else
                            <div style="width: 100%; height: 100px; display: flex; align-items: center; justify-content: center; background: #222; border-radius: 8px; margin-bottom: 8px; color: #555;">No Image</div>
                        @endif
                        
                        <input type="file" wire:model="new_image_3" id="file-upload-3" style="display: none;">
                        <label for="file-upload-3" style="color: var(--admin-accent); cursor: pointer; font-size: 13px;">{{ $image_3 ? 'Change' : 'Upload' }}</label>
                         @error('new_image_3') <span style="color: #ff3b30; font-size: 11px; display: block;">{{ $message }}</span> @enderror
                    </div>

                    <!-- Image 4 -->
                    <div style="border: 2px dashed var(--admin-border); border-radius: 12px; padding: 16px; text-align: center; background: rgba(255,255,255,0.02);">
                        <div style="margin-bottom: 8px; font-size: 12px; color: var(--text-muted);">Image 4</div>
                        @if ($new_image_4)
                            <div style="position: relative;">
                                <img src="{{ $new_image_4->temporaryUrl() }}" style="width: 100%; height: 100px; object-fit: contain; border-radius: 8px; margin-bottom: 8px;">
                                <span style="position: absolute; top: 0; right: 0; background: var(--admin-accent); color: white; font-size: 10px; padding: 2px 6px; border-radius: 4px;">New</span>
                            </div>
                        @elseif ($image_4)
                            <img src="{{ $image_4 }}" style="width: 100%; height: 100px; object-fit: contain; border-radius: 8px; margin-bottom: 8px; opacity: 0.8;">
                        @else
                            <div style="width: 100%; height: 100px; display: flex; align-items: center; justify-content: center; background: #222; border-radius: 8px; margin-bottom: 8px; color: #555;">No Image</div>
                        @endif
                        
                        <input type="file" wire:model="new_image_4" id="file-upload-4" style="display: none;">
                        <label for="file-upload-4" style="color: var(--admin-accent); cursor: pointer; font-size: 13px;">{{ $image_4 ? 'Change' : 'Upload' }}</label>
                         @error('new_image_4') <span style="color: #ff3b30; font-size: 11px; display: block;">{{ $message }}</span> @enderror
                    </div>

                </div>
                 <div wire:loading wire:target="new_image, new_image_2, new_image_3, new_image_4" style="margin-top: 8px; font-size: 12px; color: var(--text-muted);">Uploading image...</div>
            </div>

            <!-- Actions -->
            <div style="display: flex; justify-content: flex-end; gap: 12px; padding-top: 24px; border-top: 1px solid var(--admin-border);">
                <a href="{{ route('admin.products.index') }}" class="btn-secondary" style="text-decoration: none; padding: 10px 20px; border-radius: 8px; font-size: 14px; color: var(--text-muted); background: rgba(255,255,255,0.05);">Cancel</a>
                <button type="submit" class="btn-primary" style="padding: 10px 24px; border-radius: 8px; font-size: 14px; background: var(--admin-accent); color: white; border: none; cursor: pointer;">
                    <span wire:loading.remove>Update Product</span>
                    <span wire:loading>Updating...</span>
                </button>
            </div>
        </form>
    </div>
</div>
