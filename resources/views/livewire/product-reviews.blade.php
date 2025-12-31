<div>
<div class="reviews-section">
    <div class="reviews-header">
        <h2>Customer Reviews</h2>
        <div class="reviews-summary">
            <div class="rating-overview">
                <div class="rating-score">
                    <span class="score-number">{{ $averageRating }}</span>
                    <div class="stars-display">
                        @for($i = 1; $i <= 5; $i++)
                            <span class="star {{ $i <= round($averageRating) ? 'filled' : '' }}">★</span>
                        @endfor
                    </div>
                    <p class="total-reviews">{{ $totalReviews }} {{ Str::plural('review', $totalReviews) }}</p>
                </div>
                
                <div class="rating-bars">
                    @foreach($ratingDistribution as $stars => $data)
                        <div class="rating-bar-row">
                            <span class="stars-label">{{ $stars }} ★</span>
                            <div class="bar-container">
                                <div class="bar-fill" style="width: {{ $data['percentage'] }}%"></div>
                            </div>
                            <span class="count-label">{{ $data['count'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Write Review Button --}}
    @auth
        @if(!$userHasReviewed)
            <div class="write-review-section">
                <button wire:click="toggleForm" class="btn btn-primary">
                    {{ $showForm ? 'Cancel' : 'Write a Review' }}
                </button>
            </div>
        @else
            <div class="alert alert-info">
                You have already reviewed this product.
            </div>
        @endif
    @else
        <div class="alert alert-info">
            <a href="{{ route('login') }}" style="color: inherit; text-decoration: underline;">Sign in</a> to write a review.
        </div>
    @endauth

    {{-- Review Form --}}
    @if($showForm)
        <div class="review-form-container">
            <h3>Write Your Review</h3>
            
            @if (session()->has('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            
            @if (session()->has('error'))
                <div class="alert alert-error">{{ session('error') }}</div>
            @endif
            
            <form wire:submit.prevent="submitReview">
                {{-- Rating Stars --}}
                <div class="form-group">
                    <label>Rating *</label>
                    <div class="star-rating-input">
                        @for($i = 1; $i <= 5; $i++)
                            <span class="star-input {{ $rating >= $i ? 'active' : '' }}" 
                                  wire:click="$set('rating', {{ $i }})"
                                  style="cursor: pointer; font-size: 32px; color: {{ $rating >= $i ? '#FFD700' : '#ddd' }};">
                                ★
                            </span>
                        @endfor
                    </div>
                    @error('rating') <span class="error-text">{{ $message }}</span> @enderror
                </div>

                {{-- Review Title --}}
                <div class="form-group">
                    <label>Review Title (Optional)</label>
                    <input type="text" 
                           wire:model="title" 
                           placeholder="Summarize your experience"
                           maxlength="200"
                           class="form-input">
                    @error('title') <span class="error-text">{{ $message }}</span> @enderror
                </div>

                {{-- Review Comment --}}
                <div class="form-group">
                    <label>Your Review *</label>
                    <textarea wire:model="comment" 
                              rows="5" 
                              placeholder="Share your thoughts about this product..."
                              maxlength="1000"
                              class="form-textarea"></textarea>
                    <small class="char-count">{{ strlen($comment) }}/1000 characters</small>
                    @error('comment') <span class="error-text">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="btn btn-primary">Submit Review</button>
            </form>
        </div>
    @endif

    {{-- Reviews List --}}
    <div class="reviews-list">
        @forelse($reviews as $review)
            <div class="review-item">
                <div class="review-header">
                    <div class="reviewer-info">
                        <div class="reviewer-avatar">
                            {{ strtoupper(substr($review->user->name, 0, 1)) }}
                        </div>
                        <div>
                            <h4 class="reviewer-name">{{ $review->user->name }}</h4>
                            <div class="review-meta">
                                <div class="review-stars">
                                    @for($i = 1; $i <= 5; $i++)
                                        <span class="star {{ $i <= $review->rating ? 'filled' : '' }}">★</span>
                                    @endfor
                                </div>
                                <span class="review-date">{{ $review->created_at->diffForHumans() }}</span>
                                @if($review->verified_purchase)
                                    <span class="verified-badge">✓ Verified Purchase</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                @if($review->title)
                    <h5 class="review-title">{{ $review->title }}</h5>
                @endif
                
                <p class="review-comment">{{ $review->comment }}</p>
            </div>
        @empty
            <div class="no-reviews">
                <p>No reviews yet. Be the first to review this product!</p>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($reviews->hasPages())
        <div class="pagination-wrapper">
            {{ $reviews->links() }}
        </div>
    @endif
</div>

@push('styles')
<style>
.reviews-section {
    background: var(--bg-card);
    border-radius: 16px;
    padding: 30px;
    margin-top: 40px;
}

.reviews-header h2 {
    font-size: 28px;
    margin-bottom: 30px;
    color: var(--text-main);
}

.reviews-summary {
    display: flex;
    gap: 40px;
    margin-bottom: 30px;
}

.rating-overview {
    display: flex;
    gap: 40px;
    flex-wrap: wrap;
}

.rating-score {
    text-align: center;
}

.score-number {
    font-size: 48px;
    font-weight: 700;
    color: var(--text-main);
}

.stars-display {
    margin: 10px 0;
}

.stars-display .star {
    font-size: 24px;
    color: #ddd;
}

.stars-display .star.filled {
    color: #FFD700;
}

.total-reviews {
    color: var(--text-muted);
    font-size: 14px;
}

.rating-bars {
    flex: 1;
    min-width: 300px;
}

.rating-bar-row {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 8px;
}

.stars-label {
    width: 40px;
    font-size: 14px;
    color: var(--text-main);
}

.bar-container {
    flex: 1;
    height: 8px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 4px;
    overflow: hidden;
}

.bar-fill {
    height: 100%;
    background: #FFD700;
    transition: width 0.3s ease;
}

.count-label {
    width: 30px;
    text-align: right;
    font-size: 14px;
    color: var(--text-muted);
}

.write-review-section {
    margin: 20px 0;
}

.alert {
    padding: 15px 20px;
    border-radius: 8px;
    margin: 20px 0;
}

.alert-info {
    background: rgba(59, 130, 246, 0.1);
    color: #3b82f6;
    border: 1px solid rgba(59, 130, 246, 0.2);
}

.alert-success {
    background: rgba(34, 197, 94, 0.1);
    color: #22c55e;
    border: 1px solid rgba(34, 197, 94, 0.2);
}

.alert-error {
    background: rgba(239, 68, 68, 0.1);
    color: #ef4444;
    border: 1px solid rgba(239, 68, 68, 0.2);
}

.review-form-container {
    background: rgba(255, 255, 255, 0.03);
    border-radius: 12px;
    padding: 30px;
    margin: 20px 0;
}

.review-form-container h3 {
    margin-bottom: 20px;
    color: var(--text-main);
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: var(--text-main);
}

.star-rating-input {
    display: flex;
    gap: 5px;
}

.form-input,
.form-textarea {
    width: 100%;
    padding: 12px 16px;
    border: 1px solid var(--border-color);
    border-radius: 8px;
    background: rgba(255, 255, 255, 0.05);
    color: var(--text-main);
    font-size: 16px;
}

.form-textarea {
    resize: vertical;
    font-family: inherit;
}

.char-count {
    display: block;
    margin-top: 5px;
    font-size: 12px;
    color: var(--text-muted);
}

.error-text {
    color: #ef4444;
    font-size: 14px;
    display: block;
    margin-top: 5px;
}

.reviews-list {
    margin-top: 40px;
}

.review-item {
    background: rgba(255, 255, 255, 0.03);
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 20px;
}

.review-header {
    display: flex;
    justify-content: space-between;
    margin-bottom: 15px;
}

.reviewer-info {
    display: flex;
    gap: 15px;
}

.reviewer-avatar {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: var(--primary-purple);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    font-weight: 700;
    color: white;
}

.reviewer-name {
    font-size: 16px;
    font-weight: 600;
    color: var(--text-main);
    margin-bottom: 5px;
}

.review-meta {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}

.review-stars .star {
    font-size: 16px;
    color: #ddd;
}

.review-stars .star.filled {
    color: #FFD700;
}

.review-date {
    font-size: 14px;
    color: var(--text-muted);
}

.verified-badge {
    font-size: 12px;
    color: #22c55e;
    background: rgba(34, 197, 94, 0.1);
    padding: 2px 8px;
    border-radius: 4px;
}

.review-title {
    font-size: 18px;
    font-weight: 600;
    color: var(--text-main);
    margin-bottom: 10px;
}

.review-comment {
    color: var(--text-main);
    line-height: 1.6;
}

.no-reviews {
    text-align: center;
    padding: 40px;
    color: var(--text-muted);
}

.btn {
    padding: 12px 24px;
    border-radius: 8px;
    border: none;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-primary {
    background: var(--primary-gradient);
    color: white;
}

.btn-primary:hover {
    opacity: 0.9;
    transform: translateY(-2px);
}

.pagination-wrapper {
    margin-top: 30px;
    display: flex;
    justify-content: center;
}
</style>
@endpush
</div>
