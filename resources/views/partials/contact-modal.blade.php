<div id="contactModal" class="contact-modal" style="display: none;">
    <div class="contact-modal__overlay" onclick="closeContactModal()"></div>
    <div class="contact-modal__content reveal">
        <button class="contact-modal__close" onclick="closeContactModal()">
            <i class="fa-solid fa-xmark"></i>
        </button>
        
        <div class="contact-modal__header">
            <div class="contact-modal__icon">
                <i class="fa-solid fa-headset"></i>
            </div>
            <h2 class="contact-modal__title">{{ __('Contact Us') }}</h2>
            <p class="contact-modal__subtitle">{{ __('Get in touch with our team for assistance.') }}</p>
        </div>

        <div class="contact-modal__body">
            <div class="contact-item">
                <div class="contact-item__icon">
                    <i class="fa-solid fa-phone"></i>
                </div>
                <div class="contact-item__info">
                    <span class="contact-item__label">{{ __('Call or WhatsApp') }}</span>
                    <a href="tel:{{ \App\Models\Setting::get('admin_phone') }}" class="contact-item__value">
                        {{ \App\Models\Setting::get('admin_phone', '+260 977 123456') }}
                    </a>
                </div>
                <button class="contact-item__action" onclick="copyToClipboard('{{ \App\Models\Setting::get('admin_phone') }}', this)">
                    <i class="fa-regular fa-copy"></i>
                </button>
            </div>

            <div class="contact-item">
                <div class="contact-item__icon">
                    <i class="fa-solid fa-envelope"></i>
                </div>
                <div class="contact-item__info">
                    <span class="contact-item__label">{{ __('Email Address') }}</span>
                    <a href="mailto:{{ \App\Models\Setting::get('admin_email') }}" class="contact-item__value">
                        {{ \App\Models\Setting::get('admin_email', 'admin@example.com') }}
                    </a>
                </div>
                <button class="contact-item__action" onclick="copyToClipboard('{{ \App\Models\Setting::get('admin_email') }}', this)">
                    <i class="fa-regular fa-copy"></i>
                </button>
            </div>
        </div>

        <div class="contact-modal__footer">
            <button class="btn-contact-primary" onclick="closeContactModal()">{{ __('Close') }}</button>
        </div>
    </div>
</div>

<style>
    .contact-modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 10000;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .contact-modal__overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.8);
        backdrop-filter: blur(5px);
    }

    .contact-modal__content {
        position: relative;
        background: var(--bg-card);
        width: 100%;
        max-width: 450px;
        border-radius: 28px;
        padding: 40px;
        border: 1px solid var(--border-color);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        animation: modalFadeIn 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
    }

    @keyframes modalFadeIn {
        from { opacity: 0; transform: scale(0.9) translateY(20px); }
        to { opacity: 1; transform: scale(1) translateY(0); }
    }

    .contact-modal__close {
        position: absolute;
        top: 20px;
        right: 20px;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: none;
        background: var(--bg-dark);
        color: var(--text-muted);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }

    .contact-modal__close:hover {
        background: var(--primary-purple);
        color: white;
        transform: rotate(90deg);
    }

    .contact-modal__header {
        text-align: center;
        margin-bottom: 30px;
    }

    .contact-modal__icon {
        width: 64px;
        height: 64px;
        background: rgba(203, 17, 171, 0.1);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 28px;
        color: var(--primary-purple);
    }

    .contact-modal__title {
        font-size: 24px;
        font-weight: 800;
        color: var(--text-main);
        margin-bottom: 8px;
    }

    .contact-modal__subtitle {
        color: var(--text-muted);
        font-size: 14px;
    }

    .contact-modal__body {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .contact-item {
        background: var(--bg-dark);
        border: 1px solid var(--border-color);
        border-radius: 18px;
        padding: 16px;
        display: flex;
        align-items: center;
        gap: 16px;
        transition: all 0.2s;
    }

    .contact-item:hover {
        border-color: var(--primary-purple);
        background: rgba(203, 17, 171, 0.05);
    }

    .contact-item__icon {
        width: 44px;
        height: 44px;
        background: var(--bg-card);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        color: var(--primary-purple);
    }

    .contact-item__info {
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .contact-item__label {
        font-size: 12px;
        color: var(--text-muted);
        margin-bottom: 2px;
    }

    .contact-item__value {
        font-size: 16px;
        font-weight: 700;
        color: var(--text-main);
        text-decoration: none;
    }

    .contact-item__action {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        border: none;
        background: var(--bg-card);
        color: var(--text-muted);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }

    .contact-item__action:hover {
        background: var(--primary-purple);
        color: white;
    }

    .contact-modal__footer {
        margin-top: 30px;
    }

    .btn-contact-primary {
        width: 100%;
        padding: 16px;
        border-radius: 16px;
        border: none;
        background: var(--primary-gradient);
        color: white;
        font-weight: 800;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.3s;
    }

    .btn-contact-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(203, 17, 171, 0.3);
    }
</style>

<script>
    function showContactModal() {
        document.getElementById('contactModal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closeContactModal() {
        document.getElementById('contactModal').style.display = 'none';
        document.body.style.overflow = '';
    }

    function copyToClipboard(text, btn) {
        navigator.clipboard.writeText(text).then(() => {
            const icon = btn.querySelector('i');
            const originalClass = icon.className;
            icon.className = 'fa-solid fa-check';
            btn.style.color = '#34c759';
            
            setTimeout(() => {
                icon.className = originalClass;
                btn.style.color = '';
            }, 2000);
        });
    }
</script>
