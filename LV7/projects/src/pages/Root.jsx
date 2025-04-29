import { Container } from "react-bootstrap";
import { Outlet } from "react-router-dom";
import Navigation from "../components/Navigation";

export default function RootLayout() {
  return (
    <>
      <Navigation />
      <Container className="vh-100 p-3" fluid>
        <Outlet />
      </Container>
    </>
  );
}
