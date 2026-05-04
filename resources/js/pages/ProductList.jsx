import React, { useState, useEffect } from "react";
import { useSearchParams } from "react-router-dom";
import axios from "axios";
import ProductCard from "../components/ProductCard";
import { Search, Filter, X } from "lucide-react";

function ProductList() {
    const [searchParams, setSearchParams] = useSearchParams();
    const [products, setProducts] = useState([]);
    const [pagination, setPagination] = useState({});
    const [categories, setCategories] = useState([]);
    const [settings, setSettings] = useState({});
    const [loading, setLoading] = useState(true);
    const [searchTerm, setSearchTerm] = useState(searchParams.get("search") || "");
    const [activeCategory, setActiveCategory] = useState(searchParams.get("category") || "");
    const [currentPage, setCurrentPage] = useState(parseInt(searchParams.get("page")) || 1);

    useEffect(() => {
        axios.all([
            axios.get("/api/categories"),
            axios.get("/api/settings")
        ]).then(axios.spread((catsRes, setsRes) => {
            const cats = catsRes.data;
            setCategories(Array.isArray(cats) ? cats : (cats?.data || []));
            setSettings(setsRes.data || {});
        })).catch(err => console.error("Error fetching categories/settings:", err));
    }, []);

    useEffect(() => {
        setLoading(true);
        const params = new URLSearchParams();
        if (searchTerm) params.append("search", searchTerm);
        if (activeCategory) params.append("category_id", activeCategory);
        params.append("page", currentPage);
        params.append("per_page", 12);

        axios.get(`/api/products?${params.toString()}`)
            .then((res) => {
                const data = res.data;
                // Xử lý cả trường hợp trả về mảng hoặc object phân trang
                const dataArray = Array.isArray(data) ? data : (data.data || []);
                setProducts(dataArray);
                setPagination({
                    current: data.current_page || 1,
                    last: data.last_page || 1,
                    total: data.total || dataArray.length
                });
                setLoading(false);
                window.scrollTo(0, 0);
            })
            .catch((err) => {
                console.error("Error fetching products:", err);
                setLoading(false);
            });
    }, [searchTerm, activeCategory, currentPage]);

    const handleSearchChange = (e) => {
        const val = e.target.value;
        setSearchTerm(val);
        setCurrentPage(1);
        setSearchParams(prev => {
            if (val) prev.set("search", val);
            else prev.delete("search");
            prev.set("page", 1);
            return prev;
        });
    };

    const handleCategoryChange = (id) => {
        setActiveCategory(id);
        setCurrentPage(1);
        setSearchParams(prev => {
            if (id) prev.set("category", id);
            else prev.delete("category");
            prev.set("page", 1);
            return prev;
        });
    };

    const handlePageChange = (page) => {
        setCurrentPage(page);
        setSearchParams(prev => {
            prev.set("page", page);
            return prev;
        });
    };

    const [isFilterVisible, setIsFilterVisible] = useState(false);

    return (
        <div className="bg-stone-50 min-h-screen pt-24 pb-20 relative">
            <div className="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-10">
                {/* Header */}
                <div className="text-center mb-12">
                    <h1 className="text-4xl font-bold text-stone-800 mb-4" style={{ fontFamily: "'Playfair Display', serif" }}>
                        Bộ Sưu Tập Đồ Cổ
                    </h1>
                    <div className="w-24 h-1 bg-amber-700 mx-auto mb-6"></div>
                    <p className="text-stone-500 max-w-2xl mx-auto italic">
                        "Mỗi món đồ cổ là một mảnh ghép của lịch sử, mang trong mình linh hồn của thời gian."
                    </p>
                </div>

                {/* Floating Filter Icon (Mobile Only) */}
                <button 
                    onClick={() => setIsFilterVisible(true)}
                    className="lg:hidden fixed bottom-8 right-6 z-50 w-14 h-14 bg-amber-700 text-white rounded-full shadow-2xl flex items-center justify-center hover:bg-amber-800 transition-all active:scale-95"
                    title="Mở bộ lọc"
                >
                    <Filter className="w-6 h-6" />
                </button>

                <div className="flex flex-col lg:grid lg:grid-cols-12 gap-10">
                    {/* Sidebar - Filter (Desktop Only) */}
                    <aside className="hidden lg:block lg:col-span-4 flex-shrink-0">
                        <div className="bg-white p-8 rounded-2xl shadow-sm border border-stone-200 sticky top-28">
                            <h3 className="text-lg font-bold text-stone-800 mb-6 flex items-center gap-2" style={{ fontFamily: "'Playfair Display', serif" }}>
                                <Filter className="w-5 h-5 text-amber-700" />
                                Bộ lọc tìm kiếm
                            </h3>

                            {/* Search */}
                            <div className="mb-8">
                                <label className="block text-xs font-bold text-stone-400 uppercase tracking-widest mb-3">Từ khóa</label>
                                <div className="relative">
                                    <Search className="absolute left-3 top-1/2 -translate-y-1/2 text-stone-400 w-4 h-4" />
                                    <input
                                        type="text"
                                        placeholder="Tìm tuyệt phẩm..."
                                        className="w-full pl-10 pr-4 py-3 bg-stone-50 border border-stone-100 rounded-xl focus:ring-2 focus:ring-amber-500 focus:bg-white transition-all outline-none text-sm"
                                        value={searchTerm}
                                        onChange={handleSearchChange}
                                    />
                                </div>
                            </div>

                            {/* Categories */}
                            <div>
                                <label className="block text-xs font-bold text-stone-400 uppercase tracking-widest mb-3">Danh mục</label>
                                <div className="flex flex-col gap-2">
                                    <button
                                        onClick={() => handleCategoryChange("")}
                                        className={`w-full text-left px-4 py-3 rounded-xl text-sm font-bold transition-all ${
                                            !activeCategory 
                                                ? "bg-stone-800 text-white shadow-lg" 
                                                : "bg-stone-50 text-stone-600 hover:bg-stone-100 border border-stone-100"
                                        }`}
                                    >
                                        Tất cả
                                    </button>
                                    {categories.map((cat) => (
                                        <button
                                            key={cat.id}
                                            onClick={() => handleCategoryChange(cat.id)}
                                            className={`w-full text-left px-4 py-3 rounded-xl text-sm font-bold transition-all ${
                                                activeCategory == cat.id 
                                                    ? "bg-stone-800 text-white shadow-lg" 
                                                    : "bg-stone-50 text-stone-600 hover:bg-stone-100 border border-stone-100"
                                            }`}
                                        >
                                            {cat.name}
                                        </button>
                                    ))}
                                </div>
                            </div>
                        </div>
                    </aside>

                    {/* Main Content - Products */}
                    <main className="lg:col-span-8 flex-grow">
                        {/* Results Info */}
                        <div className="flex items-center justify-between mb-8">
                            <p className="text-stone-500 text-sm">
                                Tìm thấy <span className="font-bold text-stone-800">{pagination.total || 0}</span> tuyệt phẩm
                            </p>
                            <div className="hidden sm:block h-[1px] flex-grow mx-6 bg-stone-200"></div>
                        </div>

                        {/* Grid */}
                        {loading ? (
                            <div className="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-8">
                                {[...Array(6)].map((_, i) => (
                                    <div key={i} className="animate-pulse">
                                        <div className="bg-stone-200 aspect-[4/5] rounded-2xl mb-4"></div>
                                        <div className="h-4 bg-stone-200 rounded w-3/4 mb-2"></div>
                                        <div className="h-4 bg-stone-200 rounded w-1/2"></div>
                                    </div>
                                ))}
                            </div>
                        ) : products.length === 0 ? (
                            <div className="text-center py-32 bg-white rounded-3xl border border-stone-200">
                                <div className="w-20 h-20 bg-stone-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                    <Search className="w-10 h-10 text-stone-300" />
                                </div>
                                <h3 className="text-xl font-semibold text-stone-800 mb-2">Không tìm thấy sản phẩm</h3>
                                <p className="text-stone-500">Thử thay đổi từ khóa tìm kiếm hoặc bộ lọc danh mục.</p>
                            </div>
                        ) : (
                            <>
                                <div className="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-8 mb-12">
                                    {products.map((product) => (
                                        <ProductCard key={product.id} product={product} settings={settings} />
                                    ))}
                                </div>

                                {/* Pagination */}
                                {pagination.last > 1 && (
                                    <div className="flex justify-center items-center gap-2 pt-10 border-t border-stone-100">
                                        {[...Array(pagination.last)].map((_, i) => {
                                            const page = i + 1;
                                            return (
                                                <button
                                                    key={page}
                                                    onClick={() => handlePageChange(page)}
                                                    className={`w-10 h-10 rounded-lg font-bold transition-all ${
                                                        currentPage === page
                                                            ? "bg-amber-700 text-white shadow-md shadow-amber-900/20"
                                                            : "bg-white text-stone-600 hover:bg-stone-100 border border-stone-200"
                                                    }`}
                                                >
                                                    {page}
                                                </button>
                                            );
                                        })}
                                    </div>
                                )}
                            </>
                        )}
                    </main>

                    {/* Mobile Filter Drawer (Hidden on lg) */}
                    {isFilterVisible && (
                        <div className="lg:hidden fixed inset-0 z-[60] flex justify-end">
                            <div className="fixed inset-0 bg-black/60 backdrop-blur-sm" onClick={() => setIsFilterVisible(false)}></div>
                            <div className="relative w-80 max-w-full bg-white h-full shadow-2xl p-8 flex flex-col animate-in slide-in-from-right duration-300">
                                <div className="flex items-center justify-between mb-8">
                                    <h3 className="text-xl font-bold text-stone-800" style={{ fontFamily: "'Playfair Display', serif" }}>Bộ lọc</h3>
                                    <button onClick={() => setIsFilterVisible(false)} className="p-2 hover:bg-stone-100 rounded-full transition-all">
                                        <X className="w-6 h-6 text-stone-500" />
                                    </button>
                                </div>

                                <div className="flex-grow overflow-y-auto space-y-8 pr-2">
                                    <div>
                                        <label className="block text-xs font-bold text-stone-400 uppercase tracking-widest mb-3">Từ khóa</label>
                                        <div className="relative">
                                            <Search className="absolute left-3 top-1/2 -translate-y-1/2 text-stone-400 w-4 h-4" />
                                            <input
                                                type="text"
                                                placeholder="Tìm tuyệt phẩm..."
                                                className="w-full pl-10 pr-4 py-3 bg-stone-50 border border-stone-100 rounded-xl focus:ring-2 focus:ring-amber-500 focus:bg-white transition-all outline-none text-sm"
                                                value={searchTerm}
                                                onChange={handleSearchChange}
                                            />
                                        </div>
                                    </div>

                                    <div>
                                        <label className="block text-xs font-bold text-stone-400 uppercase tracking-widest mb-3">Danh mục</label>
                                        <div className="flex flex-col gap-2">
                                            <button
                                                onClick={() => { handleCategoryChange(""); setIsFilterVisible(false); }}
                                                className={`w-full text-left px-4 py-3 rounded-xl text-sm font-bold transition-all ${
                                                    !activeCategory 
                                                        ? "bg-stone-800 text-white shadow-lg" 
                                                        : "bg-stone-50 text-stone-600 hover:bg-stone-100 border border-stone-100"
                                                }`}
                                            >
                                                Tất cả
                                            </button>
                                            {categories.map((cat) => (
                                                <button
                                                    key={cat.id}
                                                    onClick={() => { handleCategoryChange(cat.id); setIsFilterVisible(false); }}
                                                    className={`w-full text-left px-4 py-3 rounded-xl text-sm font-bold transition-all ${
                                                        activeCategory == cat.id 
                                                            ? "bg-stone-800 text-white shadow-lg" 
                                                            : "bg-stone-50 text-stone-600 hover:bg-stone-100 border border-stone-100"
                                                    }`}
                                                >
                                                    {cat.name}
                                                </button>
                                            ))}
                                        </div>
                                    </div>
                                </div>

                                <button 
                                    onClick={() => setIsFilterVisible(false)}
                                    className="mt-8 w-full bg-amber-700 text-white font-bold py-4 rounded-xl shadow-lg"
                                >
                                    Xem kết quả
                                </button>
                            </div>
                        </div>
                    )}
                </div>
            </div>
        </div>
    );
}

export default ProductList;
