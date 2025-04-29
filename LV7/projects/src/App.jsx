import {
  RouterProvider,
  createBrowserRouter,
  Navigate,
} from "react-router-dom";

import { QueryClientProvider } from "@tanstack/react-query";
import { queryClient } from "./http";

import ProjectsPage from "./pages/Projects";
import RootLayout from "./pages/Root";

import "bootstrap/dist/css/bootstrap.min.css";
import NewProjectPage from "./pages/NewProject";
import ProjectDetailPage from "./pages/ProjectDetail";
import LoginPage, { authLoader } from "./pages/Login";
import RegisterPage from "./pages/Register";
import UserContextProvider from "./store/user-context";

const router = createBrowserRouter([
  {
    path: "/",
    element: <Navigate to="/auth/login" replace />,
  },
  {
    path: "/auth",
    children: [
      {
        path: "login",
        element: <LoginPage />,
      },
      {
        path: "register",
        element: <RegisterPage />,
      },
    ],
  },
  {
    path: "/projects",
    element: <RootLayout />,
    loader: authLoader,
    children: [
      {
        index: true,
        element: <ProjectsPage />,
      },
      {
        path: "new-project",
        element: <NewProjectPage />,
      },
      {
        path: ":id",
        element: <ProjectDetailPage />,
      },
    ],
  },
]);

function App() {
  return (
    <UserContextProvider>
      <QueryClientProvider client={queryClient}>
        <RouterProvider router={router} />
      </QueryClientProvider>
    </UserContextProvider>
  );
}

export default App;
