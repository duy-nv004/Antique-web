import React from "react";
import { ChevronLeft, ChevronRight } from "lucide-react";

function Pagination({ pagination, currentPage, handlePageChange }) {
    if (!pagination.last || pagination.last <= 1) return null;

    const getPageNumbers = () => {
        const pages = [];
        const delta = 1; // Số trang lân cận hiển thị xung quanh trang hiện tại

        for (let i = 1; i <= pagination.last; i++) {
            if (
                i === 1 ||
                i === pagination.last ||
                (i >= currentPage - delta && i <= currentPage + delta)
            ) {
                pages.push(i);
            } else if (i === 2 || i === pagination.last - 1) {
                pages.push("...");
            }
        }

        // Lọc để tránh hiển thị nhiều dấu ba chấm liên tiếp
        const uniquePages = [];
        pages.forEach((p) => {
            if (p === "...") {
                if (uniquePages[uniquePages.length - 1] !== "...") {
                    uniquePages.push(p);
                }
            } else {
                uniquePages.push(p);
            }
        });

        return uniquePages;
    };

    const pages = getPageNumbers();

    return (
        <div className="flex justify-center items-center gap-1.5 pt-10 border-t border-stone-100 flex-wrap">
            {/* Nút Trang Trước */}
            <button
                onClick={() => currentPage > 1 && handlePageChange(currentPage - 1)}
                disabled={currentPage === 1}
                className={`w-10 h-10 rounded-lg flex items-center justify-center transition-all border ${
                    currentPage === 1
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
                            currentPage === page
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
                onClick={() => currentPage < pagination.last && handlePageChange(currentPage + 1)}
                disabled={currentPage === pagination.last}
                className={`w-10 h-10 rounded-lg flex items-center justify-center transition-all border ${
                    currentPage === pagination.last
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
