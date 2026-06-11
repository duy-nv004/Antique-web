import React from "react";
import { ChevronLeft, ChevronRight } from "lucide-react";

function Pagination({ pagination, currentPage, handlePageChange }) {
    const lastPage = Number(pagination.last) || 1;
    const curPage = Number(currentPage) || 1;

    if (lastPage <= 1) return null;

    const getPageNumbers = () => {
        if (lastPage <= 7) {
            return Array.from({ length: lastPage }, (_, i) => i + 1);
        }

        const pages = [];
        // Always show page 1
        pages.push(1);

        if (curPage > 3) {
            pages.push("...");
        }

        // Show page range around current page
        const start = Math.max(2, curPage - 1);
        const end = Math.min(lastPage - 1, curPage + 1);

        // Adjust range to show at least 3 pages if possible
        let adjustedStart = start;
        let adjustedEnd = end;
        if (curPage <= 3) {
            adjustedEnd = Math.min(lastPage - 1, 4);
        } else if (curPage >= lastPage - 2) {
            adjustedStart = Math.max(2, lastPage - 3);
        }

        for (let i = adjustedStart; i <= adjustedEnd; i++) {
            pages.push(i);
        }

        if (curPage < lastPage - 2) {
            pages.push("...");
        }

        // Always show last page
        pages.push(lastPage);

        return pages;
    };

    const pages = getPageNumbers();

    return (
        <div className="flex justify-center items-center gap-1.5 pt-10 border-t border-stone-100 flex-wrap">
            {/* Nút Trang Trước */}
            <button
                onClick={() => curPage > 1 && handlePageChange(curPage - 1)}
                disabled={curPage === 1}
                className={`w-10 h-10 rounded-lg flex items-center justify-center transition-all border ${
                    curPage === 1
                        ? "bg-stone-50 border-stone-200 text-stone-300 cursor-not-allowed"
                        : "bg-white border-stone-200 text-stone-600 hover:bg-stone-50"
                }`}
                aria-label="Trang trước"
            >
                <ChevronLeft className="w-5 h-5" />
            </button>

            {/* Danh sách các trang */}
            {pages.map((page, index) => {
                if (page === "...") {
                    return (
                        <span
                            key={`ellipsis-${index}`}
                            className="w-10 h-10 flex items-center justify-center text-stone-400 font-bold"
                        >
                            ...
                        </span>
                    );
                }

                return (
                    <button
                        key={page}
                        onClick={() => handlePageChange(page)}
                        className={`w-10 h-10 rounded-lg font-bold transition-all border ${
                            curPage === page
                                ? "bg-amber-700 border-amber-700 text-white shadow-md shadow-amber-900/10"
                                : "bg-white border-stone-200 text-stone-600 hover:bg-stone-50"
                        }`}
                    >
                        {page}
                    </button>
                );
            })}

            {/* Nút Trang Sau */}
            <button
                onClick={() => curPage < lastPage && handlePageChange(curPage + 1)}
                disabled={curPage === lastPage}
                className={`w-10 h-10 rounded-lg flex items-center justify-center transition-all border ${
                    curPage === lastPage
                        ? "bg-stone-50 border-stone-200 text-stone-300 cursor-not-allowed"
                        : "bg-white border-stone-200 text-stone-600 hover:bg-stone-50"
                }`}
                aria-label="Trang sau"
            >
                <ChevronRight className="w-5 h-5" />
            </button>
        </div>
    );
}

export default Pagination;
