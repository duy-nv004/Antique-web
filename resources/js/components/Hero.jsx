import React from "react";
import { useNavigate } from "react-router-dom";

function Hero({ categories = [], onCategorySelect }) {
    const navigate = useNavigate();
    const defaultCategories = [
        { id: "gc", name: "Đồ gốm sứ cổ" },
        { id: "ta", name: "Tranh ảnh cổ" },
        { id: "dk", name: "Đồ đồng - Kim loại" },
        { id: "go", name: "Đồ gỗ cổ" },
        { id: "tc", name: "Tiền cổ" },
        { id: "tl", name: "Vật phẩm tâm linh" },
    ];
    const safeCategories = Array.isArray(categories) ? categories : [];
    const displayCategories = safeCategories.length > 0 ? safeCategories : defaultCategories;

    const handleCategoryClick = (id) => {
        if (onCategorySelect) {
            onCategorySelect(id);
        } else {
            navigate(id ? `/products?category=${id}` : "/products");
        }
    };

    return (
        <div className="relative bg-stone-900 overflow-hidden">
            {/* Decorative background pattern */}
            <div className="absolute inset-0 opacity-10">
                <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <pattern id="heroPattern" x="0" y="0" width="60" height="60" patternUnits="userSpaceOnUse">
                            <path d="M30 0 L60 30 L30 60 L0 30 Z" fill="none" stroke="#d97706" strokeWidth="0.5" />
                        </pattern>
                    </defs>
                    <rect width="100%" height="100%" fill="url(#heroPattern)" />
                </svg>
            </div>

            <div className="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 md:py-28">
                <div className="flex flex-col lg:flex-row items-center gap-12">
                    {/* Text Content */}
                    <div className="flex-1 text-center lg:text-left">
                        <div className="inline-flex items-center gap-2 bg-amber-700/20 border border-amber-600/30 text-amber-400 text-xs font-semibold uppercase tracking-widest px-4 py-1.5 rounded-full mb-6">
                            <span className="w-1.5 h-1.5 bg-amber-400 rounded-full animate-pulse"></span>
                            Đồ Cổ Chính Hãng
                        </div>

                        <h1
                            className="text-4xl md:text-5xl lg:text-6xl font-bold text-white leading-tight mb-6"
                            style={{ fontFamily: "'Playfair Display', serif" }}
                        >
                            Tinh Hoa<br />
                            <span className="text-amber-400">Đồ Cổ</span> Việt Nam
                        </h1>

                        <p className="text-stone-300 text-lg md:text-xl leading-relaxed mb-8 max-w-xl">
                            Mỗi món đồ là một câu chuyện lịch sử quý giá. Khám phá bộ sưu tập đồ cổ
                            độc đáo và liên hệ trực tiếp để được tư vấn chi tiết.
                        </p>

                        <div className="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                            <button
                                onClick={() => navigate("/products")}
                                className="inline-flex items-center justify-center gap-2 px-7 py-3.5 bg-amber-700 hover:bg-amber-600 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg shadow-amber-900/40 hover:shadow-amber-700/50 hover:-translate-y-0.5"
                            >
                                <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                                Khám phá bộ sưu tập
                            </button>
                            <a
                                href="#contact"
                                className="inline-flex items-center justify-center gap-2 px-7 py-3.5 bg-white/10 hover:bg-white/20 border border-white/20 text-white font-semibold rounded-xl transition-all duration-200 hover:-translate-y-0.5 backdrop-blur-sm"
                            >
                                <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                                Liên hệ tư vấn
                            </a>
                        </div>

                        {/* Stats */}
                        <div className="flex gap-8 mt-10 justify-center lg:justify-start">
                            {[
                                { value: "500+", label: "Sản phẩm" },
                                { value: "100%", label: "Chính hãng" },
                                { value: "24/7", label: "Hỗ trợ" },
                            ].map((stat) => (
                                <div key={stat.label} className="text-center">
                                    <div className="text-2xl font-bold text-amber-400" style={{ fontFamily: "'Playfair Display', serif" }}>
                                        {stat.value}
                                    </div>
                                    <div className="text-xs text-stone-400 uppercase tracking-wide mt-0.5">{stat.label}</div>
                                </div>
                            ))}
                        </div>
                    </div>

                    {/* Categories Card */}
                    <div className="w-full lg:w-72 flex-shrink-0">
                        <div className="bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl overflow-hidden">
                            <div className="bg-amber-700/40 border-b border-amber-600/20 px-5 py-3.5">
                                <h3 className="text-white font-semibold text-sm flex items-center gap-2">
                                    <svg className="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M4 6h16M4 12h16M4 18h16" />
                                    </svg>
                                    Danh mục sản phẩm
                                </h3>
                            </div>
                            <ul className="py-2">
                                <li>
                                    <button
                                        onClick={() => handleCategoryClick(null)}
                                        className="w-full text-left flex items-center justify-between px-5 py-2.5 text-stone-300 hover:text-amber-300 hover:bg-white/5 transition-colors text-sm"
                                    >
                                        <span>Tất cả sản phẩm</span>
                                        <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 5l7 7-7 7" />
                                        </svg>
                                    </button>
                                </li>
                                {displayCategories.map((category, index) => (
                                    <li key={category.id || index}>
                                        <button
                                            onClick={() => handleCategoryClick(category.id)}
                                            className="w-full text-left flex items-center justify-between px-5 py-2.5 text-stone-300 hover:text-amber-300 hover:bg-white/5 transition-colors text-sm border-t border-white/5"
                                        >
                                            <span>{typeof category === "object" ? category.name : category}</span>
                                            <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 5l7 7-7 7" />
                                            </svg>
                                        </button>
                                    </li>
                                ))}
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default Hero;
