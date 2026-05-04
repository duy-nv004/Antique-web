import React, { useState } from "react";
import { X, Phone, MessageSquare, Send } from "lucide-react";

function ConsultationModal({ isOpen, onClose, product, settings }) {
    const [phone, setPhone] = useState("");
    const [isSubmitted, setIsSubmitted] = useState(false);

    if (!isOpen) return null;

    const handleSubmit = (e) => {
        e.preventDefault();
        // Giả lập gửi thông tin
        console.log(`Gửi yêu cầu tư vấn cho SP: ${product.name}, SĐT: ${phone}`);
        setIsSubmitted(true);
        setTimeout(() => {
            setIsSubmitted(false);
            setPhone("");
            onClose();
        }, 2000);
    };

    const zaloLink = settings?.zalo_phone 
        ? `https://zalo.me/${settings.zalo_phone}` 
        : "#";

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
                    {isSubmitted ? (
                        <div className="text-center py-8">
                            <div className="w-16 h-16 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-4">
                                <Send className="w-8 h-8" />
                            </div>
                            <h4 className="text-lg font-bold text-stone-800 mb-2">Gửi yêu cầu thành công!</h4>
                            <p className="text-stone-500">Chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất.</p>
                        </div>
                    ) : (
                        <>
                            <p className="text-stone-600 mb-6 leading-relaxed">
                                Bạn đang quan tâm đến sản phẩm <span className="font-semibold text-amber-800">"{product.name}"</span>. 
                                Hãy để lại thông tin hoặc kết nối trực tiếp với chuyên gia của chúng tôi.
                            </p>

                            <form onSubmit={handleSubmit} className="space-y-4 mb-6">
                                <div>
                                    <label className="block text-sm font-medium text-stone-700 mb-1.5">Số điện thoại của bạn</label>
                                    <input 
                                        type="tel" 
                                        required
                                        placeholder="Nhập số điện thoại..."
                                        className="w-full px-4 py-3 bg-stone-50 border border-stone-200 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent outline-none transition-all"
                                        value={phone}
                                        onChange={(e) => setPhone(e.target.value)}
                                    />
                                </div>
                                <button 
                                    type="submit"
                                    className="w-full py-3.5 bg-stone-800 text-white rounded-xl font-bold hover:bg-amber-800 transition-all shadow-lg shadow-stone-200"
                                >
                                    Gửi Yêu Cầu Ngay
                                </button>
                            </form>

                            <div className="grid grid-cols-2 gap-4">
                                <a 
                                    href={zaloLink}
                                    target="_blank"
                                    rel="noreferrer"
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
                        </>
                    )}
                </div>
            </div>
        </div>
    );
}

export default ConsultationModal;
