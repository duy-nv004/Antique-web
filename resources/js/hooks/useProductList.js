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
    const [isNew, setIsNew] = useState(searchParams.get("is_new") || "");
    const [status, setStatus] = useState(searchParams.get("status") || "");
    const [sortBy, setSortBy] = useState(searchParams.get("sort_by") || "");
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

    // Sync state with search params (e.g. back/forward button)
    useEffect(() => {
        setSearchTerm(searchParams.get("search") || "");
        setActiveCategory(searchParams.get("category") || "");
        setIsNew(searchParams.get("is_new") || "");
        setStatus(searchParams.get("status") || "");
        setSortBy(searchParams.get("sort_by") || "");
        setCurrentPage(parseInt(searchParams.get("page")) || 1);
    }, [searchParams]);

    useEffect(() => {
        setLoading(true);
        const params = new URLSearchParams();
        if (searchTerm) params.append("search", searchTerm);
        if (activeCategory) params.append("category_id", activeCategory);
        if (isNew) params.append("is_new", isNew);
        if (status) params.append("status", status);
        if (sortBy) params.append("sort_by", sortBy);
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
    }, [searchTerm, activeCategory, isNew, status, sortBy, currentPage]);

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

    const handleIsNewChange = (val) => {
        setIsNew(val);
        setCurrentPage(1);
        setSearchParams(prev => {
            if (val) prev.set("is_new", val);
            else prev.delete("is_new");
            prev.set("page", 1);
            return prev;
        });
    };

    const handleStatusChange = (val) => {
        setStatus(val);
        setCurrentPage(1);
        setSearchParams(prev => {
            if (val) prev.set("status", val);
            else prev.delete("status");
            prev.set("page", 1);
            return prev;
        });
    };

    const handleSortByChange = (val) => {
        setSortBy(val);
        setCurrentPage(1);
        setSearchParams(prev => {
            if (val) prev.set("sort_by", val);
            else prev.delete("sort_by");
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
        isNew,
        status,
        sortBy,
        currentPage,
        isFilterVisible,
        setIsFilterVisible,
        handleSearchChange,
        handleCategoryChange,
        handleIsNewChange,
        handleStatusChange,
        handleSortByChange,
        handlePageChange
    };
}

export default useProductList;
