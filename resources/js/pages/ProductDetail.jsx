import React, { useState, useEffect } from "react";
import { useParams, Link } from "react-router-dom";
import { MessageCircle, Phone, History, ShieldCheck, MapPin, ArrowLeft, Paintbrush, Sparkles } from "lucide-react";
import axios from "axios";

function ProductDetail({ settings }) {
    const { slug } = useParams();
    const [product, setProduct] = useState(null);
    const [loading, setLoading] = useState(true);
    const [mainImage, setMainImage] = useState("");
    const [copied, setCopied] = useState(false);

    useEffect(() => {
        setLoading(true);
        axios.get(`/api/products/${slug}`)
            .then((res) => {
                const data = res.data;
                setProduct(data);
                const images = Array.isArray(data.images) ? data.images : [];
                const mainImg = images.find(img => img.is_main)?.image_path || images[0]?.image_path;
                setMainImage(mainImg ? `/storage/${mainImg}` : "/product/default.jpg");
                setLoading(false);
            })
            .catch((err) => {
                console.error("Error fetching product detail:", err);
                setLoading(false);
            });
    }, [slug]);

    const handleContactClick = async (type) => {
        // Record click in database
        try {
            await axios.post("/api/contact-click", { product_id: product.id });
        } catch (err) {
            console.error("Error recording click:", err);
        }

        const productUrl = window.location.href;

        // Copy product URL to clipboard
        try {
            await navigator.clipboard.writeText(productUrl);
            setCopied(true);
            setTimeout(() => setCopied(false), 4000);
        } catch (clipboardErr) {
            console.error("Failed to copy link:", clipboardErr);
        }

        const messageText = `Xin chào! Tôi muốn nhận tư vấn về sản phẩm: "${product?.name}" - ${productUrl}`;

        // Redirect based on type
        if (type === "zalo" && settings?.zalo_phone) {
            const zaloDest = `https://zalo.me/${settings.zalo_phone}?msg=${encodeURIComponent(messageText)}`;
            window.open(zaloDest, "_blank");
        } else if (type === "messenger" && settings?.facebook_url) {
            let destUrl = settings.facebook_url;
            try {
                // Tự động đổi facebook.com sang m.me để hỗ trợ điền sẵn nội dung tin nhắn (?text=...)
                // Bỏ qua nếu là link đi thẳng vào hòm thư tin nhắn riêng (chứa /messages/)
                if (destUrl.includes("facebook.com") && !destUrl.includes("m.me") && !destUrl.includes("/messages/")) {
                    destUrl = destUrl.replace(/https?:\/\/(www\.)?facebook\.com\//, "https://m.me/");
                }

                if (destUrl.includes("m.me")) {
                    const separator = destUrl.includes("?") ? "&" : "?";
                    destUrl = `${destUrl}${separator}text=${encodeURIComponent(messageText)}`;
                } else {
                    const separator = destUrl.includes("?") ? "&" : "?";
                    destUrl = `${destUrl}${separator}text=${encodeURIComponent(messageText)}`;
                }
            } catch (urlErr) {
                console.error("Failed to parse Facebook URL:", urlErr);
            }
            window.open(destUrl, "_blank");
        } else if (type === "phone" && settings?.hotline) {
            window.location.href = `tel:${settings.hotline}`;
        }
    };

    if (loading) {
        return (
            <div className="min-h-screen flex items-center justify-center bg-stone-50">
                <div className="flex flex-col items-center">
                    <div className="w-16 h-16 border-4 border-amber-200 border-t-amber-800 rounded-full animate-spin mb-4"></div>
                    <p className="text-stone-500 font-serif italic">Đang tìm lại ký ức...</p>
                </div>
            </div>
        );
    }

    if (!product) {
        return (
            <div className="min-h-screen flex flex-col items-center justify-center bg-stone-50">
                <h2 className="text-3xl font-serif text-stone-800 mb-6">Món đồ này chưa được tìm thấy</h2>
                <Link to="/products" className="text-amber-800 flex items-center gap-2 font-bold hover:gap-4 transition-all">
                    <ArrowLeft className="w-5 h-5" /> Quay lại bộ sưu tập
                </Link>
            </div>
        );
    }

    return (
        <div className="bg-stone-50 min-h-screen pt-24 pb-20">
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                {/* Breadcrumbs */}
                <nav className="mb-10 flex items-center gap-2 text-[10px] sm:text-xs uppercase tracking-[0.2em] font-medium text-stone-400">
                    <Link to="/" className="hover:text-amber-800 transition-colors">Trang chủ</Link>
                    <span className="text-stone-300">/</span>
                    <Link to="/products" className="hover:text-amber-800 transition-colors">
                        {product.category?.name || "Cổ vật"}
                    </Link>
                    <span className="text-stone-300">/</span>
                    <span className="text-amber-900 font-semibold truncate">{product.name}</span>
                </nav>

                {/* Main Product Info Section */}
                <div className="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-start">
                    {/* Left Column: Image Gallery */}
                    <div className="lg:col-span-5 space-y-6">
                        <div className="aspect-[4/5] max-h-[420px] md:max-h-[480px] w-full overflow-hidden rounded-lg shadow-xl bg-white border border-stone-200/50 group flex items-center justify-center">
                            <img 
                                src={mainImage} 
                                alt={product.name}
                                className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-1000"
                            />
                        </div>
                        <div className="grid grid-cols-4 gap-4">
                            {Array.isArray(product.images) && product.images.map((img, idx) => {
                                const imgUrl = `/storage/${img.image_path}`;
                                return (
                                    <button 
                                        key={idx}
                                        onClick={() => setMainImage(imgUrl)}
                                        className={`aspect-square rounded-lg overflow-hidden transition-all shadow-sm border ${
                                            mainImage === imgUrl 
                                                ? "border-amber-700 ring-2 ring-amber-700/20 opacity-100 scale-[0.98]" 
                                                : "border-stone-200 opacity-60 hover:opacity-100"
                                        }`}
                                    >
                                        <img src={imgUrl} alt="" className="w-full h-full object-cover" />
                                    </button>
                                );
                            })}
                        </div>
                    </div>

                    {/* Right Column: Product Detail & Actions */}
                    <div className="lg:col-span-7 flex flex-col justify-start">
                        {/* Tags */}
                        <div className="flex flex-wrap gap-2 mb-4">
                            {product.period && (
                                <span className="bg-stone-900 text-stone-100 px-3 py-1 text-[10px] font-bold tracking-[0.15em] uppercase rounded-sm">
                                    {product.period.toUpperCase()}
                                </span>
                            )}
                            <span className="bg-[#FAF1D6] text-amber-950 border border-amber-300/30 px-3 py-1 text-[10px] font-bold tracking-[0.15em] uppercase rounded-sm">
                                {product.availability_status === "sold" ? "ĐÃ BÁN" : product.availability_status === "display" ? "TRƯNG BÀY" : "HIẾM CÓ"}
                            </span>
                        </div>

                        {/* Product Title */}
                        <h1 className="text-2xl md:text-3.5xl lg:text-4xl font-normal text-stone-900 mb-3 leading-tight font-serif">
                            {product.name}
                        </h1>

                        {/* Tagline/Subtitle */}
                        {product.period && (
                            <div className="text-stone-500 font-serif italic text-base mb-6 flex items-center gap-3">
                                <span className="w-8 h-[1px] bg-stone-300"></span>
                                Kỷ vật triều đại {product.period}
                            </div>
                        )}

                        {/* Specifications Table */}
                        <div className="border-t border-b border-stone-200 py-4 mb-6 space-y-3.5 font-sans">
                            {product.sku && (
                                <div className="flex justify-between items-center text-sm">
                                    <span className="text-stone-400 uppercase tracking-widest text-xs font-semibold">MÃ SẢN PHẨM</span>
                                    <span className="text-stone-900 font-bold tracking-wider">{product.sku}</span>
                                </div>
                            )}
                            {product.condition && (
                                <div className="flex justify-between items-center text-sm">
                                    <span className="text-stone-400 uppercase tracking-widest text-xs font-semibold">TÌNH TRẠNG</span>
                                    <span className="text-stone-900 font-medium">{product.condition}</span>
                                </div>
                            )}
                            {product.material && (
                                <div className="flex justify-between items-center text-sm">
                                    <span className="text-stone-400 uppercase tracking-widest text-xs font-semibold">CHẤT LIỆU</span>
                                    <span className="text-stone-900 font-medium">{product.material}</span>
                                </div>
                            )}
                        </div>

                        {/* Short Consultation text */}
                        <p className="text-stone-600 italic text-sm leading-relaxed mb-6">
                            Quý khách quan tâm đến cổ vật này vui lòng liên hệ trực tiếp để nhận tư vấn chuyên sâu về xuất xứ và giá trị lịch sử.
                        </p>

                        {/* Call to Actions */}
                        <div className="space-y-4">
                            {copied && (
                                <div className="p-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-lg text-xs flex items-start gap-2.5 animate-in fade-in slide-in-from-top duration-300">
                                    <svg className="w-4 h-4 text-emerald-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" strokeWidth="2.5">
                                        <path strokeLinecap="round" strokeLinejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <div>
                                        <span className="font-bold">Đã sao chép link sản phẩm!</span> Bạn có thể <strong className="text-emerald-950">Dán (Ctrl + V)</strong> vào ô chat vừa mở để gửi nhanh cho shop.
                                    </div>
                                </div>
                            )}

                            {/* Zalo CTA */}
                            <button 
                                onClick={() => handleContactClick("zalo")}
                                className="w-full bg-[#1C1714] text-[#EAD09D] hover:bg-stone-800 hover:text-white transition-all duration-300 py-4 px-6 flex items-center justify-center gap-3 font-semibold uppercase tracking-widest text-sm rounded border border-[#EAD09D]/20 shadow-md group"
                            >
                                <MessageCircle className="w-5 h-5 text-[#EAD09D] group-hover:scale-110 transition-transform" />
                                Nhận tư vấn qua Zalo
                            </button>

                            {/* Messenger & Hotline */}
                            <div className="grid grid-cols-2 gap-4">
                                <button 
                                    onClick={() => handleContactClick("messenger")}
                                    className="bg-messenger text-white hover:shadow-lg hover:shadow-blue-100/50 transition-all py-3 px-4 flex items-center justify-center gap-2 uppercase tracking-widest text-xs font-semibold rounded border-0"
                                >
                                    <svg className="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2C6.36 2 2 6.13 2 11.7c0 2.91 1.19 5.44 3.14 7.17.16.14.26.34.26.54l.05 1.67c.02.53.56.87 1.04.65l1.86-.82c.15-.07.32-.08.48-.04C9.5 21.21 10.72 21.4 12 21.4c5.64 0 10-4.13 10-9.7S17.64 2 12 2zm5.98 7.67l-2.94 4.65c-.47.74-1.47.93-2.18.41l-2.34-1.75c-.22-.16-.52-.16-.73 0l-3.15 2.39c-.42.32-.97-.19-.69-.64l2.94-4.65c.47-.74 1.47-.93 2.18-.41l2.34 1.75c.22.16.52.16.73 0l3.15-2.39c.42-.32.97.19.69.64z"/>
                                    </svg>
                                    Messenger
                                </button>
                                <button 
                                    onClick={() => handleContactClick("phone")}
                                    className="border border-stone-400 text-stone-800 hover:bg-stone-100 transition-colors py-3 px-4 flex items-center justify-center gap-2 uppercase tracking-widest text-xs font-semibold rounded"
                                >
                                    <Phone className="w-4 h-4 text-stone-600" />
                                    Hotline
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {/* Ornate Divider */}
                <div className="my-20 flex items-center justify-center gap-6">
                    <div className="h-[1px] bg-amber-800/20 flex-grow max-w-[200px]"></div>
                    <div className="text-amber-800/80 text-sm tracking-widest">✦</div>
                    <div className="h-[1px] bg-amber-800/20 flex-grow max-w-[200px]"></div>
                </div>

                {/* "Giá Trị Lịch Sử & Nghệ Thuật" Section */}
                <div className="max-w-4xl mx-auto space-y-12">
                    <div className="text-center space-y-6">
                        <h2 className="text-3xl md:text-4xl font-serif italic text-stone-900">
                            Giá Trị Lịch Sử & Nghệ Thuật
                        </h2>
                        <div 
                            className="text-stone-600 leading-loose font-serif text-base md:text-lg space-y-6 italic max-w-3xl mx-auto text-center"
                            dangerouslySetInnerHTML={{ __html: product.content || "Món đồ này mang trong mình những giá trị văn hóa và lịch sử vô giá đang chờ bạn khám phá..." }}
                        />
                    </div>
                </div>

                {/* Bottom Specifications Details Section */}
                {(product.period || product.material || product.origin) && (
                    <div className="mt-24 pt-16 border-t border-stone-200/80">
                        <h3 className="text-center font-serif text-2xl md:text-3xl text-stone-900 mb-12">
                            Thông Số Kỹ Thuật Chi Tiết
                        </h3>
                        <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 justify-center">
                            {/* Card 1: Triều đại */}
                            {product.period && (
                                <div className="bg-stone-50 border border-stone-200/60 p-6 rounded-lg shadow-sm space-y-4">
                                    <div className="w-10 h-10 rounded-full bg-amber-50/55 flex items-center justify-center">
                                        <History className="w-5 h-5 text-amber-800" />
                                    </div>
                                    <div className="space-y-1">
                                        <span className="text-stone-400 uppercase tracking-widest text-[10px] font-bold block">TRIỀU ĐẠI</span>
                                        <span className="text-stone-800 font-semibold text-sm block">
                                            {product.period}
                                        </span>
                                    </div>
                                </div>
                            )}

                            {/* Card 2: Dòng men */}
                            {product.material && (
                                <div className="bg-stone-50 border border-stone-200/60 p-6 rounded-lg shadow-sm space-y-4">
                                    <div className="w-10 h-10 rounded-full bg-amber-50/55 flex items-center justify-center">
                                        <Paintbrush className="w-5 h-5 text-amber-800" />
                                    </div>
                                    <div className="space-y-1">
                                        <span className="text-stone-400 uppercase tracking-widest text-[10px] font-bold block">DÒNG MEN</span>
                                        <span className="text-stone-800 font-semibold text-sm block">
                                            {product.material}
                                        </span>
                                    </div>
                                </div>
                            )}

                            {/* Card 3: Xuất xứ */}
                            {product.origin && (
                                <div className="bg-stone-50 border border-stone-200/60 p-6 rounded-lg shadow-sm space-y-4">
                                    <div className="w-10 h-10 rounded-full bg-amber-50/55 flex items-center justify-center">
                                        <MapPin className="w-5 h-5 text-amber-800" />
                                    </div>
                                    <div className="space-y-1">
                                        <span className="text-stone-400 uppercase tracking-widest text-[10px] font-bold block">XUẤT XỨ</span>
                                        <span className="text-stone-800 font-semibold text-sm block">
                                            {product.origin}
                                        </span>
                                    </div>
                                </div>
                            )}
                        </div>
                    </div>
                )}
            </div>
        </div>
    );
}

export default ProductDetail;
