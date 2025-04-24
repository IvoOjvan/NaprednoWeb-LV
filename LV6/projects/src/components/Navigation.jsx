import { Container, Navbar, Nav } from "react-bootstrap";
import { Link } from "react-router-dom";

export default function Navigation() {
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
      </Container>
    </Navbar>
  );
}
