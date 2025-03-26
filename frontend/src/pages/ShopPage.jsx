import React, { useEffect } from 'react';
import { useProducts } from '../context/ProductContext';
import { Carousel } from 'react-responsive-carousel';
import 'react-responsive-carousel/lib/styles/carousel.min.css'; // Importa los estilos

const ShopPage = () => {
  const { products, getProducts, loading, error } = useProducts();

  useEffect(() => {
    getProducts();
  }, [getProducts]);

  if (loading) {
    return (
      <div className="min-h-screen flex justify-center items-center">
        <div className="animate-spin rounded-full h-32 w-32 border-t-2 border-b-2 border-blue-500"></div>
      </div>
    );
  }

  if (error) {
    return (
      <div className="min-h-screen flex justify-center items-center">
        <div className="text-red-500 text-xl">{error}</div>
      </div>
    );
  }

  if (!Array.isArray(products)) {
    return <div>No hay productos disponibles.</div>;
  }

  return (
    <div className="container mx-auto px-4 pt-50 py-8">
      <h1 className="text-3xl font-bold text-center mb-8">Nuestra Tienda</h1>

      <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        {products.map((product) => (
          <div key={product.id} className="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
            {product.images && product.images.length > 0 && (
              <Carousel 
                showThumbs={false}  
                infiniteLoop 
                showArrows={true} 
                showIndicators={true} // Agrega los puntitos debajo
                swipeable={true} 
                emulateTouch={true} 
                interval={3000}
              >
                {product.images.map((image) => (
                  <div key={image.id}>
                    <img 
                      src={image.urlImage} 
                      alt={product.productName}
                      className="w-full h-60 object-cover"
                    />
                  </div>
                ))}
              </Carousel>
            )}

            <div className="p-4">
              <h2 className="text-xl font-semibold mb-2">{product.productName}</h2>
              <p className="text-gray-600 text-sm mb-2 line-clamp-2">{product.description}</p>

              <div className="flex justify-between items-center mt-4">
                <span className="text-lg font-bold text-blue-600">{product.price}€</span>
                <span className="text-sm text-gray-500">Stock: {product.stock}</span>
              </div>

              {product.valoration && (
                <div className="flex items-center mt-2">
                  {[...Array(5)].map((_, index) => (
                    <svg
                      key={index}
                      className={`w-4 h-4 ${
                        index < product.valoration ? 'text-yellow-400' : 'text-gray-300'
                      }`}
                      fill="currentColor"
                      viewBox="0 0 20 20"
                    >
                      <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                  ))}
                </div>
              )}

              <button className="w-full mt-4 bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600 transition-colors duration-300">
                Añadir al carrito
              </button>
            </div>
          </div>
        ))}
      </div>
    </div>
  );
};

export default ShopPage;
