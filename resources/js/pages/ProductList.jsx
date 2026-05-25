import React from "react";
import ProductCard from "../components/ProductCard";
import SidebarFilter from "../components/SidebarFilter";
import MobileFilterDrawer from "../components/MobileFilterDrawer";
import Pagination from "../components/Pagination";
import useProductList from "../hooks/useProductList";
import { Search, Filter } from "lucide-react";

function ProductList({ settings }) {
    const {
        products,
        pagination,
        categories,
        loading,
        searchTerm,
        activeCategory,
        currentPage,
        isFilterVisible,
        setIsFilterVisible,
        handleSearchChange,
        handleCategoryChange,
        handlePageChange
    } = useProductList(settings);

    return (
        <div className="bg-stone-50 min-h-screen pt-24 pb-20 relative">
            <div className="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-10">

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
                    <SidebarFilter
                        searchTerm={searchTerm}
                        handleSearchChange={handleSearchChange}
                        activeCategory={activeCategory}
                        handleCategoryChange={handleCategoryChange}
                        categories={categories}
                    />

                    {/* Main Content - Products */}
                    <main className="lg:col-span-9 flex-grow">
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
                                <Pagination
                                    pagination={pagination}
                                    currentPage={currentPage}
                                    handlePageChange={handlePageChange}
                                />
                            </>
                        )}
                    </main>

                    {/* Mobile Filter Drawer (Hidden on lg) */}
                    <MobileFilterDrawer
                        isOpen={isFilterVisible}
                        onClose={() => setIsFilterVisible(false)}
                        searchTerm={searchTerm}
                        handleSearchChange={handleSearchChange}
                        activeCategory={activeCategory}
                        handleCategoryChange={handleCategoryChange}
                        categories={categories}
                    />
                </div>
            </div>
        </div>
    );
}

export default ProductList;
