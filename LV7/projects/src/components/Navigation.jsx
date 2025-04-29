import { useNavigate } from "react-router-dom";
import { useContext } from "react";
import { UserContext } from "../store/user-context";

import { Container, Navbar, Nav } from "react-bootstrap";
import { Link } from "react-router-dom";

export default function Navigation() {
  const navigate = useNavigate();
  const { setUser } = useContext(UserContext);

  function handleLogout() {
    setUser(null);
    //localStorage.removeItem("user");
    navigate("/auth/login");
  }

  return (
    <Navbar bg="light" data-bs-theme="light">
      <Container fluid className="px-3">
        <Navbar.Brand href="#home">LV6</Navbar.Brand>
        <Nav className="me-auto">
          <Nav.Link as={Link} to="/projects">
            Projects
          </Nav.Link>
          <Nav.Link as={Link} to="new-project">
            New Project
          </Nav.Link>
          <Nav.Link href="#pricing">Archive</Nav.Link>
        </Nav>
        <Nav className="ms-auto">
          <Nav.Link onClick={handleLogout}>Logout</Nav.Link>
        </Nav>
      </Container>
    </Navbar>
  );
}
