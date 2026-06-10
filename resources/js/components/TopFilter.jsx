import React, { useState, useRef, useEffect } from "react";
import { Search, ChevronDown, Check, X, Sparkles, FolderOpen, ArrowUpDown, CheckCircle } from "lucide-react";

function TopFilter({
    searchTerm,
    handleSearchChange,
    activeCategory,
    handleCategoryChange,
    categories,
    isNew,
    handleIsNewChange,
    status,
    handleStatusChange,
    sortBy,
    handleSortByChange
}) {
    const [isCatOpen, setIsCatOpen] = useState(false);
    const [isFocused, setIsFocused] = useState(false);
    const [catSearch, setCatSearch] = useState("");
    const catRef = useRef(null);

    // Đóng dropdown khi click ra ngoài
    useEffect(() => {
        const handleClickOutside = (event) => {
            if (catRef.current && !catRef.current.contains(event.target)) {
                setIsCatOpen(false);
                setIsFocused(false);
            }
        };
        document.addEventListener("mousedown", handleClickOutside);
        return () => document.removeEventListener("mousedown", handleClickOutside);
    }, []);

    // Lọc danh mục dựa theo ô tìm kiếm danh mục
    const filteredCategories = categories.filter((cat) =>
        cat.name.toLowerCase().includes(catSearch.toLowerCase())
    );

    // Lấy tên danh mục đang được chọn
    const selectedCategoryName = activeCategory
        ? categories.find((c) => c.id == activeCategory)?.name
        : "Tất cả danh mục";

    // Khi người dùng bấm vào danh mục trong dropdown
    const handleSelectCategory = (catId) => {
        handleCategoryChange(catId);
        setIsCatOpen(false);
        setIsFocused(false);
        setCatSearch("");
    };

    return (
        <div className="w-full mb-8">
            <div className="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                
                {/* 1. Tìm kiếm theo tên (3 cols) */}
                <div className="md:col-span-3 relative">
                    <Search className="absolute left-3.5 top-1/2 -translate-y-1/2 text-stone-400 w-4.5 h-4.5" />
                    <input
                        type="text"
                        placeholder="Tìm theo tên hiện vật..."
                        className="w-full pl-11 pr-4 py-3 bg-stone-50 border border-stone-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all outline-none text-sm text-stone-800 placeholder-stone-400"
                        value={searchTerm}
                        onChange={handleSearchChange}
                    />
                </div>

                {/* 2. Danh mục: Bấm vào là input tìm kiếm luôn + hiển thị dropdown (3 cols) */}
                <div className="md:col-span-3 relative" ref={catRef}>
                    <div className="relative">
                        <FolderOpen className="absolute left-3.5 top-1/2 -translate-y-1/2 text-stone-400 w-4.5 h-4.5" />
                        <input
                            type="text"
                            placeholder={isFocused ? "Nhập tên danh mục..." : (selectedCategoryName || "Tất cả danh mục")}
                            className={`w-full pl-11 pr-10 py-3 bg-stone-50 border border-stone-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all outline-none text-sm font-medium ${
                                isFocused ? "text-stone-850 placeholder-stone-400" : "text-stone-800 cursor-pointer placeholder-stone-800"
                            }`}
                            value={isFocused ? catSearch : (activeCategory ? selectedCategoryName : "")}
                            onChange={(e) => {
                                setCatSearch(e.target.value);
                                setIsCatOpen(true);
                            }}
                            onFocus={() => {
                                setIsFocused(true);
                                setIsCatOpen(true);
                                setCatSearch("");
                            }}
                        />
                        {/* Nút X xóa nhanh danh mục đã chọn */}
                        {activeCategory ? (
                            <button
                                type="button"
                                onClick={(e) => {
                                    e.stopPropagation();
                                    handleCategoryChange("");
                                    setCatSearch("");
                                    setIsCatOpen(false);
                                    setIsFocused(false);
                                }}
                                className="absolute right-3.5 top-1/2 -translate-y-1/2 p-1 hover:bg-stone-200 rounded-full text-stone-400 hover:text-stone-600 transition-colors"
                            >
                                <X className="w-3.5 h-3.5" />
                            </button>
                        ) : (
                            <ChevronDown className="absolute right-3.5 top-1/2 -translate-y-1/2 text-stone-400 w-4.5 h-4.5 pointer-events-none" />
                        )}
                    </div>

                    {isCatOpen && (
                        <div className="absolute left-0 right-0 mt-2 bg-white border border-stone-200 rounded-xl shadow-xl z-50 p-2 animate-in fade-in slide-in-from-top-2 duration-150">
                            {/* Danh sách danh mục cuộn (Hiện tối đa 5 item) */}
                            <div 
                                className="overflow-y-auto max-h-[200px] flex flex-col gap-0.5 scrollbar-thin"
                                style={{ scrollbarWidth: "thin", scrollbarColor: "#d6d3d1 transparent" }}
                            >
                                <button
                                    onClick={() => handleSelectCategory("")}
                                    className={`w-full text-left px-3 py-2 rounded-lg text-xs font-semibold flex items-center justify-between transition-colors ${
                                        !activeCategory 
                                            ? "bg-amber-50 text-amber-900" 
                                            : "text-stone-600 hover:bg-stone-50"
                                    }`}
                                >
                                    <span>Tất cả danh mục</span>
                                    {!activeCategory && <Check className="w-3.5 h-3.5 text-amber-700 stroke-[3px]" />}
                                </button>

                                {filteredCategories.length === 0 ? (
                                    <div className="text-center text-stone-400 text-[11px] py-3">Không tìm thấy danh mục</div>
                                ) : (
                                    filteredCategories.map((cat) => {
                                        const isActive = activeCategory == cat.id;
                                        return (
                                            <button
                                                key={cat.id}
                                                onClick={() => handleSelectCategory(cat.id)}
                                                className={`w-full text-left px-3 py-2 rounded-lg text-xs font-semibold flex items-center justify-between transition-colors ${
                                                    isActive 
                                                        ? "bg-amber-50 text-amber-900" 
                                                        : "text-stone-600 hover:bg-stone-50"
                                                }`}
                                            >
                                                <span className="truncate">{cat.name}</span>
                                                {isActive && <Check className="w-3.5 h-3.5 text-amber-700 stroke-[3px]" />}
                                            </button>
                                        );
                                    })
                                )}
                            </div>
                        </div>
                    )}
                </div>

                {/* 3. Sắp xếp giá (2 cols) */}
                <div className="md:col-span-2 relative">
                    <select
                        className="w-full pl-10 pr-8 py-3 bg-stone-50 border border-stone-200 rounded-xl text-sm font-medium text-stone-800 appearance-none outline-none hover:bg-stone-100/50 transition-colors cursor-pointer"
                        value={sortBy}
                        onChange={(e) => handleSortByChange(e.target.value)}
                    >
                        <option value="">Sắp xếp giá</option>
                        <option value="price_asc">Giá: Thấp đến Cao</option>
                        <option value="price_desc">Giá: Cao đến Thấp</option>
                    </select>
                    <ArrowUpDown className="absolute left-3.5 top-1/2 -translate-y-1/2 text-stone-400 w-4 h-4 pointer-events-none" />
                    <ChevronDown className="absolute right-3.5 top-1/2 -translate-y-1/2 text-stone-400 w-4 h-4 pointer-events-none" />
                </div>

                {/* 4. Sản phẩm mới (2 cols) */}
                <div className="md:col-span-2">
                    <button
                        type="button"
                        onClick={() => handleIsNewChange(isNew === "true" ? "" : "true")}
                        className={`w-full flex items-center justify-center gap-2 px-4 py-3 border !rounded-xl text-sm font-semibold transition-all ${
                            isNew === "true"
                                ? "bg-amber-700 border-amber-800 text-white shadow-sm"
                                : "bg-stone-50 border-stone-200 text-stone-600 hover:bg-stone-100/50"
                        }`}
                    >
                        <span>Mới nhất</span>
                    </button>
                </div>

                {/* 5. Trạng thái: Còn hàng / Đã bán (2 cols) */}
                <div className="md:col-span-2 relative">
                    <select
                        className="w-full pl-10 pr-8 py-3 bg-stone-50 border border-stone-200 rounded-xl text-sm font-medium text-stone-800 appearance-none outline-none hover:bg-stone-100/50 transition-colors cursor-pointer"
                        value={status}
                        onChange={(e) => handleStatusChange(e.target.value)}
                    >
                        <option value="">Trạng thái</option>
                        <option value="in_stock">Còn hàng</option>
                        <option value="sold">Đã bán</option>
                    </select>
                    <CheckCircle className="absolute left-3.5 top-1/2 -translate-y-1/2 text-stone-400 w-4 h-4 pointer-events-none" />
                    <ChevronDown className="absolute right-3.5 top-1/2 -translate-y-1/2 text-stone-400 w-4 h-4 pointer-events-none" />
                </div>

            </div>
        </div>
    );
}

export default TopFilter;
