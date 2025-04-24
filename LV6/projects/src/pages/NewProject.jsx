import { useState } from "react";
import { useNavigate } from "react-router-dom";
import { Form, Row, Col, Button } from "react-bootstrap";
import { createNewProject, queryClient } from "../http";
import { useMutation } from "@tanstack/react-query";

export default function NewProjectPage() {
  const navigate = useNavigate();

  const { mutate, isPending, isError, error } = useMutation({
    mutationFn: createNewProject,
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ["projects"] });
      navigate("/projects");
    },
  });

  function handleSubmit(event) {
    event.preventDefault();

    const formData = new FormData(event.target);
    const newProject = Object.fromEntries(formData);
    newProject.completedJobs = [];
    newProject.workers = [];

    mutate(newProject);
  }

  return (
    <div className="w-50 mx-auto">
      <Form onSubmit={handleSubmit}>
        <Form.Group className="py-2">
          <Form.Label>Project name</Form.Label>
          <Form.Control type="text" name="title" />
        </Form.Group>
        <Form.Group className="py-2">
          <Form.Label>Description</Form.Label>
          <Form.Control as="textarea" rows={3} name="description" />
        </Form.Group>
        <Form.Group className="py-2">
          <Form.Label>Price</Form.Label>
          <Form.Control type="number" name="price" />
        </Form.Group>
        <Row>
          <Col>
            <Form.Label>Start date</Form.Label>
            <Form.Control type="text" name="start_date" />
          </Col>
          <Col>
            <Form.Label>Due date</Form.Label>
            <Form.Control type="text" name="due_date" />
          </Col>
        </Row>
        <Button className="my-2" type="submit">
          {isPending && "Submitting"}
          {!isPending && "Create"}
        </Button>
        {isError && <p>{error.info?.message}</p>}
      </Form>
    </div>
  );
}
