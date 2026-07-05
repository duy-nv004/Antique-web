import React, { useState } from "react";
import { Link } from "react-router-dom";

function Navbar({ settings }) {
    const [isMenuOpen, setIsMenuOpen] = useState(false);
    const shopName = settings?.shop_name || "Antique Shop";
    const hotline = settings?.hotline || null;

    return (
        <>
            <nav className="bg-stone-900/95 backdrop-blur-md text-white sticky top-0 z-50 shadow-lg border-b border-white/5">
            {/* Top Bar */}
            <div className="hidden md:block bg-stone-800/50 border-b border-stone-700/50">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="flex justify-between items-center h-9">
                        <div className="flex items-center space-x-4 text-xs text-stone-300">
                            <span className="flex items-center gap-1.5">
                                <svg className="w-3.5 h-3.5 text-amber-400" fill="none" stroke="currentColor" strokeWidth={2} viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                <a href={`tel:${settings?.hotline || "0985408685"}`} className="!text-amber-400 hover:!text-amber-300 transition-colors">
                                    {settings?.hotline || "0985408685"}
                                </a>
                            </span>
                            <span className="text-stone-600">|</span>
                            <span>Trưng bày & Kết nối đồ cổ tinh hoa</span>
                        </div>
                        <div className="flex items-center space-x-5">
                            {settings?.facebook_fanpage && (
                                <a href={settings.facebook_fanpage} target="_blank" rel="noreferrer" className="text-stone-400 hover:text-amber-300 transition-colors flex items-center" title="Facebook Fanpage">
                                    <svg className="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                    </svg>
                                </a>
                            )}
                            {settings?.tiktok_url && (
                                <a href={settings.tiktok_url} target="_blank" rel="noreferrer" className="text-stone-400 hover:text-amber-300 transition-colors flex items-center" title="TikTok">
                                    <svg className="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12.53.02C13.84 0 15.14.01 16.44 0c.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.52-4.06-1.39v7.76c-.04 2.11-.83 4.29-2.52 5.56-1.74 1.34-4.14 1.83-6.27 1.25-2.47-.64-4.57-2.61-5.18-5.09-.78-2.91.4-6.19 2.92-7.55 1.53-.84 3.39-1.01 5.08-.47V14.1c-1.12-.34-2.39-.17-3.34.52-.94.7-1.4 1.9-1.22 3.08.15 1.18.96 2.21 2.05 2.65 1.17.48 2.6.21 3.48-.68.61-.63.89-1.51.87-2.38V.02z" />
                                    </svg>
                                </a>
                            )}
                            {settings?.instagram_url && (
                                <a href={settings.instagram_url} target="_blank" rel="noreferrer" className="text-stone-400 hover:text-amber-300 transition-colors flex items-center" title="Instagram">
                                    <svg className="w-4 h-4" fill="none" stroke="currentColor" strokeWidth="2.4" strokeLinecap="round" strokeLinejoin="round" viewBox="0 0 24 24">
                                        <rect x="2" y="2" width="20" height="20" rx="5" ry="5" />
                                        <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z" />
                                        <line x1="17.5" y1="6.5" x2="17.51" y2="6.5" />
                                    </svg>
                                </a>
                            )}
                        </div>
                    </div>
                </div>
            </div>

            {/* Main Navbar */}
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div className="flex justify-between items-center h-16 md:h-20">
                    {/* Logo */}
                    <Link to="/" className="flex items-center space-x-2.5 group">
                        <div className="w-10 h-10 bg-amber-700 rounded-lg flex items-center justify-center group-hover:bg-amber-600 transition-all group-hover:scale-110">
                            <svg className="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={1.5} d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <span
                            className="text-xl md:text-2xl font-bold text-white group-hover:text-amber-300 transition-colors"
                            style={{ fontFamily: "'Playfair Display', serif" }}
                        >
                            {shopName}
                        </span>
                    </Link>

                    {/* Desktop Menu */}
                    <div className="hidden md:flex items-center space-x-8">
                        <Link to="/" className="text-stone-300 hover:text-amber-300 transition-colors text-sm font-semibold tracking-wide">
                            TRANG CHỦ
                        </Link>
                        <Link to="/products" className="text-stone-300 hover:text-amber-300 transition-colors text-sm font-semibold tracking-wide">
                            BỘ SƯU TẬP
                        </Link>
                        <Link to="/contact" className="text-stone-300 hover:text-amber-300 transition-colors text-sm font-semibold tracking-wide">
                            LIÊN HỆ
                        </Link>
                        {hotline && (
                            <a
                                href={`tel:${hotline}`}
                                className="flex items-center gap-2 bg-amber-700 hover:bg-amber-600 text-white px-5 py-2.5 rounded-xl text-sm font-bold transition-all duration-200 hover:shadow-lg hover:shadow-amber-900/30 hover:-translate-y-0.5"
                            >
                                <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                {hotline}
                            </a>
                        )}
                    </div>

                    {/* Mobile menu button */}
                    <button
                        onClick={() => setIsMenuOpen(true)}
                        className="md:hidden text-stone-300 hover:text-white p-2 rounded-lg hover:bg-stone-700 transition-colors"
                        aria-label="Menu"
                    >
                        <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </nav>

        {/* Mobile Sidebar Menu (Slide in from right) */}
        {/* Backdrop */}
            <div
                className={`fixed inset-0 bg-black/60 backdrop-blur-sm z-40 transition-opacity duration-300 md:hidden ${
                    isMenuOpen ? "opacity-100 pointer-events-auto" : "opacity-0 pointer-events-none"
                }`}
                onClick={() => setIsMenuOpen(false)}
            />

            {/* Drawer */}
            <div
                className={`fixed top-0 right-0 bottom-0 w-72 max-w-[80vw] bg-stone-900 z-50 shadow-2xl border-l border-white/5 flex flex-col transition-transform duration-300 ease-in-out md:hidden ${
                    isMenuOpen ? "translate-x-0" : "translate-x-full"
                }`}
            >
                {/* Header inside drawer */}
                <div className="flex justify-end items-center px-6 h-16 border-b border-white/5 flex-shrink-0">
                    <button
                        onClick={() => setIsMenuOpen(false)}
                        className="text-stone-400 hover:text-white p-2 rounded-lg hover:bg-stone-800 transition-colors"
                        aria-label="Đóng Menu"
                    >
                        <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {/* Links */}
                <div className="px-4 py-6 space-y-2 flex-grow overflow-y-auto">
                    <Link
                        to="/"
                        className="block px-4 py-3 !text-stone-300 hover:!text-amber-400 hover:bg-stone-800 rounded-xl text-base font-semibold transition-colors"
                        onClick={() => setIsMenuOpen(false)}
                    >
                        Trang chủ
                    </Link>
                    <Link
                        to="/products"
                        className="block px-4 py-3 !text-stone-300 hover:!text-amber-400 hover:bg-stone-800 rounded-xl text-base font-semibold transition-colors"
                        onClick={() => setIsMenuOpen(false)}
                    >
                        Bộ sưu tập
                    </Link>
                    <Link
                        to="/contact"
                        className="block px-4 py-3 !text-stone-300 hover:!text-amber-400 hover:bg-stone-800 rounded-xl text-base font-semibold transition-colors"
                        onClick={() => setIsMenuOpen(false)}
                    >
                        Liên hệ
                    </Link>

                    {hotline && (
                        <div className="pt-6 px-4">
                            <a
                                href={`tel:${hotline}`}
                                className="flex items-center justify-center gap-2 w-full py-3 bg-amber-700 hover:bg-amber-600 text-white rounded-xl font-bold transition-colors shadow-lg shadow-amber-900/20"
                            >
                                <svg className="w-4 h-4" fill="none" stroke="currentColor" strokeWidth={2} viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                Gọi tư vấn: {hotline}
                            </a>
                        </div>
                    )}
                </div>
            </div>
        </>
    );
}
export default Navbar;