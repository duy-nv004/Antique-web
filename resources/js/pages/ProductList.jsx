import React from "react";
import ProductCard from "../components/ProductCard";
import TopFilter from "../components/TopFilter";
import Pagination from "../components/Pagination";
import useProductList from "../hooks/useProductList";
import { Search } from "lucide-react";

function ProductList({ settings }) {
    const {
        products,
        pagination,
        categories,
        loading,
        searchTerm,
        activeCategory,
        isNew,
        status,
        sortBy,
        currentPage,
        handleSearchChange,
        handleCategoryChange,
        handleIsNewChange,
        handleStatusChange,
        handleSortByChange,
        handlePageChange
    } = useProductList(settings);

    return (
        <div className="bg-stone-50 min-h-screen pt-24 pb-20 relative">
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                {/* Bộ lọc ngang phía trên danh sách sản phẩm */}
                <TopFilter
                    searchTerm={searchTerm}
                    handleSearchChange={handleSearchChange}
                    activeCategory={activeCategory}
                    handleCategoryChange={handleCategoryChange}
                    categories={categories}
                    isNew={isNew}
                    handleIsNewChange={handleIsNewChange}
                    status={status}
                    handleStatusChange={handleStatusChange}
                    sortBy={sortBy}
                    handleSortByChange={handleSortByChange}
                />

                {/* Main Content - Products Grid */}
                <main className="w-full flex-grow">
                    {/* Grid */}
                    {loading ? (
                        <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-8">
                            {[...Array(8)].map((_, i) => (
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
                            <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-8 mb-12">
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
            </div>
        </div>
    );
}

export default ProductList;
