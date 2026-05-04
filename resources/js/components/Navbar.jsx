import React, { useState } from "react";
import { Link } from "react-router-dom";

function Navbar({ settings }) {
    const [isMenuOpen, setIsMenuOpen] = useState(false);
    const shopName = settings?.shop_name || "Antique Shop";
    const hotline  = settings?.hotline || null;

    return (
        <nav className="bg-stone-900/95 backdrop-blur-md text-white sticky top-0 z-50 shadow-lg border-b border-white/5">
            {/* Top Bar */}
            <div className="hidden md:block bg-stone-800/50 border-b border-stone-700/50">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="flex justify-between items-center h-9">
                        <div className="flex items-center space-x-4 text-xs text-stone-300">
                            <span className="flex items-center gap-1.5">
                                <svg className="w-3.5 h-3.5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                {settings?.shop_email || "contact@antiqueshop.vn"}
                            </span>
                            <span className="text-stone-600">|</span>
                            <span>Trưng bày & Kết nối đồ cổ tinh hoa</span>
                        </div>
                        <div className="flex items-center space-x-6">
                            <Link to="/admin" className="text-[10px] uppercase tracking-widest text-stone-400 hover:text-amber-400 transition-colors">
                                Quản trị hệ thống
                            </Link>
                            {settings?.facebook_url && (
                                <a href={settings.facebook_url} target="_blank" rel="noreferrer" className="text-stone-400 hover:text-amber-300 transition">
                                    Facebook
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
                        <a href="#" className="text-stone-300 hover:text-amber-300 transition-colors text-sm font-semibold tracking-wide">
                            KIẾN THỨC ĐỒ CỔ
                        </a>
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
                        onClick={() => setIsMenuOpen(!isMenuOpen)}
                        className="md:hidden text-stone-300 hover:text-white p-2 rounded-lg hover:bg-stone-700 transition-colors"
                        aria-label="Menu"
                    >
                        <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            {isMenuOpen
                                ? <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M6 18L18 6M6 6l12 12" />
                                : <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M4 6h16M4 12h16M4 18h16" />
                            }
                        </svg>
                    </button>
                </div>
            </div>

            {/* Mobile Menu */}
            {isMenuOpen && (
                <div className="md:hidden bg-stone-800 border-t border-stone-700 animate-in slide-in-from-top duration-300">
                    <div className="px-4 pt-2 pb-6 space-y-1">
                        <Link
                            to="/"
                            className="block px-3 py-3 text-stone-300 hover:text-white hover:bg-stone-700 rounded-lg text-base font-medium transition-colors"
                            onClick={() => setIsMenuOpen(false)}
                        >
                            Trang chủ
                        </Link>
                        <Link
                            to="/products"
                            className="block px-3 py-3 text-stone-300 hover:text-white hover:bg-stone-700 rounded-lg text-base font-medium transition-colors"
                            onClick={() => setIsMenuOpen(false)}
                        >
                            Bộ sưu tập
                        </Link>
                        <Link
                            to="/admin"
                            className="block px-3 py-3 text-amber-400 hover:text-amber-300 hover:bg-stone-700 rounded-lg text-base font-medium transition-colors"
                            onClick={() => setIsMenuOpen(false)}
                        >
                            Quản trị
                        </Link>
                        {hotline && (
                            <div className="pt-4 px-3">
                                <a
                                    href={`tel:${hotline}`}
                                    className="flex items-center justify-center gap-2 w-full py-3 bg-amber-700 text-white rounded-xl font-bold"
                                >
                                    Liên hệ: {hotline}
                                </a>
                            </div>
                        )}
                    </div>
                </div>
            )}
        </nav>
    );
}
export default Navbar;