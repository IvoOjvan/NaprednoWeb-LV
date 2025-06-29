import { QueryClient } from "@tanstack/react-query";
export const queryClient = new QueryClient();

export async function fetchAllProjects({ signal }) {
  const response = await fetch(`http://localhost:5050/projects`, {
    signal,
  });

  if (!response.ok) {
    const error = new Error("An error occurred while fetching the projects.");
    error.code = response.status;
    error.info = await response.json();
    throw error;
  }

  const projects = await response.json();
  return projects;
}

export async function createNewProject(project) {
  const response = await fetch("http://localhost:5050/projects", {
    method: "POST",
    body: JSON.stringify(project),
    headers: {
      "Content-Type": "application/json",
    },
  });

  if (!response.ok) {
    const error = new Error("An error occurred while creating the project.");
    error.code = response.status;
    error.info = await response.json();
    throw error;
  }

  const { message } = await response.json();

  return message;
}

export async function fetchProject({ id, signal }) {
  const response = await fetch(`http://localhost:5050/projects/${id}`, {
    signal,
  });

  if (!response.ok) {
    const error = new Error("An error occurred while fetching the event.");
    error.code = response.status;
    error.info = await response.json();
    throw error;
  }

  const project = await response.json();
  return project;
}

export async function deleteProject(id) {
  const response = await fetch("http://localhost:5050/projects/" + id, {
    method: "DELETE",
  });

  if (!response.ok) {
    const error = new Error("An error occurred while deleting project.");
    error.code = response.status;
    error.info = await response.json();
    throw error;
  }

  return response.json();
}

export async function updateProject(projectId, updatedData) {
  const response = await fetch("http://localhost:5050/projects/" + projectId, {
    method: "PATCH",
    body: JSON.stringify(updatedData),
    headers: {
      "Content-Type": "application/json",
    },
  });

  if (!response.ok) {
    const error = new Error("An error occurred while updating the project.");
    error.code = response.status;
    error.info = await response.json();
    throw error;
  }

  return response.json();
}

export async function registerUser(userData) {
  const response = await fetch("http://localhost:5050/auth/register", {
    method: "POST",
    body: JSON.stringify(userData),
    headers: {
      "Content-Type": "application/json",
    },
  });

  if (!response.ok) {
    const error = new Error("An error occurred while registering user.");
    error.code = response.status;
    error.info = await response.json();
    throw error;
  }

  return response.json();
}

export async function loginUser(userData) {
  const response = await fetch("http://localhost:5050/auth/login", {
    method: "POST",
    body: JSON.stringify(userData),
    headers: {
      "Content-Type": "application/json",
    },
  });

  if (!response.ok) {
    const error = new Error("An error occurred while loging in.");
    error.code = response.status;
    error.info = await response.json();
    throw error;
  }

  const user = response.json();
  return user;
}

export async function fetchUsers({ signal }) {
  const response = await fetch("http://localhost:5050/auth/users", { signal });

  if (!response.ok) {
    const error = new Error("An error occurred while fetching users.");
    error.code = response.status;
    error.info = await response.json();
    throw error;
  }

  const users = await response.json();
  return users;
}
