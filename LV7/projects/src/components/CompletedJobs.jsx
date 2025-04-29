import { Form, InputGroup, Button } from "react-bootstrap";
import { useMutation } from "@tanstack/react-query";
import { updateProject, queryClient } from "../http";

export default function CompletedJobs({ project, setEditableProject }) {
  const { mutate } = useMutation({
    mutationFn: ({ id, updatedData }) => updateProject(id, updatedData),

    onMutate: async ({ id, updatedData }) => {
      await queryClient.cancelQueries({ queryKey: ["projects", id] });
      const previousData = queryClient.getQueryData(["projects", id]);

      queryClient.setQueryData(["projects", id], (old) => ({
        ...old,
        completedJobs: [
          ...(old.completedJobs || []),
          ...updatedData.completedJobs,
        ],
      }));

      return { previousData };
    },

    onError: (err, variables, context) => {
      if (context?.previousData) {
        queryClient.setQueryData(
          ["projects", project._id],
          context.previousData
        );
      }
    },

    onSettled: () => {
      queryClient.invalidateQueries({ queryKey: ["projects", project._id] });
    },
  });

  function handleSubmit(event) {
    event.preventDefault();

    const formData = new FormData(event.target);
    const newJob = formData.get("completed_job").trim();

    if (!newJob) return;

    event.target.reset();

    const updatedJobs = [...(project.completedJobs || []), newJob];
    setEditableProject((prev) => ({
      ...prev,
      completedJobs: updatedJobs,
    }));

    mutate({
      id: project._id,
      updatedData: {
        completedJobs: updatedJobs,
      },
    });
  }

  return (
    <div className="my-2">
      <Form onSubmit={handleSubmit}>
        <Form.Group>
          <Form.Label>Completed job</Form.Label>
          <InputGroup>
            <Form.Control type="text" name="completed_job" />
            <Button type="submit">Submit</Button>
          </InputGroup>
        </Form.Group>
      </Form>

      <ul>
        {(project.completedJobs || []).map((job) => (
          <li key={job}>{job}</li>
        ))}
      </ul>
    </div>
  );
}
