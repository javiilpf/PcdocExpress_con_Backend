import React, { createContext, useContext, useState, useCallback } from 'react';
import { useAuth } from './AuthContext';

const API_URL = import.meta.env.VITE_API_URL;
const ProductContext = createContext();

export const ProductProvider = ({ children }) => {
    const [products, setProducts] = useState([]);
    const [loading, setLoading] = useState(false);
    const [error, setError] = useState(null);
    const { token } = useAuth();

    const getProducts = useCallback(async () => {
        try {
            setLoading(true);
            const response = await fetch(`${API_URL}/product`, {
                headers: {
                    'Accept': 'application/json'
                }
            });
            
            if (!response.ok) {
                throw new Error('Error al obtener los productos');
            }
            
            const data = await response.json();
            setProducts(data.data);
            setError(null);
        } catch (error) {
            setError(error.message);
        } finally {
            setLoading(false);
        }
    }, [API_URL, token]);

    const getProductById = async (id) => {
        setLoading(true);
        try {
            const response = await fetch(`${API_URL}/product/${id}`);
            
            if (!response.ok) {
                throw new Error('Error al obtener el producto');
            }
            const data = await response.json();
            return data.data;
        } catch (err) {
            setError(err.message);
            return null;
        } finally {
            setLoading(false);
        }
    };

    const createProduct = async (productData) => {
        setLoading(true);
        try {
            const response = await fetch(`${API_URL}/product`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                },
                body: JSON.stringify(productData)
            });
            if (!response.ok) {
                throw new Error('Error al crear el producto');
            }
            const data = await response.json();
            setProducts([...products, data.data]);
            return data.data;
        } catch (err) {
            setError(err.message);
            throw err;
        } finally {
            setLoading(false);
        }
    };

    return (
        <ProductContext.Provider value={{
            products,
            loading,
            error,
            getProducts,
            getProductById,
            createProduct
        }}>
            {children}
        </ProductContext.Provider>
    );
};

export const useProducts = () => {
    return useContext(ProductContext);
};