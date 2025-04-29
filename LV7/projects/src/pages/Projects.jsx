import { fetchAllProjects } from "../http";
import { useQuery } from "@tanstack/react-query";
import ProjectCard from "../components/ProjectCard";
import { useContext } from "react";
import { UserContext } from "../store/user-context";

export default function ProjectsPage() {
  const { user } = useContext(UserContext);

  const { data, isLoading, isError, error } = useQuery({
    queryKey: ["projects"],
    queryFn: ({ signal }) => fetchAllProjects({ signal }),
    enabled: !!user,
  });

  if (isLoading) return <p>Loading projects...</p>;
  if (isError) return <p>Error: {error.info?.message}</p>;

  let usersProjects = data.filter(
    (item) => item.owner === user._id || item.workers.includes(user._id)
  );

  return (
    <div className="px-4 d-flex flex-wrap gap-3 ">
      {usersProjects.length === 0 ? (
        <p>No projects found.</p>
      ) : (
        usersProjects.map((project) => (
          <ProjectCard key={project._id} project={project} />
        ))
      )}
    </div>
  );
}
