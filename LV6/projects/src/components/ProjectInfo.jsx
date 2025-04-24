import { useState } from "react";
import { Card, Form, Row, Col, Button } from "react-bootstrap";
import { updateProject } from "../http";
import { useMutation, useQueryClient } from "@tanstack/react-query";

export default function ProjectInfo({
  project,
  onChange,
  setActionInfo,
  setShow,
}) {
  const queryClient = useQueryClient();

  const { mutate, isPending, isError, error } = useMutation({
    mutationFn: ({ id, updatedData }) => updateProject(id, updatedData),
    // 1. Optimistically update the cache
    onMutate: async ({ id, updatedData }) => {
      await queryClient.cancelQueries({ queryKey: ["projects", id] });
      const previousData = queryClient.getQueryData(["projects", id]);
      queryClient.setQueryData(["projects", id], (old) => ({
        ...old,
        ...updatedData,
      }));
      return { previousData };
    },
    // 2. Rollback on error
    onError: (err, variables, context) => {
      if (context?.previousData) {
        queryClient.setQueryData(
          ["projects", project._id],
          context.previousData
        );
      }
      setActionInfo({ message: "Failed to update project.", type: "Danger" });
      setShow(true);
    },
    onSettled: () => {
      queryClient.invalidateQueries({ queryKey: ["projects"] });
    },
    onSuccess: () => {
      setActionInfo({ message: "Updated successfully.", type: "Success" });
      setShow(true);
    },
  });

  function handleUpdate(event) {
    event.preventDefault();
    const updatedData = {
      title: project.title,
      description: project.description,
      price: parseFloat(project.price),
      start_date: project.start_date,
      due_date: project.due_date,
    };

    mutate({ id: project._id, updatedData });
  }

  /*
  function handleUpdate(event) {
    event.preventDefault();
    try {
      // Update
      await updateProject(project._id, {
        title: project.title,
        description: project.description,
        price: parseFloat(project.price),
        start_date: project.start_date,
        due_date: project.due_date,
      });
    } catch (error) {
      console.log(error);
      setActionInfo({ message: "Failed to update", type: "Danger" });
      setShow(true);
    }
    setActionInfo({ message: "Updated successfully.", type: "Success" });
    setShow(true);
  }*/

  return (
    <>
      <Card className="p-2">
        <Form className="p-2" onSubmit={handleUpdate}>
          <Form.Group className="py-2">
            <Form.Label>Project name</Form.Label>
            <Form.Control
              type="text"
              name="title"
              value={project.title}
              onChange={(e) => onChange("title", e.target.value)}
            />
          </Form.Group>
          <Form.Group className="py-2">
            <Form.Label>Description</Form.Label>
            <Form.Control
              as="textarea"
              rows={3}
              name="description"
              value={project.description}
              onChange={(e) => onChange("description", e.target.value)}
            />
          </Form.Group>
          <Row>
            <Col>
              <Form.Label>Start date</Form.Label>
              <Form.Control
                type="text"
                name="start_date"
                value={project.start_date}
                onChange={(e) => onChange("start_date", e.target.value)}
              />
            </Col>
            <Col>
              <Form.Label>Due date</Form.Label>
              <Form.Control
                type="text"
                name="due_date"
                value={project.due_date}
                onChange={(e) => onChange("due_date", e.target.value)}
              />
            </Col>
            <Col>
              <Form.Label>Price</Form.Label>
              <Form.Control
                type="number"
                name="price"
                value={project.price}
                onChange={(e) => onChange("price", e.target.value)}
              />
            </Col>
          </Row>
          <Button className="mt-2" type="submit">
            Update
          </Button>
        </Form>
      </Card>
    </>
  );
}
