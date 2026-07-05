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
    handleSortByChange,
    handleApplyFilters
}) {
    const [isCatOpen, setIsCatOpen] = useState(false);
    const [isFocused, setIsFocused] = useState(false);
    const [catSearch, setCatSearch] = useState("");
    const catRef = useRef(null);

    // Responsive mobile detector state
    const [isMobile, setIsMobile] = useState(false);
    const [isMobileFiltersOpen, setIsMobileFiltersOpen] = useState(false);

    // Local states to prevent auto-search on mobile
    const [localSearch, setLocalSearch] = useState(searchTerm);
    const [localCategory, setLocalCategory] = useState(activeCategory);
    const [localIsNew, setLocalIsNew] = useState(isNew);
    const [localStatus, setLocalStatus] = useState(status);
    const [localSortBy, setLocalSortBy] = useState(sortBy);

    // Detect screen width to set mobile flag
    useEffect(() => {
        const handleResize = () => {
            setIsMobile(window.innerWidth < 768); // 768px matches Tailwind's 'md' breakpoint
        };
        handleResize();
        window.addEventListener("resize", handleResize);
        return () => window.removeEventListener("resize", handleResize);
    }, []);

    // Sync local states if props change from outside (e.g. page changes, reset filters)
    useEffect(() => {
        setLocalSearch(searchTerm);
        setLocalCategory(activeCategory);
        setLocalIsNew(isNew);
        setLocalStatus(status);
        setLocalSortBy(sortBy);
    }, [searchTerm, activeCategory, isNew, status, sortBy]);

    // Close category dropdown when clicking outside
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

    // Filter categories based on selection search input
    const filteredCategories = categories.filter((cat) =>
        cat.name.toLowerCase().includes(catSearch.toLowerCase())
    );

    // Selected category name helper
    const selectedCategoryName = localCategory
        ? categories.find((c) => c.id == localCategory)?.name
        : "Tất cả danh mục";

    // Handle search input changes
    const onSearchChange = (e) => {
        const val = e.target.value;
        setLocalSearch(val);
        if (!isMobile) {
            handleSearchChange(e);
        }
    };

    // Handle category selections
    const handleSelectCategory = (catId) => {
        setLocalCategory(catId);
        if (!isMobile) {
            handleCategoryChange(catId);
        }
        setIsCatOpen(false);
        setIsFocused(false);
        setCatSearch("");
    };

    // Handle sort changes
    const onSortByChange = (val) => {
        setLocalSortBy(val);
        if (!isMobile) {
            handleSortByChange(val);
        }
    };

    // Handle newest toggle changes
    const onIsNewChange = () => {
        const nextVal = localIsNew === "true" ? "" : "true";
        setLocalIsNew(nextVal);
        if (!isMobile) {
            handleIsNewChange(nextVal);
        }
    };

    // Handle status dropdown changes
    const onStatusChange = (val) => {
        setLocalStatus(val);
        if (!isMobile) {
            handleStatusChange(val);
        }
    };

    // Clear all filters handler
    const handleClearAll = () => {
        setLocalSearch("");
        setLocalCategory("");
        setLocalIsNew("");
        setLocalStatus("");
        setLocalSortBy("");
        setCatSearch("");
        
        handleApplyFilters({
            search: "",
            category: "",
            isNew: "",
            status: "",
            sortBy: ""
        });
        
        setIsMobileFiltersOpen(false);
    };

    // Check if any filter is currently active
    const hasActiveFilters = !!(localSearch || localCategory || localIsNew === "true" || localStatus || localSortBy);

    return (
        <div className="w-full mb-8">
            {/* Desktop Filters (Hidden on Mobile) */}
            <div className="hidden md:grid grid-cols-12 gap-4 items-center">
                {/* 1. Tìm kiếm theo tên (3 cols) */}
                <div className="md:col-span-3 relative">
                    <Search className="absolute left-3.5 top-1/2 -translate-y-1/2 text-stone-400 w-4.5 h-4.5" />
                    <input
                        type="text"
                        placeholder="Tìm theo tên hiện vật..."
                        className="w-full pl-11 pr-4 py-3 bg-stone-50 border border-stone-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all outline-none text-sm text-stone-800 placeholder-stone-400"
                        value={localSearch}
                        onChange={onSearchChange}
                    />
                </div>

                {/* 2. Danh mục: Bấm vào là bộ lọc + hiển thị dropdown (3 cols) */}
                <div className="md:col-span-3 relative" ref={catRef}>
                    <div className="relative">
                        <FolderOpen className="absolute left-3.5 top-1/2 -translate-y-1/2 text-stone-400 w-4.5 h-4.5" />
                        <input
                            type="text"
                            placeholder={isFocused ? "Nhập tên danh mục..." : (selectedCategoryName || "Tất cả danh mục")}
                            className={`w-full pl-11 pr-10 py-3 bg-stone-50 border border-stone-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all outline-none text-sm font-medium ${
                                isFocused ? "text-stone-850 placeholder-stone-400" : "text-stone-800 cursor-pointer placeholder-stone-800"
                            }`}
                            value={isFocused ? catSearch : (localCategory ? selectedCategoryName : "")}
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
                        {localCategory ? (
                            <button
                                type="button"
                                onClick={(e) => {
                                    e.stopPropagation();
                                    handleSelectCategory("");
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
                            <div 
                                className="overflow-y-auto max-h-[200px] flex flex-col gap-0.5 scrollbar-thin"
                                style={{ scrollbarWidth: "thin", scrollbarColor: "#d6d3d1 transparent" }}
                            >
                                <button
                                    onClick={() => handleSelectCategory("")}
                                    className={`w-full text-left px-3 py-2 rounded-lg text-xs font-semibold flex items-center justify-between transition-colors ${
                                        !localCategory 
                                            ? "bg-amber-50 text-amber-900" 
                                            : "text-stone-600 hover:bg-stone-50"
                                    }`}
                                >
                                    <span>Tất cả danh mục</span>
                                    {!localCategory && <Check className="w-3.5 h-3.5 text-amber-700 stroke-[3px]" />}
                                </button>

                                {filteredCategories.length === 0 ? (
                                    <div className="text-center text-stone-400 text-[11px] py-3">Không tìm thấy danh mục</div>
                                ) : (
                                    filteredCategories.map((cat) => {
                                        const isActive = localCategory == cat.id;
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
                        value={localSortBy}
                        onChange={(e) => onSortByChange(e.target.value)}
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
                        onClick={onIsNewChange}
                        className={`w-full flex items-center justify-center gap-2 px-4 py-3 border !rounded-xl text-sm font-semibold transition-all ${
                            localIsNew === "true"
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
                        value={localStatus}
                        onChange={(e) => onStatusChange(e.target.value)}
                    >
                        <option value="">Trạng thái</option>
                        <option value="in_stock">Còn hàng</option>
                        <option value="sold">Đã bán</option>
                    </select>
                    <CheckCircle className="absolute left-3.5 top-1/2 -translate-y-1/2 text-stone-400 w-4 h-4 pointer-events-none" />
                    <ChevronDown className="absolute right-3.5 top-1/2 -translate-y-1/2 text-stone-400 w-4 h-4 pointer-events-none" />
                </div>
            </div>

            {/* Desktop Clear Filters Action Row */}
            {hasActiveFilters && (
                <div className="hidden md:flex justify-end mt-2.5">
                    <button
                        type="button"
                        onClick={handleClearAll}
                        className="text-xs font-semibold text-stone-500 hover:text-amber-700 transition-colors flex items-center gap-1.5"
                    >
                        <X className="w-3.5 h-3.5" />
                        Xóa tất cả bộ lọc
                    </button>
                </div>
            )}

            {/* Mobile Filters (Visible on Mobile only) */}
            <div className="md:hidden flex flex-col gap-4">
                {/* Search Bar + Filter Icon Row */}
                <div className="flex gap-2 w-full">
                    <div className="relative flex-grow">
                        <Search className="absolute left-3.5 top-1/2 -translate-y-1/2 text-stone-400 w-4.5 h-4.5" />
                        <input
                            type="text"
                            placeholder="Tìm theo tên hiện vật..."
                            className="w-full pl-11 pr-4 py-3 bg-stone-50 border border-stone-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all outline-none text-sm text-stone-800 placeholder-stone-400 shadow-sm"
                            value={localSearch}
                            onChange={(e) => setLocalSearch(e.target.value)}
                            onKeyDown={(e) => {
                                if (e.key === "Enter") {
                                    handleApplyFilters({
                                        search: localSearch,
                                        category: localCategory,
                                        isNew: localIsNew,
                                        status: localStatus,
                                        sortBy: localSortBy
                                    });
                                }
                            }}
                        />
                    </div>
                    
                    {/* Toggle Button for mobile filters panel */}
                    <button
                        type="button"
                        onClick={() => setIsMobileFiltersOpen(!isMobileFiltersOpen)}
                        className={`p-3 border rounded-xl flex items-center justify-center transition-colors shadow-sm ${
                            isMobileFiltersOpen 
                                ? "bg-amber-700 border-amber-800 text-white" 
                                : "bg-stone-50 border-stone-200 text-stone-600 hover:bg-stone-100/50"
                        }`}
                        title="Bộ lọc"
                    >
                        <svg className="w-5 h-5" fill="none" stroke="currentColor" strokeWidth={2} viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                        </svg>
                    </button>
                </div>
            </div>

            {/* Mobile Filter Drawer (Slide in from right) */}
            {/* Backdrop */}
            <div
                className={`fixed inset-0 bg-black/60 backdrop-blur-sm z-50 transition-opacity duration-300 md:hidden ${
                    isMobileFiltersOpen ? "opacity-100 pointer-events-auto" : "opacity-0 pointer-events-none"
                }`}
                onClick={() => setIsMobileFiltersOpen(false)}
            />

            {/* Drawer */}
            <div
                className={`fixed top-0 right-0 bottom-0 w-80 max-w-[85vw] bg-stone-900 text-white z-50 shadow-2xl border-l border-white/5 flex flex-col transition-transform duration-300 ease-in-out md:hidden ${
                    isMobileFiltersOpen ? "translate-x-0" : "translate-x-full"
                }`}
            >
                {/* Header inside drawer */}
                <div className="flex justify-between items-center px-6 h-16 border-b border-white/5 flex-shrink-0">
                    <span className="font-bold text-amber-500 font-playfair text-base">Bộ lọc tìm kiếm</span>
                    <button
                        type="button"
                        onClick={() => setIsMobileFiltersOpen(false)}
                        className="text-stone-400 hover:text-white p-2 rounded-lg hover:bg-stone-800 transition-colors"
                        aria-label="Đóng Bộ Lọc"
                    >
                        <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {/* Filters Content */}
                <div className="p-6 space-y-5 flex-grow overflow-y-auto flex flex-col">
                    {/* 1. Category */}
                    <div className="space-y-1.5 relative" ref={catRef}>
                        <label className="text-[10px] uppercase font-bold text-stone-400 tracking-wider">Danh mục bộ sưu tập</label>
                        <div className="relative">
                            <FolderOpen className="absolute left-3.5 top-1/2 -translate-y-1/2 text-stone-400 w-4.5 h-4.5" />
                            <input
                                type="text"
                                placeholder={isFocused ? "Nhập tên danh mục..." : (selectedCategoryName || "Tất cả danh mục")}
                                className={`w-full pl-11 pr-10 py-3 bg-stone-800 border border-stone-700 rounded-xl focus:bg-stone-850 focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all outline-none text-sm font-medium ${
                                    isFocused ? "text-white placeholder-stone-500" : "text-stone-300 cursor-pointer placeholder-stone-300"
                                }`}
                                value={isFocused ? catSearch : (localCategory ? selectedCategoryName : "")}
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
                            {localCategory ? (
                                <button
                                    type="button"
                                    onClick={(e) => {
                                        e.stopPropagation();
                                        handleSelectCategory("");
                                    }}
                                    className="absolute right-3.5 top-1/2 -translate-y-1/2 p-1 hover:bg-stone-700 rounded-full text-stone-400 hover:text-stone-200 transition-colors"
                                >
                                    <X className="w-3.5 h-3.5" />
                                </button>
                            ) : (
                                <ChevronDown className="absolute right-3.5 top-1/2 -translate-y-1/2 text-stone-400 w-4.5 h-4.5 pointer-events-none" />
                            )}
                        </div>

                        {isCatOpen && (
                            <div className="absolute left-0 right-0 mt-2 bg-stone-800 border border-stone-700 rounded-xl shadow-xl z-50 p-2">
                                <div 
                                    className="overflow-y-auto max-h-[150px] flex flex-col gap-0.5 scrollbar-thin"
                                    style={{ scrollbarWidth: "thin", scrollbarColor: "#4b5563 transparent" }}
                                >
                                    <button
                                        onClick={() => handleSelectCategory("")}
                                        className={`w-full text-left px-3 py-2 rounded-lg text-xs font-semibold flex items-center justify-between transition-colors ${
                                            !localCategory ? "bg-amber-900/50 text-amber-300" : "text-stone-300 hover:bg-stone-700"
                                        }`}
                                    >
                                        <span>Tất cả danh mục</span>
                                        {!localCategory && <Check className="w-3.5 h-3.5 text-amber-400 stroke-[3px]" />}
                                    </button>

                                    {filteredCategories.length === 0 ? (
                                        <div className="text-center text-stone-500 text-[11px] py-3">Không tìm thấy danh mục</div>
                                    ) : (
                                        filteredCategories.map((cat) => {
                                            const isActive = localCategory == cat.id;
                                            return (
                                                <button
                                                    key={cat.id}
                                                    onClick={() => handleSelectCategory(cat.id)}
                                                    className={`w-full text-left px-3 py-2 rounded-lg text-xs font-semibold flex items-center justify-between transition-colors ${
                                                        isActive ? "bg-amber-900/50 text-amber-300" : "text-stone-300 hover:bg-stone-700"
                                                    }`}
                                                >
                                                    <span className="truncate">{cat.name}</span>
                                                    {isActive && <Check className="w-3.5 h-3.5 text-amber-400 stroke-[3px]" />}
                                                </button>
                                            );
                                        })
                                    )}
                                </div>
                            </div>
                        )}
                    </div>

                    {/* 2. Sort by Price */}
                    <div className="space-y-1.5">
                        <label className="text-[10px] uppercase font-bold text-stone-400 tracking-wider">Sắp xếp theo giá</label>
                        <div className="relative">
                            <select
                                className="w-full pl-10 pr-8 py-3 bg-stone-800 border border-stone-700 rounded-xl text-sm font-medium text-stone-300 appearance-none outline-none hover:bg-stone-700/50 transition-colors cursor-pointer"
                                value={localSortBy}
                                onChange={(e) => onSortByChange(e.target.value)}
                            >
                                <option value="">Không sắp xếp</option>
                                <option value="price_asc">Giá: Thấp đến Cao</option>
                                <option value="price_desc">Giá: Cao đến Thấp</option>
                            </select>
                            <ArrowUpDown className="absolute left-3.5 top-1/2 -translate-y-1/2 text-stone-400 w-4.5 h-4.5 pointer-events-none" />
                            <ChevronDown className="absolute right-3.5 top-1/2 -translate-y-1/2 text-stone-400 w-4.5 h-4.5 pointer-events-none" />
                        </div>
                    </div>

                    {/* 3. Availability status */}
                    <div className="space-y-1.5">
                        <label className="text-[10px] uppercase font-bold text-stone-400 tracking-wider">Trạng thái giao dịch</label>
                        <div className="relative">
                            <select
                                className="w-full pl-10 pr-8 py-3 bg-stone-800 border border-stone-700 rounded-xl text-sm font-medium text-stone-300 appearance-none outline-none hover:bg-stone-700/50 transition-colors cursor-pointer"
                                value={localStatus}
                                onChange={(e) => onStatusChange(e.target.value)}
                            >
                                <option value="">Tất cả trạng thái</option>
                                <option value="in_stock">Còn hàng</option>
                                <option value="sold">Đã bán</option>
                            </select>
                            <CheckCircle className="absolute left-3.5 top-1/2 -translate-y-1/2 text-stone-400 w-4.5 h-4.5 pointer-events-none" />
                            <ChevronDown className="absolute right-3.5 top-1/2 -translate-y-1/2 text-stone-400 w-4.5 h-4.5 pointer-events-none" />
                        </div>
                    </div>

                    {/* 4. Newest filter */}
                    <div className="pt-2">
                        <button
                            type="button"
                            onClick={onIsNewChange}
                            className={`w-full flex items-center justify-center gap-2 px-4 py-3 border !rounded-xl text-sm font-semibold transition-all ${
                                localIsNew === "true"
                                    ? "bg-amber-700 border-amber-800 text-white shadow-sm"
                                    : "bg-stone-800 border-stone-700 text-stone-300 hover:bg-stone-700"
                            }`}
                        >
                            <span>Mới nhất</span>
                        </button>
                    </div>

                    {/* 5. Big Submit button */}
                    <div className="pt-4 mt-auto space-y-2.5">
                        <button
                            type="button"
                            onClick={() => {
                                handleApplyFilters({
                                    search: localSearch,
                                    category: localCategory,
                                    isNew: localIsNew,
                                    status: localStatus,
                                    sortBy: localSortBy
                                });
                                setIsMobileFiltersOpen(false);
                            }}
                            className="w-full py-3.5 bg-amber-700 hover:bg-amber-600 text-white font-bold rounded-xl shadow-lg transition-colors flex items-center justify-center gap-2 text-sm tracking-wider uppercase"
                        >
                            <Search className="w-4 h-4" />
                            Tìm kiếm
                        </button>
                        
                        {hasActiveFilters && (
                            <button
                                type="button"
                                onClick={handleClearAll}
                                className="w-full py-3 bg-stone-850 hover:bg-stone-800 text-stone-300 font-semibold rounded-xl border border-white/5 transition-colors flex items-center justify-center gap-2 text-xs uppercase"
                            >
                                <X className="w-4 h-4 text-stone-500" />
                                Xóa tất cả bộ lọc
                            </button>
                        )}
                    </div>
                </div>
            </div>
        </div>
    );
}

export default TopFilter;
