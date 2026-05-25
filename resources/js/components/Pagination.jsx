import React from "react";

function Pagination({ pagination, currentPage, handlePageChange }) {
    if (!pagination.last || pagination.last <= 1) return null;

    return (
        <div className="flex justify-center items-center gap-2 pt-10 border-t border-stone-100">
            {[...Array(pagination.last)].map((_, i) => {
                const page = i + 1;
                return (
                    <button
                        key={page}
                        onClick={() => handlePageChange(page)}
                        className={`w-10 h-10 rounded-lg font-bold transition-all ${currentPage === page
                                ? "bg-amber-700 text-white shadow-md shadow-amber-900/20"
                                : "bg-white text-stone-600 hover:bg-stone-100 border border-stone-200"
                            }`}
                    >
                        {page}
                    </button>
                );
            })}
        </div>
    );
}

export default Pagination;
