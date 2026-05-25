import React from "react";
import { Link } from "react-router-dom";
function Footer({ settings = {} }) {
    const shopName = settings.shop_name || "Antique Shop";
    const shopAddress = settings.shop_address || "123 Đường ABC, Hà Nội";
    const hotline = settings.hotline || null;
    const shopEmail = settings.shop_email || "antique_shop@gmail.com";
    const year = new Date().getFullYear();

    return (
        <footer className="bg-stone-900 text-white border-t border-stone-800" id="contact">
            {/* Main Footer */}
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
                    {/* About */}
                    <div className="lg:col-span-1">
                        <div className="flex items-center gap-2.5 mb-4">
                            <div className="w-10 h-10 bg-amber-700 rounded-lg flex items-center justify-center">
                                <svg className="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={1.5} d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <span className="text-lg font-bold" style={{ fontFamily: "'Playfair Display', serif" }}>
                                {shopName}
                            </span>
                        </div>
                        <p className="text-stone-400 text-sm mb-5 leading-relaxed">
                            Chuyên cung cấp các sản phẩm đồ cổ chính hãng, uy tín và có giấy tờ nguồn gốc rõ ràng.
                        </p>
                        <ul className="space-y-2.5 text-sm text-stone-400">
                            <li className="flex items-start gap-2">
                                <svg className="w-4 h-4 text-amber-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span>{shopAddress}</span>
                            </li>
                            {hotline && (
                                <li>
                                    <a href={`tel:${hotline}`} className="flex items-center gap-2 hover:text-amber-400 transition-colors">
                                        <svg className="w-4 h-4 text-amber-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                        {hotline}
                                    </a>
                                </li>
                            )}
                            <li>
                                <a href={`mailto:${shopEmail}`} className="flex items-center gap-2 hover:text-amber-400 transition-colors">
                                    <svg className="w-4 h-4 text-amber-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    {shopEmail}
                                </a>
                            </li>
                        </ul>
                    </div>

                    {/* Quick Links */}
                    <div>
                        <h4 className="text-sm font-semibold text-stone-200 uppercase tracking-widest mb-5">Khám phá</h4>
                        <ul className="space-y-2.5">
                            {[
                                { to: "/", label: "Trang chủ", isHash: false },
                                { to: "/products", label: "Bộ sưu tập", isHash: false },
                                { to: "/", label: "Về chúng tôi", isHash: false },
                                { to: "/contact", label: "Liên hệ", isHash: false },
                            ].map((link) => (
                                <li key={link.label}>
                                    {link.isHash ? (
                                        <a href={link.to} className="text-stone-400 hover:text-amber-400 transition-colors text-sm flex items-center gap-1.5">
                                            <svg className="w-3 h-3 text-amber-700" fill="currentColor" viewBox="0 0 20 20">
                                                <path fillRule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clipRule="evenodd" />
                                            </svg>
                                            {link.label}
                                        </a>
                                    ) : (
                                        <Link to={link.to} className="text-stone-400 hover:text-amber-400 transition-colors text-sm flex items-center gap-1.5">
                                            <svg className="w-3 h-3 text-amber-700" fill="currentColor" viewBox="0 0 20 20">
                                                <path fillRule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clipRule="evenodd" />
                                            </svg>
                                            {link.label}
                                        </Link>
                                    )}
                                </li>
                            ))}
                        </ul>
                    </div>

                    {/* Contact Channels */}
                    <div>
                        <h4 className="text-sm font-semibold text-stone-200 uppercase tracking-widest mb-5">Kênh liên lạc</h4>
                        <div className="space-y-3">
                            {settings.zalo_phone && (
                                <a
                                    href={`https://zalo.me/${settings.zalo_phone}`}
                                    target="_blank" rel="noreferrer"
                                    className="flex items-center gap-3 text-stone-400 hover:text-amber-400 transition-colors text-sm"
                                >
                                    <div className="w-8 h-8 bg-[#0068FF]/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <span className="text-[#0068FF] font-bold text-xs">Z</span>
                                    </div>
                                    <div>
                                        <div className="font-medium text-stone-300">Zalo</div>
                                        <div className="text-xs">{settings.zalo_phone}</div>
                                    </div>
                                </a>
                            )}
                            {settings.facebook_url && (
                                <a
                                    href={settings.facebook_url}
                                    target="_blank" rel="noreferrer"
                                    className="flex items-center gap-3 text-stone-400 hover:text-amber-400 transition-colors text-sm"
                                >
                                    <div className="w-8 h-8 bg-[#0866FF]/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <svg className="w-4 h-4 text-[#0866FF]" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <div className="font-medium text-stone-300">Facebook Messenger</div>
                                        <div className="text-xs">Nhắn tin trực tiếp</div>
                                    </div>
                                </a>
                            )}
                            {hotline && (
                                <a
                                    href={`tel:${hotline}`}
                                    className="flex items-center gap-3 text-stone-400 hover:text-amber-400 transition-colors text-sm"
                                >
                                    <div className="w-8 h-8 bg-emerald-600/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <svg className="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <div className="font-medium text-stone-300">Hotline</div>
                                        <div className="text-xs">{hotline}</div>
                                    </div>
                                </a>
                            )}
                        </div>
                    </div>

                    {/* Pledge */}
                    <div>
                        <h4 className="text-sm font-semibold text-stone-200 uppercase tracking-widest mb-5">Cam kết</h4>
                        <ul className="space-y-3">
                            {[
                                "100% đồ cổ thật, chính hãng",
                                "Có giấy tờ nguồn gốc rõ ràng",
                                "Tư vấn tận tình, miễn phí",
                                "Hỗ trợ 24/7 qua Zalo & Hotline",
                            ].map((item) => (
                                <li key={item} className="flex items-start gap-2 text-stone-400 text-sm">
                                    <svg className="w-4 h-4 text-amber-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {item}
                                </li>
                            ))}
                        </ul>
                    </div>
                </div>
            </div>

            {/* Copyright */}
            <div className="border-t border-stone-800">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5 flex flex-col sm:flex-row items-center justify-between gap-3">
                    <p className="text-stone-500 text-sm">
                        © {year} <span className="text-stone-400">{shopName}</span>. All rights reserved.
                    </p>
                    <p className="text-stone-600 text-xs">
                        Mô hình Catalog & Connect — Liên hệ trực tiếp để mua hàng
                    </p>
                </div>
            </div>
        </footer>
    );
}

export default Footer;