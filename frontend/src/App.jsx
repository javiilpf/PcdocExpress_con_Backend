import { RouterProvider } from "react-router-dom";
import { AuthProvider } from "./context/AuthContext";
import { MaintenanceProvider } from "./context/MaintenanceContext"; // Asegúrate de importar el MaintenanceProvider
import { router } from "./router";
import { ReparationProvider } from "./context/ReparationContext";
import { ProductProvider } from "./context/ProductContext";

const App = () => {
  return (
    <AuthProvider>
      <MaintenanceProvider> 
        <ReparationProvider>
          <ProductProvider>
            <RouterProvider router={router}/>
          </ProductProvider>
        </ReparationProvider>
      </MaintenanceProvider>
    </AuthProvider>
  );
};

export default App;