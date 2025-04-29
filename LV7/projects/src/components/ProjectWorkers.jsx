import { Button, Table } from "react-bootstrap";
import { useMutation, useQuery } from "@tanstack/react-query";
import { updateProject, queryClient, fetchUsers } from "../http";

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

  const {
    data: workers,
    isLoading,
    isError,
    error,
  } = useQuery({
    queryFn: ({ signal }) => fetchUsers({ signal }),
    queryKey: ["users"],
  });

  async function handleAddWorker(workerId) {
    const updatedWorkers = [...(project.workers || []), workerId];
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

  async function handleRemoveWorker(workerId) {
    const updatedWorkers = project.workers.filter((item) => item !== workerId);
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
      {isLoading && <p>Loading...</p>}
      {!isLoading && workers && (
        <Table striped bordered hover>
          <thead>
            <tr>
              <th>#</th>
              <th>First Name</th>
              <th>Last Name</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            {workers.map((item, index) => {
              if (item._id !== project.owner) {
                return (
                  <tr key={item._id}>
                    <td>{index}</td>
                    <td>{item.firstname}</td>
                    <td>{item.lastname}</td>
                    <td>
                      {project.workers.includes(item._id) ? (
                        <Button
                          variant="danger"
                          onClick={() => handleRemoveWorker(item._id)}
                        >
                          Remove
                        </Button>
                      ) : (
                        <Button
                          variant="success"
                          onClick={() => handleAddWorker(item._id)}
                        >
                          Add
                        </Button>
                      )}
                    </td>
                  </tr>
                );
              }
              return null;
            })}
          </tbody>
        </Table>
      )}
    </div>
  );
}
