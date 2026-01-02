@if($layout === 'desktop')
    {{-- Desktop Search --}}
    <div class="header__search-wrapper" 
         x-data="{ inputFocused: false }"
         @click.outside="inputFocused = false">
        
        <div class="header__search">
            <input type="text" 
                   wire:model.live.debounce.300ms="search" 
                   wire:keydown.enter="performSearch"
                   @focus="inputFocused = true"
                   placeholder="{{ __('Search products...') }}"
                   autocomplete="off">
            <button class="header__search-btn" wire:click="performSearch" type="button">
                <img src="https://img.icons8.com/ios/24/000000/search--v1.png" alt="search">
            </button>
        </div>

        @if(count($suggestions) > 0)
            <div class="search-suggestions" 
                 x-show="inputFocused"
                 x-transition
                 wire:key="suggestions-desktop-{{ md5(json_encode($suggestions)) }}">
                <div class="suggestions-header">{{ __('Quick Results') }} ({{ count($suggestions) }})</div>
                <ul class="suggestions-list">
                    @foreach($suggestions as $suggestion)
                        <li wire:click="selectSuggestion('{{ addslashes($suggestion['name']) }}')" 
                            @click="inputFocused = false"
                            style="cursor: pointer;">
                            <img src="https://img.icons8.com/ios/20/999999/search--v1.png" alt="ico">
                            <span>{{ $suggestion['name'] }}</span>
                            <span class="suggestion-brand">{{ $suggestion['brand'] }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

@else
    {{-- Mobile Search --}}
    <div class="header-mobile__search-wrapper" 
         x-data="{ inputFocused: false }"
         @click.outside="inputFocused = false">
        
        <div class="header-mobile__search">
            <input type="text" 
                   wire:model.live.debounce.300ms="search" 
                   wire:keydown.enter="performSearch"
                   @focus="inputFocused = true"
                   placeholder="{{ __('Search products...') }}"
                   autocomplete="off">
            <img src="https://img.icons8.com/ios/50/999999/camera.png" alt="photo" class="search-camera">
        </div>

        @if(count($suggestions) > 0)
            <div class="search-suggestions search-suggestions--mobile" 
                 x-show="inputFocused"
                 x-transition
                 wire:key="suggestions-mobile-{{ md5(json_encode($suggestions)) }}">
                <ul class="suggestions-list">
                    @foreach($suggestions as $suggestion)
                        <li wire:click="selectSuggestion('{{ addslashes($suggestion['name']) }}')"
                            @click="inputFocused = false"
                            style="cursor: pointer;">
                            <img src="https://img.icons8.com/ios/20/999999/search--v1.png" alt="ico">
                            <span>{{ $suggestion['name'] }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
@endif

