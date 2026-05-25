import React from "react";
import { Search, Filter } from "lucide-react";

function SidebarFilter({
    searchTerm,
    handleSearchChange,
    activeCategory,
    handleCategoryChange,
    categories
}) {
    return (
        <aside className="hidden lg:block lg:col-span-3 flex-shrink-0">
            <div className="pr-6">
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
                            className="w-full pl-10 pr-4 py-3 bg-white border border-stone-200 rounded-xl focus:ring-2 focus:ring-amber-500 transition-all outline-none text-sm"
                            value={searchTerm}
                            onChange={handleSearchChange}
                        />
                    </div>
                </div>

                {/* Categories */}
                <div>
                    <label className="block text-xs font-bold text-stone-400 uppercase tracking-widest mb-3">Danh mục</label>
                    <div 
                        className="flex flex-col gap-1.5 max-h-[320px] overflow-y-auto pr-1.5"
                        style={{ scrollbarWidth: "thin", scrollbarColor: "#e7e5e4 transparent" }}
                    >
                        <button
                            onClick={() => handleCategoryChange("")}
                            className={`w-full text-left px-3.5 py-2.5 rounded-lg text-xs font-semibold transition-all ${!activeCategory
                                    ? "bg-stone-800 text-white shadow-md"
                                    : "bg-white text-stone-600 hover:bg-stone-100 border border-stone-200/80"
                                }`}
                        >
                            Tất cả
                        </button>
                        {categories.map((cat) => (
                            <button
                                key={cat.id}
                                onClick={() => handleCategoryChange(cat.id)}
                                className={`w-full text-left px-3.5 py-2.5 rounded-lg text-xs font-semibold transition-all ${activeCategory == cat.id
                                        ? "bg-stone-800 text-white shadow-md"
                                        : "bg-white text-stone-600 hover:bg-stone-100 border border-stone-200/80"
                                    }`}
                            >
                                {cat.name}
                            </button>
                        ))}
                    </div>
                </div>
            </div>
        </aside>
    );
}

export default SidebarFilter;
