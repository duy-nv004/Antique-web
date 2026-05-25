import { useState, useEffect } from "react";
import { useSearchParams } from "react-router-dom";
import axios from "axios";

export function useProductList() {
    const [searchParams, setSearchParams] = useSearchParams();
    const [products, setProducts] = useState([]);
    const [pagination, setPagination] = useState({});
    const [categories, setCategories] = useState([]);
    const [loading, setLoading] = useState(true);
    const [searchTerm, setSearchTerm] = useState(searchParams.get("search") || "");
    const [activeCategory, setActiveCategory] = useState(searchParams.get("category") || "");
    const [currentPage, setCurrentPage] = useState(parseInt(searchParams.get("page")) || 1);
    const [isFilterVisible, setIsFilterVisible] = useState(false);

    useEffect(() => {
        axios.get("/api/categories")
            .then((res) => {
                const cats = res.data;
                setCategories(Array.isArray(cats) ? cats : (cats?.data || []));
            })
            .catch(err => console.error("Error fetching categories:", err));
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

    return {
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
    };
}

export default useProductList;
