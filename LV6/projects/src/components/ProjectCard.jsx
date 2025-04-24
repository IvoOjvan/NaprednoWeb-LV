import { Card } from "react-bootstrap";
import { Link } from "react-router-dom";

export default function ProjectCard({ project }) {
  return (
    <Card style={{ width: "18rem " }}>
      <Card.Body>
        <Card.Title>{project.title}</Card.Title>
        <Card.Subtitle className="mb-2 text-muted">
          {project.start_date} - {project.due_date}
        </Card.Subtitle>
        <Card.Text>{project.description}</Card.Text>
        <Card.Link as={Link} to={project._id}>
          Details
        </Card.Link>
      </Card.Body>
    </Card>
  );
}
