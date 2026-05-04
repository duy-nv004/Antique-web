import React, { useState } from "react";

function ProductDetailModal({ product, settings, onClose, onContactClick }) {
    const [activeImageIndex, setActiveImageIndex] = useState(0);

    const formatPrice = (price) =>
        new Intl.NumberFormat("vi-VN", { style: "currency", currency: "VND" }).format(price);

    const images = product.images && product.images.length > 0
        ? product.images
        : [{ image_path: null, is_main: 1 }];

    const currentImageUrl = images[activeImageIndex]?.image_path
        ? `/storage/${images[activeImageIndex].image_path}`
        : "/client/img/product/product-1.jpg";

    const availabilityConfig = {
        in_stock: { label: "Còn hàng",  cls: "bg-emerald-100 text-emerald-800 border-emerald-300", dot: "bg-emerald-500" },
        sold:     { label: "Đã bán",    cls: "bg-red-100 text-red-700 border-red-300",             dot: "bg-red-500"     },
        display:  { label: "Trưng bày", cls: "bg-amber-100 text-amber-800 border-amber-300",       dot: "bg-amber-500"   },
    };
    const avail = availabilityConfig[product.availability_status] || availabilityConfig.in_stock;

    const details = [
        { icon: "🏛️", label: "Niên đại",   value: product.period },
        { icon: "✨", label: "Chất liệu",  value: product.material },
        { icon: "🔍", label: "Tình trạng", value: product.condition },
        { icon: "🌍", label: "Xuất xứ",    value: product.origin },
        { icon: "🏷️", label: "Mã sản phẩm",value: product.sku },
    ].filter((d) => d.value);

    return (
        <div
            className="fixed inset-0 bg-black/70 backdrop-blur-sm z-50 flex items-center justify-center p-4"
            onClick={onClose}
        >
            <div
                className="bg-white rounded-2xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-hidden flex flex-col"
                onClick={(e) => e.stopPropagation()}
                style={{ animation: "detailFadeIn 0.3s ease-out" }}
            >
                {/* Header */}
                <div className="flex items-center justify-between px-6 py-4 border-b border-stone-100 bg-stone-50 flex-shrink-0">
                    <div className="flex items-center gap-3">
                        <span className={`flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1 rounded-full border ${avail.cls}`}>
                            <span className={`w-1.5 h-1.5 rounded-full ${avail.dot} animate-pulse`}></span>
                            {avail.label}
                        </span>
                        {product.category && (
                            <span className="text-xs text-stone-400 bg-stone-100 px-2.5 py-1 rounded-full">
                                {product.category.name}
                            </span>
                        )}
                    </div>
                    <button
                        onClick={onClose}
                        className="w-8 h-8 flex items-center justify-center rounded-full text-stone-400 hover:text-stone-700 hover:bg-stone-200 transition-colors"
                        aria-label="Đóng"
                    >
                        <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {/* Content */}
                <div className="flex-1 overflow-y-auto">
                    <div className="flex flex-col lg:flex-row">
                        {/* Image Gallery - Left */}
                        <div className="lg:w-1/2 p-6 flex flex-col gap-4 bg-stone-50">
                            {/* Main Image */}
                            <div className="relative rounded-xl overflow-hidden bg-stone-100 aspect-square">
                                <img
                                    src={currentImageUrl}
                                    alt={product.name}
                                    className="w-full h-full object-cover"
                                    onError={(e) => { e.target.src = "/client/img/product/default.jpg"; }}
                                />
                                {images.length > 1 && (
                                    <>
                                        <button
                                            onClick={() => setActiveImageIndex((i) => (i - 1 + images.length) % images.length)}
                                            className="absolute left-3 top-1/2 -translate-y-1/2 w-8 h-8 bg-white/80 rounded-full flex items-center justify-center hover:bg-white shadow-md transition-all"
                                        >
                                            <svg className="w-4 h-4 text-stone-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 19l-7-7 7-7" />
                                            </svg>
                                        </button>
                                        <button
                                            onClick={() => setActiveImageIndex((i) => (i + 1) % images.length)}
                                            className="absolute right-3 top-1/2 -translate-y-1/2 w-8 h-8 bg-white/80 rounded-full flex items-center justify-center hover:bg-white shadow-md transition-all"
                                        >
                                            <svg className="w-4 h-4 text-stone-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 5l7 7-7 7" />
                                            </svg>
                                        </button>
                                    </>
                                )}
                                <div className="absolute bottom-3 right-3 bg-black/50 text-white text-xs px-2 py-1 rounded-full">
                                    {activeImageIndex + 1} / {images.length}
                                </div>
                            </div>

                            {/* Thumbnails */}
                            {images.length > 1 && (
                                <div className="flex gap-2 overflow-x-auto pb-1">
                                    {images.map((img, idx) => {
                                        const thumbUrl = img.image_path
                                            ? `/storage/${img.image_path}`
                                            : "/client/img/product/default.jpg";
                                        return (
                                            <button
                                                key={idx}
                                                onClick={() => setActiveImageIndex(idx)}
                                                className={`flex-shrink-0 w-16 h-16 rounded-lg overflow-hidden border-2 transition-all ${
                                                    activeImageIndex === idx
                                                        ? "border-amber-600 ring-2 ring-amber-300"
                                                        : "border-transparent hover:border-stone-300"
                                                }`}
                                            >
                                                <img
                                                    src={thumbUrl}
                                                    alt={`Ảnh ${idx + 1}`}
                                                    className="w-full h-full object-cover"
                                                    onError={(e) => { e.target.src = "/client/img/product/default.jpg"; }}
                                                />
                                            </button>
                                        );
                                    })}
                                </div>
                            )}
                        </div>

                        {/* Product Info - Right */}
                        <div className="lg:w-1/2 p-6 flex flex-col">
                            <h1
                                className="text-2xl font-bold text-stone-800 leading-snug mb-2"
                                style={{ fontFamily: "'Playfair Display', serif" }}
                            >
                                {product.name}
                            </h1>

                            <p className="text-3xl font-bold text-amber-700 mb-5">
                                {formatPrice(product.price)}
                            </p>

                            {/* Details Grid */}
                            {details.length > 0 && (
                                <div className="grid grid-cols-1 gap-2 mb-5">
                                    {details.map((detail) => (
                                        <div
                                            key={detail.label}
                                            className="flex items-center gap-3 bg-stone-50 rounded-lg px-4 py-2.5 border border-stone-100"
                                        >
                                            <span className="text-lg">{detail.icon}</span>
                                            <div className="flex-1 flex items-center justify-between gap-2">
                                                <span className="text-xs font-medium text-stone-400 uppercase tracking-wide w-24 flex-shrink-0">
                                                    {detail.label}
                                                </span>
                                                <span className="text-sm font-semibold text-stone-700 text-right">
                                                    {detail.value}
                                                </span>
                                            </div>
                                        </div>
                                    ))}
                                </div>
                            )}

                            {/* Description */}
                            {product.content && (
                                <div className="mb-6">
                                    <h3 className="text-sm font-semibold text-stone-500 uppercase tracking-wide mb-2">
                                        Lịch sử & Mô tả
                                    </h3>
                                    <div className="text-stone-600 text-sm leading-relaxed prose prose-sm max-w-none">
                                        {product.content.split("\n").map((line, i) => (
                                            <p key={i} className="mb-1">{line}</p>
                                        ))}
                                    </div>
                                </div>
                            )}

                            <div className="mt-auto space-y-3">
                                <button
                                    onClick={() => onContactClick(product)}
                                    className="w-full py-3.5 bg-amber-700 hover:bg-amber-800 text-white rounded-xl font-semibold transition-all duration-200 flex items-center justify-center gap-2 shadow-md hover:shadow-amber-200 hover:-translate-y-0.5"
                                    style={{ fontFamily: "'Playfair Display', serif" }}
                                >
                                    <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                    Liên hệ tư vấn ngay
                                </button>
                                <p className="text-center text-xs text-stone-400">
                                    Mã sản phẩm sẽ được tự động gửi kèm trong tin nhắn
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <style>{`
                @keyframes detailFadeIn {
                    from { opacity: 0; transform: scale(0.97) translateY(16px); }
                    to   { opacity: 1; transform: scale(1) translateY(0); }
                }
            `}</style>
        </div>
    );
}

export default ProductDetailModal;
