@if($layout === 'desktop')
    <div class="header__search-wrapper" x-data="{ open: false }" @click.away="open = false">
        <div class="header__search">
            <input type="text" 
                   wire:model.live.debounce.300ms="search" 
                   wire:keydown.enter="performSearch"
                   @focus="open = true"
                   @input="open = true"
                   placeholder="Search products...">
            <button class="header__search-btn" wire:click="performSearch">
                <img src="https://img.icons8.com/ios/24/000000/search--v1.png" alt="search">
            </button>
        </div>

        @if(count($suggestions) > 0)
            <div class="search-suggestions" 
                 x-show="open"
                 x-transition>
                <div class="suggestions-header">Quick Results</div>
                <ul class="suggestions-list">
                    @foreach($suggestions as $suggestion)
                        <li wire:click="performSearch('{{ $suggestion['name'] }}')">
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
    <div class="header-mobile__search-wrapper" x-data="{ open: false }" @click.away="open = false">
        <div class="header-mobile__search">
            <input type="text" 
                   wire:model.live.debounce.300ms="search" 
                   wire:keydown.enter="performSearch"
                   @focus="open = true"
                   @input="open = true"
                   placeholder="Search products...">
            <img src="https://img.icons8.com/ios/50/999999/camera.png" alt="photo" class="search-camera">
        </div>

        @if(count($suggestions) > 0)
            <div class="search-suggestions search-suggestions--mobile" 
                 x-show="open"
                 x-transition>
                <ul class="suggestions-list">
                    @foreach($suggestions as $suggestion)
                        <li wire:click="performSearch('{{ $suggestion['name'] }}')">
                            <img src="https://img.icons8.com/ios/20/999999/search--v1.png" alt="ico">
                            <span>{{ $suggestion['name'] }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
@endif

