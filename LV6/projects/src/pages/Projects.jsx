import { useFetch } from "../hooks/useFetch";
import { fetchAllProjects } from "../http";
import { useQuery } from "@tanstack/react-query";
import ProjectCard from "../components/ProjectCard";
import { Row } from "react-bootstrap";

export default function ProjectsPage() {
  const { data, isLoading, isError, error } = useQuery({
    queryKey: ["projects"],
    queryFn: ({ signal }) => fetchAllProjects({ signal }),
  });

  if (isLoading) return <p>Loading projects...</p>;
  if (isError) return <p>Error: {error.info?.message}</p>;

  return (
    <div className="px-4 d-flex flex-wrap gap-3 ">
      {data.length === 0 ? (
        <p>No projects found.</p>
      ) : (
        data.map((project) => (
          <ProjectCard key={project._id} project={project} />
        ))
      )}
    </div>
  );
}
