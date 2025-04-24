import { Form, InputGroup, Button } from "react-bootstrap";
import { useMutation } from "@tanstack/react-query";
import { updateProject, queryClient } from "../http";

export default function ProjectWorkers({ project, setEditableProject }) {
  const { mutate } = useMutation({
    mutationFn: ({ id, updatedData }) => updateProject(id, updatedData),

    onMutate: async ({ id, updatedData }) => {
      await queryClient.cancelQueries({ queryKey: ["projects", id] });
      const previousData = queryClient.getQueryData(["projects", id]);

      queryClient.setQueryData(["projects", id], (old) => ({
        ...old,
        workers: [...(old.workers || []), ...updatedData.workers],
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
    const newWorker = formData.get("worker").trim();

    if (!newWorker) return;

    event.target.reset();

    const updatedWorkers = [...(project.workers || []), newWorker];
    setEditableProject((prev) => ({
      ...prev,
      workers: updatedWorkers,
    }));

    mutate({
      id: project._id,
      updatedData: {
        workers: updatedWorkers,
      },
    });
  }

  return (
    <div className="my-2">
      <Form onSubmit={handleSubmit}>
        <Form.Group>
          <Form.Label>Wrokers</Form.Label>
          <InputGroup>
            <Form.Control type="text" name="worker" />
            <Button type="submit">Submit</Button>
          </InputGroup>
        </Form.Group>
      </Form>

      <ul>
        {(project.workers || []).map((worker) => (
          <li key={worker}>{worker}</li>
        ))}
      </ul>
    </div>
  );
}
