import React, { useState } from "react";
import { X, Phone, MessageSquare } from "lucide-react";

function ConsultationModal({ isOpen, onClose, product, settings }) {
    const [copied, setCopied] = useState(false);

    if (!isOpen) return null;

    const productUrl = product 
        ? `${window.location.origin}/products/${product.slug || product.id}` 
        : "";

    const messageText = `Xin chào! Tôi muốn nhận tư vấn về sản phẩm: "${product?.name}" - ${productUrl}`;

    const zaloLink = settings?.zalo_phone 
        ? `https://zalo.me/${settings.zalo_phone}?msg=${encodeURIComponent(messageText)}` 
        : "#";

    let messengerLink = settings?.facebook_url || "https://m.me/";
    if (settings?.facebook_url) {
        let formattedUrl = settings.facebook_url;
        // Tự động đổi facebook.com sang m.me để hỗ trợ điền sẵn nội dung tin nhắn (?text=...)
        // Bỏ qua nếu là link đi thẳng vào hòm thư tin nhắn riêng (chứa /messages/)
        if (formattedUrl.includes("facebook.com") && !formattedUrl.includes("m.me") && !formattedUrl.includes("/messages/")) {
            formattedUrl = formattedUrl.replace(/https?:\/\/(www\.)?facebook\.com\//, "https://m.me/");
        }
        
        if (formattedUrl.includes("m.me")) {
            const separator = formattedUrl.includes("?") ? "&" : "?";
            messengerLink = `${formattedUrl}${separator}text=${encodeURIComponent(messageText)}`;
        } else {
            // Đối với link messages thường của facebook, chúng ta vẫn chèn thêm ?text đề phòng tương lai hoặc phiên bản web hỗ trợ
            const separator = formattedUrl.includes("?") ? "&" : "?";
            messengerLink = `${formattedUrl}${separator}text=${encodeURIComponent(messageText)}`;
        }
    }

    const handleButtonClick = async (e, url) => {
        e.preventDefault();
        
        // Thực hiện copy link sản phẩm vào clipboard
        if (productUrl) {
            try {
                await navigator.clipboard.writeText(productUrl);
                setCopied(true);
                setTimeout(() => setCopied(false), 4000);
            } catch (err) {
                console.error("Failed to copy link:", err);
            }
        }

        // Đợi 2 giây rồi mới chuyển qua kênh chat (Zalo/Messenger)
        setTimeout(() => {
            if (url && url !== "#") {
                window.open(url, "_blank", "noopener,noreferrer");
            }
        }, 2000);
    };

    return (
        <div className="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-stone-900/60 backdrop-blur-sm">
            <div className="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden animate-in fade-in zoom-in duration-300">
                <div className="relative h-32 bg-stone-800">
                    <img 
                        src={product.images?.[0]?.image_path ? `/storage/${product.images[0].image_path}` : ""} 
                        alt="" 
                        className="w-full h-full object-cover opacity-40"
                    />
                    <div className="absolute inset-0 bg-gradient-to-t from-stone-900 to-transparent"></div>
                    <button 
                        onClick={onClose}
                        className="absolute top-4 right-4 text-white/70 hover:text-white p-1 rounded-full hover:bg-white/10 transition-colors"
                    >
                        <X className="w-6 h-6" />
                    </button>
                    <div className="absolute bottom-4 left-6">
                        <h3 className="text-xl font-bold text-white" style={{ fontFamily: "'Playfair Display', serif" }}>Nhận Tư Vấn</h3>
                    </div>
                </div>

                <div className="p-6">
                    <p className="text-stone-600 mb-6 leading-relaxed">
                        Bạn đang quan tâm đến sản phẩm <span className="font-semibold text-amber-800">"{product.name}"</span>. 
                        Hãy kết nối trực tiếp với chúng tôi qua Facebook Messenger, Zalo hoặc Hotline để nhận tư vấn chi tiết về xuất xứ và giá trị lịch sử.
                    </p>

                    {copied && (
                        <div className="mb-4 p-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-[11px] flex items-start gap-2.5 animate-in fade-in slide-in-from-top duration-300">
                            <svg className="w-4 h-4 text-emerald-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" strokeWidth="2.5">
                                <path strokeLinecap="round" strokeLinejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            <div>
                                <span className="font-bold">Đã sao chép link sản phẩm!</span> 
                            </div>
                        </div>
                    )}

                    {/* Facebook Messenger (Primary CTA) */}
                    <a 
                        href={messengerLink}
                        target="_blank"
                        rel="noreferrer"
                        onClick={(e) => handleButtonClick(e, messengerLink)}
                        className="w-full flex items-center justify-center gap-3 py-3.5 bg-messenger text-white rounded-xl font-bold transition-all duration-200 shadow-lg shadow-blue-100 hover:shadow-blue-200 hover:-translate-y-0.5 group mb-5"
                    >
                        <svg className="w-5 h-5 text-white group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.36 2 2 6.13 2 11.7c0 2.91 1.19 5.44 3.14 7.17.16.14.26.34.26.54l.05 1.67c.02.53.56.87 1.04.65l1.86-.82c.15-.07.32-.08.48-.04C9.5 21.21 10.72 21.4 12 21.4c5.64 0 10-4.13 10-9.7S17.64 2 12 2zm5.98 7.67l-2.94 4.65c-.47.74-1.47.93-2.18.41l-2.34-1.75c-.22-.16-.52-.16-.73 0l-3.15 2.39c-.42.32-.97-.19-.69-.64l2.94-4.65c.47-.74 1.47-.93 2.18-.41l2.34 1.75c.22.16.52.16.73 0l3.15-2.39c.42-.32.97.19.69.64z"/>
                        </svg>
                        <span>Nhận tư vấn qua Messenger</span>
                    </a>

                    <div className="grid grid-cols-2 gap-4">
                        <a 
                            href={zaloLink}
                            target="_blank"
                            rel="noreferrer"
                            onClick={(e) => handleButtonClick(e, zaloLink)}
                            className="flex items-center justify-center gap-2 py-3 border border-stone-200 rounded-xl hover:bg-blue-50 hover:border-blue-200 transition-colors group"
                        >
                            <MessageSquare className="w-5 h-5 text-blue-500" />
                            <span className="text-sm font-semibold text-stone-700 group-hover:text-blue-700">Chat Zalo</span>
                        </a>
                        <a 
                            href={`tel:${settings?.hotline}`}
                            className="flex items-center justify-center gap-2 py-3 border border-stone-200 rounded-xl hover:bg-amber-50 hover:border-amber-200 transition-colors group"
                        >
                            <Phone className="w-5 h-5 text-amber-600" />
                            <span className="text-sm font-semibold text-stone-700 group-hover:text-amber-800">Gọi Hotline</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default ConsultationModal;
