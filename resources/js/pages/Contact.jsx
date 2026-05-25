import React from "react";
import { MapPin, Phone, Mail, MessageCircle } from "lucide-react";

function Contact({ settings = {} }) {
    const shopName = settings.shop_name || "Đồ Cổ Antique";
    const shopAddress = settings.shop_address || "123 Đường ABC, Hà Nội";
    const hotline = settings.hotline || "0985408685";
    const shopEmail = settings.shop_email || "antique_shop@gmail.com";
    const zaloPhone = settings.zalo_phone || "";
    const facebookUrl = settings.facebook_url || "";
    const facebookFanpage = settings.facebook_fanpage || "";
    const tiktokUrl = settings.tiktok_url || "";
    const instagramUrl = settings.instagram_url || "";

    return (
        <div className="bg-stone-50 min-h-screen pt-24 pb-20">
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                {/* Header Section */}
                <div className="text-center max-w-3xl mx-auto mb-16">
                    <span className="text-amber-700 text-xs font-bold tracking-[0.2em] uppercase mb-3 block">Kết nối di sản</span>
                    <h1 
                        className="text-3xl md:text-5xl font-bold text-stone-900 mb-6 leading-tight"
                        style={{ fontFamily: "'Playfair Display', serif" }}
                    >
                        Liên Hệ Với Chúng Tôi
                    </h1>
                    <p className="text-stone-600 text-sm md:text-base leading-relaxed font-serif italic">
                        "Mỗi hiện vật cổ là một cầu nối thời gian. Hãy liên hệ với chúng tôi qua các kênh dưới đây để nhận tư vấn chi tiết nhất về xuất xứ và giá trị lịch sử của từng món đồ."
                    </p>
                </div>

                {/* Centered layout for showroom and social networks */}
                <div className="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto items-stretch">
                    {/* Showroom Details */}
                    <div className="bg-white rounded-2xl border border-stone-200/60 p-8 shadow-sm space-y-6 flex flex-col justify-start">
                        <h3 
                            className="text-xl font-bold text-stone-900 border-b border-stone-100 pb-4"
                            style={{ fontFamily: "'Playfair Display', serif" }}
                        >
                            Thông tin showroom
                        </h3>

                        <div className="space-y-6 flex-grow">
                            {/* Shop Name & Address */}
                            <div className="flex gap-4">
                                <div className="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center text-amber-800 flex-shrink-0">
                                    <MapPin className="w-5 h-5" />
                                </div>
                                <div>
                                    <h4 className="text-xs font-bold text-stone-400 uppercase tracking-wider mb-1">Địa chỉ trưng bày</h4>
                                    <p className="text-stone-800 font-semibold text-sm leading-relaxed">{shopName}</p>
                                    <p className="text-stone-600 text-sm mt-0.5">{shopAddress}</p>
                                </div>
                            </div>

                            {/* Hotline */}
                            <div className="flex gap-4">
                                <div className="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center text-amber-800 flex-shrink-0">
                                    <Phone className="w-5 h-5" />
                                </div>
                                <div>
                                    <h4 className="text-xs font-bold text-stone-400 uppercase tracking-wider mb-1">Đường dây nóng</h4>
                                    <a href={`tel:${hotline}`} className="text-amber-800 font-bold text-lg hover:underline block">
                                        {hotline}
                                    </a>
                                    <p className="text-stone-400 text-xs mt-0.5">Tư vấn trực tiếp 24/7</p>
                                </div>
                            </div>

                            {/* Email */}
                            <div className="flex gap-4">
                                <div className="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center text-amber-800 flex-shrink-0">
                                    <Mail className="w-5 h-5" />
                                </div>
                                <div>
                                    <h4 className="text-xs font-bold text-stone-400 uppercase tracking-wider mb-1">Thư điện tử</h4>
                                    <a href={`mailto:${shopEmail}`} className="text-stone-700 font-semibold text-sm hover:text-amber-800 hover:underline block">
                                        {shopEmail}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    {/* Social Networks block */}
                    {(zaloPhone || facebookUrl || facebookFanpage || tiktokUrl || instagramUrl) && (
                        <div className="bg-white rounded-2xl border border-stone-200/60 p-8 shadow-sm space-y-6 flex flex-col justify-start">
                            <h3 
                                className="text-xl font-bold text-stone-900 border-b border-stone-100 pb-4"
                                style={{ fontFamily: "'Playfair Display', serif" }}
                            >
                                Kênh kết nối nhanh
                            </h3>

                            <div className="grid grid-cols-1 sm:grid-cols-2 gap-4 flex-grow content-start">
                                {zaloPhone && (
                                    <a 
                                        href={`https://zalo.me/${zaloPhone}`} 
                                        target="_blank" 
                                        rel="noreferrer" 
                                        className="flex items-center gap-3 p-3 bg-stone-50 border border-stone-200/40 rounded-xl hover:bg-amber-50/50 hover:border-amber-200/60 transition-all group"
                                    >
                                        <div className="w-9 h-9 bg-blue-100/80 rounded-lg flex items-center justify-center flex-shrink-0 text-blue-700 font-bold text-sm">
                                            Z
                                        </div>
                                        <div>
                                            <div className="text-xs font-bold text-stone-800 group-hover:text-amber-900">Zalo Chat</div>
                                            <div className="text-[10px] text-stone-400 font-medium">{zaloPhone}</div>
                                        </div>
                                    </a>
                                )}

                                {facebookUrl && (
                                    <a 
                                        href={facebookUrl} 
                                        target="_blank" 
                                        rel="noreferrer" 
                                        className="flex items-center gap-3 p-3 bg-stone-50 border border-stone-200/40 rounded-xl hover:bg-amber-50/50 hover:border-amber-200/60 transition-all group"
                                    >
                                        <div className="w-9 h-9 bg-indigo-100/80 rounded-lg flex items-center justify-center flex-shrink-0 text-indigo-700">
                                            <MessageCircle className="w-4 h-4" />
                                        </div>
                                        <div>
                                            <div className="text-xs font-bold text-stone-800 group-hover:text-amber-900">Messenger</div>
                                            <div className="text-[10px] text-stone-400 font-medium">Nhắn tin trực tiếp</div>
                                        </div>
                                    </a>
                                )}

                                {facebookFanpage && (
                                    <a 
                                        href={facebookFanpage} 
                                        target="_blank" 
                                        rel="noreferrer" 
                                        className="flex items-center gap-3 p-3 bg-stone-50 border border-stone-200/40 rounded-xl hover:bg-amber-50/50 hover:border-amber-200/60 transition-all group"
                                    >
                                        <div className="w-9 h-9 bg-blue-100/80 rounded-lg flex items-center justify-center flex-shrink-0 text-blue-850 font-bold text-sm">
                                            F
                                        </div>
                                        <div>
                                            <div className="text-xs font-bold text-stone-800 group-hover:text-amber-900">Facebook</div>
                                            <div className="text-[10px] text-stone-400 font-medium">Theo dõi Fanpage</div>
                                        </div>
                                    </a>
                                )}

                                {instagramUrl && (
                                    <a 
                                        href={instagramUrl} 
                                        target="_blank" 
                                        rel="noreferrer" 
                                        className="flex items-center gap-3 p-3 bg-stone-50 border border-stone-200/40 rounded-xl hover:bg-amber-50/50 hover:border-amber-200/60 transition-all group"
                                    >
                                        <div className="w-9 h-9 bg-pink-100/80 rounded-lg flex items-center justify-center flex-shrink-0 text-pink-700 font-bold text-xs">
                                            IG
                                        </div>
                                        <div>
                                            <div className="text-xs font-bold text-stone-800 group-hover:text-amber-900">Instagram</div>
                                            <div className="text-[10px] text-stone-400 font-medium">Bộ sưu tập ảnh</div>
                                        </div>
                                    </a>
                                )}

                                {tiktokUrl && (
                                    <a 
                                        href={tiktokUrl} 
                                        target="_blank" 
                                        rel="noreferrer" 
                                        className="flex items-center gap-3 p-3 bg-stone-50 border border-stone-200/40 rounded-xl hover:bg-amber-50/50 hover:border-amber-200/60 transition-all group col-span-1 sm:col-span-2"
                                    >
                                        <div className="w-9 h-9 bg-stone-900 rounded-lg flex items-center justify-center flex-shrink-0 text-white font-bold text-xs">
                                            T
                                        </div>
                                        <div>
                                            <div className="text-xs font-bold text-stone-800 group-hover:text-amber-900">TikTok</div>
                                            <div className="text-[10px] text-stone-400 font-medium">Video cận cảnh hiện vật</div>
                                        </div>
                                    </a>
                                )}
                            </div>
                        </div>
                    )}
                </div>
            </div>
        </div>
    );
}

export default Contact;
