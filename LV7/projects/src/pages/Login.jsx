import { useMutation } from "@tanstack/react-query";
import { redirect, useNavigate } from "react-router-dom";
import { useContext } from "react";
import { UserContext } from "../store/user-context";
import { Container, Form, Button } from "react-bootstrap";
import { Link } from "react-router-dom";
import { loginUser } from "../http";
import { useEffect } from "react";

export default function LoginPage() {
  const navigate = useNavigate();
  const { user, setUser } = useContext(UserContext);

  useEffect(() => {
    if (user) {
      navigate("/projects");
    }
  }, [user, navigate]);

  const { mutate } = useMutation({
    mutationFn: loginUser,
    onSuccess: (response) => {
      setUser(response);
      navigate("/projects");
    },
  });

  function handleSubmit(event) {
    event.preventDefault();

    const formData = new FormData(event.target);
    const loginData = Object.fromEntries(formData);

    mutate(loginData);
  }

  return (
    <Container
      className="d-flex justify-content-center align-items-center vh-100"
      fluid
    >
      <Form
        className="p-4 border rounded shadow"
        style={{ minWidth: "300px" }}
        onSubmit={handleSubmit}
      >
        <Form.Group className="mb-3" controlId="formBasicEmail">
          <Form.Label>Email address</Form.Label>
          <Form.Control type="email" placeholder="Enter email" name="email" />
        </Form.Group>

        <Form.Group className="mb-3" controlId="formBasicPassword">
          <Form.Label>Password</Form.Label>
          <Form.Control
            type="password"
            placeholder="Password"
            name="password"
          />
        </Form.Group>

        <Button variant="primary" type="submit">
          Sign In
        </Button>
        <div>
          Don't have and account?
          <span>
            <Link to="/auth/register">Register</Link>
          </span>
        </div>
      </Form>
    </Container>
  );
}

export function authLoader() {
  //const { user } = useContext(UserContext);
  const user = localStorage.getItem("user");

  if (!user) {
    return redirect("/auth/login");
  }

  return null;
}
