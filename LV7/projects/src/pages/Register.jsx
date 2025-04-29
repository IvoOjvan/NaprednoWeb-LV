import { useMutation } from "@tanstack/react-query";
import { useNavigate } from "react-router-dom";
import { Container, Form, Button } from "react-bootstrap";
import { Link } from "react-router-dom";
import { registerUser } from "../http";

export default function RegisterPage() {
  const navigate = useNavigate();

  const { mutate } = useMutation({
    mutationFn: registerUser,
    onSuccess: () => {
      console.log("User registered.");
      navigate("/auth/login");
    },
  });

  function handleSubmit(event) {
    event.preventDefault();

    const formData = new FormData(event.target);
    const user = Object.fromEntries(formData);

    mutate(user);
  }

  return (
    <Container
      className="d-flex justify-content-center align-items-center vh-100"
      fluid
    >
      <Form
        className="p-4 border rounded shadow"
        style={{ minWidth: "500px" }}
        onSubmit={handleSubmit}
      >
        <Form.Group className="mb-3">
          <Form.Label>Firstname</Form.Label>
          <Form.Control type="text" name="firstname" required />
        </Form.Group>

        <Form.Group className="mb-3">
          <Form.Label>Lastname</Form.Label>
          <Form.Control type="text" name="lastname" required />
        </Form.Group>

        <Form.Group className="mb-3" controlId="formBasicEmail">
          <Form.Label>Email address</Form.Label>
          <Form.Control type="email" name="email" required />
        </Form.Group>

        <Form.Group className="mb-3" controlId="formBasicPassword">
          <Form.Label>Password</Form.Label>
          <Form.Control type="password" name="password" required />
        </Form.Group>

        <Button variant="primary" type="submit">
          Sign Up
        </Button>
        <div>
          Already have an account?
          <span>
            <Link to="/auth/login">Login</Link>
          </span>
        </div>
      </Form>
    </Container>
  );
}
