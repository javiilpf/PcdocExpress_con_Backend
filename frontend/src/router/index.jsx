import { createBrowserRouter, Navigate } from "react-router-dom";
import RootLayout from "../layout/RootLayout";
import ErrorPage from "../pages/ErrorPage";
import LoginPage from "../pages/LoginPage";
import RegisterPage from "../pages/RegisterPage";
import HomePage from "../pages/HomePage";
import AuthLayout from "../layout/AuthLayout";
import ProtectedRoute from "../components/ProtectedRoute";
import ApplicationPage from "../pages/ApplicationPage";
import NewReparationPage from "../pages/NewReparationPage";
import NewInstallationPage from "../pages/NewInstallationPage";
import NewMaintenancePage from "../pages/NewMaintenancePage";
import ShopPage from "../pages/shopPage";

export const router = createBrowserRouter([
  {
    path: "/",
    element: <RootLayout />,
    errorElement: <ErrorPage />,
    children: [
      {
        index: true,
        element: <HomePage />,
      },
      {
        path: "application",
        children: [
          {
            index: true,
            element: (
              <ProtectedRoute>
                <ApplicationPage />
              </ProtectedRoute>
            ),
          },
          {
            path: "reparation/new",
            element: (
              <ProtectedRoute>
                <NewReparationPage />
              </ProtectedRoute>
            ),
          },
          {
            path: "installation/new",
            element: (
              <ProtectedRoute>
                <NewInstallationPage />
              </ProtectedRoute>
            ),
          },
          {
            path: "maintenance/new",
            element: (
              <ProtectedRoute>
                <NewMaintenancePage />
              </ProtectedRoute>
            ),
          },
        ],
      },
      {
        path: "shop",
        element: <ShopPage />, 
      },
    ],
  },
  {
    path: "/auth",
    element: <AuthLayout />,
    errorElement: <ErrorPage />,
    children: [
      {
        path: "login", // Eliminado `index`
        element: <LoginPage />,
      },
      {
        path: "register", // Eliminado `index`
        element: <RegisterPage />,
      },
    ],
  },
  {
    path: "*",
    element: <Navigate to="/404" replace />,
  },
]);