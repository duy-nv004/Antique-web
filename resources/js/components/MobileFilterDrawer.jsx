import React from "react";
import { Search, X } from "lucide-react";

function MobileFilterDrawer({
    isOpen,
    onClose,
    searchTerm,
    handleSearchChange,
    activeCategory,
    handleCategoryChange,
    categories
}) {
    if (!isOpen) return null;

    return (
        <div className="lg:hidden fixed inset-0 z-[60] flex justify-end">
            <div className="fixed inset-0 bg-black/60 backdrop-blur-sm" onClick={onClose}></div>
            <div className="relative w-80 max-w-full bg-white h-full shadow-2xl p-8 flex flex-col animate-in slide-in-from-right duration-300">
                <div className="flex items-center justify-between mb-8">
                    <h3 className="text-xl font-bold text-stone-800" style={{ fontFamily: "'Playfair Display', serif" }}>Bộ lọc</h3>
                    <button onClick={onClose} className="p-2 hover:bg-stone-100 rounded-full transition-all">
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
                        <div 
                            className="flex flex-col gap-1.5 max-h-[320px] overflow-y-auto pr-1.5"
                            style={{ scrollbarWidth: "thin", scrollbarColor: "#e7e5e4 transparent" }}
                        >
                            <button
                                onClick={() => { handleCategoryChange(""); onClose(); }}
                                className={`w-full text-left px-3.5 py-2.5 rounded-lg text-xs font-semibold transition-all ${!activeCategory
                                        ? "bg-stone-800 text-white shadow-md"
                                        : "bg-stone-50 text-stone-600 hover:bg-stone-100 border border-stone-100"
                                    }`}
                            >
                                Tất cả
                            </button>
                            {categories.map((cat) => (
                                <button
                                    key={cat.id}
                                    onClick={() => { handleCategoryChange(cat.id); onClose(); }}
                                    className={`w-full text-left px-3.5 py-2.5 rounded-lg text-xs font-semibold transition-all ${activeCategory == cat.id
                                            ? "bg-stone-800 text-white shadow-md"
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
                    onClick={onClose}
                    className="mt-8 w-full bg-amber-700 text-white font-bold py-4 rounded-xl shadow-lg"
                >
                    Xem kết quả
                </button>
            </div>
        </div>
    );
}

export default MobileFilterDrawer;
