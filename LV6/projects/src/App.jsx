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

const router = createBrowserRouter([
  {
    path: "/",
    element: <Navigate to="/projects" replace />,
  },
  {
    path: "/projects",
    element: <RootLayout />,
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
    <QueryClientProvider client={queryClient}>
      <RouterProvider router={router} />
    </QueryClientProvider>
  );
}

export default App;
