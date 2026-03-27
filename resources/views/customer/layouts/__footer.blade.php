{{-- ========================================================
     FOOTER — Warung Nusantara
     ======================================================== --}}
<footer style="background:var(--footer-bg); margin-top: auto;">
    <div style="max-width:1400px; margin:0 auto; padding: 48px 24px 0;">
        <div style="display:grid; grid-template-columns: 1fr; gap: 40px; padding-bottom: 40px; border-bottom: 1px solid rgba(255,255,255,0.06);">

            {{-- Brand col --}}
            <div style="max-width:340px">
                <div style="display:flex; align-items:center; gap:10px; margin-bottom:16px">
                    <div style="width:38px;height:38px;background:var(--amber);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0">🍜</div>
                    <div>
                        <div style="font-family:'Playfair Display',serif; font-size:1.2rem; font-weight:700; color:#fff; line-height:1">Warung Nusantara</div>
                        <div style="font-size:.7rem; color:rgba(255,255,255,0.4); margin-top:2px">Digital Menu</div>
                    </div>
                </div>
                <p style="font-size:.83rem; color:rgba(255,255,255,0.45); line-height:1.75; margin-bottom:20px">
                    Pilihan cita rasa Nusantara terbaik untuk pengalaman kuliner yang mudah, cepat, dan menyenangkan.
                </p>
                <div style="display:flex; gap:8px">
                    @foreach([['fab fa-instagram',''], ['fab fa-tiktok',''], ['fab fa-youtube','https://youtube.com']] as [$icon, $href])
                    <a href="{{ $href ?: '#' }}" target="{{ $href ? '_blank' : '_self' }}"
                       style="width:36px;height:36px;border-radius:50%;border:1px solid rgba(255,255,255,0.1);color:rgba(255,255,255,0.45);display:flex;align-items:center;justify-content:center;transition:all .2s;font-size:.85rem"
                       onmouseover="this.style.borderColor='var(--amber)';this.style.color='var(--amber)'"
                       onmouseout="this.style.borderColor='rgba(255,255,255,0.1)';this.style.color='rgba(255,255,255,0.45)'">
                        <i class="{{ $icon }}"></i>
                    </a>
                    @endforeach
                </div>
            </div>

            {{-- Contact col --}}
            <div>
                <div style="font-size:.8rem;font-weight:600;color:rgba(255,255,255,0.75);letter-spacing:1px;text-transform:uppercase;margin-bottom:16px">Hubungi Kami</div>
                <div style="display:flex;flex-direction:column;gap:12px">
                    @foreach([
                        ['fas fa-map-marker-alt','Tegalsari, Laweyan, Kota Surakarta, Jawa Tengah', null, null],
                        ['fas fa-envelope','info@warungnusantara.id','mailto:info@warungnusantara.id', null],
                        ['fas fa-phone','+62 812-3456-7890','tel:+6281234567890', null],
                        ['fab fa-whatsapp','Chat via WhatsApp','https://wa.me/6281234567890','_blank'],
                        ['fas fa-clock','Setiap hari, 10:00 – 22:00 WIB', null, null],
                    ] as [$icon, $label, $href, $target])
                    <div style="display:flex;gap:10px;align-items:flex-start">
                        <i class="{{ $icon }}" style="color:var(--amber);width:14px;flex-shrink:0;margin-top:2px;font-size:.85rem"></i>
                        @if($href)
                            <a href="{{ $href }}" {{ $target ? 'target='.$target : '' }} style="font-size:.82rem;color:rgba(255,255,255,0.45);text-decoration:none;transition:color .2s"
                               onmouseover="this.style.color='var(--amber)'" onmouseout="this.style.color='rgba(255,255,255,0.45)'">
                                {{ $label }}
                            </a>
                        @else
                            <span style="font-size:.82rem;color:rgba(255,255,255,0.45)">{{ $label }}</span>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Payment col --}}
            <div>
                <div style="font-size:.8rem;font-weight:600;color:rgba(255,255,255,0.75);letter-spacing:1px;text-transform:uppercase;margin-bottom:16px">Metode Pembayaran</div>
                <div style="display:flex;flex-direction:column;gap:8px">
                    @foreach([
                        ['fas fa-qrcode','QRIS / Scan QR'],
                        ['fab fa-cc-mastercard','Transfer Bank'],
                        ['fas fa-money-bill-wave','Tunai'],
                    ] as [$icon, $label])
                    <div style="display:flex;align-items:center;gap:10px;background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.07);border-radius:10px;padding:10px 14px">
                        <i class="{{ $icon }}" style="color:var(--amber);font-size:.9rem;width:16px"></i>
                        <span style="font-size:.82rem;color:rgba(255,255,255,0.55)">{{ $label }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>

    {{-- Copyright --}}
    <div style="padding:16px 24px; max-width:1400px; margin:0 auto; display:flex; flex-wrap:wrap; gap:8px; justify-content:space-between; align-items:center">
        <span style="font-size:.75rem;color:rgba(255,255,255,0.25)">
            &copy; Warung Nusantara <span id="wn-year"></span>. All rights reserved.
        </span>
        <span style="font-size:.75rem;color:rgba(255,255,255,0.2)">
            Powered by <span style="color:rgba(255,255,255,0.35)">Laravel</span>
        </span>
    </div>
</footer>

<style>
    @media (min-width: 640px) {
        footer > div:first-child > div:first-child {
            grid-template-columns: 1fr 1fr !important;
        }
    }
    @media (min-width: 1024px) {
        footer > div:first-child > div:first-child {
            grid-template-columns: 1.5fr 1fr 1fr !important;
        }
    }
</style>