import React, { useState } from "react";

function ContactModal({ product, settings, onClose }) {
    const [copied, setCopied] = useState(false);

    const formatPrice = (price) =>
        new Intl.NumberFormat("vi-VN", { style: "currency", currency: "VND" }).format(price);

    const productMsg = `Xin chào! Tôi muốn hỏi về sản phẩm [Mã: ${product.id}] - "${product.name}"`;

    const handleContact = (platform) => {
        let url = "";
        switch (platform) {
            case "zalo":
                url = `https://zalo.me/${settings.zalo_phone || "0000000000"}?text=${encodeURIComponent(productMsg)}`;
                break;
            case "facebook":
                url = `${settings.facebook_url || "https://m.me/"}?text=${encodeURIComponent(productMsg)}`;
                break;
            case "hotline":
                url = `tel:${settings.hotline || "0000000000"}`;
                break;
            default:
                break;
        }
        if (url) window.open(url, "_blank");
    };

    const mainImage = product.images && product.images.find((img) => img.is_main === 1) || product.images?.[0];
    const imageUrl = mainImage ? (mainImage.image_path && mainImage.image_path.startsWith("http") ? mainImage.image_path : `/storage/${mainImage.image_path}`) : "/client/img/product/default.jpg";

    const availabilityConfig = {
        in_stock: { label: "Còn hàng", cls: "bg-emerald-100 text-emerald-800 border-emerald-200" },
        sold:     { label: "Đã bán",   cls: "bg-red-100 text-red-700 border-red-200" },
        display:  { label: "Trưng bày",cls: "bg-amber-100 text-amber-800 border-amber-200" },
    };
    const avail = availabilityConfig[product.availability_status] || availabilityConfig.in_stock;

    return (
        <div
            className="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4"
            onClick={onClose}
        >
            <div
                className="bg-white rounded-2xl shadow-2xl max-w-md w-full overflow-hidden animate-fadeIn"
                onClick={(e) => e.stopPropagation()}
                style={{ animation: "fadeInScale 0.25s ease-out" }}
            >
                {/* Header */}
                <div className="relative bg-gradient-to-r from-stone-800 to-amber-900 px-6 py-5">
                    <div className="flex items-center gap-3">
                        <div className="w-10 h-10 bg-amber-500/20 border border-amber-400/30 rounded-full flex items-center justify-center">
                            <svg className="w-5 h-5 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                        </div>
                        <div>
                            <h3 className="text-white font-semibold text-base" style={{ fontFamily: "'Playfair Display', serif" }}>
                                Liên hệ tư vấn
                            </h3>
                            <p className="text-amber-200/70 text-xs">Chọn kênh liên lạc bên dưới</p>
                        </div>
                    </div>
                    <button
                        onClick={onClose}
                        className="absolute top-4 right-4 text-white/60 hover:text-white transition-colors"
                        aria-label="Đóng"
                    >
                        <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {/* Product Info */}
                <div className="flex items-center gap-4 bg-stone-50 border-b border-stone-100 px-5 py-4">
                    <div className="w-16 h-16 rounded-lg overflow-hidden flex-shrink-0 ring-1 ring-stone-200">
                        <img
                            src={imageUrl}
                            alt={product.name}
                            className="w-full h-full object-cover"
                            onError={(e) => { e.target.src = "/client/img/product/default.jpg"; }}
                        />
                    </div>
                    <div className="flex-1 min-w-0">
                        <h4 className="font-semibold text-stone-800 text-sm truncate">{product.name}</h4>
                        <p className="text-amber-700 font-bold text-base">{formatPrice(product.price)}</p>
                        <span className={`inline-block text-xs px-2 py-0.5 rounded-full border font-medium mt-1 ${avail.cls}`}>
                            {avail.label}
                        </span>
                    </div>
                </div>

                {/* Contact Options */}
                <div className="p-5">
                    <p className="text-stone-500 text-xs text-center mb-5 leading-relaxed">
                        Đây là đồ cổ độc nhất. Vui lòng liên hệ trực tiếp để được tư vấn và xác nhận trước khi mua.
                    </p>

                    <div className="space-y-3">
                        {/* Zalo */}
                        {settings.zalo_phone && (
                            <button
                                onClick={() => handleContact("zalo")}
                                className="w-full flex items-center gap-4 px-4 py-3.5 bg-[#0068FF] text-white rounded-xl font-medium hover:bg-[#0055cc] transition-all duration-200 hover:shadow-lg hover:shadow-blue-200 hover:-translate-y-0.5"
                            >
                                <div className="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg className="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 2C6.48 2 2 6.04 2 11c0 3.17 1.64 5.97 4.16 7.72L5 21l2.44-1.22C8.84 20.58 10.38 21 12 21c5.52 0 10-4.04 10-9S17.52 2 12 2zm1 13H8v-2h5v2zm3-4H8V9h8v2z"/>
                                    </svg>
                                </div>
                                <div className="text-left">
                                    <div className="font-semibold text-sm">Nhắn tin Zalo</div>
                                    <div className="text-blue-200 text-xs">{settings.zalo_phone}</div>
                                </div>
                            </button>
                        )}

                        {/* Facebook Messenger */}
                        {settings.facebook_url && (
                            <button
                                onClick={() => handleContact("facebook")}
                                className="w-full flex items-center gap-4 px-4 py-3.5 bg-[#0866FF] text-white rounded-xl font-medium hover:bg-[#0052d4] transition-all duration-200 hover:shadow-lg hover:shadow-blue-200 hover:-translate-y-0.5"
                            >
                                <div className="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2C6.36 2 2 6.13 2 11.7c0 2.91 1.19 5.44 3.14 7.17.16.14.26.34.26.54l.05 1.67c.02.53.56.87 1.04.65l1.86-.82c.15-.07.32-.08.48-.04C9.5 21.21 10.72 21.4 12 21.4c5.64 0 10-4.13 10-9.7S17.64 2 12 2zm5.98 7.67l-2.94 4.65c-.47.74-1.47.93-2.18.41l-2.34-1.75c-.22-.16-.52-.16-.73 0l-3.15 2.39c-.42.32-.97-.19-.69-.64l2.94-4.65c.47-.74 1.47-.93 2.18-.41l2.34 1.75c.22.16.52.16.73 0l3.15-2.39c.42-.32.97.19.69.64z"/>
                                    </svg>
                                </div>
                                <div className="text-left">
                                    <div className="font-semibold text-sm">Chat Facebook</div>
                                    <div className="text-blue-200 text-xs">Messenger</div>
                                </div>
                            </button>
                        )}

                        {/* Hotline */}
                        {settings.hotline && (
                            <button
                                onClick={() => handleContact("hotline")}
                                className="w-full flex items-center gap-4 px-4 py-3.5 bg-emerald-600 text-white rounded-xl font-medium hover:bg-emerald-700 transition-all duration-200 hover:shadow-lg hover:shadow-emerald-200 hover:-translate-y-0.5"
                            >
                                <div className="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                </div>
                                <div className="text-left">
                                    <div className="font-semibold text-sm">Gọi Hotline</div>
                                    <div className="text-emerald-200 text-xs">{settings.hotline}</div>
                                </div>
                            </button>
                        )}
                    </div>

                    <div className="mt-4 flex items-start gap-2 text-stone-400 text-xs bg-amber-50 border border-amber-100 px-3 py-2.5 rounded-lg">
                        <svg className="w-3.5 h-3.5 mt-0.5 flex-shrink-0 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Thông tin sản phẩm sẽ được tự động đính kèm trong tin nhắn của bạn.</span>
                    </div>
                </div>
            </div>

            <style>{`
                @keyframes fadeInScale {
                    from { opacity: 0; transform: scale(0.95) translateY(10px); }
                    to   { opacity: 1; transform: scale(1) translateY(0); }
                }
            `}</style>
        </div>
    );
}

export default ContactModal;
