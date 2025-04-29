import { useNavigate, useParams } from "react-router-dom";
import { deleteProject, fetchProject, queryClient } from "../http";
import { useState, useEffect, useContext } from "react";
import { useMutation, useQuery } from "@tanstack/react-query";
import { UserContext } from "../store/user-context";

import ProjectInfo from "../components/ProjectInfo";
import ProjectFooter from "../components/ProjectFooter";
import ToastNotification from "../components/Notification";
import ModalConfirmation from "../components/UI/Modal";
import CompletedJobs from "../components/CompletedJobs";
import ProjectWorkers from "../components/ProjectWorkers";

export default function ProjectDetailPage() {
  const [isDeleting, setIsDeleting] = useState(false);
  const [show, setShow] = useState(false);
  const [actionInfo, setActionInfo] = useState(null);
  const { user } = useContext(UserContext);
  const navigate = useNavigate();
  const projectId = useParams().id;

  const [editableProject, setEditableProject] = useState(null);

  const {
    data: project,
    isPending,
    isError,
    error,
  } = useQuery({
    queryKey: ["projects", projectId],
    queryFn: ({ signal }) => fetchProject({ signal, id: projectId }),
  });

  useEffect(() => {
    if (project) {
      setEditableProject(project);
    }
  }, [project]);

  const {
    mutate: mutateDeleteProject,
    isPending: isPendingDeletion,
    isError: isErrorDeleting,
    error: deleteError,
  } = useMutation({
    mutationFn: deleteProject,
    onSuccess: () => {
      setIsDeleting(false);
      queryClient.invalidateQueries({
        queryKey: ["projects"],
        refetchType: "none",
      });
      navigate("/projects");
    },
  });

  function handleStartDelete() {
    setIsDeleting(true);
    console.log("Delete clicked - setting isDeleting to true");
  }

  function handleStopDelete() {
    setIsDeleting(false);
  }

  function handleDelete() {
    mutateDeleteProject(projectId);
  }

  function handleChange(key, value) {
    setEditableProject((prev) => ({
      ...prev,
      [key]: value,
    }));
  }

  if (!editableProject) return <p>Loading...</p>;

  if (isPending) return <p>Loading...</p>;
  if (isError) {
    return (
      <p>Error: {error.info?.message || "Failed to fetch project data."}</p>
    );
  }

  const isEditable = project.owner === user._id;

  return (
    <>
      {isDeleting && (
        <ModalConfirmation
          onClose={handleStopDelete}
          isDeleting={isDeleting}
          isPendingDeletion={isPendingDeletion}
          handleDelete={handleDelete}
        />
      )}

      <ToastNotification
        actionInfo={actionInfo}
        show={show}
        setShow={setShow}
      />
      <ProjectInfo
        project={editableProject}
        onChange={handleChange}
        setActionInfo={setActionInfo}
        setShow={setShow}
        isEditable={isEditable}
      />

      <CompletedJobs
        project={editableProject}
        setEditableProject={setEditableProject}
      />

      {isEditable && (
        <>
          <ProjectWorkers
            project={editableProject}
            setEditableProject={setEditableProject}
          />
          <ProjectFooter onStartDelete={handleStartDelete} />
        </>
      )}
    </>
  );
}
